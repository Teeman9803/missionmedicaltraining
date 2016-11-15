<?php

defined( 'DS' ) OR define( 'DS', DIRECTORY_SEPARATOR );

$thim_uri_data = THIM_URI . 'inc/admin/data/';

$thim_theme_options = get_theme_mods();

$demo_datas_dir = THIM_DIR . 'inc' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'data';

if ( class_exists( 'Vc_Manager' ) && isset( $thim_theme_options['thim_page_builder_chosen'] ) && $thim_theme_options['thim_page_builder_chosen'] === 'visual_composer' ) {
	$demo_datas_dir = THIM_DIR . 'inc' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'data-vc';
}

$demo_datas = array(
	'demo-01'               => array(
		'data_dir'      => $demo_datas_dir . DS . 'demo-01',
		'thumbnail_url' => $thim_uri_data . 'demo-01/screenshot.jpg',
		'title'         => esc_html__( 'Demo 01', 'eduma' ),
		'demo_url'      => 'http://educationwp.thimpress.com',
	),
	'demo-02'               => array(
		'data_dir'      => $demo_datas_dir . DS . 'demo-02',
		'thumbnail_url' => $thim_uri_data . 'demo-02/screenshot.jpg',
		'title'         => esc_html__( 'Demo 02', 'eduma' ),
		'demo_url'      => 'http://educationwp.thimpress.com/demo-2/',
	),
	'demo-03'               => array(
		'data_dir'      => $demo_datas_dir . DS . 'demo-03',
		'thumbnail_url' => $thim_uri_data . 'demo-03/screenshot.jpg',
		'title'         => esc_html__( 'Demo 03', 'eduma' ),
		'demo_url'      => 'http://educationwp.thimpress.com/demo-3/',
	),
	'demo-one-course'       => array(
		'data_dir'      => $demo_datas_dir . DS . 'demo-one-course',
		'thumbnail_url' => $thim_uri_data . 'demo-one-course/screenshot.jpg',
		'title'         => esc_html__( 'Demo One Course', 'eduma' ),
		'demo_url'      => 'http://educationwp.thimpress.com/demo-one-course/',
	),
	'demo-one-instructor'   => array(
		'data_dir'      => $demo_datas_dir . DS . 'demo-one-instructor',
		'thumbnail_url' => $thim_uri_data . 'demo-one-instructor/screenshot.jpg',
		'title'         => esc_html__( 'Demo One Instructor', 'eduma' ),
		'demo_url'      => 'http://educationwp.thimpress.com/demo-one-instructor/',
	),
	'demo-university'       => array(
		'data_dir'      => $demo_datas_dir . DS . 'demo-university',
		'thumbnail_url' => $thim_uri_data . 'demo-university/screenshot.jpg',
		'title'         => esc_html__( 'Demo University 1', 'eduma' ),
		'demo_url'      => 'http://educationwp.thimpress.com/demo-university/',
	),
	'demo-university-2'     => array(
		'data_dir'      => $demo_datas_dir . DS . 'demo-university-2',
		'thumbnail_url' => $thim_uri_data . 'demo-university-2/screenshot.jpg',
		'title'         => esc_html__( 'Demo University 2', 'eduma' ),
		'demo_url'      => 'http://educationwp.thimpress.com/demo-university-2/',
	),
	'demo-languages-school' => array(
		'data_dir'      => $demo_datas_dir . DS . 'demo-languages-school',
		'thumbnail_url' => $thim_uri_data . 'demo-languages-school/screenshot.jpg',
		'title'         => esc_html__( 'Demo Languages School', 'eduma' ),
		'demo_url'      => 'http://educationwp.thimpress.com/demo-languages-school/',
	),
	'demo-courses-hub'      => array(
		'data_dir'      => $demo_datas_dir . DS . 'demo-courses-hub',
		'thumbnail_url' => $thim_uri_data . 'demo-courses-hub/screenshot.jpg',
		'title'         => esc_html__( 'Demo Courses Hub', 'eduma' ),
		'demo_url'      => 'http://educationwp.thimpress.com/demo-courses-hub/',
	),
	'demo-kindergarten'      => array(
		'data_dir'      => $demo_datas_dir . DS . 'demo-kindergarten',
		'thumbnail_url' => $thim_uri_data . 'demo-kindergarten/screenshot.jpg',
		'title'         => esc_html__( 'Demo Kindergarten', 'eduma' ),
		'demo_url'      => 'http://educationwp.thimpress.com/demo-kindergarten/',
	),
	'demo-boxed'            => array(
		'data_dir'      => $demo_datas_dir . DS . 'demo-boxed',
		'thumbnail_url' => $thim_uri_data . 'demo-boxed/screenshot.jpg',
		'title'         => esc_html__( 'Demo Boxed', 'eduma' ),
		'demo_url'      => 'http://educationwp.thimpress.com/demo-boxed/',
	),
	'demo-rtl'              => array(
		'data_dir'      => $demo_datas_dir . DS . 'demo-rtl',
		'thumbnail_url' => $thim_uri_data . 'demo-rtl/screenshot.jpg',
		'title'         => esc_html__( 'Demo RTL', 'eduma' ),
		'demo_url'      => 'http://educationwp.thimpress.com/demo-rtl/',
	),
);