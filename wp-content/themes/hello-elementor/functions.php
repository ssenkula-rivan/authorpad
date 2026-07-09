<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'HELLO_ELEMENTOR_VERSION', '3.4.6' );
define( 'EHP_THEME_SLUG', 'hello-elementor' );

define( 'HELLO_THEME_PATH', get_template_directory() );
define( 'HELLO_THEME_URL', get_template_directory_uri() );
define( 'HELLO_THEME_ASSETS_PATH', HELLO_THEME_PATH . '/assets/' );
define( 'HELLO_THEME_ASSETS_URL', HELLO_THEME_URL . '/assets/' );
define( 'HELLO_THEME_SCRIPTS_PATH', HELLO_THEME_ASSETS_PATH . 'js/' );
define( 'HELLO_THEME_SCRIPTS_URL', HELLO_THEME_ASSETS_URL . 'js/' );
define( 'HELLO_THEME_STYLE_PATH', HELLO_THEME_ASSETS_PATH . 'css/' );
define( 'HELLO_THEME_STYLE_URL', HELLO_THEME_ASSETS_URL . 'css/' );
define( 'HELLO_THEME_IMAGES_PATH', HELLO_THEME_ASSETS_PATH . 'images/' );
define( 'HELLO_THEME_IMAGES_URL', HELLO_THEME_ASSETS_URL . 'images/' );

if ( ! isset( $content_width ) ) {
	$content_width = 800; // Pixels.
}

if ( ! function_exists( 'hello_elementor_setup' ) ) {
	/**
	 * Set up theme support.
	 *
	 * @return void
	 */
	function hello_elementor_setup() {
		if ( is_admin() ) {
			hello_maybe_update_theme_version_in_db();
		}

		if ( apply_filters( 'hello_elementor_register_menus', true ) ) {
			register_nav_menus( [ 'menu-1' => esc_html__( 'Header', 'hello-elementor' ) ] );
			register_nav_menus( [ 'menu-2' => esc_html__( 'Footer', 'hello-elementor' ) ] );
		}

		if ( apply_filters( 'hello_elementor_post_type_support', true ) ) {
			add_post_type_support( 'page', 'excerpt' );
		}

		if ( apply_filters( 'hello_elementor_add_theme_support', true ) ) {
			add_theme_support( 'post-thumbnails' );
			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'title-tag' );
			add_theme_support(
				'html5',
				[
					'search-form',
					'comment-form',
					'comment-list',
					'gallery',
					'caption',
					'script',
					'style',
					'navigation-widgets',
				]
			);
			add_theme_support(
				'custom-logo',
				[
					'height'      => 100,
					'width'       => 350,
					'flex-height' => true,
					'flex-width'  => true,
				]
			);
			add_theme_support( 'align-wide' );
			add_theme_support( 'responsive-embeds' );

			/*
			 * Editor Styles
			 */
			add_theme_support( 'editor-styles' );
			add_editor_style( 'assets/css/editor-styles.css' );

			/*
			 * WooCommerce.
			 */
			if ( apply_filters( 'hello_elementor_add_woocommerce_support', true ) ) {
				// WooCommerce in general.
				add_theme_support( 'woocommerce' );
				// Enabling WooCommerce product gallery features (are off by default since WC 3.0.0).
				// zoom.
				add_theme_support( 'wc-product-gallery-zoom' );
				// lightbox.
				add_theme_support( 'wc-product-gallery-lightbox' );
				// swipe.
				add_theme_support( 'wc-product-gallery-slider' );
			}
		}
	}
}
add_action( 'after_setup_theme', 'hello_elementor_setup' );

/**
 * Custom 404 page styles
 */
function hello_elementor_404_styles() {
	if ( is_404() ) {
		?>
		<style>
		.page-content ul {
			margin: 1em 0;
			padding-left: 2em;
		}
		.search-section, .nav-menu-section, .recent-posts-section, .popular-pages-section {
			margin: 2em 0;
			padding: 1em;
			background: #f9f9f9;
			border-radius: 5px;
		}
		.back-home {
			text-align: center;
			margin-top: 2em;
		}
		.back-home .button {
			display: inline-block;
			padding: 0.8em 1.5em;
			background: #0073aa;
			color: white;
			text-decoration: none;
			border-radius: 3px;
		}
		.back-home .button:hover {
			background: #005a87;
		}
		.nav-menu-section ul {
			display: flex;
			flex-wrap: wrap;
			gap: 1em;
			list-style: none;
			padding: 0;
		}
		.nav-menu-section li a {
			padding: 0.5em 1em;
			background: #e1e1e1;
			text-decoration: none;
			border-radius: 3px;
		}
		</style>
		<?php
	}
}
add_action( 'wp_head', 'hello_elementor_404_styles' );

/**
 * Log 404 errors for debugging
 */
function hello_elementor_log_404() {
	if ( is_404() ) {
		$requested_url = $_SERVER['REQUEST_URI'] ?? 'Unknown';
		$referer = $_SERVER['HTTP_REFERER'] ?? 'Direct';
		$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
		
		$log_message = sprintf(
			"[404 Error] URL: %s | Referer: %s | User Agent: %s | Time: %s",
			$requested_url,
			$referer,
			$user_agent,
			date('Y-m-d H:i:s')
		);
		
		error_log($log_message);
	}
}
add_action( 'wp', 'hello_elementor_log_404' );

/**
 * Add search form if not available
 */
function hello_elementor_search_form() {
	if ( ! function_exists( 'get_search_form' ) ) {
		?>
		<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<label>
				<span class="screen-reader-text"><?php echo _x( 'Search for:', 'label', 'hello-elementor' ); ?></span>
				<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search ...', 'placeholder', 'hello-elementor' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
			</label>
			<input type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'hello-elementor' ); ?>" />
		</form>
		<?php
	}
}

/**
 * Create default navigation menu
 */
function hello_elementor_create_default_menu() {
    // Check if menu already exists
    $menu_name = 'Main Navigation';
    $menu_exists = wp_get_nav_menu_object($menu_name);
    
    if (!$menu_exists) {
        $menu_id = wp_create_nav_menu($menu_name);
        
        // Add menu items for essential pages
        $pages = array('home', 'about', 'services', 'blog', 'contact');
        
        foreach ($pages as $page_slug) {
            $page = get_page_by_path($page_slug);
            if ($page) {
                wp_update_nav_menu_item($menu_id, 0, array(
                    'menu-item-title' => $page->post_title,
                    'menu-item-object' => 'page',
                    'menu-item-object-id' => $page->ID,
                    'menu-item-type' => 'post_type',
                    'menu-item-status' => 'publish'
                ));
            }
        }
        
        // Set as header menu
        $locations = get_theme_mod('nav_menu_locations');
        $locations['menu-1'] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);
    }
}
add_action('wp_loaded', 'hello_elementor_create_default_menu');

/**
 * Navigation verification and debugging
 */
function hello_elementor_verify_navigation() {
    // Only for admin users and when ?debug=nav is added to URL
    if (!current_user_can('manage_options') || !isset($_GET['debug']) || $_GET['debug'] !== 'nav') {
        return;
    }
    
    echo '<div style="position: fixed; top: 32px; right: 0; background: #fff; padding: 10px; border: 1px solid #ccc; max-width: 300px; z-index: 9999;">';
    echo '<h4>Navigation Debug Info</h4>';
    
    // Check pages
    $pages = array('home', 'about', 'services', 'contact', 'blog');
    echo '<strong>Pages:</strong><br>';
    foreach ($pages as $slug) {
        $page = get_page_by_path($slug);
        echo $slug . ': ' . ($page ? '✓' : '✗') . '<br>';
    }
    
    // Check menu
    $menu_locations = get_nav_menu_locations();
    echo '<strong>Header Menu:</strong> ' . (isset($menu_locations['menu-1']) ? '✓' : '✗') . '<br>';
    
    // Check permalinks
    echo '<strong>Permalinks:</strong> ' . (get_option('permalink_structure') ? '✓' : '✗') . '<br>';
    
    echo '</div>';
}
add_action('wp_footer', 'hello_elementor_verify_navigation');

/**
 * Add navigation test widget to admin dashboard
 */
function hello_elementor_dashboard_widget() {
    wp_add_dashboard_widget(
        'authorpad_nav_status',
        'Navigation Status',
        'hello_elementor_nav_dashboard_content'
    );
}

function hello_elementor_nav_dashboard_content() {
    $issues = array();
    
    // Check essential pages
    $pages = array('home', 'about', 'services', 'contact', 'blog');
    $missing_pages = array();
    foreach ($pages as $slug) {
        if (!get_page_by_path($slug)) {
            $missing_pages[] = $slug;
        }
    }
    
    if ($missing_pages) {
        $issues[] = count($missing_pages) . ' essential pages missing: ' . implode(', ', $missing_pages);
    }
    
    // Check menu
    $menu_locations = get_nav_menu_locations();
    if (!isset($menu_locations['menu-1']) || !$menu_locations['menu-1']) {
        $issues[] = 'No header menu assigned';
    }
    
    // Check permalinks
    if (!get_option('permalink_structure')) {
        $issues[] = 'Using default permalink structure';
    }
    
    if (empty($issues)) {
        echo '<p style="color: green;">✓ All navigation components are working correctly!</p>';
        echo '<p><a href="' . home_url('?debug=nav') . '" target="_blank">View debug info on site</a></p>';
    } else {
        echo '<p style="color: red;">Issues found:</p>';
        echo '<ul>';
        foreach ($issues as $issue) {
            echo '<li>' . $issue . '</li>';
        }
        echo '</ul>';
        echo '<p><a href="' . admin_url('tools.php?page=authorpad-nav-test') . '">Run full navigation test</a></p>';
    }
}
add_action('wp_dashboard_setup', 'hello_elementor_dashboard_widget');

function hello_maybe_update_theme_version_in_db() {
	$theme_version_option_name = 'hello_theme_version';
	// The theme version saved in the database.
	$hello_theme_db_version = get_option( $theme_version_option_name );

	// If the 'hello_theme_version' option does not exist in the DB, or the version needs to be updated, do the update.
	if ( ! $hello_theme_db_version || version_compare( $hello_theme_db_version, HELLO_ELEMENTOR_VERSION, '<' ) ) {
		update_option( $theme_version_option_name, HELLO_ELEMENTOR_VERSION );
	}
}

if ( ! function_exists( 'hello_elementor_display_header_footer' ) ) {
	/**
	 * Check whether to display header footer.
	 *
	 * @return bool
	 */
	function hello_elementor_display_header_footer() {
		$hello_elementor_header_footer = true;

		return apply_filters( 'hello_elementor_header_footer', $hello_elementor_header_footer );
	}
}

if ( ! function_exists( 'hello_elementor_scripts_styles' ) ) {
	/**
	 * Theme Scripts & Styles.
	 *
	 * @return void
	 */
	function hello_elementor_scripts_styles() {
		if ( apply_filters( 'hello_elementor_enqueue_style', true ) ) {
			wp_enqueue_style(
				'hello-elementor',
				HELLO_THEME_STYLE_URL . 'reset.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}

		if ( apply_filters( 'hello_elementor_enqueue_theme_style', true ) ) {
			wp_enqueue_style(
				'hello-elementor-theme-style',
				HELLO_THEME_STYLE_URL . 'theme.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}

		if ( hello_elementor_display_header_footer() ) {
			wp_enqueue_style(
				'hello-elementor-header-footer',
				HELLO_THEME_STYLE_URL . 'header-footer.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}
	}
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_scripts_styles' );

if ( ! function_exists( 'hello_elementor_register_elementor_locations' ) ) {
	/**
	 * Register Elementor Locations.
	 *
	 * @param ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $elementor_theme_manager theme manager.
	 *
	 * @return void
	 */
	function hello_elementor_register_elementor_locations( $elementor_theme_manager ) {
		if ( apply_filters( 'hello_elementor_register_elementor_locations', true ) ) {
			$elementor_theme_manager->register_all_core_location();
		}
	}
}
add_action( 'elementor/theme/register_locations', 'hello_elementor_register_elementor_locations' );

if ( ! function_exists( 'hello_elementor_content_width' ) ) {
	/**
	 * Set default content width.
	 *
	 * @return void
	 */
	function hello_elementor_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'hello_elementor_content_width', 800 );
	}
}
add_action( 'after_setup_theme', 'hello_elementor_content_width', 0 );

if ( ! function_exists( 'hello_elementor_add_description_meta_tag' ) ) {
	/**
	 * Add description meta tag with excerpt text.
	 *
	 * @return void
	 */
	function hello_elementor_add_description_meta_tag() {
		if ( ! apply_filters( 'hello_elementor_description_meta_tag', true ) ) {
			return;
		}

		if ( ! is_singular() ) {
			return;
		}

		$post = get_queried_object();
		if ( empty( $post->post_excerpt ) ) {
			return;
		}

		echo '<meta name="description" content="' . esc_attr( wp_strip_all_tags( $post->post_excerpt ) ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'hello_elementor_add_description_meta_tag' );

// Settings page
require get_template_directory() . '/includes/settings-functions.php';

// Header & footer styling option, inside Elementor
require get_template_directory() . '/includes/elementor-functions.php';

if ( ! function_exists( 'hello_elementor_customizer' ) ) {
	// Customizer controls
	function hello_elementor_customizer() {
		if ( ! is_customize_preview() ) {
			return;
		}

		if ( ! hello_elementor_display_header_footer() ) {
			return;
		}

		require get_template_directory() . '/includes/customizer-functions.php';
	}
}
add_action( 'init', 'hello_elementor_customizer' );

if ( ! function_exists( 'hello_elementor_check_hide_title' ) ) {
	/**
	 * Check whether to display the page title.
	 *
	 * @param bool $val default value.
	 *
	 * @return bool
	 */
	function hello_elementor_check_hide_title( $val ) {
		if ( defined( 'ELEMENTOR_VERSION' ) ) {
			$current_doc = Elementor\Plugin::instance()->documents->get( get_the_ID() );
			if ( $current_doc && 'yes' === $current_doc->get_settings( 'hide_title' ) ) {
				$val = false;
			}
		}
		return $val;
	}
}
add_filter( 'hello_elementor_page_title', 'hello_elementor_check_hide_title' );

/**
 * BC:
 * In v2.7.0 the theme removed the `hello_elementor_body_open()` from `header.php` replacing it with `wp_body_open()`.
 * The following code prevents fatal errors in child themes that still use this function.
 */
if ( ! function_exists( 'hello_elementor_body_open' ) ) {
	function hello_elementor_body_open() {
		wp_body_open();
	}
}

require HELLO_THEME_PATH . '/theme.php';

HelloTheme\Theme::instance();
