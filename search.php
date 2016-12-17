<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package Nu Themes
 */

get_header(); ?>

	<div class="row">
		<main id="content" class="col-md-8 col-lg-9 content-area" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="box archive-header">
				<h1 class="archive-title"><?php printf( __( 'Search Results for: %s', 'nuthemes' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			<!-- .archive-header --></header>

			<div id="masonry" class="row">
			<?php while ( have_posts() ) : the_post(); ?>

				<div class="col-xs-6 col-lg-4 masonry-item">
					<?php get_template_part( 'content', 'search' ); ?>
				</div>

			<?php endwhile; ?>
			<!-- #masonry --></div>

			<?php nuthemes_content_nav( 'nav-below' ); ?>

		<?php else : ?>

			<?php get_template_part( 'no-results', 'search' ); ?>

		<?php endif; ?>

		<!-- #content --></main>

		<?php get_sidebar(); ?>
	<!-- .row --></div>

<?php get_footer(); ?>