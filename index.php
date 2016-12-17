<?php
/**
 * The main template file.
 *
 * @package Nu Themes
 */

get_header(); ?>

	<div class="row">
		<main id="content" class="col-md-8 col-lg-9 content-area" role="main">

		<?php if ( have_posts() ) : ?>

			<div id="masonry" class="row">
			<?php while ( have_posts() ) : the_post(); ?>

				<div class="col-xs-12 col-sm-6 col-lg-4 masonry-item">
					<?php get_template_part( 'content', get_post_format() ); ?>
				</div>

			<?php endwhile; ?>
			<!-- #masonry --></div>

			<?php nuthemes_content_nav( 'nav-below' ); ?>

		<?php else : ?>

			<?php get_template_part( 'no-results', 'index' ); ?>

		<?php endif; ?>

		<!-- #content --></main>

		<?php get_sidebar(); ?>
	<!-- .row --></div>

<?php get_footer(); ?>