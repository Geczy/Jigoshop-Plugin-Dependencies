<?php

/**
 * Functions used by plugins
 */

if ( ! class_exists( 'Jigoshop_Dependencies' ) ) require_once 'class-jigoshop-dependencies.php';

/**
 * Jigoshop detection
 *
 * @param string  $required_version Optionally force a Jigoshop version to be installed.
 * @return boolean                   Will deactivate the plugin or show an admin notice
 */

if ( ! function_exists( 'is_jigoshop_active' ) ) {

	function is_jigoshop_active( $required_version = '' ) {

		$Jigoshop_Dependencies = new Jigoshop_Dependencies;
		return $Jigoshop_Dependencies->jigoshop_active_check( $required_version );

	}

}
