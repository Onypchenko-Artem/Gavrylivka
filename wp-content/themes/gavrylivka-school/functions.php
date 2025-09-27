<?php
/**
 * Gavrylivka School functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Gavrylivka_School
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function gavrylivka_school_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Gavrylivka School, use a find and replace
		* to change 'gavrylivka-school' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'gavrylivka-school', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in multiple locations.
	register_nav_menus(
		array(
			'menu-1'     => esc_html__( 'Primary', 'gavrylivka-school' ),
			'footer-menu' => esc_html__( 'Footer Menu', 'gavrylivka-school' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'gavrylivka_school_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);


	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'gavrylivka_school_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function gavrylivka_school_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'gavrylivka_school_content_width', 640 );
}
add_action( 'after_setup_theme', 'gavrylivka_school_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function gavrylivka_school_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'gavrylivka-school' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'gavrylivka-school' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'gavrylivka_school_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function gavrylivka_school_scripts() {
	// Main stylesheet
	wp_enqueue_style( 'gavrylivka-school-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'gavrylivka-school-style', 'rtl', 'replace' );
	
	// Global styles
	wp_enqueue_style( 'gavrylivka-school-layout', get_template_directory_uri() . '/assets/css/layout/layout.css', array(), _S_VERSION );
	wp_enqueue_style( 'gavrylivka-school-header', get_template_directory_uri() . '/assets/css/header/header.css', array(), _S_VERSION );
	wp_enqueue_style( 'gavrylivka-school-footer', get_template_directory_uri() . '/assets/css/footer/footer.css', array(), _S_VERSION );
	
	// Home page sections
	if ( is_page_template( 'home.php' ) || is_front_page() ) {
		wp_enqueue_style( 'gavrylivka-school-hero-section', get_template_directory_uri() . '/assets/css/home/hero-section.css', array(), _S_VERSION );
		wp_enqueue_style( 'gavrylivka-school-about-section', get_template_directory_uri() . '/assets/css/home/about-section.css', array(), _S_VERSION );
		wp_enqueue_style( 'gavrylivka-school-news-section', get_template_directory_uri() . '/assets/css/home/news-section.css', array(), _S_VERSION );
		wp_enqueue_style( 'gavrylivka-school-contact-section', get_template_directory_uri() . '/assets/css/home/contact-section.css', array(), _S_VERSION );
		
		// Hero slider JavaScript
		wp_enqueue_script( 'gavrylivka-school-hero-slider', get_template_directory_uri() . '/assets/js/hero-slider.js', array(), _S_VERSION, true );
	}
	
	// Single post/news page styles
	if ( is_single() ) {
		wp_enqueue_style( 'gavrylivka-school-single', get_template_directory_uri() . '/assets/css/single/single.css', array(), _S_VERSION );
		wp_enqueue_script( 'gavrylivka-school-reading-progress', get_template_directory_uri() . '/assets/js/reading-progress.js', array(), _S_VERSION, true );
	}

	wp_enqueue_script( 'gavrylivka-school-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'gavrylivka_school_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';


/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

add_filter('use_block_editor_for_post', '__return_false', 10);

/**
 * Duplicate Posts and Pages Functionality
 */

/**
 * Add duplicate link to post/page actions
 */
function gavrylivka_school_duplicate_post_link( $actions, $post ) {
	if ( current_user_can( 'edit_posts' ) ) {
		$actions['duplicate'] = '<a href="' . wp_nonce_url( 'admin.php?action=gavrylivka_duplicate_post&post=' . $post->ID, basename( __FILE__ ), 'duplicate_nonce' ) . '" title="Дублювати цю запис" rel="permalink">Копіювати</a>';
	}
	return $actions;
}

add_filter( 'post_row_actions', 'gavrylivka_school_duplicate_post_link', 10, 2 );
add_filter( 'page_row_actions', 'gavrylivka_school_duplicate_post_link', 10, 2 );

/**
 * Handle the duplicate action
 */
function gavrylivka_school_duplicate_post() {
	global $wpdb;
	
	if ( ! ( isset( $_GET['post'] ) || isset( $_POST['post'] ) || ( isset( $_REQUEST['action'] ) && 'gavrylivka_duplicate_post' == $_REQUEST['action'] ) ) ) {
		wp_die( 'Не вказано пост для дублювання!' );
	}

	// Nonce verification
	if ( ! isset( $_GET['duplicate_nonce'] ) || ! wp_verify_nonce( $_GET['duplicate_nonce'], basename( __FILE__ ) ) ) {
		return;
	}

	// Get the original post id
	$post_id = ( isset( $_GET['post'] ) ? absint( $_GET['post'] ) : absint( $_POST['post'] ) );
	
	// Get the original post data
	$post = get_post( $post_id );

	// Check permissions
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		wp_die( 'У вас немає дозволу на копіювання цього посту.' );
	}

	if ( isset( $post ) && $post != null ) {
		// Create the duplicate post
		$new_post_args = array(
			'comment_status' => $post->comment_status,
			'ping_status'    => $post->ping_status,
			'post_author'    => get_current_user_id(),
			'post_content'   => $post->post_content,
			'post_excerpt'   => $post->post_excerpt,
			'post_name'      => $post->post_name . '-copy',
			'post_parent'    => $post->post_parent,
			'post_password'  => $post->post_password,
			'post_status'    => 'draft',
			'post_title'     => $post->post_title . ' (Копія)',
			'post_type'      => $post->post_type,
			'to_ping'        => $post->to_ping,
			'menu_order'     => $post->menu_order
		);

		// Insert the post
		$new_post_id = wp_insert_post( $new_post_args );

		// Get all current post terms and set them to the new post draft
		$taxonomies = get_object_taxonomies( $post->post_type );
		foreach ( $taxonomies as $taxonomy ) {
			$post_terms = wp_get_object_terms( $post_id, $taxonomy, array( 'fields' => 'slugs' ) );
			wp_set_object_terms( $new_post_id, $post_terms, $taxonomy, false );
		}

		// Copy all post meta
		$post_meta_infos = $wpdb->get_results( "SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id" );
		if ( count( $post_meta_infos ) != 0 ) {
			$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
			foreach ( $post_meta_infos as $meta_info ) {
				$meta_key = $meta_info->meta_key;
				if ( $meta_key == '_wp_old_slug' ) continue;
				$meta_value = addslashes( $meta_info->meta_value );
				$sql_query_sel[] = "SELECT $new_post_id, '$meta_key', '$meta_value'";
			}
			$sql_query .= implode( " UNION ALL ", $sql_query_sel );
			$wpdb->query( $sql_query );
		}

		// Redirect to the edit screen for the new draft
		wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
		exit;
	} else {
		wp_die( 'Помилка при створенні копії: пост не знайдено! ID посту: ' . $post_id );
	}
}

add_action( 'admin_action_gavrylivka_duplicate_post', 'gavrylivka_school_duplicate_post' );

/**
 * Add admin notice for successful duplication
 */
function gavrylivka_school_duplication_admin_notice() {
	global $pagenow;
	if ( $pagenow == 'post.php' && isset( $_GET['action'] ) && $_GET['action'] == 'edit' && isset( $_GET['post'] ) ) {
		$post = get_post( $_GET['post'] );
		if ( $post && strpos( $post->post_title, '(Копія)' ) !== false && $post->post_status == 'draft' ) {
			echo '<div class="notice notice-success is-dismissible"><p><strong>Успішно!</strong> Створено копію запису. Не забудьте відредагувати заголовок та опублікувати.</p></div>';
		}
	}
}

add_action( 'admin_notices', 'gavrylivka_school_duplication_admin_notice' );

/**
 * Footer menu fallback
 */
function gavrylivka_school_footer_menu_fallback() {
	echo '<ul class="footer-menu">';
	echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">Головна</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/about/' ) ) . '">Про нас</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/contact/' ) ) . '">Контакти</a></li>';
	echo '</ul>';
}