<?php
/**
 * The template for displaying the front page
 *
 * This is the template that displays the front page or home page
 *
 * @package HelloElementor
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();

$is_elementor_theme_exist = function_exists( 'elementor_theme_do_location' );

if ( ! $is_elementor_theme_exist || ! elementor_theme_do_location( 'single' ) ) {
	?>
	<main id="content" class="site-main">
		<?php
		// If front page is set to display a static page
		if ( get_option( 'show_on_front' ) == 'page' ) {
			while ( have_posts() ) :
				the_post();
				?>
				<div class="page-header">
					<?php if ( apply_filters( 'hello_elementor_page_title', true ) ) : ?>
						<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
					<?php endif; ?>
				</div>
				<div class="page-content">
					<?php the_content(); ?>
					<?php wp_link_pages(); ?>
				</div>
				<?php
			endwhile;
		} else {
			// If front page is set to display latest posts
			?>
			<div class="page-header">
				<h1 class="entry-title"><?php bloginfo( 'name' ); ?></h1>
				<?php if ( get_bloginfo( 'description' ) ) : ?>
					<p class="site-description"><?php bloginfo( 'description' ); ?></p>
				<?php endif; ?>
			</div>
			
			<div class="posts-container">
				<?php
				if ( have_posts() ) :
					while ( have_posts() ) :
						the_post();
						?>
						<article <?php post_class(); ?>>
							<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<div class="entry-meta">
								<?php echo get_the_date(); ?>
							</div>
							<div class="entry-summary">
								<?php the_excerpt(); ?>
							</div>
						</article>
						<?php
					endwhile;
					
					// Pagination
					the_posts_pagination();
				else :
					?>
					<p><?php esc_html_e( 'No posts found.', 'hello-elementor' ); ?></p>
					<?php
				endif;
				?>
			</div>
			<?php
		}
		?>
	</main>
	<?php
}

get_footer();