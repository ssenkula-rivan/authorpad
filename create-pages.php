<?php
/**
 * Script to create essential WordPress pages
 * Run this once via wp-admin or command line to create missing pages
 */

// Ensure WordPress is loaded
if (!defined('ABSPATH')) {
    require_once dirname(__FILE__) . '/wp-config.php';
}

// Array of essential pages to create
$essential_pages = array(
    array(
        'title' => 'Home',
        'slug' => 'home',
        'content' => '<h2>Welcome to AuthorPad</h2>
        <p>AuthorPad is your premier platform for writing, publishing, and sharing your creative works. Whether you\'re a seasoned author or just starting your writing journey, we provide the tools and community you need to succeed.</p>
        
        <h3>What We Offer:</h3>
        <ul>
        <li>Professional writing tools and editors</li>
        <li>Publishing and distribution services</li>
        <li>Community of writers and readers</li>
        <li>Educational resources and tutorials</li>
        </ul>
        
        <p><a href="/about">Learn more about us</a> or <a href="/contact">get in touch</a> to start your writing journey today!</p>',
        'template' => 'page'
    ),
    array(
        'title' => 'About',
        'slug' => 'about',
        'content' => '<h2>About AuthorPad</h2>
        <p>AuthorPad was founded with a simple mission: to empower writers and connect them with readers worldwide. Our platform combines cutting-edge technology with a deep understanding of the writing process.</p>
        
        <h3>Our Story</h3>
        <p>Founded in Uganda, AuthorPad has grown from a local initiative to support emerging African writers into a global platform serving authors from all continents. We believe every story deserves to be told and every writer deserves the tools to tell it well.</p>
        
        <h3>Our Vision</h3>
        <p>To become the leading platform where writers can create, publish, and monetize their content while building meaningful connections with their audience.</p>
        
        <h3>Our Values</h3>
        <ul>
        <li><strong>Creativity:</strong> We celebrate and nurture creative expression</li>
        <li><strong>Community:</strong> We believe in the power of connection</li>
        <li><strong>Quality:</strong> We strive for excellence in everything we do</li>
        <li><strong>Accessibility:</strong> We make writing tools available to everyone</li>
        </ul>',
        'template' => 'page'
    ),
    array(
        'title' => 'Services',
        'slug' => 'services',
        'content' => '<h2>Our Services</h2>
        <p>AuthorPad offers a comprehensive suite of services designed to support writers at every stage of their journey.</p>
        
        <div class="service-grid">
        <h3>Writing Tools</h3>
        <p>Professional-grade writing software with grammar checking, style suggestions, and collaboration features.</p>
        
        <h3>Publishing Support</h3>
        <p>End-to-end publishing assistance including editing, formatting, cover design, and distribution.</p>
        
        <h3>Marketing & Promotion</h3>
        <p>Help authors build their audience through social media marketing, book promotion, and author branding.</p>
        
        <h3>Educational Resources</h3>
        <p>Workshops, webinars, and courses on writing craft, publishing, and the business of writing.</p>
        
        <h3>Community Platform</h3>
        <p>Connect with other writers, join critique groups, and participate in writing challenges.</p>
        
        <h3>Monetization Tools</h3>
        <p>Multiple revenue streams including subscriptions, one-time purchases, and crowdfunding options.</p>
        </div>
        
        <p><a href="/contact">Contact us</a> to learn more about how we can help you succeed as a writer.</p>',
        'template' => 'page'
    ),
    array(
        'title' => 'Contact',
        'slug' => 'contact',
        'content' => '<h2>Contact Us</h2>
        <p>We\'d love to hear from you! Whether you have questions about our services, need technical support, or want to explore partnership opportunities, we\'re here to help.</p>
        
        <div class="contact-info">
        <h3>Get In Touch</h3>
        <p><strong>Email:</strong> info@authorpad.ug</p>
        <p><strong>Support:</strong> support@authorpad.ug</p>
        <p><strong>Phone:</strong> +256 XXX XXX XXX</p>
        
        <h3>Office Address</h3>
        <p>AuthorPad Uganda<br>
        [Your Address Here]<br>
        Kampala, Uganda</p>
        
        <h3>Business Hours</h3>
        <p>Monday - Friday: 9:00 AM - 6:00 PM (EAT)<br>
        Saturday: 10:00 AM - 2:00 PM (EAT)<br>
        Sunday: Closed</p>
        </div>
        
        <h3>Send us a Message</h3>
        <p>Use the contact form below to send us your message directly:</p>
        
        [contact-form-7 id="contact" title="Contact form"]
        
        <h3>Follow Us</h3>
        <p>Stay connected with AuthorPad on social media:</p>
        <ul>
        <li>Twitter: @authorpadug</li>
        <li>Facebook: AuthorPad Uganda</li>
        <li>LinkedIn: AuthorPad</li>
        <li>Instagram: @authorpadug</li>
        </ul>',
        'template' => 'page'
    ),
    array(
        'title' => 'Blog',
        'slug' => 'blog',
        'content' => '<h2>AuthorPad Blog</h2>
        <p>Welcome to the AuthorPad blog! Here you\'ll find the latest news, writing tips, author interviews, industry insights, and updates from our community.</p>
        
        <h3>Recent Posts</h3>
        <p>Discover our latest articles and insights on writing, publishing, and the literary world.</p>
        
        [recent_posts number="5"]
        
        <h3>Categories</h3>
        <ul>
        <li><a href="/category/writing-tips">Writing Tips</a></li>
        <li><a href="/category/author-interviews">Author Interviews</a></li>
        <li><a href="/category/industry-news">Industry News</a></li>
        <li><a href="/category/platform-updates">Platform Updates</a></li>
        <li><a href="/category/community-spotlights">Community Spotlights</a></li>
        </ul>',
        'template' => 'page'
    ),
    array(
        'title' => 'Privacy Policy',
        'slug' => 'privacy-policy',
        'content' => '<h2>Privacy Policy</h2>
        <p><strong>Last updated:</strong> [Date]</p>
        
        <h3>Information We Collect</h3>
        <p>AuthorPad collects information you provide directly to us, such as when you create an account, update your profile, or contact us for support.</p>
        
        <h3>How We Use Your Information</h3>
        <p>We use the information we collect to provide, maintain, and improve our services, communicate with you, and ensure the security of our platform.</p>
        
        <h3>Information Sharing</h3>
        <p>We do not sell, trade, or otherwise transfer your personal information to third parties without your consent, except as described in this policy.</p>
        
        <h3>Data Security</h3>
        <p>We implement appropriate security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction.</p>
        
        <h3>Contact Us</h3>
        <p>If you have any questions about this Privacy Policy, please contact us at privacy@authorpad.ug</p>',
        'template' => 'page'
    ),
    array(
        'title' => 'Terms of Service',
        'slug' => 'terms-of-service',
        'content' => '<h2>Terms of Service</h2>
        <p><strong>Last updated:</strong> [Date]</p>
        
        <h3>Agreement to Terms</h3>
        <p>By accessing and using AuthorPad, you accept and agree to be bound by the terms and provision of this agreement.</p>
        
        <h3>User Accounts</h3>
        <p>When you create an account with us, you must provide information that is accurate, complete, and current at all times.</p>
        
        <h3>Acceptable Use</h3>
        <p>You may use our service for lawful purposes only. You agree not to use the service in any way that violates applicable laws or regulations.</p>
        
        <h3>Intellectual Property Rights</h3>
        <p>The service and its original content, features, and functionality are and will remain the exclusive property of AuthorPad and its licensors.</p>
        
        <h3>Termination</h3>
        <p>We may terminate or suspend your account immediately, without prior notice or liability, for any reason whatsoever.</p>
        
        <h3>Contact Information</h3>
        <p>If you have any questions about these Terms of Service, please contact us at legal@authorpad.ug</p>',
        'template' => 'page'
    )
);

function create_essential_pages() {
    global $essential_pages;
    
    $created_pages = array();
    $existing_pages = array();
    
    foreach ($essential_pages as $page_data) {
        // Check if page already exists
        $existing_page = get_page_by_path($page_data['slug']);
        
        if ($existing_page) {
            $existing_pages[] = $page_data['title'];
            continue;
        }
        
        // Create the page
        $page_args = array(
            'post_title'    => $page_data['title'],
            'post_content'  => $page_data['content'],
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_name'     => $page_data['slug'],
            'post_author'   => 1, // Admin user
        );
        
        $page_id = wp_insert_post($page_args);
        
        if ($page_id && !is_wp_error($page_id)) {
            $created_pages[] = $page_data['title'];
            
            // Set the Home page as the front page
            if ($page_data['slug'] === 'home') {
                update_option('show_on_front', 'page');
                update_option('page_on_front', $page_id);
            }
            
            // Set the Blog page as the posts page
            if ($page_data['slug'] === 'blog') {
                update_option('page_for_posts', $page_id);
            }
        }
    }
    
    return array(
        'created' => $created_pages,
        'existing' => $existing_pages
    );
}

// If running from command line or admin, execute the function
if (defined('WP_CLI') || (is_admin() && current_user_can('manage_options'))) {
    $result = create_essential_pages();
    
    echo "Page Creation Results:\n";
    echo "Created: " . implode(', ', $result['created']) . "\n";
    echo "Already Existed: " . implode(', ', $result['existing']) . "\n";
}