<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Shortcode Heading
 *
 * @param $atts
 *
 * @return string
 */
function thim_shortcode_one_course_instructors( $atts ) {

	$instance = shortcode_atts( array(
		'visible_item'    => '3',
		'show_pagination' => true,
		'auto_play'       => '0',
	), $atts );


	$args                 = array();
	$args['before_title'] = '<h3 class="widget-title">';
	$args['after_title']  = '</h3>';

	$widget_template       = THIM_DIR . 'inc/widgets/one-course-instructors/tpl/base-v1.php';
	$child_widget_template = THIM_CHILD_THEME_DIR . 'inc/widgets/one-course-instructors/base-v1.php';
	if ( file_exists( $child_widget_template ) ) {
		$widget_template = $child_widget_template;
	}

	ob_start();
	echo '<div class="thim-widget-one-course-instructors">';
	include $widget_template ;
	echo '</div>';
	$html_output = ob_get_contents();
	ob_end_clean();

	return $html_output;
}

add_shortcode( 'thim-one-course-instructors', 'thim_shortcode_one_course_instructors' );


