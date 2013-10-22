<?php
/**
 * Portfolio Post Type
 *
 * @package   Portfolio_Post_Type
 * @author    Devin Price
 * @license   GPL-2.0+
 * @link      http://wptheming.com/portfolio-post-type/
 * @copyright 2011-2013 Devin Price
 *
 * @wordpress-plugin
 * Plugin Name: Portfolio Post Type
 * Plugin URI:  http://wptheming.com/portfolio-post-type/
 * Description: Enables a portfolio post type and taxonomies.
 * Version:     0.6.1
 * Author:      Devin Price
 * Author URI:  http://www.wptheming.com/
 * Text Domain: portfolioposttype
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Portfolio_Post_Type' ) ) {
	require plugin_dir_path( __FILE__ ) . 'class-portfolio-post-type.php';
}

// Register callback that is fired when the plugin is activated.
register_activation_hook( __FILE__, array( 'Portfolio_Post_Type', 'activate' ) );

add_action( 'plugins_loaded', 'portfolio_post_type' );
/**
 * Instantiate classes.
 *
 * @since 0.7.0
 */
function portfolio_post_type() {
	$portfolio_post_type = new Portfolio_Post_Type;
	$portfolio_post_type->run();
}
