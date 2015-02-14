<?php
/**
 * The template for displaying search results pages.
 *
 * @package sfm-starter
 */

get_header(); ?>

	<div class="container">
		<div class="row">
			
			<div id="primary" class="col-sm-8">
				<main id="main" role="main">
		
				<?php if ( have_posts() ) : ?>
		
					<header class="page-header">
						<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'sfm-starter' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
					</header><!-- .page-header -->
		
					<?php /* Start the Loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>
		
						<?php
						/**
						 * Run the loop for the search to output the results.
						 * If you want to overload this in a child theme then include a file
						 * called content-search.php and that will be used instead.
						 */
						get_template_part( 'content', 'search' );
						?>
		
					<?php endwhile; ?>
		
					<?php sfm_starter_paging_nav(); ?>
		
				<?php else : ?>
		
					<?php get_template_part( 'content', 'none' ); ?>
		
				<?php endif; ?>
		
				</main><!-- #main -->
			</div><!-- #primary -->
	
			<div id="sidebar-area" class="col-sm-4">
				<?php get_sidebar(); ?>
			</div><!-- #sidebar-area -->
		</div>
	</div>

<?php get_footer(); ?>
