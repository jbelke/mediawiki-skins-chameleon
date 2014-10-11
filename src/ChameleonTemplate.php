<?php

namespace Skins\Chameleon;

use BaseTemplate;
use SkinChameleon;

/**
 * File holding the ChameleonTemplate class
 *
 * @copyright (C) 2013, Stephan Gambke
 * @license       http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3 (or later)
 *
 * This file is part of the MediaWiki skin Chameleon.
 * The Chameleon skin is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * The Chameleon skin is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @file
 * @ingroup       Skins
 */

/**
 * BaseTemplate class for the Chameleon skin
 *
 * @ingroup Skins
 */
class ChameleonTemplate extends BaseTemplate {

	/**
	 * Outputs the entire contents of the page
	 */
	public function execute() {

		$this->getSkin()->getComponentFactory()->setSkinTemplate( $this );
		$this->getSkin()->addSkinModulesToOutput();
		$this->set( 'bottomscripts', $this->getSkin()->bottomScripts() );

		// output the head element
		// The headelement defines the <body> tag itself, it shouldn't be included in the html text
		// To add attributes or classes to the body tag override addToBodyAttributes() in SkinChameleon
		$this->html( 'headelement' );
		echo $this->getSkin()->getComponentFactory()->getRootComponent()->getHtml();
		$this->printTrail();
		echo "</body>\n</html>";

	}

	/**
	 * Overrides method in parent class that is unprotected against non-existent indexes in $this->data
	 *
	 * @param $key
	 *
	 * @return string|void
	 */
	function html( $key ) {
		echo $this->get( $key );
	}

	/**
	 * Get the Skin object related to this object
	 *
	 * @return SkinChameleon
	 */
	public function getSkin() {
		return parent::getSkin();
	}

	/**
	 * @param \DOMElement $description
	 * @param int         $indent
	 * @param string      $htmlClassAttribute
	 *
	 * @throws \MWException
	 * @return \Skins\Chameleon\Components\Container
	 */
	public function getComponent( \DOMElement $description, $indent = 0, $htmlClassAttribute = '' ) {
		return $this->getSkin()->getComponentFactory()->getComponent( $description, $indent, $htmlClassAttribute );
	}

	/**
	 * Generates a list item for a navigation, portlet, portal, sidebar... list
	 *
	 * Overrides the parent function to ensure ids are unique.
	 *
	 * @param $key     string, usually a key from the list you are generating this link from.
	 * @param $item    array, of list item data containing some of a specific set of keys.
	 *
	 * The "id" and "class" keys will be used as attributes for the list item,
	 * if "active" contains a value of true a "active" class will also be appended to class.
	 *
	 * @param $options array
	 *
	 * @return string
	 */
	function makeListItem( $key, $item, $options = array() ) {

		foreach ( array( 'id', 'single-id' ) as $attrib ) {

			if ( isset ( $item[ $attrib ] ) ) {
				$item[ $attrib ] = IdRegistry::getRegistry()->getId( $item[ $attrib ], $this );
			}

		}

		return parent::makeListItem( $key, $item, $options );
	}
}
