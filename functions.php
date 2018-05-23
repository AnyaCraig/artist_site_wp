<?php

/** Tell WordPress to run theme_setup() when the 'after_setup_theme' hook is run. */

if ( ! function_exists( 'theme_setup' ) ):

function theme_setup() {

	/* This theme uses post thumbnails (aka "featured images")
	*  all images will be cropped to thumbnail size (below), as well as
	*  a square size (also below). You can add more of your own crop
	*  sizes with add_image_size. */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size(120, 90, true);
  	add_image_size('square', 150, 150, true);
  	add_image_size('medium-square', 800, 800, true);
  	add_image_size('medium', 800, 600, true);
  	add_image_size('large', 1200, 900, true);
  	add_image_size('background', 1800, 9999);

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	/* This theme uses wp_nav_menu() in one location.
	* You can allow clients to create multiple menus by
  * adding additional menus to the array. */
	register_nav_menus( array(
		'header-menu' => 'Header Menu',
		'social-menu' => 'Social Media Menu',
		'footer-menu' => 'Footer Menu',
		'sidebar-menu' => 'Sidebar Menu'
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

}
endif;

add_action( 'after_setup_theme', 'theme_setup' );


/* Add all our JavaScript files here.
We'll let WordPress add them to our templates automatically instead
of writing our own script tags in the header and footer. */

function hackeryou_scripts() {


	//Don't use WordPress' local copy of jquery, load our own version from a CDN instead
	wp_deregister_script('jquery');

    wp_enqueue_script(
  		'jquery',
  		"http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://code.jquery.com/jquery-3.2.1.min.js",
  		false, //dependencies
  		null, //version number
  		true //load in footer
    );

    wp_enqueue_script(
    	'plugins', //handle
    	get_template_directory_uri() . '/js/plugins.js', //source
    	false, //dependencies
    	null, // version number
    	true //load in footer
    );

	wp_enqueue_script(
		'scripts', //handle
		get_template_directory_uri() . '/js/main.min.js', //source
		array( 'jquery', 'plugins' ), //dependencies
		null, // version number
		true //load in footer
	);

    wp_enqueue_script('flickity', 'https://npmcdn.com/flickity@1.1/dist/flickity.pkgd.js', null, 1.1, true);
    wp_enqueue_style('flickity', 'https://npmcdn.com/flickity@1.1/dist/flickity.css', null, 1.1);

  	// make the theme root available to JavaScript
  	$theme_urls = array(
  	  'theme_url' => get_stylesheet_directory_uri(),
  	  'root' => home_url(),
  	  'api' => home_url() . '/wp-json/wp/v2',
  	  'cool' => true,
  	);
  	//after wp_enqueue_script
  	wp_localize_script( 'scripts', 'wp', $theme_urls );
}

add_action( 'wp_enqueue_scripts', 'hackeryou_scripts' );


//enqueues our external font awesome stylesheet
function add_font_awesome(){
	wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'); 
}

add_action('wp_enqueue_scripts','add_font_awesome');


/* Enqueue Google Fonts */
function add_google_fonts() {

	// paste your Google Fonts link in here just like this
	// I've put these fonts in just for starters
	wp_enqueue_style ('google-fonts', 'https://fonts.googleapis.com/css?family=Assistant:300,400|Fredericka+the+Great', false);
}

add_action('wp_enqueue_scripts', 'add_google_fonts');

/* Custom Title Tags */

function hackeryou_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name', 'display' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	// Add a page number if necessary.
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'hackeryou' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'hackeryou_wp_title', 10, 2 );

/*
  Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function hackeryou_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'hackeryou_page_menu_args' );


/*
 * Sets the post excerpt length to 40 characters.
 */
function hackeryou_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'hackeryou_excerpt_length' );

/*
 * Returns a "Continue Reading" link for excerpts
 */
function hackeryou_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">Continue reading <span class="meta-nav">&rarr;</span></a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and hackeryou_continue_reading_link().
 */
function hackeryou_auto_excerpt_more( $more ) {
	return ' &hellip;' . hackeryou_continue_reading_link();
}
add_filter( 'excerpt_more', 'hackeryou_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 */
function hackeryou_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= hackeryou_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'hackeryou_custom_excerpt_more' );


/*
 * Register a single widget area.
 * You can register additional widget areas by using register_sidebar again
 * within hackeryou_widgets_init.
 * Display in your template with dynamic_sidebar()
 */
function hackeryou_widgets_init() {
	// Area 1, located at the top of the sidebar.
	register_sidebar( array(
		'name' => 'Primary Widget Area',
		'id' => 'primary-widget-area',
		'description' => 'The primary widget area',
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => 'Main Sidebar',
		'id' => 'main-sidebar',
		'description' => 'The site-wide sidebar',
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

}

add_action( 'widgets_init', 'hackeryou_widgets_init' );

/**
 * Removes the default styles that are packaged with the Recent Comments widget.
 */
function hackeryou_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'hackeryou_remove_recent_comments_style' );


if ( ! function_exists( 'hackeryou_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post—date/time and author.
 */
function hackeryou_posted_on() {
	printf('<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s',
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date()
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr( 'View all posts by %s'), get_the_author() ),
			get_the_author()
		)
	);
}
endif;

if ( ! function_exists( 'hackeryou_posted_in' ) ) :
/**
 * Prints HTML with meta information for the current post (category, tags and permalink).
 */
function hackeryou_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.';
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.';
	} else {
		$posted_in = 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.';
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}
endif;

/* Get rid of junk! - Gets rid of all the crap in the header that you dont need */

function clean_stuff_up() {
	// windows live
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
	// wordpress gen tag
	remove_action('wp_head', 'wp_generator');
	// comments RSS
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	remove_action( 'wp_head', 'feed_links', 3 );
}

add_action('init', 'clean_stuff_up');


/* Here are some utility helper functions for use in your templates! */

/* dump() - makes for easy debugging. <?php dump($post); ?> */
function dump($obj) {
	echo "<pre>";
	print_r($obj);
	echo "</pre>";
}

/* is_blog() - checks various conditionals to figure out if you are currently within a blog page */
function is_blog () {
	global  $post;
	$posttype = get_post_type($post );
	return ( ((is_archive()) || (is_author()) || (is_category()) || (is_home()) || (is_single()) || (is_tag())) && ( $posttype == 'post')  ) ? true : false ;
}

/* get_post_parent() - Returns the current posts parent, if current post if top level, returns itself */
function get_post_parent($post) {
	if ($post->post_parent) {
		return $post->post_parent;
	}
	else {
		return $post->ID;
	}
}

function my_acf_init() {
	
	acf_update_setting('google_api_key', 'AIzaSyD-Xm1Rx0tsXDfGYvZ3kAiYe8IJT017w_U');
}

add_action('acf/init', 'my_acf_init');

// Make our own custom template tag to display the slider
function the_slider($id) {
	ob_start();
	include(locate_template('partials/slider.php')); // this will get slider.php
	return ob_get_clean();
}

function slider_func($atts) {
	return the_slider($atts['id']);
}

/* add_shortcode has the ability to add a [slider id="10"] to any wysiwyg
when wordpress encounters the slider shortcode, it knows to run the slider_func 
function in our functions.php file */
add_shortcode('slider', 'slider_func');


/* adding a slider shortcode metabox */

function slider_custom_meta() {
  add_meta_box( 'slider-class', 'Slider Shortcode', 'slider_callback', 'slider', 'side');
}

function slider_callback( $post ) {
    $id = get_the_ID();
    echo "<p>To embed this slider anywhere, just paste this shortcode into any WYSIWYG (text editor).</p>";
    $shortcode = "[slider id=\"$id\"]";
    echo "<input value='$shortcode'>";
}

add_action( 'add_meta_boxes', 'slider_custom_meta' );

// set the proper timezone for our PHP date functions site-wide
date_default_timezone_set('America/Toronto');
