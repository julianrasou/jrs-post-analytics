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

		// Adds a field to configure analytics headline text.
		add_settings_field(
			'jrs-post-analytics-headline-text',
			__( 'Headline Text', 'jrs-post-analytics' ),
			array( $this, 'build_headline_settings_html' ),
			'post-analytics-settings-page',
			'jrs-post-analysis-section-one'
		);

		// Registers the setting and its data.
		register_setting(
			'jrs-data-analytics-group',
			'jrs-post-analytics-headline-text',
			array(
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => 'Post Analytics',
			)
		);

		// Adds a field to configure if word count is enabled.
		add_settings_field(
			'jrs-post-analytics-wordcount-enable',
			__( 'Enable Word Count', 'jrs-post-analytics' ),
			array( $this, 'build_wordcount_settings_html' ),
			'post-analytics-settings-page',
			'jrs-post-analysis-section-one'
		);

		// Registers the setting and its data.
		register_setting(
			'jrs-data-analytics-group',
			'jrs-post-analytics-wordcount-enable',
			array(
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => '1',
			)
		);

		// Adds a field to configure if character count is enabled.
		add_settings_field(
			'jrs-post-analytics-charactercount-enable',
			__( 'Enable Character Count', 'jrs-post-analytics' ),
			array( $this, 'build_charactercount_settings_html' ),
			'post-analytics-settings-page',
			'jrs-post-analysis-section-one'
		);

		// Registers the setting and its data.
		register_setting(
			'jrs-data-analytics-group',
			'jrs-post-analytics-charactercount-enable',
			array(
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => '1',
			)
		);

		// Adds a field to configure if readtime count is enabled.
		add_settings_field(
			'jrs-post-analytics-readtime-enable',
			__( 'Enable Read Time', 'jrs-post-analytics' ),
			array( $this, 'build_readtime_settings_html' ),
			'post-analytics-settings-page',
			'jrs-post-analysis-section-one'
		);

		// Registers the setting and its data.
		register_setting(
			'jrs-data-analytics-group',
			'jrs-post-analytics-readtime-enable',
			array(
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => '1',
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
	 * Builds the headline text setting field html.
	 */
	public function build_headline_settings_html() {
		?>
		<input type="text" name="jrs-post-analytics-headline-text" value="<?php echo esc_attr( get_option( 'jrs-post-analytics-headline-text' ) ); ?>">
		<?php
	}

	/**
	 * Builds the wordcount settings field html.
	 */
	public function build_wordcount_settings_html() {
		?>
		<input type="checkbox" name="jrs-post-analytics-wordcount-enable" value="1" <?php checked( get_option( 'jrs-post-analytics-wordcount-enable' ), '1' ); ?>>
		<?php
	}

	/**
	 * Builds the character count settings field html.
	 */
	public function build_charactercount_settings_html() {
		?>
		<input type="checkbox" name="jrs-post-analytics-charactercount-enable" value="1" <?php checked( get_option( 'jrs-post-analytics-charactercount-enable' ), '1' ); ?>>
		<?php
	}

	/**
	 * Builds the read time settings field html.
	 */
	public function build_readtime_settings_html() {
		?>
		<input type="checkbox" name="jrs-post-analytics-readtime-enable" value="1" <?php checked( get_option( 'jrs-post-analytics-readtime-enable' ), '1' ); ?>>
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
		if (
			( is_main_query() && is_single() )
			&&
			( get_option( 'jrs-post-analytics-wordcount-enable', '1' ) || get_option( 'jrs-post-analytics-charactercount-enable', '1' ) || get_option( 'jrs-post-analytics-readtime-enable', '1' ) )
		) {
			return $this->add_post_analytics_to_content( $content );
		}
		return $content;
	}

	/**
	 * Builds the post analytics section and concatenates it to the beggining or end of the post.
	 *
	 * @param string $content Content of the current post.
	 */
	public function add_post_analytics_to_content( $content ) {
		// Adds a title.
		$html = '<h3>' . esc_html( get_option( 'jrs-post-analytics-headline-text', __( 'Post Analytics', 'jrs-post-analytics' ) ) ) . '</h3>';

		// Calculates the wordcount if needed.
		if ( get_option( 'jrs-post-analytics-wordcount-enable', '1' ) || get_option( 'jrs-post-analytics-readtime-enable', '1' ) ) {
			$word_count = str_word_count( wp_strip_all_tags( $content ) );
		}

		// Adds word count line.
		if ( get_option( 'jrs-post-analytics-wordcount-enable', '1' ) ) {

			$html .= $this->generate_wordcount( $word_count );

		}

		// Adds character count line.
		if ( get_option( 'jrs-post-analytics-charactercount-enable', '1' ) ) {

			$html .= $this->generate_charactercount( $content );

		}

		// Adds read time line.
		if ( get_option( 'jrs-post-analytics-readtime-enable', '1' ) ) {

			$html .= $this->generate_readtime( $word_count );

		}

		// Returns the content with the post analytics in the preferred location.
		if ( get_option( 'jrs-post-analytics-location', '0' ) === '0' ) {
			return $html . $content;
		}
		return $content . $html;
	}

	/**
	 * Generates the word count analytics line.
	 *
	 * @param integer $word_count word count of the content.
	 * @return string Formated string for analytics.
	 */
	public function generate_wordcount( $word_count ) {
		$html  = '<p>';
		$html .= sprintf(
			/* translators: %s: word count */
			__( 'This post has %s words.', 'jrs-post-analytics' ),
			$word_count
		);
		$html .= '</p>';

		return $html;
	}


	/**
	 * Generates the character count analytics line.
	 *
	 * @param integer $content content of the page.
	 * @return string Formated string for analytics.
	 */
	public function generate_charactercount( $content ) {
		$total_characters = strlen( wp_strip_all_tags( $content ) );

		$html  = '<p>';
		$html .= sprintf(
			/* translators: %s: characteres of the post */
			__( 'This post has %s characters.', 'jrs-post-analytics' ),
			$total_characters
		);
		$html .= '</p>';

		return $html;
	}

	/**
	 * Generates the read time analytics line.
	 *
	 * @param integer $word_count word count of the content.
	 * @return string Formated string for analytics.
	 */
	public function generate_readtime( $word_count ) {
		$aproximate_readtime = round( $word_count / 225 );

		$html  = '<p>';
		$html .= sprintf(
			/* translators: %s: aproximate read time */
			__( 'This post will take about %s minute(s) to read.', 'jrs-post-analytics' ),
			$aproximate_readtime
		);
		$html .= '</p>';

		return $html;
	}
}
