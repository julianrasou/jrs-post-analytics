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
	public function add_tools_page() {
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
	public function build_settings_page_html() {
		?>
		<div class="wrap">
			<h1>
				<?php esc_html_e( 'Post Analytics Settings', 'jrs-post-analytics' ); ?>
			</h1>
			<form action="options.php" method="POST">
				<?php
				settings_fields( 'jrs-data-analytics-group' );
				do_settings_sections( 'post-analytics-settings-page' );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * Adds the settings fields to the settings page.
	 */
	public function add_settings() {
		// Adds a new section to a settings page.
		add_settings_section( 'jrs-post-analysis-section-one', null, null, 'post-analytics-settings-page' );

		// Adds a field to configure analytics location.
		add_settings_field(
			'jrs-post-analytics-location',
			__( 'Display Location', 'jrs-post-analytics' ),
			array( $this, 'build_location_settings_html' ),
			'post-analytics-settings-page',
			'jrs-post-analysis-section-one'
		);

		// Registers the setting and its data.
		register_setting(
			'jrs-data-analytics-group',
			'jrs-post-analytics-location',
			array(
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => '0',
			)
		);
	}

	/**
	 * Builds the location setting field html.
	 * Options are: beggining of post and end of post.
	 */
	public function build_location_settings_html() {
		?>
		<select name="jrs-post-analytics-location">
			<option value="0" <?php selected( get_option( 'jrs-post-analytics-location' ), '0' ); ?> >
				<?php esc_html_e( 'Beginning of post', 'jrs-post-analytics' ); ?>
			</option>
			<option value="1" <?php selected( get_option( 'jrs-post-analytics-location' ), '1' ); ?>>
				<?php esc_html_e( 'End of post', 'jrs-post-analytics' ); ?>
			</option>
		</select>
		<?php
	}

	/**
	 * Load plugin text domain.
	 */
	public function load_textdomain() {
	}

	/**
	 * Checks if the settings options are enabled, if they are:
	 * Adds post analytics at the preferred location.
	 *
	 * @param string $content Content of the current post.
	 */
	public function if_settings_enabled( $content ) {
	}
}
