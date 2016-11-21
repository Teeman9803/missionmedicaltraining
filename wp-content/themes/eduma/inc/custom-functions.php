<?php

/**
 * Animation
 *
 * @param $css_animation
 *
 * @return string
 */
function thim_getCSSAnimation( $css_animation ) {
	$output = '';
	if ( $css_animation != '' ) {
		wp_enqueue_script( 'thim-waypoints' );
		$output = ' wpb_animate_when_almost_visible wpb_' . $css_animation;
	}

	return $output;
}

/**
 * Custom excerpt
 *
 * @param $limit
 *
 * @return array|mixed|string|void
 */
function thim_excerpt( $limit ) {
	$excerpt = explode( ' ', get_the_excerpt(), $limit );
	if ( count( $excerpt ) >= $limit ) {
		array_pop( $excerpt );
		$excerpt = implode( " ", $excerpt ) . '...';
	} else {
		$excerpt = implode( " ", $excerpt );
	}
	$excerpt = preg_replace( '`\[[^\]]*\]`', '', $excerpt );

	return '<p>' . $excerpt . '</p>';
}

/**
 * Display breadcrumbs
 */
if ( !function_exists( 'thim_breadcrumbs' ) ) {
	function thim_breadcrumbs() {

		// Do not display on the homepage
		if ( is_front_page() || is_404() ) {
			return;
		}

		// Get the query & post information
		global $post;
		$categories = get_the_category();

		// Build the breadcrums
		echo '<ul itemprop="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList" id="breadcrumbs" class="breadcrumbs">';


		// Home page
		echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_html( get_home_url() ) . '" title="' . esc_attr__( 'Home', 'eduma' ) . '"><span itemprop="name">' . esc_html__( 'Home', 'eduma' ) . '</span></a></li>';

		if ( is_home() ) {
			echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr( get_the_title() ) . '">' . esc_html__( 'Blog', 'eduma' ) . '</span></li>';
		}

		if ( is_single() ) {
			if ( get_post_type() == 'tp_event' ) {
				echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_post_type_archive_link( 'tp_event' ) ) . '" title="' . esc_attr__( 'Events', 'eduma' ) . '"><span itemprop="name">' . esc_html__( 'Events', 'eduma' ) . '</span></a></li>';
			}
			// Single post (Only display the first category)
			if ( isset( $categories[0] ) ) {
			// Updated to fix for blog entries - need better fix
				echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' .  get_site_url()  . '/blog" title="Blog"><span itemprop="name">' . esc_html__( 'Blog', 'eduma' ) . '</span></a></li>';
			}
			echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr( get_the_title() ) . '">' . esc_html( get_the_title() ) . '</span></li>';

		} else if ( is_category() ) {

			// Category page
			echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">' . esc_html( $categories[0]->cat_name ) . '</span></li>';

		} else if ( is_page() ) {

			// Standard page
			if ( $post->post_parent ) {

				// If child page, get parents
				$anc = get_post_ancestors( $post->ID );

				// Get parents in the right order
				$anc = array_reverse( $anc );

				// Parent page loop
				foreach ( $anc as $ancestor ) {
					echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_permalink( $ancestor ) ) . '" title="' . esc_attr( get_the_title( $ancestor ) ) . '"><span itemprop="name">' . esc_html( get_the_title( $ancestor ) ) . '</span></a></li>';
				}
			}

			// Current page
			echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr( get_the_title() ) . '"> ' . esc_html( get_the_title() ) . '</span></li>';


		} else if ( is_tag() ) {

			// Display the tag name
			echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr( single_term_title( '', false ) ) . '">' . esc_html( single_term_title( '', false ) ) . '</span></li>';

		} elseif ( is_day() ) {

			// Day archive

			// Year link
			echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '" title="' . esc_attr( get_the_time( 'Y' ) ) . '"><span itemprop="name">' . esc_html( get_the_time( 'Y' ) ) . ' ' . esc_html__( 'Archives', 'eduma' ) . '</span></a></li>';

			// Month link
			echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) ) . '" title="' . esc_attr( get_the_time( 'M' ) ) . '"><span itemprop="name">' . esc_html( get_the_time( 'M' ) ) . ' ' . esc_html__( 'Archives', 'eduma' ) . '</span></a></li>';

			// Day display
			echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr( get_the_time( 'jS' ) ) . '"> ' . esc_html( get_the_time( 'jS' ) ) . ' ' . esc_html( get_the_time( 'M' ) ) . ' ' . esc_html__( 'Archives', 'eduma' ) . '</span></li>';

		} else if ( is_month() ) {

			// Month Archive

			// Year link
			echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '" title="' . esc_attr( get_the_time( 'Y' ) ) . '"><span itemprop="name">' . esc_html( get_the_time( 'Y' ) ) . ' ' . esc_html__( 'Archives', 'eduma' ) . '</span></a></li>';

			// Month display
			echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr( get_the_time( 'M' ) ) . '">' . esc_html( get_the_time( 'M' ) ) . ' ' . esc_html__( 'Archives', 'eduma' ) . '</span></li>';

		} else if ( is_year() ) {

			// Display year archive
			echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr( get_the_time( 'Y' ) ) . '">' . esc_html( get_the_time( 'Y' ) ) . ' ' . esc_html__( 'Archives', 'eduma' ) . '</span></li>';

		} else if ( is_author() ) {

			// Auhor archive

			// Get the author information
			global $author;
			$userdata = get_userdata( $author );

			// Display author name
			echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr( $userdata->display_name ) . '">' . esc_attr__( 'Author', 'eduma' ) . ' ' . esc_html( $userdata->display_name ) . '</span></li>';

		} else if ( get_query_var( 'paged' ) ) {

			// Paginated archives
			echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr__( 'Page', 'eduma' ) . ' ' . get_query_var( 'paged' ) . '">' . esc_html__( 'Page', 'eduma' ) . ' ' . esc_html( get_query_var( 'paged' ) ) . '</span></li>';

		} else if ( is_search() ) {

			// Search results page
			echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr__( 'Search results for:', 'eduma' ) . ' ' . esc_attr( get_search_query() ) . '">' . esc_html__( 'Search results for:', 'eduma' ) . ' ' . esc_html( get_search_query() ) . '</span></li>';

		} elseif ( is_404() ) {
			// 404 page
			echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr__( '404 Page', 'eduma' ) . '">' . esc_html__( '404 Page', 'eduma' ) . '</span></li>';
		} elseif ( is_archive() ) {
			if ( get_post_type() == "tp_event" ) {
				echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr__( 'Events', 'eduma' ) . '">' . esc_html__( 'Events', 'eduma' ) . '</span></li>';
			}
		}

		echo '</ul>';
	}
}

/**
 * Get related posts
 *
 * @param     $post_id
 * @param int $number_posts
 *
 * @return WP_Query
 */
function thim_get_related_posts( $post_id, $number_posts = - 1 ) {
	$query = new WP_Query();
	$args  = '';
	if ( $number_posts == 0 ) {
		return $query;
	}
	$args  = wp_parse_args( $args, array(
		'posts_per_page'      => $number_posts,
		'post__not_in'        => array( $post_id ),
		'ignore_sticky_posts' => 0,
		'meta_key'            => '_thumbnail_id',
		'category__in'        => wp_get_post_categories( $post_id )
	) );
	$query = new WP_Query( $args );

	return $query;
}

// bbPress
function thim_use_bbpress() {
	if ( function_exists( 'is_bbpress' ) ) {
		return is_bbpress();
	} else {
		return false;
	}
}

/************ List Comment ***************/
if ( !function_exists( 'thim_comment' ) ) {
	function thim_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		//extract( $args, EXTR_SKIP );
		if ( 'div' == $args['style'] ) {
			$tag       = 'div';
			$add_below = 'comment';
		} else {
			$tag       = 'li';
			$add_below = 'div-comment';
		}
		?>
		<<?php echo ent2ncr( $tag . ' ' ) ?><?php comment_class( 'description_comment' ) ?>>
		<div class="wrapper-comment">
			<?php
			if ( $args['avatar_size'] != 0 ) {
				echo '<div class="avatar">';
				echo get_avatar( $comment, $args['avatar_size'] );
				echo '</div>';
			}
			?>
			<div class="comment-right">
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'eduma' ) ?></em>
				<?php endif; ?>

				<div class="comment-extra-info">
					<div
						class="author"><span class="author-name"><?php echo get_comment_author_link(); ?></span></div>
					<div class="date" itemprop="commentTime">
						<?php printf( get_comment_date(), get_comment_time() ) ?></div>
					<?php edit_comment_link( esc_html__( 'Edit', 'eduma' ), '', '' ); ?>
					<?php comment_reply_link( array_merge( $args, array(
						'add_below' => $add_below,
						'depth'     => $depth,
						'max_depth' => $args['max_depth']
					) ) )
					?>
				</div>

				<div class="content-comment">
					<?php comment_text() ?>
				</div>

				<div class="comment-meta" id="div-comment-<?php comment_ID() ?>">

				</div>
			</div>
		</div>
		<?php
	}
}

// dislay setting layout
require THIM_DIR . 'inc/wrapper-before-after.php';

/**
 * @param $mtb_setting
 *
 * @return mixed
 */
function thim_mtb_setting_after_created( $mtb_setting ) {
	$mtb_setting->removeOption( array( 11 ) );
	$option_name_space = $mtb_setting->owner->optionNamespace;

	$settings   = array(
		'name'      => esc_html__( 'Color Sub Title', 'eduma' ),
		'id'        => 'mtb_color_sub_title',
		'type'      => 'color-opacity',
		'desc'      => ' ',
		'row_class' => 'child_of_' . $option_name_space . '_mtb_using_custom_heading thim_sub_option',
	);
	$settings_1 = array(
		'name' => esc_html__( 'No Padding Content', 'eduma' ),
		'id'   => 'mtb_no_padding',
		'type' => 'checkbox',
		'desc' => ' ',
	);

	$mtb_setting->insertOptionBefore( $settings, 11 );
	$mtb_setting->insertOptionBefore( $settings_1, 16 );

	return $mtb_setting;
}

add_filter( 'thim_mtb_setting_after_created', 'thim_mtb_setting_after_created', 10, 2 );


/**
 * @param $tabs
 *
 * @return array
 */
function thim_widget_group( $tabs ) {
	$tabs[] = array(
		'title'  => esc_html__( 'Thim Widget', 'eduma' ),
		'filter' => array(
			'groups' => array( 'thim_widget_group' )
		)
	);

	return $tabs;
}

add_filter( 'siteorigin_panels_widget_dialog_tabs', 'thim_widget_group', 19 );

/**
 * @param $attributes
 * @param $args
 *
 * @return mixed
 */
function thim_row_style_attributes( $attributes, $args ) {
	if ( !empty( $args['parallax'] ) ) {
		array_push( $attributes['class'], 'article__parallax' );
	}

	if ( !empty( $args['row_stretch'] ) && $args['row_stretch'] == 'full-stretched' ) {
		array_push( $attributes['class'], 'thim-fix-stretched' );
	}

	return $attributes;
}

add_filter( 'siteorigin_panels_row_style_attributes', 'thim_row_style_attributes', 10, 2 );

/**
 * @return string
 */
function thim_excerpt_length() {
	$theme_options_data = get_theme_mods();
	if ( isset( $theme_options_data['thim_archive_excerpt_length'] ) ) {
		$length = $theme_options_data['thim_archive_excerpt_length'];
	} else {
		$length = '50';
	}

	return $length;
}

add_filter( 'excerpt_length', 'thim_excerpt_length', 999 );

/**
 * @param $text
 *
 * @return mixed|string|void
 */
function thim_wp_new_excerpt( $text ) {
	if ( $text == '' ) {
		$text           = get_the_content( '' );
		$text           = strip_shortcodes( $text );
		$text           = apply_filters( 'the_content', $text );
		$text           = str_replace( ']]>', ']]>', $text );
		$text           = strip_tags( $text );
		$text           = nl2br( $text );
		$excerpt_length = apply_filters( 'excerpt_length', 55 );
		$words          = explode( ' ', $text, $excerpt_length + 1 );
		if ( count( $words ) > $excerpt_length ) {
			array_pop( $words );
			array_push( $words, '' );
			$text = implode( ' ', $words );
		}
	}

	return $text;
}

remove_filter( 'get_the_excerpt', 'wp_trim_excerpt' );
add_filter( 'get_the_excerpt', 'thim_wp_new_excerpt' );

/**
 * Social sharing
 */
if ( !function_exists( 'thim_social_share' ) ) {
	function thim_social_share() {
		$theme_options_data = get_theme_mods();

		$facebook  = isset( $theme_options_data['thim_sharing_facebook'] ) && $theme_options_data['thim_sharing_facebook'] ? $theme_options_data['thim_sharing_facebook'] : null;
		$twitter   = isset( $theme_options_data['thim_sharing_twitter'] ) && $theme_options_data['thim_sharing_twitter'] ? $theme_options_data['thim_sharing_twitter'] : null;
		$pinterest = isset( $theme_options_data['thim_sharing_pinterest'] ) && $theme_options_data['thim_sharing_pinterest'] ? $theme_options_data['thim_sharing_pinterest'] : null;
		$google    = isset( $theme_options_data['thim_sharing_google'] ) && $theme_options_data['thim_sharing_google'] ? $theme_options_data['thim_sharing_google'] : null;

		if ( $facebook || $twitter || $pinterest || $google ) {
			echo '<ul class="thim-social-share">';
			do_action( 'thim_before_social_list' );
			echo '<li class="heading">' . esc_html__( 'Share:', 'eduma' ) . '</li>';
			if ( $facebook ) {

				echo '<li><div class="facebook-social"><a target="_blank" class="facebook"  href="https://www.facebook.com/sharer.php?u=' . urlencode( get_permalink() ) . '" title="' . esc_attr__( 'Facebook', 'eduma' ) . '"><i class="fa fa-facebook"></i></a></div></li>';

			}
			if ( $google ) {
				echo '<li><div class="googleplus-social"><a target="_blank" class="googleplus" href="https://plus.google.com/share?url=' . urlencode( get_permalink() ) . '&amp;title=' . rawurlencode( esc_attr( get_the_title() ) ) . '" title="' . esc_attr__( 'Google Plus', 'eduma' ) . '" onclick=\'javascript:window.open(this.href, "", "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600");return false;\'><i class="fa fa-google"></i></a></div></li>';

			}
			if ( $twitter ) {
				echo '<li><div class="twitter-social"><a target="_blank" class="twitter" href="https://twitter.com/share?url=' . urlencode( get_permalink() ) . '&amp;text=' . rawurlencode( esc_attr( get_the_title() ) ) . '" title="' . esc_attr__( 'Twitter', 'eduma' ) . '"><i class="fa fa-twitter"></i></a></div></li>';

			}

			if ( $pinterest ) {
				echo '<li><div class="pinterest-social"><a target="_blank" class="pinterest"  href="http://pinterest.com/pin/create/button/?url=' . urlencode( get_permalink() ) . '&amp;description=' . rawurlencode( esc_attr( get_the_excerpt() ) ) . '&amp;media=' . urlencode( wp_get_attachment_url( get_post_thumbnail_id() ) ) . '" onclick="window.open(this.href); return false;" title="' . esc_attr__( 'Pinterest', 'eduma' ) . '"><i class="fa fa-pinterest-p"></i></a></div></li>';

			}
			do_action( 'thim_after_social_list' );

			echo '</ul>';
		}

	}
}
add_action( 'thim_social_share', 'thim_social_share' );


/**
 * Display favicon
 */
function thim_favicon() {
	if ( function_exists( 'wp_site_icon' ) ) {
		if ( function_exists( 'has_site_icon' ) ) {
			if ( !has_site_icon() ) {
				// Icon default
				$thim_favicon_src = get_template_directory_uri() . "/images/favicon.png";
				echo '<link rel="shortcut icon" href="' . esc_url( $thim_favicon_src ) . '" type="image/x-icon" />';

				return;
			}

			return;
		}
	}

	/**
	 * Support WordPress < 4.3
	 */
	$theme_options_data = get_theme_mods();
	$thim_favicon_src   = '';
	if ( isset( $theme_options_data['thim_favicon'] ) ) {
		$thim_favicon       = $theme_options_data['thim_favicon'];
		$favicon_attachment = wp_get_attachment_image_src( $thim_favicon, 'full' );
		$thim_favicon_src   = $favicon_attachment[0];
	}
	if ( !$thim_favicon_src ) {
		$thim_favicon_src = get_template_directory_uri() . "/images/favicon.png";
	}
	echo '<link rel="shortcut icon" href="' . esc_url( $thim_favicon_src ) . '" type="image/x-icon" />';
}

add_action( 'wp_head', 'thim_favicon' );

/**
 * Redirect to custom login page
 */
if ( !function_exists( 'thim_login_failed' ) ) {
	function thim_login_failed() {

		if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'thim_login_ajax' ) {
			return;
		}
		wp_redirect( add_query_arg( 'result', 'failed', thim_get_login_page_url() ) );
		exit;
	}

	add_action( 'wp_login_failed', 'thim_login_failed', 1000 );
}

/**
 * Filter register link
 *
 * @param $register_url
 *
 * @return string|void
 */
function thim_get_register_url() {
	$url = add_query_arg( 'action', 'register', thim_get_login_page_url() );

	return $url;
}

/**
 * Register failed
 *
 * @param $sanitized_user_login
 * @param $user_email
 * @param $errors
 */
if ( !function_exists( 'thim_register_failed' ) ) {
	function thim_register_failed( $sanitized_user_login, $user_email, $errors ) {

		$errors = apply_filters( 'registration_errors', $errors, $sanitized_user_login, $user_email );

		if ( $errors->get_error_code() ) {

			//setup your custom URL for redirection
			$url = add_query_arg( 'action', 'register', thim_get_login_page_url() );

			foreach ( $errors->errors as $e => $m ) {
				$url = add_query_arg( $e, '1', $url );
			}
			wp_redirect( $url );
			exit;
		}
	}

	add_action( 'register_post', 'thim_register_failed', 99, 3 );
}

/**
 * Process extra register fields
 *
 * @param $login
 * @param $email
 * @param $errors
 */
function thim_check_extra_register_fields( $login, $email, $errors ) {
	if ( $_POST['password'] !== $_POST['repeat_password'] ) {
		$errors->add( 'passwords_not_matched', "<strong>ERROR</strong>: Passwords must match" );
	}
}

add_action( 'register_post', 'thim_check_extra_register_fields', 10, 3 );

/**
 * Update password
 *
 * @param $user_id
 */
function thim_register_extra_fields( $user_id ) {
	$user_data       = array();
	$user_data['ID'] = $user_id;
	if ( !empty( $_POST['password'] ) ) {
		$user_data['user_pass'] = $_POST['password'];
		add_filter( 'send_password_change_email', '__return_false' );
	}
	$new_user_id = wp_update_user( $user_data );

	// Login after registered
	if ( !is_admin() ) {
		wp_set_current_user( $user_id );
		wp_set_auth_cookie( $user_id );
		wp_new_user_notification( $user_id, null, 'both' );
		if ( ( isset( $_POST['billing_email'] ) && !empty( $_POST['billing_email'] ) ) || ( isset( $_POST['bconfirmemail'] ) && !empty( $_POST['bconfirmemail'] ) ) ) {
			return;
		} else {
			$theme_options_data = get_theme_mods();
			if ( !empty( $theme_options_data['thim_register_redirect'] ) ) {
				wp_redirect( $theme_options_data['thim_register_redirect'] );
			} else {
				wp_redirect( home_url() );
			}
			exit;
		}
	}
}

add_action( 'user_register', 'thim_register_extra_fields', 1000 );


/**
 * Redirect to custom register page in case multi sites
 *
 * @param $url
 *
 * @return mixed
 */
function thim_multisite_register_redirect( $url ) {

	if ( is_multisite() ) {
		$url = add_query_arg( 'action', 'register', thim_get_login_page_url() );
	}

	$user_login = isset( $_POST['user_login'] ) ? $_POST['user_login'] : '';
	$user_email = isset( $_POST['user_email'] ) ? $_POST['user_email'] : '';
	$errors     = register_new_user( $user_login, $user_email );
	if ( !is_wp_error( $errors ) ) {
		$redirect_to = !empty( $_POST['redirect_to'] ) ? $_POST['redirect_to'] : 'wp-login.php?checkemail=registered';
		wp_safe_redirect( $redirect_to );
		exit();
	}

	return $url;
}

add_filter( 'wp_signup_location', 'thim_multisite_register_redirect' );


function thim_multisite_signup_redirect() {
	if ( is_multisite() ) {
		wp_redirect( wp_registration_url() );
		die();
	}
}

add_action( 'signup_header', 'thim_multisite_signup_redirect' );


/**
 * Filter lost password link
 *
 * @param $url
 *
 * @return string
 */
function thim_get_lost_password_url() {
	$url = add_query_arg( 'action', 'lostpassword', thim_get_login_page_url() );

	return $url;
}

/**
 * Add lost password link into login form
 *
 * @param $content
 * @param $args
 *
 * @return string
 */
function thim_add_lost_password_link() {
	$content = '<a class="lost-pass-link" href="' . thim_get_lost_password_url() . '" title="' . esc_attr__( 'Lost Password', 'eduma' ) . '">' . esc_html__( 'Lost your password?', 'eduma' ) . '</a>';

	return $content;
}

add_filter( 'login_form_middle', 'thim_add_lost_password_link', 999 );

/**
 * Register failed
 */
function thim_reset_password_failed() {

	//setup your custom URL for redirection
	$url = add_query_arg( 'action', 'lostpassword', thim_get_login_page_url() );

	if ( empty( $_POST['user_login'] ) ) {
		$url = add_query_arg( 'empty', '1', $url );
		wp_redirect( $url );
		exit;
	} elseif ( strpos( $_POST['user_login'], '@' ) ) {
		$user_data = get_user_by( 'email', trim( $_POST['user_login'] ) );
		if ( empty( $user_data ) ) {
			$url = add_query_arg( 'user_not_exist', '1', $url );
			wp_redirect( $url );
			exit;
		}
	} elseif ( !username_exists( $_POST['user_login'] ) ) {
		$url = add_query_arg( 'user_not_exist', '1', $url );
		wp_redirect( $url );
		exit;
	}


}

add_action( 'lostpassword_post', 'thim_reset_password_failed', 999 );

/**
 * Get login page url
 *
 * @return false|string
 */
function thim_get_login_page_url() {

	if ( !thim_plugin_active( 'siteorigin-panels/siteorigin-panels.php' ) && !thim_plugin_active( 'js_composer/js_composer.php' ) ) {
		return wp_login_url();
	}

	if ( $page = get_option( 'thim_login_page' ) ) {
		return get_permalink( $page );
	} else {
		global $wpdb;
		$page = $wpdb->get_col(
			$wpdb->prepare(
				"SELECT p.ID FROM $wpdb->posts AS p INNER JOIN $wpdb->postmeta AS pm ON p.ID = pm.post_id
			WHERE 	pm.meta_key = %s
			AND 	pm.meta_value = %s
			AND		p.post_type = %s
			AND		p.post_status = %s",
				'thim_login_page',
				'1',
				'page',
				'publish'
			)
		);
		if ( !empty( $page[0] ) ) {
			return get_permalink( $page[0] );
		}
	}

	return wp_login_url();

}

/**
 * Display feature image
 *
 * @param $attachment_id
 * @param $size_type
 * @param $width
 * @param $height
 * @param $alt
 * @param $title
 *
 * @return string
 */
function thim_get_feature_image( $attachment_id, $size_type = null, $width = null, $height = null, $alt = null, $title = null ) {

	if ( !$size_type ) {
		$size_type = 'full';
	}
	$src   = wp_get_attachment_image_src( $attachment_id, $size_type );
	$style = '';
	if ( !$src ) {
		// Get demo image
		global $wpdb;
		$attachment_id = $wpdb->get_col(
			$wpdb->prepare(
				"SELECT p.ID FROM $wpdb->posts AS p INNER JOIN $wpdb->postmeta AS pm ON p.ID = pm.post_id
				WHERE 	pm.meta_key = %s
				AND 	pm.meta_value LIKE %s",
				'_wp_attached_file',
				'%demo_image.jpg'
			)
		);

		if ( empty( $attachment_id[0] ) ) {
			return;
		}

		$attachment_id = $attachment_id[0];
		$src           = wp_get_attachment_image_src( $attachment_id, 'full' );

	}

	if ( $width && $height ) {

		if ( $src[1] >= $width || $src[2] >= $height ) {

			$crop = ( $src[1] >= $width && $src[2] >= $height ) ? true : false;

			if ( $new_link = aq_resize( $src[0], $width, $height, $crop ) ) {

				$src[0] = $new_link;

			}

		}
		$style = ' width="' . $width . '" height="' . $height . '"';
	}

	if ( !$alt ) {
		$alt = get_the_title( $attachment_id );
	}

	if ( !$title ) {
		$title = get_the_title( $attachment_id );
	}

	return '<img src="' . esc_url( $src[0] ) . '" alt="' . esc_attr( $alt ) . '" title="' . esc_attr( $title ) . '" ' . $style . '>';

}

function thim_get_feature_image_lazyload( $attachment_id, $size_type = null, $width = null, $height = null, $alt = null, $title = null ) {
	if ( !$size_type ) {
		$size_type = 'full';
	}
	$src   = wp_get_attachment_image_src( $attachment_id, $size_type );
	$style = '';
	if ( !$src ) {
		// Get demo image
		global $wpdb;
		$attachment_id = $wpdb->get_col(
			$wpdb->prepare(
				"SELECT p.ID FROM $wpdb->posts AS p INNER JOIN $wpdb->postmeta AS pm ON p.ID = pm.post_id
				WHERE 	pm.meta_key = %s
				AND 	pm.meta_value LIKE %s",
				'_wp_attached_file',
				'%demo_image.jpg'
			)
		);

		if ( empty( $attachment_id[0] ) ) {
			return;
		}

		$attachment_id = $attachment_id[0];
		$src           = wp_get_attachment_image_src( $attachment_id, 'full' );

	}

	if ( $width && $height ) {

		if ( $src[1] >= $width || $src[2] >= $height ) {

			$crop = ( $src[1] >= $width && $src[2] >= $height ) ? true : false;

			$src[0] = aq_resize( $src[0], $width, $height, $crop );

		}
		$style = ' width="' . $width . '" height="' . $height . '"';
	}

	if ( !$alt ) {
		$alt = get_the_title( $attachment_id );
	}

	if ( !$title ) {
		$title = get_the_title( $attachment_id );
	}

	return '<img class="lazyOwl" data-src="' . esc_url( $src[0] ) . '" alt="' . esc_attr( $alt ) . '" title="' . esc_attr( $title ) . '" ' . $style . '>';
}


/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function thim_event_add_meta_boxes() {

	if ( !post_type_exists( 'tp_event' ) || !post_type_exists( 'our_team' ) ) {
		return;
	}
	add_meta_box(
		'thim_organizers',
		esc_html__( 'Organizers', 'eduma' ),
		'thim_event_meta_boxes_callback',
		'tp_event'
	);
}

add_action( 'add_meta_boxes', 'thim_event_add_meta_boxes' );

/**
 * Prints the box content.
 *
 * @param WP_Post $post The object for the current post/page.
 */
function thim_event_meta_boxes_callback( $post ) {

	// Add a nonce field so we can check for it later.
	wp_nonce_field( 'thim_event_save_meta_boxes', 'thim_event_meta_boxes_nonce' );

	// Get all team
	$team = new WP_Query( array(
		'post_type'           => 'our_team',
		'post_status'         => 'publish',
		'ignore_sticky_posts' => true,
		'posts_per_page'      => - 1
	) );

	if ( empty( $team->post_count ) ) {
		echo '<p>' . esc_html__( 'No members exists. You can create a member data from', 'eduma' ) . ' <a target="_blank" href="' . admin_url( 'post-new.php?post_type=our_team' ) . '">Our Team</a></p>';

		return;
	}

	echo '<label for="thim_event_members">';
	esc_html_e( 'Get Members', 'eduma' );
	echo '</label> ';
	echo '<select id="thim_event_members" name="thim_event_members[]" multiple>';
	if ( isset( $team->posts ) ) {
		$team = $team->posts;
		foreach ( $team as $member ) {
			echo '<option value="' . esc_attr( $member->ID ) . '">' . get_the_title( $member->ID ) . '</option>';
		}
	}
	echo '</select>';
	echo '<span>';
	esc_html_e( 'Hold down the Ctrl (Windows) / Command (Mac) button to select multiple options.', 'eduma' );
	echo '</span><br>';
	wp_reset_postdata();

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	$members = get_post_meta( $post->ID, 'thim_event_members', true );
	echo '<p>' . esc_html__( 'Current Members: ', 'eduma' );
	if ( !$members ) {
		echo esc_html__( 'None', 'eduma' ) . '</p>';
	} else {
		$total = count( $members );
		foreach ( $members as $key => $id ) {
			echo '<strong><a target="_blank" href="' . get_edit_post_link( $id ) . '">' . get_the_title( $id ) . '</a></strong>';
			if ( $key != count( $total ) ) {
				echo ', ';
			}
		}
	}
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function thim_event_save_meta_boxes( $post_id ) {

	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */

	// Check if our nonce is set.
	if ( !isset( $_POST['thim_event_meta_boxes_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( !wp_verify_nonce( $_POST['thim_event_meta_boxes_nonce'], 'thim_event_save_meta_boxes' ) ) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'tp_event' == $_POST['post_type'] ) {

		if ( !current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

	}

	/* OK, it's safe for us to save the data now. */

	// Make sure that it is set.
	if ( !isset( $_POST['thim_event_members'] ) ) {
		return;
	}

	// Update the meta field in the database.
	update_post_meta( $post_id, 'thim_event_members', $_POST['thim_event_members'] );
}

add_action( 'save_post', 'thim_event_save_meta_boxes' );


/**
 * Change default comment fields
 *
 * @param $field
 *
 * @return string
 */
function thim_new_comment_fields( $fields ) {
	$commenter = wp_get_current_commenter();
	$req       = get_option( 'require_name_email' );
	$aria_req  = ( $req ? 'aria-required=true' : '' );

	$fields = array(
		'author' => '<p class="comment-form-author">' . '<input placeholder="' . esc_attr__( 'Name', 'eduma' ) . ( $req ? ' *' : '' ) . '" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" ' . $aria_req . ' /></p>',
		'email'  => '<p class="comment-form-email">' . '<input placeholder="' . esc_attr__( 'Email', 'eduma' ) . ( $req ? ' *' : '' ) . '" id="email" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" ' . $aria_req . ' /></p>',
		'url'    => '<p class="comment-form-url">' . '<input placeholder="' . esc_attr__( 'Website', 'eduma' ) . ( $req ? ' *' : '' ) . '" id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" ' . $aria_req . ' /></p>',
	);

	return $fields;
}

add_filter( 'comment_form_default_fields', 'thim_new_comment_fields', 1 );


/**
 * Remove Emoji scripts
 */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

/**
 * Optimize script files
 */
if ( !function_exists( 'thim_optimize_scripts' ) ) {
	function thim_optimize_scripts() {
		global $wp_scripts;
		if ( !is_a( $wp_scripts, 'WP_Scripts' ) ) {
			return;
		}
		foreach ( $wp_scripts->registered as $handle => $script ) {
			$wp_scripts->registered[$handle]->ver = null;
		}
	}
}
//add_action( 'wp_print_scripts', 'thim_optimize_scripts', 999 );
//add_action( 'wp_print_footer_scripts', 'thim_optimize_scripts', 999 );

/**
 * Optimize style files
 */
if ( !function_exists( 'thim_optimize_styles' ) ) {
	function thim_optimize_styles() {
		global $wp_styles;
		if ( !is_a( $wp_styles, 'WP_Styles' ) ) {
			return;
		}
		foreach ( $wp_styles->registered as $handle => $style ) {
			$wp_styles->registered[$handle]->ver = null;
		}
	}
}
//add_action( 'admin_print_styles', 'thim_optimize_styles', 999 );
//add_action( 'wp_print_styles', 'thim_optimize_styles', 999 );

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @param array $args Configuration arguments.
 *
 * @return array
 */
function thim_page_menu_args( $args ) {
	$args['show_home'] = true;

	return $args;
}

add_filter( 'wp_page_menu_args', 'thim_page_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function thim_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}

add_filter( 'body_class', 'thim_body_classes' );

/**
 * Sets the authordata global when viewing an author archive.
 *
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function thim_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}

add_action( 'wp', 'thim_setup_author' );

function thim_add_event_admin_styles() {
	?>
	<style type="text/css">
		#thim_event_members {
			min-height: 200px;
		}
	</style>
	<?php
}

add_action( 'admin_print_styles', 'thim_add_event_admin_styles' );

/**
 * Check a plugin activate
 *
 * @param $plugin
 *
 * @return bool
 */
function thim_plugin_active( $plugin ) {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if ( is_plugin_active( $plugin ) ) {
		return true;
	}

	return false;
}


/**
 * Custom WooCommerce breadcrumbs
 *
 * @return array
 */
function thim_woocommerce_breadcrumbs() {
	return array(
		'delimiter'   => '',
		'wrap_before' => '<ul class="breadcrumbs" id="breadcrumbs" itemtype="http://schema.org/BreadcrumbList" itemscope="" itemprop="breadcrumb">',
		'wrap_after'  => '</ul>',
		'before'      => '<li itemtype="http://schema.org/ListItem" itemscope="" itemprop="itemListElement">',
		'after'       => '</li>',
		'home'        => esc_html__( 'Home', 'eduma' ),
	);
}

add_filter( 'woocommerce_breadcrumb_defaults', 'thim_woocommerce_breadcrumbs' );

/**
 * Display post thumbnail by default
 *
 * @param $size
 */
function thim_default_get_post_thumbnail( $size ) {

	if ( thim_plugin_active( 'thim-framework/tp-framework.php' ) ) {
		return;
	}

	if ( get_the_post_thumbnail( get_the_ID(), $size ) ) {
		?>
		<div class='post-formats-wrapper'>
			<a class="post-image" href="<?php echo esc_url( get_permalink() ); ?>">
				<?php echo get_the_post_thumbnail( get_the_ID(), $size ); ?>
			</a>
		</div>
		<?php
	}
}

add_action( 'thim_entry_top', 'thim_default_get_post_thumbnail', 20 );


/**
 * Set unlimit events in archive
 *
 * @param $query
 */
function thim_event_post_filter( $query ) {
	global $wp_query;

	if ( is_post_type_archive( 'tp_event' ) && 'tp_event' == $query->get( 'post_type' ) ) {
		$query->set( 'posts_per_page', - 1 );

		return;
	}
}

add_action( 'pre_get_posts', 'thim_event_post_filter' );


function thim_start_widget_element_content( $content, $panels_data, $post_id ) {
	global $siteorigin_panels_inline_css;

	if ( !empty( $siteorigin_panels_inline_css[$post_id] ) ) {
		$content = '<style scoped>' . ( $siteorigin_panels_inline_css[$post_id] ) . '</style>' . $content;
	}

	return $content;
}

remove_action( 'wp_footer', 'siteorigin_panels_print_inline_css' );
add_filter( 'siteorigin_panels_before_content', 'thim_start_widget_element_content', 10, 3 );

//Override ajax-loader contact form
function thim_wpcf7_ajax_loader() {
	return THIM_URI . 'images/ajax-loader.gif';
}

add_filter( 'wpcf7_ajax_loader', 'thim_wpcf7_ajax_loader' );

if ( !function_exists( 'thim_ssl_secure_url' ) ) {
	function thim_ssl_secure_url( $sources ) {
		$scheme = parse_url( site_url(), PHP_URL_SCHEME );
		if ( 'https' == $scheme ) {
			if ( stripos( $sources, 'http://' ) === 0 ) {
				$sources = 'https' . substr( $sources, 4 );
			}

			return $sources;
		}

		return $sources;
	}
}
if ( !function_exists( 'thim_ssl_secure_image_srcset' ) ) {
	function thim_ssl_secure_image_srcset( $sources ) {
		$scheme = parse_url( site_url(), PHP_URL_SCHEME );
		if ( 'https' == $scheme ) {
			foreach ( $sources as &$source ) {
				if ( stripos( $source['url'], 'http://' ) === 0 ) {
					$source['url'] = 'https' . substr( $source['url'], 4 );
				}
			}

			return $sources;
		}

		return $sources;
	}
}

//add_filter( 'wp_calculate_image_srcset', 'thim_ssl_secure_image_srcset' );
//add_filter( 'wp_get_attachment_url', 'thim_ssl_secure_url', 1000 );
//add_filter( 'image_widget_image_url', 'thim_ssl_secure_url' );


/**
 * Testing with CF7 scripts
 */
if ( !function_exists( 'thim_disable_cf7_cache' ) ) {
	function thim_disable_cf7_cache() {
		global $wp_scripts;
		if ( !empty( $wp_scripts->registered['contact-form-7'] ) ) {
			if ( !empty( $wp_scripts->registered['contact-form-7']->extra['data'] ) ) {
				$localize                                                = $wp_scripts->registered['contact-form-7']->extra['data'];
				$localize                                                = str_replace( '"cached":"1"', '"cached":0', $localize );
				$wp_scripts->registered['contact-form-7']->extra['data'] = $localize;
			}
		}
	}
}

add_action( 'wpcf7_enqueue_scripts', 'thim_disable_cf7_cache' );


//Function thim_related_our_team
if ( !function_exists( 'thim_related_our_team' ) ) {
	function thim_related_our_team( $post_id, $number_posts = - 1 ) {
		$query = new WP_Query();
		$args  = '';
		if ( $number_posts == 0 ) {
			return $query;
		}
		$args  = wp_parse_args( $args, array(
			'posts_per_page'      => $number_posts,
			'post_type'           => 'our_team',
			'post__not_in'        => array( $post_id ),
			'ignore_sticky_posts' => true,
			'category__in'        => wp_get_post_categories( $post_id )
		) );
		$query = new WP_Query( $args );

		return $query;
	}
}


/**
 * Process events order
 */

add_filter( 'posts_fields', 'thim_event_posts_fields', 10, 2 );
add_filter( 'posts_join_paged', 'thim_event_posts_join_paged', 10, 2 );
add_filter( 'posts_where_paged', 'thim_event_posts_where_paged', 10, 2 );
add_filter( 'posts_orderby', 'thim_event_posts_orderby', 10, 2 );

function thim_is_events_archive() {
	global $pagenow, $post_type;
	if ( !is_post_type_archive( 'tp_event' ) || !is_main_query() ) {
		return false;
	}

	return true;
}

function thim_event_posts_fields( $fields, $q ) {
	if ( !thim_is_events_archive() ) {
		return $fields;
	}
	if ( $q->get( 'post_status' ) == 'tp-event-expired' ) {
		$alias = 'end_date_time';
	} else {
		$alias = 'start_date_time';
	}
	$fields = " DISTINCT " . $fields;
	$fields .= ', concat( str_to_date( pm1.meta_value, \'%m/%d/%Y\' ), \' \', str_to_date(pm2.meta_value, \'%h:%i %p\' ) ) as ' . $alias;

	return $fields;
}

function thim_event_posts_join_paged( $join, $q ) {
	if ( !thim_is_events_archive() ) {
		return $join;
	}

	global $wpdb;
	if ( $q->get( 'post_status' ) == 'tp-event-expired' ) {
		$join .= " LEFT JOIN {$wpdb->postmeta} pm1 ON pm1.post_id = {$wpdb->posts}.ID AND pm1.meta_key = 'tp_event_date_end'";
		$join .= " LEFT JOIN {$wpdb->postmeta} pm2 ON pm2.post_id = {$wpdb->posts}.ID AND pm2.meta_key = 'tp_event_time_end'";
	} else {
		$join .= " LEFT JOIN {$wpdb->postmeta} pm1 ON pm1.post_id = {$wpdb->posts}.ID AND pm1.meta_key = 'tp_event_date_start'";
		$join .= " LEFT JOIN {$wpdb->postmeta} pm2 ON pm2.post_id = {$wpdb->posts}.ID AND pm2.meta_key = 'tp_event_time_start'";
	}

	return $join;
}

function thim_event_posts_where_paged( $where, $q ) {
	if ( !thim_is_events_archive() ) {
		return $where;
	}

	return $where;
}

function thim_event_posts_orderby( $order_by_statement, $q ) {
	global $wp_query;
	if ( !thim_is_events_archive() ) {
		return $order_by_statement;
	}
	if ( $q->get( 'post_status' ) == 'tp-event-expired' ) {
		$order_by_statement = "end_date_time DESC";
	} else {
		$order_by_statement = "start_date_time ASC";
	}

	return $order_by_statement;
}

function thim_replace_retrieve_password_message( $message, $key, $user_login, $user_data ) {

	$reset_link = add_query_arg(
		array(
			'action' => 'rp',
			'key'    => $key,
			'login'  => rawurlencode( $user_login )
		), thim_get_login_page_url()
	);

	// Create new message
	$message = __( 'Someone has requested a password reset for the following account:', 'eduma' ) . "\r\n\r\n";
	$message .= network_home_url( '/' ) . "\r\n\r\n";
	$message .= sprintf( __( 'Username: %s', 'eduma' ), $user_login ) . "\r\n\r\n";
	$message .= __( 'If this was a mistake, just ignore this email and nothing will happen.', 'eduma' ) . "\r\n\r\n";
	$message .= __( 'To reset your password, visit the following address:', 'eduma' ) . "\r\n\r\n";
	$message .= $reset_link . "\r\n";

	return $message;
}

add_filter( 'retrieve_password_message', 'thim_replace_retrieve_password_message', 10, 4 );


function thim_do_password_reset() {

	$login_page = thim_get_login_page_url();
	if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {

		if ( !isset( $_REQUEST['key'] ) || !isset( $_REQUEST['login'] ) ) {
			return;
		}

		$key   = $_REQUEST['key'];
		$login = $_REQUEST['login'];

		$user = check_password_reset_key( $key, $login );

		if ( !$user || is_wp_error( $user ) ) {
			if ( $user && $user->get_error_code() === 'expired_key' ) {
				wp_redirect( add_query_arg(
					array(
						'action'      => 'rp',
						'expired_key' => '1',
					), $login_page
				) );
			} else {
				wp_redirect( add_query_arg(
					array(
						'action'      => 'rp',
						'invalid_key' => '1',
					), $login_page
				) );
			}
			exit;
		}

		if ( isset( $_POST['password'] ) ) {

			if ( empty( $_POST['password'] ) ) {
				// Password is empty
				wp_redirect( add_query_arg(
					array(
						'action'           => 'rp',
						'key'              => $_REQUEST['key'],
						'login'            => $_REQUEST['login'],
						'invalid_password' => '1',
					), $login_page
				) );
				exit;
			}

			// Parameter checks OK, reset password
			reset_password( $user, $_POST['password'] );
			wp_redirect( add_query_arg(
				array(
					'result' => 'changed',
				), $login_page
			) );
		} else {
			_e( 'Invalid request.', 'eduma' );
		}

		exit;
	}
}

add_action( 'login_form_rp', 'thim_do_password_reset', 1000 );
add_action( 'login_form_resetpass', 'thim_do_password_reset', 1000 );


if ( !function_exists( 'thim_related_portfolio' ) ) {
	function thim_related_portfolio( $post_id ) {

		?>
		<div class="related-portfolio col-md-12">
			<div class="module_title"><h4 class="widget-title"><?php esc_html_e( 'Related Items', 'eduma' ); ?></h4>
			</div>

			<?php //Get Related posts by category	-->
			$args      = array(
				'posts_per_page' => 3,
				'post_type'      => 'portfolio',
				'post_status'    => 'publish',
				'post__not_in'   => array( $post_id )
			);
			$port_post = get_posts( $args );
			?>

			<ul class="row">
				<?php
				foreach ( $port_post as $post ) : setup_postdata( $post ); ?>
					<?php
					$bk_ef = get_post_meta( $post->ID, 'thim_portfolio_bg_color_ef', true );
					if ( $bk_ef == '' ) {
						$bk_ef = get_post_meta( $post->ID, 'thim_portfolio_bg_color_ef', true );
						$bg    = '';
					} else {
						$bk_ef = get_post_meta( $post->ID, 'thim_portfolio_bg_color_ef', true );
						$bg    = 'style="background-color:' . $bk_ef . ';"';
					}
					?>
					<li class="col-sm-4">
						<?php

						$imImage = get_permalink( $post->ID );

						$image_url = thim_get_feature_image( get_post_thumbnail_id( $post->ID ), 'full', apply_filters( 'thim_portfolio_thumbnail_width', 480 ), apply_filters( 'thim_portfolio_thumbnail_height', 320 ) );
						echo '<div data-color="' . $bk_ef . '" ' . $bg . '>';
						echo '<div class="portfolio-image" ' . $bg . '>' . $image_url . '
					<div class="portfolio_hover"><div class="thumb-bg"><div class="mask-content">';
						echo '<h3><a href="' . esc_url( get_permalink( $post->ID ) ) . '" title="' . esc_attr( get_the_title( $post->ID ) ) . '" >' . get_the_title( $post->ID ) . '</a></h3>';
						echo '<span class="p_line"></span>';
						$terms    = get_the_terms( $post->ID, 'portfolio_category' );
						$cat_name = "";
						if ( $terms && !is_wp_error( $terms ) ) :
							foreach ( $terms as $term ) {
								if ( $cat_name ) {
									$cat_name .= ', ';
								}
								$cat_name .= '<a href="' . esc_url( get_term_link( $term ) ) . '">' . $term->name . "</a>";
							}
							echo '<div class="cat_portfolio">' . $cat_name . '</div>';
						endif;
						echo '<a href="' . esc_url( $imImage ) . '" title="' . esc_attr( get_the_title( $post->ID ) ) . '" class="btn_zoom ">' . esc_html__( 'Zoom', 'eduma' ) . '</a>';
						echo '</div></div></div></div></div>';
						?>
					</li>
				<?php endforeach; ?>
			</ul>
			<?php wp_reset_postdata(); ?>
		</div><!--#portfolio_related-->
		<?php
	}
}


//Function ajax widget gallery-posts
add_action( 'wp_ajax_thim_gallery_popup', 'thim_gallery_popup' );
add_action( 'wp_ajax_nopriv_thim_gallery_popup', 'thim_gallery_popup' );
/** widget gallery posts ajax output **/
if ( !function_exists( 'thim_gallery_popup' ) ) {
	function thim_gallery_popup() {
		global $post;
		$post_id = $_POST["post_id"];
		$post    = get_post( $post_id );

		$images = thim_meta( 'thim_gallery', "type=image&single=false&size=full" );
		// Get category permalink
		ob_start();
		$error = true;
		if ( !empty( $images ) ) {
			foreach ( $images as $k => $value ) {
				$url_image = $value['url'];
				if ( $url_image && $url_image != '' ) {
					echo '<a href="' . $url_image . '">';
					echo '<img src="' . $url_image . '" />';
					echo '</a>';
					$error = false;
				}
			}
		}
		if ( $error ) {
			if ( is_user_logged_in() ) {
				$link = get_edit_post_link( $post_id );
				echo '<div class="thim-gallery-message"><a class="link" href="' . $link . '">' . esc_html__( 'This post doesn\'t have any gallery images, please add some!', 'eduma' ) . '</a></div>';
			} else {
				echo '<div class="thim-gallery-message">' . esc_html__( 'This post doesn\'t have any gallery images, please add some!', 'eduma' ) . '</div>';
			}

		}
		?>

		<?php
		$output = ob_get_contents();
		ob_end_clean();
		echo ent2ncr( $output );
		die();
	}
}


/**
 * LearnPress section
 */

if ( thim_plugin_active( 'learnpress/learnpress.php' ) ) {
	//filter learnpress hooks
	if ( thim_is_new_learnpress( '2.0' ) ) {

		function thim_new_learnpress_template_path() {
			return 'learnpress-v2/';
		}

		add_filter( 'learn_press_template_path', 'thim_new_learnpress_template_path', 999 );
		require_once THIM_DIR . 'inc/learnpress-v2-functions.php';

	} else if( thim_is_new_learnpress( '1.0' ) ){

		function thim_new_learnpress_template_path() {
			return 'learnpress-v1/';
		}

		add_filter( 'learn_press_template_path', 'thim_new_learnpress_template_path', 999 );
		require_once THIM_DIR . 'inc/learnpress-v1-functions.php';
		
	} else{
		require_once THIM_DIR . 'inc/learnpress-functions.php';
	}

}

/**
 * Check new version of LearnPress
 *
 * @return mixed
 */
function thim_is_new_learnpress( $version ) {
	return version_compare( get_option( 'learnpress_version' ), $version, '>=' );
}


//Action call reload page when change font on preview box
function thim_chameleon_add_script_reload() {
	?>
	location.reload();
	<?php
}

add_action( 'tp_chameleon_script_after_change_body_font', 'thim_chameleon_add_script_reload' );
add_action( 'tp_chameleon_script_after_change_heading_font', 'thim_chameleon_add_script_reload' );


//Remove action single event
remove_action( 'tp_event_after_loop_event_item', 'event_auth_register' );
remove_action( 'tp_event_after_single_event', 'event_auth_register' );


add_action( 'activate_plugin', 'thim_remove_activate_action_event_auth' );
function thim_remove_activate_action_event_auth( $plugin ) {
	if ( $plugin === 'tp-event-auth' ) {
		add_filter( 'event_auth_create_pages', 'thim_remove_create_page_action_event_auth' );
	}
}

if ( !function_exists( 'thim_remove_create_page_action_event_auth' ) ) {
	function thim_remove_create_page_action_event_auth( $return ) {
		return false;
	}
}

add_action( 'wp_head', 'thim_define_ajaxurl', 1000 );
function thim_define_ajaxurl() {
	?>
	<script type="text/javascript">
		if (typeof ajaxurl === 'undefined') {
			/* <![CDATA[ */
			var ajaxurl = "<?php echo esc_js( admin_url( 'admin-ajax.php' ) ); ?>";
			/* ]]> */
		}
	</script>
	<?php
}

if ( !function_exists( 'thim_js_inline_windowload' ) ) {
	function thim_js_inline_windowload() {
		$theme_options_data = get_theme_mods();
		if ( isset( $theme_options_data['thim_preload'] ) && $theme_options_data['thim_preload'] == '1' ) {
			?>
			<script data-cfasync="false" type="text/javascript">
				window.onload = function () {
					setTimeout(function () {
						var body = document.getElementById("thim-body"),
							thim_preload = document.getElementById("preload"),
							len = body.childNodes.length,
							class_name = body.className.replace(/(?:^|\s)thim-body-preload(?!\S)/, '').replace(/(?:^|\s)thim-body-load-overlay(?!\S)/, '');

						body.className = class_name;
						if (typeof thim_preload !== 'undefined' && thim_preload !== null) {
							for (var i = 0; i < len; i++) {
								if (body.childNodes[i].id !== 'undefined' && body.childNodes[i].id == "preload") {
									body.removeChild(body.childNodes[i]);
									break;
								}
							}
						}
					}, 1000);
				};
			</script>
			<?php
		}
	}
}
add_action( 'wp_footer', 'thim_js_inline_windowload' );


function thim_rocket_loader_attributes_start() {
	ob_start();
}

function thim_rocket_loader_attributes_end() {
	$script_out = ob_get_clean();
	$script_out = str_replace(
		"src='{rocket-ignore}",
		"data-cfasync='false'" . " src='",
		$script_out );
	print $script_out;
}

function thim_rocket_loader_attributes_mark( $url ) {
	// Set up which scripts/strings to ignore
	$ignore = array(
		'jquery.js',
		'jquery.timer.js',
		'single-quiz.js'
	);
	//matches only the script file name
	preg_match( '/(.*)\?/', $url, $_url );
	if ( isset( $_url[1] ) && substr( $_url[1], - 3 ) == '.js' ) {
		foreach ( $ignore as $s ) {
			if ( strpos( $_url[1], $s ) !== false ) {
				return "{rocket-ignore}$url";
			}
		}
		//return "$url' data-cfasync='true";
	}

	return "$url";

}

//if (!is_admin()) {
//	add_filter( 'clean_url', 'thim_rocket_loader_attributes_mark', 11, 1);
//	add_action( 'wp_print_scripts', 'thim_rocket_loader_attributes_start');
//	add_action( 'print_head_scripts', 'thim_rocket_loader_attributes_end');
//}

/**
 * @param $output
 * @param $args
 *
 * @return string
 */
function thim_polylang_dropdown( $output, $args ) {

	if ( $args['dropdown'] ) {
		global $polylang;
		$languages        = $polylang->get_languages_list();
		$current_language = $list = '';

		foreach ( $languages as $language ) {
			if ( pll_current_language() == $language->slug ) {
				$current_language = '<a class="lang-item active" href="' . $language->home_url . '"><img src="' . $language->flag_url . '" alt="' . $language->slug . '" />' . $language->name . '</a>';
			}
			$list .= '<li class="lang-item"><a class="lang-select" href="' . $language->home_url . '"><img src="' . $language->flag_url . '" alt="' . $language->slug . '" />' . $language->name . '</a></li>';
		}

		$output = sprintf(
			'<div class="thim-language" id="lang_choice_polylang-3">%s<ul class="list-lang">%s</ul></div>',
			$current_language, $list
		);
	}

	return $output;
}

add_filter( 'pll_the_languages', 'thim_polylang_dropdown', 10, 2 );


/**
 * tunn added 04 Apr 2016
 */


if ( class_exists( 'TP_Event_Authentication' ) ) {
	if( !version_compare( get_option( 'event_auth_version' ), '1.0.3', '>=' ) ) {
		$auth = TP_Event_Authentication::getInstance()->auth;

		remove_action( 'login_form_login', array( $auth, 'redirect_to_login_page' ) );
		remove_action( 'login_form_register', array( $auth, 'login_form_register' ) );
		remove_action( 'login_form_lostpassword', array( $auth, 'redirect_to_lostpassword' ) );
		remove_action( 'login_form_rp', array( $auth, 'resetpass' ) );
		remove_action( 'login_form_resetpass', array( $auth, 'resetpass' ) );

		remove_action( 'wp_logout', array( $auth, 'wp_logout' ) );
		remove_filter( 'login_url', array( $auth, 'login_url' ) );
	}
}


function thim_redirect_rp_url() {
	if (
		!empty( $_REQUEST['action'] ) && $_REQUEST['action'] == 'rp'
		&& !empty( $_REQUEST['key'] ) && !empty( $_REQUEST['login'] )
	) {
		$reset_link = add_query_arg(
			array(
				'action' => 'rp',
				'key'    => $_REQUEST['key'],
				'login'  => rawurlencode( $_REQUEST['login'] )
			), thim_get_login_page_url()
		);

		if ( !thim_is_current_url( $reset_link ) ) {
			wp_redirect( $reset_link );
			exit();
		}
	}
}

add_action( 'init', 'thim_redirect_rp_url' );

if ( !function_exists( 'thim_get_current_url' ) ) {
	function thim_get_current_url() {
		static $current_url;
		if ( !$current_url ) {
			if ( !empty( $_REQUEST['login'] ) ) {
				$url = add_query_arg( array( 'login' => rawurlencode( $_REQUEST['login'] ) ) );
			} else {
				$url = add_query_arg();
			}

			if ( !preg_match( '!^https?!', $url ) ) {
				$segs1 = explode( '/', get_site_url() );
				$segs2 = explode( '/', $url );
				if ( $removed = array_intersect( $segs1, $segs2 ) ) {
					$segs2 = array_diff( $segs2, $removed );
					$url   = get_site_url() . '/' . join( '/', $segs2 );
				}
			}

			$current_url = $url;

		}

		return $current_url;
	}
}
if ( !function_exists( 'thim_is_current_url' ) ) {
	function thim_is_current_url( $url ) {
		return strcmp( thim_get_current_url(), $url ) == 0;
	}
}


//Filter post_status tp_event
if ( !function_exists( 'thim_get_upcoming_events' ) ) {
	function thim_get_upcoming_events( $args = array() ) {
		$args = wp_parse_args(
			$args,
			array(
				'post_type'   => 'tp_event',
				'post_status' => 'tp-event-upcoming'
			)
		);

		return new WP_Query( $args );
	}
}

if ( !function_exists( 'thim_get_expired_events' ) ) {
	function thim_get_expired_events( $args = array() ) {
		$args = wp_parse_args(
			$args,
			array(
				'post_type'   => 'tp_event',
				'post_status' => 'tp-event-expired',
			)
		);

		return new WP_Query( $args );
	}
}

if ( !function_exists( 'thim_get_happening_events' ) ) {
	function thim_get_happening_events( $args = array() ) {
		$args = wp_parse_args(
			$args,
			array(
				'post_type'   => 'tp_event',
				'post_status' => 'tp-event-happenning'
			)
		);

		return new WP_Query( $args );
	}
}

if ( !function_exists( 'thim_archive_event_template' ) ) {
	function thim_archive_event_template( $template ) {
		if ( get_post_type() == 'tp_event' && is_post_type_archive( 'tp_event' ) ) {
			$GLOBALS['thim_happening_events'] = thim_get_happening_events();
			$GLOBALS['thim_upcoming_events']  = thim_get_upcoming_events();
			$GLOBALS['thim_expired_events']   = thim_get_expired_events();
		}

		return $template;
	}
}
add_action( 'template_include', 'thim_archive_event_template' );


add_filter( 'pmpro_format_price', 'thim_pmpro_formatPrice', 10, 4 );
if ( !function_exists( 'thim_pmpro_formatPrice' ) ) {
	function thim_pmpro_formatPrice( $formatted, $price, $pmpro_currency, $pmpro_currency_symbol ) {
		if ( is_numeric( $price ) && ( intval( $price ) == floatval( $price ) ) ) {
			return $pmpro_currency_symbol . number_format( $price );
		} else {
			return $pmpro_currency_symbol . number_format( $price, 2 );
		}

	}
}


add_filter( 'pmpro_level_cost_text', 'thim_pmpro_getLevelCost', 10, 4 );
if ( !function_exists( 'thim_pmpro_getLevelCost' ) ) {
	function thim_pmpro_getLevelCost( $r, $level, $tags, $short ) {
		//initial payment
		if ( !$short )
			$r = sprintf( __( 'The price for membership is <p class="price">%s</p>', 'eduma' ), pmpro_formatPrice( $level->initial_payment ) );
		else
			$r = sprintf( __( '<p class="price">%s</p>', 'eduma' ), pmpro_formatPrice( $level->initial_payment ) );

		//recurring part
		if ( $level->billing_amount != '0.00' ) {
			if ( $level->billing_limit > 1 ) {
				if ( $level->cycle_number == '1' ) {
					$r .= sprintf( __( '<p class="expired">then %s per %s for %d more %s</p>', 'eduma' ), pmpro_formatPrice( $level->billing_amount ), pmpro_translate_billing_period( $level->cycle_period ), $level->billing_limit, pmpro_translate_billing_period( $level->cycle_period, $level->billing_limit ) );
				} else {
					$r .= sprintf( __( '<p class="expired">then %s every %d %s for %d more payments</p>', 'eduma' ), pmpro_formatPrice( $level->billing_amount ), $level->cycle_number, pmpro_translate_billing_period( $level->cycle_period, $level->cycle_number ), $level->billing_limit );
				}
			} elseif ( $level->billing_limit == 1 ) {
				$r .= sprintf( __( '<p class="expired">then %s after %d %s</p>', 'eduma' ), pmpro_formatPrice( $level->billing_amount ), $level->cycle_number, pmpro_translate_billing_period( $level->cycle_period, $level->cycle_number ) );
			} else {
				if ( $level->billing_amount === $level->initial_payment ) {
					if ( $level->cycle_number == '1' ) {
						if ( !$short )
							$r = sprintf( __( 'The price for membership is <strong>%s per %s</strong>', 'eduma' ), pmpro_formatPrice( $level->initial_payment ), pmpro_translate_billing_period( $level->cycle_period ) );
						else
							$r = sprintf( __( '<p class="expired">%s per %s</p>', 'eduma' ), pmpro_formatPrice( $level->initial_payment ), pmpro_translate_billing_period( $level->cycle_period ) );
					} else {
						if ( !$short )
							$r = sprintf( __( 'The price for membership is <strong>%s every %d %s</strong>', 'eduma' ), pmpro_formatPrice( $level->initial_payment ), $level->cycle_number, pmpro_translate_billing_period( $level->cycle_period, $level->cycle_number ) );
						else
							$r = sprintf( __( '<p class="expired">%s every %d %s</p>', 'eduma' ), pmpro_formatPrice( $level->initial_payment ), $level->cycle_number, pmpro_translate_billing_period( $level->cycle_period, $level->cycle_number ) );
					}
				} else {
					if ( $level->cycle_number == '1' ) {
						$r .= sprintf( __( '<p class="expired">then %s per %s</p>', 'eduma' ), pmpro_formatPrice( $level->billing_amount ), pmpro_translate_billing_period( $level->cycle_period ) );
					} else {
						$r .= sprintf( __( '<p class="expired">and then %s every %d %s</p>', 'eduma' ), pmpro_formatPrice( $level->billing_amount ), $level->cycle_number, pmpro_translate_billing_period( $level->cycle_period, $level->cycle_number ) );
					}
				}
			}
		}

		//trial part
		if ( $level->trial_limit ) {
			if ( $level->trial_amount == '0.00' ) {
				if ( $level->trial_limit == '1' ) {
					$r .= ' ' . __( 'After your initial payment, your first payment is Free.', 'eduma' );
				} else {
					$r .= ' ' . sprintf( __( 'After your initial payment, your first %d payments are Free.', 'eduma' ), $level->trial_limit );
				}
			} else {
				if ( $level->trial_limit == '1' ) {
					$r .= ' ' . sprintf( __( 'After your initial payment, your first payment will cost %s.', 'eduma' ), pmpro_formatPrice( $level->trial_amount ) );
				} else {
					$r .= ' ' . sprintf( __( 'After your initial payment, your first %d payments will cost %s.', 'eduma' ), $level->trial_limit, pmpro_formatPrice( $level->trial_amount ) );
				}
			}
		}

		//taxes part
		$tax_state = pmpro_getOption( "tax_state" );
		$tax_rate  = pmpro_getOption( "tax_rate" );

		if ( $tax_state && $tax_rate && !pmpro_isLevelFree( $level ) ) {
			$r .= sprintf( __( 'Customers in %s will be charged %s%% tax.', 'eduma' ), $tax_state, round( $tax_rate * 100, 2 ) );
		}

		if ( !$tags ){
			$r = strip_tags( $r );
		}

		return $r;
	}
}


//Ajax widget login-popup
add_action( 'wp_ajax_nopriv_thim_login_ajax', 'thim_login_ajax_callback' );
add_action( 'wp_ajax_thim_login_ajax', 'thim_login_ajax_callback' );
if ( !function_exists( 'thim_login_ajax_callback' ) ) {
	function thim_login_ajax_callback() {
		//ob_start();
		global $wpdb;

		//We shall SQL prepare all inputs to avoid sql injection.
		$username = $wpdb->prepare( $_REQUEST['username'], array() );
		$password = $_REQUEST['password'];//$wpdb->prepare( $_REQUEST['password'] );
		$remember = $wpdb->prepare( $_REQUEST['remember'], array() );

		if ( $remember ) {
			$remember = "true";
		} else {
			$remember = "false";
		}

		$login_data                  = array();
		$login_data['user_login']    = $username;
		$login_data['user_password'] = $password;
		$login_data['remember']      = $remember;
		$user_verify                 = wp_signon( $login_data, false );


		$code = 1;

		if ( is_wp_error( $user_verify ) ) {
			$message = '<p class="message message-error">' . esc_html__( 'Wrong username or password.', 'eduma' ) . '</p>';
			$code    = - 1;
		} else {
			$message = '<p class="message message-success">' . esc_html__( 'Login successful, redirecting...', 'eduma' ) . '</p>';
		}

		$response_data = array(
			'code'    => $code,
			'message' => $message
		);

		echo json_encode( $response_data );
		die(); // this is required to return a proper result
	}
}

/**
 * @param $settings
 *
 * @return array
 */
if ( !function_exists( 'thim_update_metabox_settings' ) ) {
	function thim_update_metabox_settings( $settings ) {
		$settings[] = 'lp_course';
		$settings[] = 'tp_event';
		return $settings;
	}
}

add_filter( 'thim_framework_metabox_settings', 'thim_update_metabox_settings' );

// Turn off Paid Membership pro register redirect
add_filter( 'pmpro_register_redirect', '__return_false' );


if ( !function_exists( 'thim_add_custom_js' ) ) {
	function thim_add_custom_js() {
		$theme_options_data = get_theme_mods();
		if ( !empty( $theme_options_data['thim_custom_js'] ) ) {
			?>
			<script data-cfasync="false" type="text/javascript">
				<?php echo ent2ncr( $theme_options_data['thim_custom_js'] ); ?>
			</script>
			<?php
		}

		//Add code js to oepn login-popup if not logged in.
		if ( !empty( $theme_options_data['thim_learnpress_single_popup'] ) ) {
			?>
			<script data-cfasync="false" type="text/javascript">
				(function ($) {
					"use strict";
					$(document).on('click', 'body:not(".logged-in") .purchase-course .thim-enroll-course-button', function (e) {
						if ($(window).width() > 767) {
							if ( $('.thim-login-popup .login').length ) {
								e.preventDefault();
								$('.thim-login-popup .login').trigger('click');
							}
						}
					});
				})(jQuery);
			</script>
			<?php
		}
	}
}
add_action( 'wp_footer', 'thim_add_custom_js' );

// Remove Paid Membership pro login redirect
remove_filter( 'login_redirect', 'pmpro_login_redirect', 10, 3 );


/* Function which remove Plugin Update Notices – LearnPress */
function thim_disable_plugin_learnpress_updates( $value ) {
	if( !empty( $value ) ) {
		unset( $value->response['learnpress/learnpress.php'] );
	}
    return $value;
}
add_filter( 'site_transient_update_plugins', 'thim_disable_plugin_learnpress_updates' );
