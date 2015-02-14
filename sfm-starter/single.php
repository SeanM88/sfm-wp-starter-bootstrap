<?php
/**
 * The template for displaying all single posts.
 *
 * @package sfm-starter
 */

get_header(); ?>

	<div class="container">
		<div class="row">

			<div id="primary" class="col-sm-8">
				<main id="main" class="site-main" role="main">
		
				<?php while ( have_posts() ) : the_post(); ?>
		
					<?php get_template_part( 'content', 'single' ); ?>
		
					<?php sfm_starter_post_nav(); ?>
		
					<?php
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
					?>
		
				<?php endwhile; // end of the loop. ?>
		
				</main><!-- #main -->
			</div><!-- #primary -->
			
			<div id="sidebar-area" class="col-sm-4">
				<?php get_sidebar(); ?>
			</div><!-- #sidebar-area -->
			
		</div>
	</div>

<?php get_footer(); ?>
