<?php
/**
 * JRS Post Analytics
 *
 * @package           JRS\Post_Analytics
 * @author            Julián Ramos Souza
 * @copyright         2025 Julián Ramos Souza
 * @license           GPLv3
 *
 * @wordpless-plugin
 * Plugin Name:       JRS Post Analytics
 * Plugin URI:        https://github.com/julianrasou/jrs-post-analytics
 * Description:       Displays post analytics (word count, character count, reading time) at the beggining or end of your posts
 * Version:           1.0.0
 * Requires at least: 5.0
 * Requires PHP:      7.4
 * Author:            Julián Ramos Souza
 * Author URI:        https://github.com/julianrasou
 * Text Domain:       jrs-post-analytics
 * License:           GPLv3
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 */

// Avoids direct file acces if ABSPATH global is not defined.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'You shall not pass!' );
}

/**
 * Requires the class that contains the plugin's functionalities.
 */
require_once plugin_dir_path( __FILE__ ) . '/class-jrs-post-analytics.php';

new Jrs_Post_Analytics();
