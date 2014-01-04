<?php
/**
 * Gamajo Dashboard Glancer, for WP 3.7 and earlier.
 *
 * @package   Portfolio_Post_Type
 * @author    Gary Jones
 * @link      http://gamajo.com/dashboard-glancer
 * @copyright 2013 Gary Jones, Gamajo Tech
 * @license   GPL-2.0+
 */

/**
 * Easily add items to the Right Now Dashboard widget in WordPress 3.7-.
 *
 * @package Gamajo_Dashboard_Glancer
 * @author  Gary Jones
 */
class Gamajo_Dashboard_RightNow extends Gamajo_Dashboard_Glancer {

	/**
	 * Automatically show any registered items.
	 *
	 * With this, there's no need to explicitly call show() during the dashboard_glance_items hook,
	 * and items can be registered at any time before dashboard_glance_items priority 20 (including on earlier hooks).
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'right_now_content_table_end', array( $this, 'show' ), 20 );
	}

	/**
	 * Build and return the data and markup for a single item.
	 *
	 * If the item count is zero, return an empty string, to avoid visual clutter.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $item Registered item.
	 *
	 * @return string Markup, or empty string if item count is zero.
	 */
	protected function get_single_item( array $item ) {
		$num_posts = wp_count_posts( $item['type'] );
		$count = $num_posts->$item['status'];

		if ( ! $count ) {
			return '';
		}

		$href  = $this->get_link_url( $item );
		$num   = $this->maybe_link( number_format_i18n( $count ), $href );
		$text  = $this->maybe_link( $this->get_label( $item, $count ), $href );
		return $this->get_markup( $num . '|' . $text, $item['type'] );
	}

	/**
	 * Wrap number and text within list item markup.
	 *
	 * @since 1.0.0
	 *
	 * @param string  $text   Text to display. May be wrapped in a link.
	 */
	protected function get_markup( $text, $post_type ) {
		$text_parts = explode( '|', $text );
		return '<tr>
			<td class="first b ' . sanitize_html_class( 'b-' . $post_type ) . '">' . $text_parts[0] . '</td>
			<td class="t ' . sanitize_html_class( $post_type ) . '">' . $text_parts[1] . '</td>
		</tr>';
	}
}
