<?php
/**
 * Description:       Displays post analytics (word count, character count, reading time) at the beggining or end of your posts
 *
 * @package           JRS\Post_Analytics
 * License:           GPLv3
 * Text Domain:       jrs-post-analytics
 */

/**
 * Contains the plugin's functionality
 *
 * @since             1.0.0
 */
class Jrs_Post_Analytics {

	/**
	 * Summary of __construct
	 * initializes the settings menu and the filter to add statistics to posts
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_tools_page' ) );
		add_action( 'admin_init', array( $this, 'add_settings' ) );
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
		add_filter( 'the_content', array( $this, 'if_settings_enabled' ) );
	}

	/**
	 * Adds a submenu page to the Tools main menu.
	 */
	private function add_tools_page() {
		add_management_page(
			__( 'Post Analytics Settings', 'jrs-post-analytics' ),
			__( 'Post Analytics', 'jrs-post-analytics' ),
			'manage_options',
			'post-analytics-settings-page',
			array( $this, 'build_settings_page_html' ),
			null
		);
	}

	/**
	 * Builds the content of the settings page.
	 */
	private function build_settings_page_html() {
	}

	/**
	 * Adds the settings fields to the settigs page.
	 */
	private function add_settings() {
	}

	/**
	 * Load plugin text domain.
	 */
	private function load_textdomain() {
	}

	/**
	 * Checks if the settings options are enabled, if they are:
	 * Adds post analytics at the preffered location.
	 *
	 * @param string $content Content of the current post.
	 */
	private function if_settings_enabled( $content ) {
	}
}
