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
 * Version:     0.7.0
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

require plugin_dir_path( __FILE__ ) . 'includes/class-portfolio-post-type.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-portfolio-post-type-registrations.php';

// Instantiate registration class, so we can add it as a dependency to main plugin class.
$portfolio_post_type_registrations = new Portfolio_Post_Type_Registrations;

// Instantiate main plugin file, so activation callback does not need to be static.
$portfolio_post_type = new Portfolio_Post_Type( $portfolio_post_type_registrations );


// Register callback that is fired when the plugin is activated.
register_activation_hook( __FILE__, array( $portfolio_post_type, 'activate' ) );

// Initialise registrations for post-activation requests.
$portfolio_post_type_registrations->init();

if ( is_admin() ) {
	if ( ! class_exists( 'Gamajo_Dashboard_Glancer' ) ) {
		require plugin_dir_path( __FILE__ ) . 'includes/class-gamajo-dashboard-glancer.php';  // WP 3.8
	}
	if ( ! class_exists( 'Gamajo_Dashboard_RightNow' ) ) {
		require plugin_dir_path( __FILE__ ) . 'includes/class-gamajo-dashboard-rightnow.php'; // WP 3.7
	}
	require plugin_dir_path( __FILE__ ) . 'includes/class-portfolio-post-type-admin.php';
	$portfolio_post_type_admin = new Portfolio_Post_Type_Admin( $portfolio_post_type_registrations );
	$portfolio_post_type_admin->init();
} else {
	if ( apply_filters( 'portfolioposttype_add_taxonomy_terms_classes', true ) ) {
		if ( ! class_exists( 'Gamajo_Single_Entry_Term_Body_Classes' ) ) {
			require plugin_dir_path( __FILE__ ) . 'includes/class-gamajo-single-entry-term-body-classes.php';
		}
		$portfolio_post_type_body_classes = new Gamajo_Single_Entry_Term_Body_Classes;
		$portfolio_post_type_body_classes->init( 'portfolio' );
	}
}
