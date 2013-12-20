<?php
/**
 * Portfolio Post Type
 *
 * @package   Portfolio_Post_Type
 * @author    Devin Price
 * @author    Gary Jones
 * @license   GPL-2.0+
 * @link      http://wptheming.com/portfolio-post-type/
 * @copyright 2011-2013 Devin Price
 */

/**
 * Register post types and taxonomies.
 *
 * @package Portfolio_Post_Type
 * @author  Devin Price
 * @author  Gary Jones
 */
class Portfolio_Post_Type_Admin {

	protected $registration_handler;

	public function __construct( $registration_handler ) {
		$this->registration_handler = $registration_handler;
	}

	public function init() {

		// Add thumbnail support for this post type
		add_theme_support( 'post-thumbnails', $this->registration_handler->post_type );

		// Add thumbnails to column view
		add_filter( 'manage_edit-' . $this->registration_handler->post_type . '_columns', array( $this, 'add_thumbnail_column'), 10, 1 );
		add_action( 'manage_posts_custom_column', array( $this, 'display_thumbnail' ), 10, 1 );

		// Allow filtering of posts by taxonomy in the admin view
		add_action( 'restrict_manage_posts', array( $this, 'add_taxonomy_filters' ) );

		// Show post counts in the dashboard
		add_action( 'right_now_content_table_end', array( $this, 'add_right_now_counts' ) );

		// Give the post type menu item a unique icon
		add_action( 'admin_head', array( $this, 'add_icon' ) );

	}

	/**
	 * Add columns to post type list screen.
	 *
	 * @link http://wptheming.com/2010/07/column-edit-pages/
	 *
	 * @param array $columns Existing columns.
	 *
	 * @return array Amended columns.
	 */
	public function add_thumbnail_column( $columns ) {
		$column_thumbnail = array( 'thumbnail' => __( 'Thumbnail', 'portfolio-post-type' ) );
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

		// global $post;
		switch ( $column ) {
			case 'thumbnail':
				// echo get_the_post_thumbnail( $post->ID, array(35, 35) );
				echo get_the_post_thumbnail( get_the_ID(), array( 35, 35 ) );
				break;
		}
	}

	/**
	 * Add taxonomy filters to the post type list page.
	 *
	 * Code artfully lifted from http://pippinsplugins.com/
	 *
	 * @global string $typenow
	 */
	public function add_taxonomy_filters() {
		global $typenow;

		// Must set this to the post type you want the filter(s) displayed on
		if ( $this->registration_handler->post_type !== $typenow ) {
			return;
		}

		foreach ( $this->registration_handler->taxonomies as $tax_slug ) {
			echo $this->build_taxonomy_filter( $tax_slug );
		}
	}

	/**
	 * Build an individual dropdown filter.
	 *
	 * @param  string $tax_slug Taxonomy slug to build filter for.
	 *
	 * @return string Markup, or empty string if taxonomy has no terms.
	 */
	protected function build_taxonomy_filter( $tax_slug ) {
		$terms = get_terms( $tax_slug );
		if ( 0 == count( $terms ) ) {
			return '';
		}

		$tax_name         = $this->get_taxonomy_name_from_slug( $tax_slug );
		$current_tax_slug = isset( $_GET[$tax_slug] ) ? $_GET[$tax_slug] : false;

		$filter  = '<select name="' . esc_attr( $tax_slug ) . '" id="' . esc_attr( $tax_slug ) . '" class="postform">';
		$filter .= '<option value="0">' . esc_html( $tax_name ) .'</option>';
		$filter .= $this->build_term_options( $terms, $current_tax_slug );
		$filter .= '</select>';

		return $filter;
	}

	/**
	 * Get the friendly taxonomy name, if given a taxonomy slug.
	 *
	 * @param  string $tax_slug Taxonomy slug.
	 *
	 * @return string Friendly name of taxonomy, or empty string if not a valid taxonomy.
	 */
	protected function get_taxonomy_name_from_slug( $tax_slug ) {
		$tax_obj = get_taxonomy( $tax_slug );
		if ( ! $tax_obj )
			return '';
		return $tax_obj->labels->name;
	}

	/**
	 * Build a series of option elements from an array.
	 *
	 * Also checks to see if one of the options is selected.
	 *
	 * @param  array  $terms            Array of term objects.
	 * @param  string $current_tax_slug Slug of currently selected term.
	 *
	 * @return string Markup.
	 */
	protected function build_term_options( $terms, $current_tax_slug ) {
		$options = '';
		foreach ( $terms as $term ) {
			$options .= sprintf(
				'<option value="%s"%s />%s</option>',
				esc_attr( $term->slug ),
				selected( $current_tax_slug, $term->slug ),
				esc_html( $term->name . '(' . $term->count . ')' )
			);
		}
		return $options;
	}

	/**
	 * Add counts to "Right Now" dashboard widget.
	 *
	 * @return null Return early if post type does not exist.
	 */
	public function add_right_now_counts() {
		if ( ! post_type_exists( $this->registration_handler->post_type ) ) {
			return;
		}

		$labels = array(
			'published' => _n_noop( 'Portfolio Item', 'Portfolio Items', 'portfolio-post-type' ),
			'pending'   => _n_noop( 'Portfolio Item Pending', 'Portfolio Items Pending', 'portfolio-post-type' ),
		);

		$num_posts = wp_count_posts( $this->registration_handler->post_type );

		// Published items
		$href = 'edit.php?post_type=' . $this->registration_handler->post_type;
		$num  = number_format_i18n( $num_posts->publish );
		$num  = $this->link_if_can_edit_posts( $num, $href );
		$text = translate_nooped_plural( $labels['published'], intval( $num_posts->publish ) );
		$text = $this->link_if_can_edit_posts( $text, $href );
		$this->display_dashboard_count( $num, $text );

		if ( 0 == $num_posts->pending ) {
			return;
		}

		// Pending items
		$href = 'edit.php?post_status=pending&amp;post_type=' . $this->registration_handler->post_type;
		$num  = number_format_i18n( $num_posts->pending );
		$num  = $this->link_if_can_edit_posts( $num, $href );
		$text = translate_nooped_plural( $labels['pending'], intval( $num_posts->pending ) );
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
			<td class="first b <?php echo sanitize_html_class( 'b-' . $this->registration_handler->post_type ); ?>"><?php echo $number; ?></td>
			<td class="t <?php echo sanitize_html_class( $this->registration_handler->post_type ); ?>"><?php echo $label; ?></td>
		</tr>
		<?php
	}

	/**
	 * Display the custom post type icon in the dashboard.
	 */
	public function add_icon() {
		$plugin_dir_url = plugin_dir_url( dirname(__FILE__) );
		if ( version_compare( $GLOBALS['wp_version'], '3.8-alpha', '<' ) ) { ?>
			<style>
				#menu-posts-<?php echo $this->registration_handler->post_type; ?> .wp-menu-image {
					background: url(<?php echo $plugin_dir_url; ?>images/portfolio-icon.png) no-repeat 6px 6px !important;
				}
				#menu-posts-<?php echo $this->registration_handler->post_type; ?>:hover .wp-menu-image,
				#menu-posts-<?php echo $this->registration_handler->post_type; ?>.wp-has-current-submenu .wp-menu-image {
					background-position: 6px -16px !important;
				}
				#icon-edit.icon32-posts-<?php echo $this->registration_handler->post_type; ?> {
					background: url(<?php echo $plugin_dir_url; ?>images/portfolio-32x32.png) no-repeat;
				}
			</style>
		<?php } else { ?>
			<style>
				#adminmenu .menu-icon-portfolio div.wp-menu-image:before {
					content:'\f322'
				}
			</style>
		<?php }
	}

}
