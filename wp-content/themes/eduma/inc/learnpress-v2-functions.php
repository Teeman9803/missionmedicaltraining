<?php
/**
 * Custom functions for LearnPress 2.x
 *
 * @package thim
 */

if ( !function_exists( 'thim_learnpress_page_title' ) ) {
	function thim_learnpress_page_title() {
		if ( get_post_type() == 'lp_course' && !is_404() && !is_search() ) {
			if ( is_tax() ) {
				echo single_term_title( '', false );
			} else {
				echo esc_html__( 'All Courses', 'eduma' );
			}
		}
		if ( get_post_type() == 'lp_quiz' && !is_404() && !is_search() ) {
			if ( is_tax() ) {
				echo single_term_title( '', false );
			} else {
				echo esc_html__( 'Quiz', 'eduma' );
			}
		}
	}
}

if ( !function_exists( 'thim_learnpress_breadcrumb' ) ) {
	function thim_learnpress_breadcrumb() {
		return;
	}
}

/**
 * Display co instructors
 *
 * @param $course_id
 */
if ( !function_exists( 'thim_co_instructors' ) ) {
	function thim_co_instructors( $course_id, $author_id ) {
		return;
	}
}