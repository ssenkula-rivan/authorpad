<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package HelloElementor
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<main id="content" class="site-main">

	<?php if ( apply_filters( 'hello_elementor_page_title', true ) ) : ?>
		<div class="page-header">
			<h1 class="entry-title"><?php echo esc_html__( 'Page Not Found', 'hello-elementor' ); ?></h1>
		</div>
	<?php endif; ?>

	<div class="page-content">
		<p><?php echo esc_html__( 'Sorry, the page you are looking for could not be found. This might be because:', 'hello-elementor' ); ?></p>
		
		<ul>
			<li><?php echo esc_html__( 'The page has been moved or deleted', 'hello-elementor' ); ?></li>
			<li><?php echo esc_html__( 'You typed the web address incorrectly', 'hello-elementor' ); ?></li>
			<li><?php echo esc_html__( 'The link you followed is broken or outdated', 'hello-elementor' ); ?></li>
		</ul>

		<h3><?php echo esc_html__( 'What can you do?', 'hello-elementor' ); ?></h3>
		
		<!-- Search Form -->
		<div class="search-section">
			<p><?php echo esc_html__( 'Try searching for what you need:', 'hello-elementor' ); ?></p>
			<?php get_search_form(); ?>
		</div>

		<!-- Navigation Menu -->
		<?php if ( has_nav_menu( 'menu-1' ) ) : ?>
			<div class="nav-menu-section">
				<h4><?php echo esc_html__( 'Browse our main sections:', 'hello-elementor' ); ?></h4>
				<?php
				wp_nav_menu( array(
					'theme_location' => 'menu-1',
					'container'      => 'nav',
					'container_class' => 'main-navigation',
					'fallback_cb'    => false,
				) );
				?>
			</div>
		<?php endif; ?>

		<!-- Recent Posts -->
		<div class="recent-posts-section">
			<h4><?php echo esc_html__( 'Recent Posts:', 'hello-elementor' ); ?></h4>
			<?php
			$recent_posts = wp_get_recent_posts( array(
				'numberposts' => 5,
				'post_status' => 'publish'
			) );
			
			if ( $recent_posts ) : ?>
				<ul>
					<?php foreach ( $recent_posts as $post ) : ?>
						<li><a href="<?php echo get_permalink( $post['ID'] ); ?>"><?php echo esc_html( $post['post_title'] ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>

		<!-- Popular Pages -->
		<div class="popular-pages-section">
			<h4><?php echo esc_html__( 'Popular Pages:', 'hello-elementor' ); ?></h4>
			<?php
			$pages = get_pages( array(
				'sort_order' => 'ASC',
				'sort_column' => 'menu_order',
				'number' => 5
			) );
			
			if ( $pages ) : ?>
				<ul>
					<?php foreach ( $pages as $page ) : ?>
						<li><a href="<?php echo get_permalink( $page->ID ); ?>"><?php echo esc_html( $page->post_title ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>

		<!-- Back to Home -->
		<div class="back-home">
			<p><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="button"><?php echo esc_html__( '← Back to Home', 'hello-elementor' ); ?></a></p>
		</div>
	</div>

</main>
