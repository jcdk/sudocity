<?php
/**
 * @package Nu Themes
 */
 
$location = get_field('place_location');
$tags = get_field('place_tag');
 
$location_ctry = trim(end(explode(",", $location['address'])));

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'box' ); ?>>
	<header class="entry-header">
		<div class="entry-thumbnail">
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
			<?php the_post_thumbnail( 'thumb-small' ); ?>
		</a>
		</div>
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?> <?php if ( get_field('place_visit_boolean') == TRUE ) : ?>(I've been here!)<?php endif; ?>" rel="bookmark"><?php the_title(); ?><?php if ( get_field('place_visit_boolean') == TRUE ) : ?><span class="genericon genericon-checkmark"></span><?php endif; ?></a></h2>

		<?php if ( 'place' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php echo $location_ctry; ?>
		<!-- .entry-meta --></div>
		<?php endif; ?>
	<!-- .entry-header --></header>

	<div class="clearfix entry-summary">
		<div class="row">
			<div class="col-sm-12">
			<p><?php the_field('place_line'); ?></p>
			</div>
			<div class="col-sm-12">
				<p>
				<?php 
				if( $tags ): ?> 
					<ul class="tags">
					<?php foreach( $tags as $tag ): ?>
						<li><?php echo get_term_by('id', $tag, 'post_tag')->name; ?></li>
					<?php endforeach; ?>
					</ul>
				<?php endif; ?>
				</p>
			</div>
		</div>	
	<!-- .entry-summary --></div>

	<footer class="entry-meta entry-footer">

		<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
		<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'nuthemes' ), __( '1 Comment', 'nuthemes' ), __( '% Comments', 'nuthemes' ) ); ?></span>
		<?php endif; ?>

		<?php edit_post_link( __( 'Edit', 'nuthemes' ), '<span class="edit-link">', '</span>' ); ?>
	<!-- .entry-footer --></footer>
<!-- #post-<?php the_ID(); ?> --></article>