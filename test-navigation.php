<?php
/**
 * Navigation Testing Script for AuthorPad.ug
 * 
 * This script tests all navigation links and verifies page functionality
 * Run this script to ensure all pages are working correctly
 */

// Load WordPress
require_once dirname(__FILE__) . '/wp-config.php';

class NavigationTester {
    
    private $test_results = array();
    private $errors = array();
    
    public function __construct() {
        $this->run_all_tests();
        $this->display_results();
    }
    
    private function run_all_tests() {
        echo "<h1>AuthorPad Navigation Testing Results</h1>\n";
        echo "<p>Testing all navigation links and page functionality...</p>\n";
        
        $this->test_essential_pages();
        $this->test_permalink_structure();
        $this->test_menu_functionality();
        $this->test_404_handling();
        $this->test_home_page_setup();
        $this->test_blog_page_setup();
    }
    
    private function test_essential_pages() {
        echo "<h2>Testing Essential Pages</h2>\n";
        
        $required_pages = array(
            'home' => 'Home',
            'about' => 'About Us', 
            'services' => 'Services',
            'contact' => 'Contact',
            'blog' => 'Blog',
            'privacy-policy' => 'Privacy Policy',
            'terms-of-service' => 'Terms of Service'
        );
        
        foreach ($required_pages as $slug => $title) {
            $page = get_page_by_path($slug);
            
            if ($page) {
                $this->test_results[] = "✓ Page '$title' exists (ID: {$page->ID})";
                
                // Test if page is published
                if ($page->post_status === 'publish') {
                    $this->test_results[] = "✓ Page '$title' is published";
                } else {
                    $this->errors[] = "✗ Page '$title' exists but is not published";
                }
                
                // Test permalink
                $permalink = get_permalink($page->ID);
                if ($permalink) {
                    $this->test_results[] = "✓ Page '$title' has valid permalink: $permalink";
                } else {
                    $this->errors[] = "✗ Page '$title' has invalid permalink";
                }
                
            } else {
                $this->errors[] = "✗ Required page '$title' ($slug) does not exist";
            }
        }
    }
    
    private function test_permalink_structure() {
        echo "<h2>Testing Permalink Structure</h2>\n";
        
        $permalink_structure = get_option('permalink_structure');
        if ($permalink_structure) {
            $this->test_results[] = "✓ Custom permalink structure is set: $permalink_structure";
        } else {
            $this->errors[] = "✗ Using default permalinks (may cause navigation issues)";
        }
        
        // Test .htaccess
        $htaccess_path = ABSPATH . '.htaccess';
        if (file_exists($htaccess_path)) {
            $htaccess_content = file_get_contents($htaccess_path);
            if (strpos($htaccess_content, 'RewriteEngine On') !== false) {
                $this->test_results[] = "✓ .htaccess file exists and has rewrite rules";
            } else {
                $this->errors[] = "✗ .htaccess file exists but missing rewrite rules";
            }
        } else {
            $this->errors[] = "✗ .htaccess file not found";
        }
    }
    
    private function test_menu_functionality() {
        echo "<h2>Testing Navigation Menus</h2>\n";
        
        // Check if menus are registered
        $nav_menus = get_registered_nav_menus();
        if (!empty($nav_menus)) {
            $this->test_results[] = "✓ Navigation menus are registered: " . implode(', ', array_keys($nav_menus));
        } else {
            $this->errors[] = "✗ No navigation menus are registered";
        }
        
        // Check if header menu exists
        $menu_locations = get_nav_menu_locations();
        if (isset($menu_locations['menu-1']) && $menu_locations['menu-1']) {
            $menu = wp_get_nav_menu_object($menu_locations['menu-1']);
            if ($menu) {
                $this->test_results[] = "✓ Header menu exists: {$menu->name}";
                
                // Count menu items
                $menu_items = wp_get_nav_menu_items($menu->term_id);
                if ($menu_items) {
                    $this->test_results[] = "✓ Header menu has " . count($menu_items) . " items";
                } else {
                    $this->errors[] = "✗ Header menu exists but has no items";
                }
            } else {
                $this->errors[] = "✗ Header menu location is set but menu doesn't exist";
            }
        } else {
            $this->errors[] = "✗ No header menu is assigned";
        }
    }
    
    private function test_404_handling() {
        echo "<h2>Testing 404 Error Handling</h2>\n";
        
        // Check if 404.php template exists
        $template_404 = locate_template('404.php');
        if ($template_404) {
            $this->test_results[] = "✓ Custom 404.php template exists";
        } else {
            $this->errors[] = "✗ No custom 404.php template found";
        }
        
        // Check if 404 template part exists
        $template_404_part = locate_template('template-parts/404.php');
        if ($template_404_part) {
            $this->test_results[] = "✓ 404 template part exists";
        } else {
            $this->errors[] = "✗ 404 template part not found";
        }
    }
    
    private function test_home_page_setup() {
        echo "<h2>Testing Home Page Configuration</h2>\n";
        
        $show_on_front = get_option('show_on_front');
        $page_on_front = get_option('page_on_front');
        
        if ($show_on_front === 'page' && $page_on_front) {
            $front_page = get_post($page_on_front);
            if ($front_page) {
                $this->test_results[] = "✓ Static front page is set: {$front_page->post_title}";
            } else {
                $this->errors[] = "✗ Front page is set but page doesn't exist";
            }
        } else {
            $this->test_results[] = "ℹ Using latest posts as front page (default behavior)";
        }
        
        // Check if front-page.php template exists
        $front_page_template = locate_template('front-page.php');
        if ($front_page_template) {
            $this->test_results[] = "✓ Custom front-page.php template exists";
        } else {
            $this->test_results[] = "ℹ Using default front page template";
        }
    }
    
    private function test_blog_page_setup() {
        echo "<h2>Testing Blog Page Configuration</h2>\n";
        
        $page_for_posts = get_option('page_for_posts');
        if ($page_for_posts) {
            $blog_page = get_post($page_for_posts);
            if ($blog_page) {
                $this->test_results[] = "✓ Blog page is set: {$blog_page->post_title}";
            } else {
                $this->errors[] = "✗ Blog page is set but page doesn't exist";
            }
        } else {
            $this->test_results[] = "ℹ No dedicated blog page set";
        }
    }
    
    private function display_results() {
        echo "<h2>Test Summary</h2>\n";
        
        echo "<h3>Successful Tests (" . count($this->test_results) . ")</h3>\n";
        echo "<ul>\n";
        foreach ($this->test_results as $result) {
            echo "<li style='color: green;'>$result</li>\n";
        }
        echo "</ul>\n";
        
        if (!empty($this->errors)) {
            echo "<h3>Issues Found (" . count($this->errors) . ")</h3>\n";
            echo "<ul>\n";
            foreach ($this->errors as $error) {
                echo "<li style='color: red;'>$error</li>\n";
            }
            echo "</ul>\n";
        } else {
            echo "<h3 style='color: green;'>✓ All Tests Passed!</h3>\n";
        }
        
        $this->display_recommendations();
    }
    
    private function display_recommendations() {
        echo "<h2>Recommendations</h2>\n";
        
        echo "<h3>Next Steps:</h3>\n";
        echo "<ol>\n";
        echo "<li>Activate the 'AuthorPad Essential Pages' plugin to create missing pages</li>\n";
        echo "<li>Go to Appearance > Menus to verify and customize navigation</li>\n";
        echo "<li>Visit Settings > Permalinks and click 'Save Changes' to refresh URL structure</li>\n";
        echo "<li>Test each page manually by clicking navigation links</li>\n";
        echo "<li>Check 404 error logs to identify any remaining broken links</li>\n";
        echo "</ol>\n";
        
        echo "<h3>WordPress Admin Links:</h3>\n";
        echo "<ul>\n";
        echo "<li><a href='" . admin_url('nav-menus.php') . "'>Manage Menus</a></li>\n";
        echo "<li><a href='" . admin_url('options-permalink.php') . "'>Permalink Settings</a></li>\n";
        echo "<li><a href='" . admin_url('edit.php?post_type=page') . "'>Manage Pages</a></li>\n";
        echo "<li><a href='" . admin_url('plugins.php') . "'>Manage Plugins</a></li>\n";
        echo "</ul>\n";
    }
}

// Run the tests
new NavigationTester();