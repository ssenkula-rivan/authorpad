<?php
/**
 * Plugin Name: AuthorPad Essential Pages
 * Description: Creates essential pages for the AuthorPad website navigation
 * Version: 1.0
 * Author: AuthorPad Team
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class AuthorPadEssentialPages {
    
    public function __construct() {
        add_action('init', array($this, 'create_pages_if_needed'));
        add_action('admin_notices', array($this, 'show_admin_notice'));
    }
    
    public function create_pages_if_needed() {
        // Only run once
        if (get_option('authorpad_pages_created')) {
            return;
        }
        
        $this->create_essential_pages();
        update_option('authorpad_pages_created', true);
    }
    
    private function create_essential_pages() {
        $pages = array(
            array(
                'title' => 'Home',
                'slug' => 'home',
                'content' => $this->get_home_content(),
                'is_front_page' => true
            ),
            array(
                'title' => 'About Us',
                'slug' => 'about',
                'content' => $this->get_about_content()
            ),
            array(
                'title' => 'Services',
                'slug' => 'services', 
                'content' => $this->get_services_content()
            ),
            array(
                'title' => 'Contact',
                'slug' => 'contact',
                'content' => $this->get_contact_content()
            ),
            array(
                'title' => 'Blog',
                'slug' => 'blog',
                'content' => $this->get_blog_content(),
                'is_blog_page' => true
            ),
            array(
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => $this->get_privacy_content()
            ),
            array(
                'title' => 'Terms of Service',
                'slug' => 'terms-of-service',
                'content' => $this->get_terms_content()
            )
        );
        
        foreach ($pages as $page_data) {
            $this->create_page($page_data);
        }
    }
    
    private function create_page($page_data) {
        // Check if page exists
        if (get_page_by_path($page_data['slug'])) {
            return;
        }
        
        $page_args = array(
            'post_title'    => $page_data['title'],
            'post_content'  => $page_data['content'],
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_name'     => $page_data['slug'],
            'post_author'   => 1,
        );
        
        $page_id = wp_insert_post($page_args);
        
        if ($page_id && !is_wp_error($page_id)) {
            // Set as front page if specified
            if (isset($page_data['is_front_page']) && $page_data['is_front_page']) {
                update_option('show_on_front', 'page');
                update_option('page_on_front', $page_id);
            }
            
            // Set as blog page if specified  
            if (isset($page_data['is_blog_page']) && $page_data['is_blog_page']) {
                update_option('page_for_posts', $page_id);
            }
        }
    }
    
    private function get_home_content() {
        return '<h2>Welcome to AuthorPad Uganda</h2>
<p>Your premier platform for writing, publishing, and sharing creative works across East Africa and beyond.</p>

<div class="features">
<h3>What We Offer</h3>
<ul>
<li>Professional writing and editing tools</li>
<li>Publishing and distribution services</li>
<li>Community of African writers and readers</li>
<li>Educational resources and mentorship</li>
<li>Digital and print publishing options</li>
</ul>
</div>

<p><strong>Ready to start your writing journey?</strong> <a href="/about">Learn more about us</a> or <a href="/contact">get in touch</a> today!</p>';
    }
    
    private function get_about_content() {
        return '<h2>About AuthorPad Uganda</h2>
<p>AuthorPad is Uganda\'s leading platform for writers, providing tools and opportunities for creative expression and professional development.</p>

<h3>Our Mission</h3>
<p>To empower African writers by providing world-class tools, publishing opportunities, and a supportive community that celebrates our unique voices and stories.</p>

<h3>Our Story</h3>
<p>Founded in Kampala, AuthorPad grew from recognizing the need for better support systems for emerging African writers. We bridge the gap between traditional publishing and digital innovation.</p>

<h3>What Makes Us Different</h3>
<ul>
<li>Focus on African narratives and perspectives</li>
<li>Support for both English and local languages</li>
<li>Mentorship programs with established authors</li>
<li>Direct connection to regional and international markets</li>
</ul>';
    }
    
    private function get_services_content() {
        return '<h2>Our Services</h2>
<p>Comprehensive support for writers at every stage of their journey.</p>

<h3>Writing Platform</h3>
<p>State-of-the-art writing tools with collaboration features, version control, and integrated research capabilities.</p>

<h3>Publishing Services</h3>
<p>End-to-end publishing support including professional editing, formatting, cover design, and distribution across multiple channels.</p>

<h3>Author Development</h3>
<p>Workshops, masterclasses, and one-on-one mentoring with established authors and industry professionals.</p>

<h3>Community & Networking</h3>
<p>Connect with fellow writers, join critique groups, participate in writing contests, and attend literary events.</p>

<h3>Marketing Support</h3>
<p>Book promotion, author branding, social media strategy, and access to media opportunities.</p>

<p><a href="/contact">Contact us</a> to discuss your writing goals and how we can help you achieve them.</p>';
    }
    
    private function get_contact_content() {
        return '<h2>Get In Touch</h2>
<p>We\'re here to support your writing journey. Reach out with questions, ideas, or collaboration opportunities.</p>

<h3>Contact Information</h3>
<p><strong>Email:</strong> info@authorpad.ug<br>
<strong>Phone:</strong> +256 XXX XXX XXX<br>
<strong>WhatsApp:</strong> +256 XXX XXX XXX</p>

<h3>Office Location</h3>
<p>Kampala, Uganda<br>
[Physical address to be updated]</p>

<h3>Business Hours</h3>
<p>Monday - Friday: 9:00 AM - 6:00 PM (EAT)<br>
Saturday: 10:00 AM - 2:00 PM (EAT)<br>
Sunday: Closed</p>

<h3>For Writers</h3>
<p>Ready to join our community? Send us your writing samples and tell us about your goals.</p>

<h3>For Publishers & Partners</h3>
<p>Interested in collaboration? Let\'s discuss how we can work together to support African literature.</p>';
    }
    
    private function get_blog_content() {
        return '<h2>AuthorPad Blog</h2>
<p>Discover the latest in African literature, writing craft, publishing insights, and author spotlights.</p>

<h3>Featured Categories</h3>
<ul>
<li><strong>Writing Craft:</strong> Tips and techniques to improve your writing</li>
<li><strong>Author Spotlight:</strong> Interviews and profiles of African writers</li>
<li><strong>Industry News:</strong> Publishing trends and opportunities</li>
<li><strong>Platform Updates:</strong> New features and community news</li>
<li><strong>Cultural Stories:</strong> Celebrating African narratives and traditions</li>
</ul>

<p>Our blog features contributions from established authors, industry experts, and emerging voices from across the continent.</p>';
    }
    
    private function get_privacy_content() {
        return '<h2>Privacy Policy</h2>
<p><em>Last updated: ' . date('F j, Y') . '</em></p>

<h3>Information We Collect</h3>
<p>We collect information you provide when creating an account, submitting content, or contacting us for support.</p>

<h3>How We Use Your Information</h3>
<p>Your information helps us provide and improve our services, communicate updates, and ensure platform security.</p>

<h3>Information Sharing</h3>
<p>We do not sell or share your personal information with third parties except as necessary to provide our services or as required by law.</p>

<h3>Data Security</h3>
<p>We implement industry-standard security measures to protect your personal information and creative works.</p>

<h3>Your Rights</h3>
<p>You have the right to access, update, or delete your personal information at any time through your account settings.</p>

<p>For questions about this policy, contact us at privacy@authorpad.ug</p>';
    }
    
    private function get_terms_content() {
        return '<h2>Terms of Service</h2>
<p><em>Last updated: ' . date('F j, Y') . '</em></p>

<h3>Acceptance of Terms</h3>
<p>By using AuthorPad, you agree to these terms and our community guidelines.</p>

<h3>User Accounts</h3>
<p>You are responsible for maintaining the confidentiality of your account and all activities under your account.</p>

<h3>Content and Copyright</h3>
<p>You retain ownership of content you create. By posting content, you grant us a limited license to display and distribute it through our platform.</p>

<h3>Acceptable Use</h3>
<p>Our platform is for creative expression within legal and ethical boundaries. Prohibited content includes hate speech, plagiarism, and illegal material.</p>

<h3>Service Availability</h3>
<p>We strive for 99.9% uptime but cannot guarantee uninterrupted service due to maintenance and technical requirements.</p>

<p>Questions about these terms? Contact legal@authorpad.ug</p>';
    }
    
    public function show_admin_notice() {
        if (get_option('authorpad_pages_created') && !get_option('authorpad_notice_dismissed')) {
            echo '<div class="notice notice-success is-dismissible">
                <p>AuthorPad essential pages have been created successfully!</p>
            </div>';
            update_option('authorpad_notice_dismissed', true);
        }
    }
}

new AuthorPadEssentialPages();

/**
 * Add admin page for navigation testing
 */
class AuthorPadNavigationTester {
    
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_page'));
    }
    
    public function add_admin_page() {
        add_management_page(
            'Navigation Tester',
            'Navigation Tester', 
            'manage_options',
            'authorpad-nav-test',
            array($this, 'admin_page_content')
        );
    }
    
    public function admin_page_content() {
        ?>
        <div class="wrap">
            <h1>AuthorPad Navigation Tester</h1>
            <p>This tool tests all navigation links and page functionality to ensure your website is working correctly.</p>
            
            <?php $this->run_navigation_tests(); ?>
            
            <div style="margin-top: 20px; padding: 15px; background: #f1f1f1; border-left: 4px solid #0073aa;">
                <h3>Manual Testing Steps:</h3>
                <ol>
                    <li>Visit your website homepage</li>
                    <li>Click each menu item to verify pages load correctly</li>
                    <li>Try accessing non-existent URLs to test 404 handling</li>
                    <li>Test search functionality if available</li>
                    <li>Check responsive design on mobile devices</li>
                </ol>
            </div>
        </div>
        <?php
    }
    
    private function run_navigation_tests() {
        echo "<div class='notice notice-info'><p>Running navigation tests...</p></div>";
        
        // Test essential pages
        $this->test_pages();
        $this->test_menus();
        $this->test_permalinks();
    }
    
    private function test_pages() {
        echo "<h2>Page Status</h2>";
        echo "<table class='wp-list-table widefat fixed striped'>";
        echo "<thead><tr><th>Page</th><th>Status</th><th>URL</th><th>Action</th></tr></thead>";
        echo "<tbody>";
        
        $pages = array('home', 'about', 'services', 'contact', 'blog', 'privacy-policy', 'terms-of-service');
        
        foreach ($pages as $slug) {
            $page = get_page_by_path($slug);
            echo "<tr>";
            echo "<td>" . ucfirst(str_replace('-', ' ', $slug)) . "</td>";
            
            if ($page) {
                echo "<td><span style='color: green;'>✓ Exists</span></td>";
                echo "<td><a href='" . get_permalink($page->ID) . "' target='_blank'>" . get_permalink($page->ID) . "</a></td>";
                echo "<td><a href='" . admin_url('post.php?post=' . $page->ID . '&action=edit') . "'>Edit</a></td>";
            } else {
                echo "<td><span style='color: red;'>✗ Missing</span></td>";
                echo "<td>-</td>";
                echo "<td>Create manually or activate plugin</td>";
            }
            echo "</tr>";
        }
        
        echo "</tbody></table>";
    }
    
    private function test_menus() {
        echo "<h2>Navigation Menu Status</h2>";
        
        $menu_locations = get_nav_menu_locations();
        $registered_menus = get_registered_nav_menus();
        
        echo "<table class='wp-list-table widefat fixed striped'>";
        echo "<thead><tr><th>Menu Location</th><th>Assigned Menu</th><th>Status</th><th>Action</th></tr></thead>";
        echo "<tbody>";
        
        foreach ($registered_menus as $location => $description) {
            echo "<tr>";
            echo "<td>$description ($location)</td>";
            
            if (isset($menu_locations[$location]) && $menu_locations[$location]) {
                $menu = wp_get_nav_menu_object($menu_locations[$location]);
                if ($menu) {
                    echo "<td>{$menu->name}</td>";
                    echo "<td><span style='color: green;'>✓ Active</span></td>";
                    echo "<td><a href='" . admin_url('nav-menus.php?action=edit&menu=' . $menu->term_id) . "'>Edit Menu</a></td>";
                } else {
                    echo "<td>Invalid menu assigned</td>";
                    echo "<td><span style='color: red;'>✗ Error</span></td>";
                    echo "<td><a href='" . admin_url('nav-menus.php') . "'>Fix Menu</a></td>";
                }
            } else {
                echo "<td>No menu assigned</td>";
                echo "<td><span style='color: orange;'>⚠ Not Set</span></td>";
                echo "<td><a href='" . admin_url('nav-menus.php') . "'>Assign Menu</a></td>";
            }
            echo "</tr>";
        }
        
        echo "</tbody></table>";
    }
    
    private function test_permalinks() {
        echo "<h2>Permalink Structure</h2>";
        
        $permalink_structure = get_option('permalink_structure');
        $flush_rules_needed = get_option('rewrite_rules') === false;
        
        echo "<table class='wp-list-table widefat fixed striped'>";
        echo "<thead><tr><th>Setting</th><th>Value</th><th>Status</th></tr></thead>";
        echo "<tbody>";
        
        echo "<tr>";
        echo "<td>Permalink Structure</td>";
        echo "<td>" . ($permalink_structure ?: 'Default (Plain)') . "</td>";
        echo "<td>" . ($permalink_structure ? "<span style='color: green;'>✓ Custom</span>" : "<span style='color: orange;'>⚠ Plain</span>") . "</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td>Rewrite Rules</td>";
        echo "<td>" . ($flush_rules_needed ? "Need refresh" : "Current") . "</td>";
        echo "<td>" . ($flush_rules_needed ? "<span style='color: orange;'>⚠ Refresh needed</span>" : "<span style='color: green;'>✓ Current</span>") . "</td>";
        echo "</tr>";
        
        echo "</tbody></table>";
        
        if ($flush_rules_needed || !$permalink_structure) {
            echo "<p><a href='" . admin_url('options-permalink.php') . "' class='button button-primary'>Update Permalink Settings</a></p>";
        }
    }
}

new AuthorPadNavigationTester();