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
	define( '_S_VERSION', '1.0.8' );
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
	
	// Add custom image sizes for news
	add_image_size( 'news-thumbnail', 400, 225, true ); // 16:9 aspect ratio
	add_image_size( 'news-large', 800, 450, true ); // 16:9 aspect ratio for larger displays

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
	wp_enqueue_style( 'gavrylivka-school-breadcrumbs', get_template_directory_uri() . '/assets/css/components/breadcrumbs.css', array(), _S_VERSION );
	wp_enqueue_style( 'gavrylivka-school-documents', get_template_directory_uri() . '/assets/css/components/documents.css', array(), _S_VERSION );
	
	// Home page sections
	if ( is_page_template( 'home.php' ) || is_front_page() ) {
		wp_enqueue_style( 'gavrylivka-school-hero-section', get_template_directory_uri() . '/assets/css/home/hero-section.css', array(), _S_VERSION );
		wp_enqueue_style( 'gavrylivka-school-about-section', get_template_directory_uri() . '/assets/css/home/about-section.css', array(), _S_VERSION );
		wp_enqueue_style( 'gavrylivka-school-news-section', get_template_directory_uri() . '/assets/css/home/news-section.css', array(), _S_VERSION );
		wp_enqueue_style( 'gavrylivka-school-gallery-section', get_template_directory_uri() . '/assets/css/home/gallery-section.css', array(), _S_VERSION );
		
		// Hero slider JavaScript
		wp_enqueue_script( 'gavrylivka-school-hero-slider', get_template_directory_uri() . '/assets/js/hero-slider.js', array(), _S_VERSION, true );
		// Gallery slider JavaScript
		wp_enqueue_script( 'gavrylivka-school-gallery-slider', get_template_directory_uri() . '/assets/js/gallery-slider.js', array(), _S_VERSION, true );
	}
	
	// Single post/news page styles
	if ( is_single() ) {
		wp_enqueue_style( 'gavrylivka-school-single', get_template_directory_uri() . '/assets/css/single/single.css', array(), _S_VERSION );
		
		// Swiper for related news slider
		wp_enqueue_style( 'swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), '11.0.0' );
		wp_enqueue_script( 'swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), '11.0.0', true );
		
		// Related news slider script
		wp_enqueue_script( 'gavrylivka-school-related-news-slider', get_template_directory_uri() . '/assets/js/related-news-slider.js', array('swiper-js'), _S_VERSION, true );
		wp_enqueue_script( 'gavrylivka-school-reading-progress', get_template_directory_uri() . '/assets/js/reading-progress.js', array(), _S_VERSION, true );
	}
	
	// Archive/blog page styles - Force load for debugging
	wp_enqueue_style( 'gavrylivka-school-archive', get_template_directory_uri() . '/assets/css/archive/archive.css', array(), filemtime(get_template_directory() . '/assets/css/archive/archive.css') );
	
	// Gallery page styles and lightbox script
	if ( is_page_template( 'page-gallery.php' ) || is_page( 'gallery' ) || has_shortcode( get_the_content(), 'gallery' ) ) {
		wp_enqueue_style( 'gavrylivka-school-gallery', get_template_directory_uri() . '/assets/css/gallery/gallery.css', array(), _S_VERSION );
		wp_enqueue_script( 'gavrylivka-school-simple-lightbox', get_template_directory_uri() . '/assets/js/simple-lightbox.js', array(), _S_VERSION, true );
	}
	
	// Team page styles
	if ( is_page_template( 'page-team.php' ) ) {
		wp_enqueue_style( 'gavrylivka-school-team', get_template_directory_uri() . '/assets/css/team/team.css', array(), _S_VERSION );
	}
	
	// Agenda page styles
	if ( is_page_template( 'page-agenda.php' ) ) {
		wp_enqueue_style( 'gavrylivka-school-agenda', get_template_directory_uri() . '/assets/css/agenda/agenda.css', array(), _S_VERSION );
		wp_enqueue_script( 'gavrylivka-school-agenda-tabs', get_template_directory_uri() . '/assets/js/agenda-tabs.js', array(), _S_VERSION, true );
	}
	
	// Also load lightbox on any page that might have gallery content
	if ( is_singular() && ( has_shortcode( get_the_content(), 'gallery' ) || has_block( 'gallery' ) ) ) {
		wp_enqueue_style( 'gavrylivka-school-gallery', get_template_directory_uri() . '/assets/css/gallery/gallery.css', array(), _S_VERSION );
		wp_enqueue_script( 'gavrylivka-school-simple-lightbox', get_template_directory_uri() . '/assets/js/simple-lightbox.js', array(), _S_VERSION, true );
	}

	wp_enqueue_script( 'gavrylivka-school-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'gavrylivka_school_scripts' );

/**
 * Set posts per page for archive pages
 */
function gavrylivka_school_posts_per_page( $query ) {
	if ( ! is_admin() && $query->is_main_query() ) {
		if ( is_archive() || is_home() ) {
			$query->set( 'posts_per_page', 6 );
		}
	}
}
add_action( 'pre_get_posts', 'gavrylivka_school_posts_per_page' );

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

/**
 * Get news thumbnail image HTML
 * Returns featured image if available, otherwise returns default placeholder
 */
function gavrylivka_school_get_news_thumbnail( $size = 'news-thumbnail', $class = 'news-thumbnail' ) {
	if ( has_post_thumbnail() ) {
		return get_the_post_thumbnail( null, $size, array('class' => $class) );
	} else {
		$default_class = $class . ' default-thumbnail';
		return sprintf(
			'<img src="%s" alt="%s" class="%s">',
			esc_url( get_template_directory_uri() . '/assets/img/default-news.svg' ),
			esc_attr( get_the_title() ),
			esc_attr( $default_class )
		);
	}
}

/**
 * Custom pagination function with numbered pages and arrows
 */
function gavrylivka_school_pagination( $query_obj = null, $echo = true ) {
	global $wp_query;
	
	$query = $query_obj ? $query_obj : $wp_query;
	$total_pages = $query->max_num_pages;
	
	if ( $total_pages <= 1 ) {
		return;
	}
	
	$current_page = max( 1, get_query_var( 'paged' ) );
	$range = 2; // Number of pages to show around current page
	
	$output = '<nav class="pagination-wrapper" aria-label="Навігація по сторінках">';
	$output .= '<ul class="pagination">';
	
	// Previous arrow
	if ( $current_page > 1 ) {
		$output .= '<li class="pagination-item">';
		$output .= '<a href="' . get_pagenum_link( $current_page - 1 ) . '" class="pagination-link pagination-prev" aria-label="Попередня сторінка">';
		$output .= '<span aria-hidden="true">‹</span>';
		$output .= '</a>';
		$output .= '</li>';
	}
	
	// First page
	if ( $current_page > $range + 1 ) {
		$output .= '<li class="pagination-item">';
		$output .= '<a href="' . get_pagenum_link( 1 ) . '" class="pagination-link">1</a>';
		$output .= '</li>';
		
		if ( $current_page > $range + 2 ) {
			$output .= '<li class="pagination-item pagination-dots"><span>…</span></li>';
		}
	}
	
	// Pages around current page
	for ( $i = max( 1, $current_page - $range ); $i <= min( $total_pages, $current_page + $range ); $i++ ) {
		$output .= '<li class="pagination-item">';
		if ( $i == $current_page ) {
			$output .= '<span class="pagination-link pagination-current" aria-current="page">' . $i . '</span>';
		} else {
			$output .= '<a href="' . get_pagenum_link( $i ) . '" class="pagination-link">' . $i . '</a>';
		}
		$output .= '</li>';
	}
	
	// Last page
	if ( $current_page < $total_pages - $range ) {
		if ( $current_page < $total_pages - $range - 1 ) {
			$output .= '<li class="pagination-item pagination-dots"><span>…</span></li>';
		}
		
		$output .= '<li class="pagination-item">';
		$output .= '<a href="' . get_pagenum_link( $total_pages ) . '" class="pagination-link">' . $total_pages . '</a>';
		$output .= '</li>';
	}
	
	// Next arrow
	if ( $current_page < $total_pages ) {
		$output .= '<li class="pagination-item">';
		$output .= '<a href="' . get_pagenum_link( $current_page + 1 ) . '" class="pagination-link pagination-next" aria-label="Наступна сторінка">';
		$output .= '<span aria-hidden="true">›</span>';
		$output .= '</a>';
		$output .= '</li>';
	}
	
	$output .= '</ul>';
	$output .= '</nav>';
	
	if ( $echo ) {
		echo $output;
	} else {
		return $output;
	}
}

/**
 * Breadcrumbs function
 */
function gavrylivka_school_breadcrumbs( $echo = true ) {
	// Don't show breadcrumbs on homepage
	if ( is_front_page() ) {
		return;
	}
	
	$separator = '<span class="breadcrumb-separator">›</span>';
	$home_text = 'Головна';
	$home_url = home_url( '/' );
	
	$output = '<nav class="breadcrumbs" aria-label="Навігаційні стежки">';
	$output .= '<ol class="breadcrumb-list">';
	
	// Home link
	$output .= '<li class="breadcrumb-item">';
	$output .= '<a href="' . esc_url( $home_url ) . '" class="breadcrumb-link">' . esc_html( $home_text ) . '</a>';
	$output .= '</li>';
	
	// Current page logic
	if ( is_category() || is_single() ) {
		// Category page
		if ( is_category() ) {
			$output .= '<li class="breadcrumb-separator">' . $separator . '</li>';
			$output .= '<li class="breadcrumb-item">';
			$output .= '<span class="breadcrumb-current">' . single_cat_title( '', false ) . '</span>';
			$output .= '</li>';
		}
		// Single post
		elseif ( is_single() ) {
			// Add "Новини" link for blog posts
			$output .= '<li class="breadcrumb-separator">' . $separator . '</li>';
			$output .= '<li class="breadcrumb-item">';
			$output .= '<a href="' . esc_url( get_permalink( get_option('page_for_posts') ) ) . '" class="breadcrumb-link">Новини</a>';
			$output .= '</li>';
			
			$output .= '<li class="breadcrumb-separator">' . $separator . '</li>';
			$output .= '<li class="breadcrumb-item">';
			$output .= '<span class="breadcrumb-current">' . get_the_title() . '</span>';
			$output .= '</li>';
		}
	}
	// Page
	elseif ( is_page() ) {
		$output .= '<li class="breadcrumb-separator">' . $separator . '</li>';
		$output .= '<li class="breadcrumb-item">';
		$output .= '<span class="breadcrumb-current">' . get_the_title() . '</span>';
		$output .= '</li>';
	}
	// Archive
	elseif ( is_archive() ) {
		$output .= '<li class="breadcrumb-separator">' . $separator . '</li>';
		$output .= '<li class="breadcrumb-item">';
		$output .= '<span class="breadcrumb-current">Архів</span>';
		$output .= '</li>';
	}
	// Search
	elseif ( is_search() ) {
		$output .= '<li class="breadcrumb-separator">' . $separator . '</li>';
		$output .= '<li class="breadcrumb-item">';
		$output .= '<span class="breadcrumb-current">Результати пошуку</span>';
		$output .= '</li>';
	}
	// 404
	elseif ( is_404() ) {
		$output .= '<li class="breadcrumb-separator">' . $separator . '</li>';
		$output .= '<li class="breadcrumb-item">';
		$output .= '<span class="breadcrumb-current">404 - Сторінка не знайдена</span>';
		$output .= '</li>';
	}
	
	$output .= '</ol>';
	$output .= '</nav>';
	
	if ( $echo ) {
		echo $output;
	} else {
		return $output;
	}
}

/**
 * Enable upload of Word documents and PowerPoint presentations
 */
function gavrylivka_school_custom_upload_mimes( $mimes ) {
	// Microsoft Word
	$mimes['doc']  = 'application/msword';
	$mimes['docx'] = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
	
	// Microsoft PowerPoint
	$mimes['ppt']  = 'application/vnd.ms-powerpoint';
	$mimes['pptx'] = 'application/vnd.openxmlformats-officedocument.presentationml.presentation';
	
	// Microsoft Excel (bonus)
	$mimes['xls']  = 'application/vnd.ms-excel';
	$mimes['xlsx'] = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
	
	return $mimes;
}
add_filter( 'upload_mimes', 'gavrylivka_school_custom_upload_mimes' );

/**
 * Fix MIME type check for MS Office files
 */
function gavrylivka_school_fix_mime_type_check( $data, $file, $filename, $mimes ) {
	$wp_filetype = wp_check_filetype( $filename, $mimes );

	$ext = $wp_filetype['ext'];
	$type = $wp_filetype['type'];
	$proper_filename = $data['proper_filename'];

	// Fix for .docx, .pptx, .xlsx files
	if ( $ext && $type ) {
		$data['ext'] = $ext;
		$data['type'] = $type;
	}

	return $data;
}
add_filter( 'wp_check_filetype_and_ext', 'gavrylivka_school_fix_mime_type_check', 10, 4 );

/**
 * Display document as a tile
 * 
 * @param int|string $attachment Either attachment ID or file URL
 * @param string $title Optional custom title. If empty, uses attachment title or filename
 * @param bool $echo Echo or return output
 * @return string HTML markup for document tile
 */
function gavrylivka_school_document_tile( $attachment, $title = '', $echo = true ) {
	// Get file URL
	if ( is_numeric( $attachment ) ) {
		$file_url = wp_get_attachment_url( $attachment );
		$attachment_id = $attachment;
		
		if ( empty( $title ) ) {
			$title = get_the_title( $attachment_id );
		}
	} else {
		$file_url = $attachment;
		$attachment_id = attachment_url_to_postid( $file_url );
		
		if ( empty( $title ) ) {
			if ( $attachment_id ) {
				$title = get_the_title( $attachment_id );
			} else {
				$title = basename( $file_url );
			}
		}
	}
	
	if ( ! $file_url ) {
		return '';
	}
	
	// Get document icon
	$extension = strtolower( pathinfo( $file_url, PATHINFO_EXTENSION ) );
	$icon_map = array(
		'doc'  => 'word.svg',
		'docx' => 'word.svg',
		'xls'  => 'excel.svg',
		'xlsx' => 'excel.svg',
		'pdf'  => 'pdf.svg',
		'ppt'  => 'powerpoint.svg',
		'pptx' => 'powerpoint.svg',
	);
	
	$icon_file = isset( $icon_map[ $extension ] ) ? $icon_map[ $extension ] : null;
	$icon_url = $icon_file ? get_template_directory_uri() . '/assets/img/' . $icon_file : null;
	
	// Build HTML
	$output = '<div class="document-tile">';
	
	// Main link (opens in browser)
	$output .= sprintf(
		'<a href="%s" class="document-tile-link" target="_blank">',
		esc_url( $file_url )
	);
	
	if ( $icon_url ) {
		$output .= sprintf( '<img src="%s" class="document-icon" alt="" />', esc_url( $icon_url ) );
	}
	
	$output .= sprintf( '<span class="document-title">%s</span>', esc_html( $title ) );
	$output .= '</a>';
	
	// Download icon (downloads file)
	$output .= sprintf(
		'<a href="%s" class="document-download-icon" download title="Завантажити">',
		esc_url( $file_url )
	);
	$output .= '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">';
	$output .= '<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>';
	$output .= '<polyline points="7 10 12 15 17 10"></polyline>';
	$output .= '<line x1="12" y1="15" x2="12" y2="3"></line>';
	$output .= '</svg>';
	$output .= '</a>';
	
	$output .= '</div>';
	
	if ( $echo ) {
		echo $output;
	} else {
		return $output;
	}
}

/**
 * Shortcode for displaying document tile
 * Usage: [document id="123" title="Custom Title"]
 * or: [document url="https://example.com/file.docx" title="Custom Title"]
 */
function gavrylivka_school_document_shortcode( $atts ) {
	$atts = shortcode_atts( array(
		'id'    => '',
		'url'   => '',
		'title' => '',
	), $atts );
	
	if ( ! empty( $atts['id'] ) ) {
		return gavrylivka_school_document_tile( intval( $atts['id'] ), $atts['title'], false );
	} elseif ( ! empty( $atts['url'] ) ) {
		return gavrylivka_school_document_tile( $atts['url'], $atts['title'], false );
	}
	
	return '';
}
add_shortcode( 'document', 'gavrylivka_school_document_shortcode' );

/**
 * Automatically convert document links to tiles in content
 */
function gavrylivka_school_auto_document_tiles( $content ) {
	// Check if we're in a post/page content
	if ( ! is_singular() && ! is_page() ) {
		return $content;
	}
	
	// Pattern to match links to document files
	$pattern = '/<a\s+(?:[^>]*?\s+)?href="([^"]*\.(?:doc|docx|ppt|pptx|xls|xlsx|pdf))"(?:[^>]*?)>([^<]*)<\/a>/i';
	
	// Replace with document tiles
	$content = preg_replace_callback( $pattern, function( $matches ) {
		$url = $matches[1];
		$title = $matches[2];
		
		// Get attachment ID from URL
		$attachment_id = attachment_url_to_postid( $url );
		
		if ( $attachment_id ) {
			return gavrylivka_school_document_tile( $attachment_id, $title, false );
		} else {
			return gavrylivka_school_document_tile( $url, $title, false );
		}
	}, $content );
	
	return $content;
}
add_filter( 'the_content', 'gavrylivka_school_auto_document_tiles', 20 );

/**
 * Parse CSV file and generate HTML table
 *
 * @param string $file_path Path to CSV file.
 * @return string HTML table.
 */
function gavrylivka_school_parse_csv_to_table( $file_path ) {
	if ( ! file_exists( $file_path ) ) {
		return '<p class="csv-error">' . esc_html__( 'CSV файл не знайдено.', 'gavrylivka-school' ) . '</p>';
	}

	// Read file content
	$content = file_get_contents( $file_path ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
	if ( false === $content ) {
		return '<p class="csv-error">' . esc_html__( 'Не вдалося прочитати CSV файл.', 'gavrylivka-school' ) . '</p>';
	}

	// Parse CSV
	$lines = array_map( 'str_getcsv', explode( "\n", $content ) );
	$lines = array_filter( $lines, function( $line ) {
		return ! empty( array_filter( $line ) );
	});

	if ( empty( $lines ) ) {
		return '<p class="csv-error">' . esc_html__( 'CSV файл порожній.', 'gavrylivka-school' ) . '</p>';
	}

	// Start building table
	$html = '<div class="agenda-table-wrapper">';
	$html .= '<table class="agenda-table">';
	
	// First row as header
	$header = array_shift( $lines );
	$html .= '<thead><tr>';
	foreach ( $header as $cell ) {
		$html .= '<th>' . esc_html( $cell ) . '</th>';
	}
	$html .= '</tr></thead>';
	
	// Rest of rows as body
	$html .= '<tbody>';
	foreach ( $lines as $row ) {
		$html .= '<tr>';
		foreach ( $row as $cell ) {
			$html .= '<td>' . esc_html( $cell ) . '</td>';
		}
		$html .= '</tr>';
	}
	$html .= '</tbody>';
	
	$html .= '</table>';
	$html .= '</div>';
	
	return $html;
}