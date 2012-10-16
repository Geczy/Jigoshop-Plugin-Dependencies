<?php
/**
 * Jigoshop dependencies checker.
 *
 * Version: 1.0.1
 *
 * @category Helpers
 * @package  Jigoshop
 * @author   Matt Gates <info@mgates.me>
 */
class Jigoshop_Dependencies {

	/**
	 * Current version of the Jigoshop_Dependencies class
	 *
	 * @var float
	 *
	 * @access private
	 * @static
	 */

	public function jigoshop_active_check( $required_version = '' ) {
		$this->required_version = $required_version;
		$this->file = $this->get_calling_file();

		$this->do_actions_and_hooks();
	}

	/**
	 * Return the main plugin that's calling the Jigoshop
	 * dependencies library.
	 *
	 * @access private
	 *
	 * @return string File path to the main plugin.
	 */
	private function get_calling_file() {
		$file = debug_backtrace();

		// Three functions is how long it took for
		// the main plugin to call us. So three we go!
		$file = $file[2]['file'];

		return $file;
	}

	/**
	 * Begins the necessary actions this library
	 * requires.
	 *
	 * @access private
	 */
	private function do_actions_and_hooks() {
		add_action( 'admin_init', array( &$this, 'get_plugin_title' ) );
		add_action( 'admin_init', array( &$this, 'check_jigoshop_on_init' ) );
		add_action( 'admin_init', array( &$this, 'check_jigoshop_version' ) );
	}

	/**
	 * Retrieve the main plugin's title.
	 * Used for display in the admin notices.
	 *
	 * @access public
	 */
	public function get_plugin_title() {
		$plugin = get_plugin_data( $this->file );
		$this->title = $plugin['Name'];
	}

	/**
	 * Verifies whether or not Jigoshop is activated.
	 *
	 * @access private
	 *
	 * @return boolean Whether JIGOSHOP_VERSION is defined.
	 */
	private function is_jigoshop_activated() {
		return defined( 'JIGOSHOP_VERSION' );
	}

	/**
	 * Deactivate the main plugin.
	 *
	 * @access private
	 */
	private function deactivate_main_plugin() {
		deactivate_plugins( plugin_basename( $this->file ) );
	}

	/**
	 * Deactivate if Jigoshop isn't activated.
	 *
	 * @access public
	 */
	public function check_jigoshop_on_init() {
		if ( !$this->is_jigoshop_activated() ) {
			$this->deactivate_main_plugin();
			add_action( 'admin_notices', array( &$this, 'jigoshop_is_not_activated' ) );
		}
	}

	/**
	 * Version check against Jigoshop.
	 * Compares a specified version against the current
	 * installed Jigoshop version, and deactivates if
	 * there is a discrepancy.
	 *
	 * @access public
	 */
	public function check_jigoshop_version() {
		if ( empty( $this->required_version ) || !$this->is_jigoshop_activated() ) return false;

		$plugins = get_plugins();
		foreach ( $plugins as $folder => $data ) {

			if ( !strpos( $folder, '/jigoshop.php' ) ) continue;

			if ( version_compare( $data['Version'], $this->required_version, '<' ) ) {
				$this->deactivate_main_plugin();
				add_action( 'admin_notices', array( &$this, 'invalid_jigoshop_version' ) );
			}

		}
	}

	/**
	 * Prompt the user to update Jigoshop.
	 *
	 * @access public
	 */
	public function invalid_jigoshop_version() {
		echo '<div class="error">
				<h3>' . $this->title . '</h3>
				<p>' . sprintf( __('<a href="%s" target="_TOP">Jigoshop</a> v%s or greater is required to activate this plugin. Please update Jigoshop.', 'jigoshop'), 'http://jigoshop.com', $this->required_version ) . '</p>
			  </div>';
	}

	/**
	 * Prompt the user to install / activate Jigoshop.
	 *
	 * @access public
	 */
	public function jigoshop_is_not_activated() {
		echo '<div class="error">
				<h3>' . $this->title . '</h3>
				<p>' . sprintf( __('<a href="%s" target="_TOP">Jigoshop</a> is not installed or is inactive. Please install / activate Jigoshop.', 'jigoshop'), 'http://jigoshop.com' ) . '</p>
			  </div>';
	}

}
