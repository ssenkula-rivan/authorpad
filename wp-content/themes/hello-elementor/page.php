<?php
/**
 * The template for displaying pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @package HelloElementor
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();

$is_elementor_theme_exist = function_exists( 'elementor_theme_do_location' );

if ( ! $is_elementor_theme_exist || ! elementor_theme_do_location( 'single' ) ) {
	while ( have_posts() ) :
		the_post();
		?>

		<main id="content" <?php post_class( 'site-main' ); ?>>

			<?php if ( apply_filters( 'hello_elementor_page_title', true ) ) : ?>
				<div class="page-header">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				</div>
			<?php endif; ?>

			<div class="page-content">
				<?php
				the_content();
				
				// Display child pages if this is a parent page
				$child_pages = get_children( array(
					'post_parent' => get_the_ID(),
					'post_type'   => 'page',
					'post_status' => 'publish'
				) );
				
				if ( $child_pages ) : ?>
					<div class="child-pages">
						<h3><?php esc_html_e( 'Sub Pages', 'hello-elementor' ); ?></h3>
						<ul>
							<?php foreach ( $child_pages as $child ) : ?>
								<li><a href="<?php echo get_permalink( $child->ID ); ?>"><?php echo esc_html( $child->post_title ); ?></a></li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>

				<?php wp_link_pages(); ?>
			</div>

			<?php
			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
			?>

		</main>

		<?php
	endwhile;
}

get_footer();