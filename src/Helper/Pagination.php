<?php
namespace Never5\WPCarManager\Helper;

class Pagination {

	/**
	 * Generate pagination
	 *
	 * @param int $cur current page
	 * @param int $total total amount of pages
	 *
	 * @return string
	 */
	public static function generate( $cur, $total ) {

		$args = array(
			'total'              => $total,
			'current'            => $cur,
			'show_all'           => false,
			'prev_next'          => true,
			'prev_text'          => '&larr;',
			'next_text'          => '&rarr;',
			'end_size'           => 3,
			'mid_size'           => 3,
			'add_fragment'       => '',
			'before_page_number' => '',
			'after_page_number'  => ''
		);

		// Who knows what else people pass in $args
		$total = (int) $args['total'];
		if ( $total < 2 ) {
			return;
		}

		$current  = (int) $args['current'];
		$end_size = (int) $args['end_size']; // Out of bounds?  Make it the default.
		if ( $end_size < 1 ) {
			$end_size = 1;
		}
		$mid_size = (int) $args['mid_size'];
		if ( $mid_size < 0 ) {
			$mid_size = 2;
		}

		$r          = '';
		$page_links = array();
		$dots       = false;

		// prev link
		if ( $args['prev_next'] && $current && 1 < $current ) {
			$page_links[] = '<a class="prev page-numbers" href="javascript:;" data-page="prev">' . $args['prev_text'] . '</a>';
		}

		// the actual pagination links
		for ( $n = 1; $n <= $total; $n ++ ) {
			if ( $n == $current ) {
				$page_links[] = "<span class='page-numbers current'>" . $args['before_page_number'] . number_format_i18n( $n ) . $args['after_page_number'] . "</span>";
				$dots         = true;
			} else {
				if ( $args['show_all'] || ( $n <= $end_size || ( $current && $n >= $current - $mid_size && $n <= $current + $mid_size ) || $n > $total - $end_size ) ) {

					$page_links[] = "<a class='page-numbers' href='javascript:;' data-page='" . $n . "'>" . $args['before_page_number'] . number_format_i18n( $n ) . $args['after_page_number'] . "</a>";
					$dots         = true;
				} elseif ( $dots && ! $args['show_all'] ) {
					$page_links[] = '<span class="page-numbers dots">' . __( '&hellip;' ) . '</span>';
					$dots         = false;
				}
			}
		}

		// next link
		if ( $args['prev_next'] && $current && ( $current < $total || - 1 == $total ) ) {
			$page_links[] = '<a class="next page-numbers" href="javascript:;" data-page="next">' . $args['next_text'] . '</a>';
		}

		$r .= "<ul class='page-numbers'>\n\t<li>";
		$r .= join( "</li>\n\t<li>", $page_links );
		$r .= "</li>\n</ul>\n";

		return $r;
	}

	/**
	 * Calculate total pages
	 *
	 * @param int $per_page
	 * @param int $total_items
	 *
	 * @return int
	 */
	public static function calc_total_pages( $per_page, $total_items ) {
		return ceil( $total_items / $per_page );
	}
}