<?php
/**
 * Portfolio Post Type
 *
 * @package   PortfolioPostType
 * @author    Devin Price
 * @license   GPL-2.0+
 * @link      http://wptheming.com/portfolio-post-type/
 * @copyright 2011-2013 Devin Price
 *
 * @wordpress-plugin
 * Plugin Name: Portfolio Post Type
 * Plugin URI:  http://wptheming.com/portfolio-post-type/
 * Description: Enables a portfolio post type and taxonomies.
 * Version:     0.6.0
 * Author:      Devin Price
 * Author URI:  http://www.wptheming.com/
 * Text Domain: portfolioposttype
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 */

if ( ! class_exists( 'Portfolio_Post_Type' ) ) :

class Portfolio_Post_Type {

	public function __construct() {

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_textdomain' ) );

		// Run when the plugin is activated
		register_activation_hook( __FILE__, array( $this, 'plugin_activation' ) );

		// Add the portfolio post type and taxonomies
		add_action( 'init', array( $this, 'portfolio_init' ) );

		// Thumbnail support for portfolio posts
		add_theme_support( 'post-thumbnails', array( 'portfolio' ) );

		// Add thumbnails to column view
		add_filter( 'manage_edit-portfolio_columns', array( $this, 'add_thumbnail_column'), 10, 1 );
		add_action( 'manage_posts_custom_column', array( $this, 'display_thumbnail' ), 10, 1 );

		// Allow filtering of posts by taxonomy in the admin view
		add_action( 'restrict_manage_posts', array( $this, 'add_taxonomy_filters' ) );

		// Show portfolio post counts in the dashboard
		add_action( 'right_now_content_table_end', array( $this, 'add_portfolio_counts' ) );

		// Give the portfolio menu item a unique icon
		add_action( 'admin_head', array( $this, 'portfolio_icon' ) );

		// Add taxonomy terms as body classes
		add_filter( 'body_class', array( $this, 'add_body_classes' ) );
	}

	/**
	 * Load the plugin text domain for translation.
	 */
	public function load_textdomain() {

		$domain = 'portfolioposttype';
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, basename( dirname( __FILE__ ) ) . '/languages' );
	}

	/**
	 * Flushes rewrite rules on plugin activation to ensure portfolio posts don't 404.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/flush_rewrite_rules
	 *
	 * @uses Portfolio_Post_Type::portfolio_init()
	 */
	public function plugin_activation() {
		$this->load_plugin_textdomain();
		$this->portfolio_init();
		flush_rewrite_rules();
	}

	/**
	 * Initiate registrations of post type and taxonomies.
	 *
	 * @uses Portfolio_Post_Type::register_post_type()
	 * @uses Portfolio_Post_Type::register_taxonomy_tag()
	 * @uses Portfolio_Post_Type::register_taxonomy_category()
	 */
	public function portfolio_init() {
		$this->register_post_type();
		$this->register_taxonomy_category();
		$this->register_taxonomy_tag();
	}

	/**
	 * Get an array of all taxonomies this plugin handles.
	 *
	 * @return array Taxonomy slugs.
	 */
	protected function get_taxonomies() {
		return array( 'portfolio_category', 'portfolio_tag' );
	}

	/**
	 * Enable the Portfolio custom post type.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_post_type
	 */
	protected function register_post_type() {
		$labels = array(
			'name'               => __( 'Portfolio', 'portfolioposttype' ),
			'singular_name'      => __( 'Portfolio Item', 'portfolioposttype' ),
			'add_new'            => __( 'Add New Item', 'portfolioposttype' ),
			'add_new_item'       => __( 'Add New Portfolio Item', 'portfolioposttype' ),
			'edit_item'          => __( 'Edit Portfolio Item', 'portfolioposttype' ),
			'new_item'           => __( 'Add New Portfolio Item', 'portfolioposttype' ),
			'view_item'          => __( 'View Item', 'portfolioposttype' ),
			'search_items'       => __( 'Search Portfolio', 'portfolioposttype' ),
			'not_found'          => __( 'No portfolio items found', 'portfolioposttype' ),
			'not_found_in_trash' => __( 'No portfolio items found in trash', 'portfolioposttype' ),
		);

		$args = array(
			'labels'          => $labels,
			'public'          => true,
			'supports'        => array(
				'title',
				'editor',
				'excerpt',
				'thumbnail',
				'comments',
				'author',
				'custom-fields',
				'revisions',
			),
			'capability_type' => 'post',
			'rewrite'         => array( 'slug' => 'portfolio', ), // Permalinks format
			'menu_position'   => 5,
			'has_archive'     => true,
		);

		$args = apply_filters( 'portfolioposttype_args', $args );

		register_post_type( 'portfolio', $args );
	}

	/**
	 * Register a taxonomy for Portfolio Tags.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
	 */
	protected function register_taxonomy_tag() {
		$labels = array(
			'name'                       => __( 'Portfolio Tags', 'portfolioposttype' ),
			'singular_name'              => __( 'Portfolio Tag', 'portfolioposttype' ),
			'menu_name'                  => __( 'Portfolio Tags', 'portfolioposttype' ),
			'edit_item'                  => __( 'Edit Portfolio Tag', 'portfolioposttype' ),
			'update_item'                => __( 'Update Portfolio Tag', 'portfolioposttype' ),
			'add_new_item'               => __( 'Add New Portfolio Tag', 'portfolioposttype' ),
			'new_item_name'              => __( 'New Portfolio Tag Name', 'portfolioposttype' ),
			'parent_item'                => __( 'Parent Portfolio Tag', 'portfolioposttype' ),
			'parent_item_colon'          => __( 'Parent Portfolio Tag:', 'portfolioposttype' ),
			'all_items'                  => __( 'All Portfolio Tags', 'portfolioposttype' ),
			'search_items'               => __( 'Search Portfolio Tags', 'portfolioposttype' ),
			'popular_items'              => __( 'Popular Portfolio Tags', 'portfolioposttype' ),
			'separate_items_with_commas' => __( 'Separate portfolio tags with commas', 'portfolioposttype' ),
			'add_or_remove_items'        => __( 'Add or remove portfolio tags', 'portfolioposttype' ),
			'choose_from_most_used'      => __( 'Choose from the most used portfolio tags', 'portfolioposttype' ),
			'not_found'                  => __( 'No portfolio tags found.', 'portfolioposttype' ),
		);

		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_ui'           => true,
			'show_tagcloud'     => true,
			'hierarchical'      => false,
			'rewrite'           => array( 'slug' => 'portfolio_tag' ),
			'show_admin_column' => true,
			'query_var'         => true,
		);

		$args = apply_filters( 'portfolioposttype_tag_args', $args );

		register_taxonomy( 'portfolio_tag', array( 'portfolio' ), $args );

	}

	/**
	 * Register a taxonomy for Portfolio Categories.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
	 */
	protected function register_taxonomy_category() {
		$labels = array(
			'name'                       => __( 'Portfolio Categories', 'portfolioposttype' ),
			'singular_name'              => __( 'Portfolio Category', 'portfolioposttype' ),
			'menu_name'                  => __( 'Portfolio Categories', 'portfolioposttype' ),
			'edit_item'                  => __( 'Edit Portfolio Category', 'portfolioposttype' ),
			'update_item'                => __( 'Update Portfolio Category', 'portfolioposttype' ),
			'add_new_item'               => __( 'Add New Portfolio Category', 'portfolioposttype' ),
			'new_item_name'              => __( 'New Portfolio Category Name', 'portfolioposttype' ),
			'parent_item'                => __( 'Parent Portfolio Category', 'portfolioposttype' ),
			'parent_item_colon'          => __( 'Parent Portfolio Category:', 'portfolioposttype' ),
			'all_items'                  => __( 'All Portfolio Categories', 'portfolioposttype' ),
			'search_items'               => __( 'Search Portfolio Categories', 'portfolioposttype' ),
			'popular_items'              => __( 'Popular Portfolio Categories', 'portfolioposttype' ),
			'separate_items_with_commas' => __( 'Separate portfolio categories with commas', 'portfolioposttype' ),
			'add_or_remove_items'        => __( 'Add or remove portfolio categories', 'portfolioposttype' ),
			'choose_from_most_used'      => __( 'Choose from the most used portfolio categories', 'portfolioposttype' ),
			'not_found'                  => __( 'No portfolio categories found.', 'portfolioposttype' ),
		);

		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_ui'           => true,
			'show_tagcloud'     => true,
			'hierarchical'      => true,
			'rewrite'           => array( 'slug' => 'portfolio_category' ),
			'show_admin_column' => true,
			'query_var'         => true,
		);

		$args = apply_filters( 'portfolioposttype_category_args', $args );

		register_taxonomy( 'portfolio_category', array( 'portfolio' ), $args );
	}

	/**
	 * Add taxonomy terms as body classes.
	 *
	 * If the taxonomy doesn't exist (has been unregistered), then get_the_terms() returns WP_Error, which is checked
	 * for before adding classes.
	 *
	 * @param array $classes Existing body classes.
	 *
	 * @return array Amended body classes.
	 */
	public function add_body_classes( $classes ) {
		$taxonomies = $this->get_taxonomies();

		foreach( $taxonomies as $taxonomy ) {
			$terms = get_the_terms( get_the_ID(), $taxonomy );
			if ( $terms && ! is_wp_error( $terms ) ) {
				foreach( $terms as $term ) {
					$classes[] = sanitize_html_class( str_replace( '_', '-', $taxonomy ) . '-' . $term->slug );
				}
			}
		}

		return $classes;
	}

	/**
	 * Add columns to Portfolio list screen.
	 *
	 * @link http://wptheming.com/2010/07/column-edit-pages/
	 *
	 * @param array $columns Existing columns.
	 *
	 * @return array Amended columns.
	 */
	public function add_thumbnail_column( $columns ) {
		$column_thumbnail = array( 'thumbnail' => __( 'Thumbnail', 'portfolioposttype' ) );
		return array_slice( $columns, 0, 2, true ) + $column_thumbnail + array_slice( $columns, 1, null, true );
	}

	/**
	 * Custom column callback
	 *
	 * @global stdClass $post Post object.
	 *
	 * @param string $column Column ID.
	 */
	public function display_thumbnail( $column ) {
		global $post;
		switch ( $column ) {
			case 'thumbnail':
				echo get_the_post_thumbnail( $post->ID, array(35, 35) );
				break;
		}
	}

	/**
	 * Add taxonomy filters to the portfolio admin page.
	 *
	 * Code artfully lifted from http://pippinsplugins.com/
	 *
	 * @global string $typenow
	 */
	public function add_taxonomy_filters() {
		global $typenow;

		// An array of all the taxonomies you want to display. Use the taxonomy name or slug
		$taxonomies = $this->get_taxonomies();

		// Must set this to the post type you want the filter(s) displayed on
		if ( 'portfolio' != $typenow ) {
			return;
		}

		foreach ( $taxonomies as $tax_slug ) {
			$current_tax_slug = isset( $_GET[$tax_slug] ) ? $_GET[$tax_slug] : false;
			$tax_obj          = get_taxonomy( $tax_slug );
			$tax_name         = $tax_obj->labels->name;
			$terms            = get_terms( $tax_slug );
			if ( 0 == count( $terms ) ) {
				return;
			}
			echo '<select name="' . esc_attr( $tax_slug ) . '" id="' . esc_attr( $tax_slug ) . '" class="postform">';
			echo '<option>' . esc_html( $tax_name ) .'</option>';
			foreach ( $terms as $term ) {
				printf(
					'<option value="%s"%s />%s</option>',
					esc_attr( $term->slug ),
					selected( $current_tax_slug, $term->slug ),
					esc_html( $term->name . '(' . $term->count . ')' )
				);
			}
			echo '</select>';
		}
	}

	/**
	 * Add Portfolio count to "Right Now" dashboard widget.
	 *
	 * @return null Return early if portfolio post type does not exist.
	 */
	public function add_portfolio_counts() {
		if ( ! post_type_exists( 'portfolio' ) ) {
			return;
		}

		$num_posts = wp_count_posts( 'portfolio' );

		// Published items
		$href = 'edit.php?post_type=portfolio';
		$num  = number_format_i18n( $num_posts->publish );
		$num  = $this->link_if_can_edit_posts( $num, $href );
		$text = _n( 'Portfolio Item', 'Portfolio Items', intval( $num_posts->publish ) );
		$text = $this->link_if_can_edit_posts( $text, $href );
		$this->display_dashboard_count( $num, $text );

		if ( 0 == $num_posts->pending ) {
			return;
		}

		// Pending items
		$href = 'edit.php?post_status=pending&amp;post_type=portfolio';
		$num  = number_format_i18n( $num_posts->pending );
		$num  = $this->link_if_can_edit_posts( $num, $href );
		$text = _n( 'Portfolio Item Pending', 'Portfolio Items Pending', intval( $num_posts->pending ) );
		$text = $this->link_if_can_edit_posts( $text, $href );
		$this->display_dashboard_count( $num, $text );
	}

	/**
	 * Wrap a dashboard number or text value in a link, if the current user can edit posts.
	 *
	 * @param  string $value Value to potentially wrap in a link.
	 * @param  string $href  Link target.
	 *
	 * @return string        Value wrapped in a link if current user can edit posts, or original value otherwise.
	 */
	protected function link_if_can_edit_posts( $value, $href ) {
		if ( current_user_can( 'edit_posts' ) ) {
			return '<a href="' . esc_url( $href ) . '">' . $value . '</a>';
		}
		return $value;
	}

	/**
	 * Display a number and text with table row and cell markup for the dashboard counters.
	 *
	 * @param  string $number Number to display. May be wrapped in a link.
	 * @param  string $label  Text to display. May be wrapped in a link.
	 */
	protected function display_dashboard_count( $number, $label ) {
		?>
		<tr>
			<td class="first b b-portfolio"><?php echo $number; ?></td>
			<td class="t portfolio"><?php echo $label; ?></td>
		</tr>
		<?php
	}

	/**
	 * Display the custom post type icon in the dashboard.
	 */
	public function portfolio_icon() {
		$plugin_dir_url = plugin_dir_url( __FILE__ );
		?>
		<style>
			#menu-posts-portfolio .wp-menu-image {
				background: url(<?php echo $plugin_dir_url; ?>images/portfolio-icon.png) no-repeat 6px 6px !important;
			}
			#menu-posts-portfolio:hover .wp-menu-image, #menu-posts-portfolio.wp-has-current-submenu .wp-menu-image {
				background-position: 6px -16px !important;
			}
			#icon-edit.icon32-posts-portfolio {
				background: url(<?php echo $plugin_dir_url; ?>images/portfolio-32x32.png) no-repeat;
			}
		</style>
		<?php
	}

}

new Portfolio_Post_Type;

endif;
