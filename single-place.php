<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Nu Themes
 */

get_header(); ?>

	<div class="row">
		<main id="content" class="col-md-10 col-lg-8 col-md-offset-1 col-lg-offset-2 content-area" role="main">

			<div class="row">
			<?php while ( have_posts() ) : the_post(); ?>

				<div class="col-xs-12">
					<?php get_template_part( 'content', 'place' ); ?>
				</div>

				<div class="col-xs-12">
					<?php
						if ( comments_open() || '0' != get_comments_number() )
							comments_template();
					?>
				</div>

			<?php endwhile; ?>
			<!-- .row --></div>

		<!-- #content --></main>

	<!-- .row --></div>

<?php get_footer(); ?>