<?php
/**
 * @package Nu Themes
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'box' ); ?>>
	<header class="entry-header">
<?php
if ( has_post_thumbnail() ) {
	?> <div class="featuredonpost" style="height: 350px;"> <?php the_post_thumbnail('large'); ?> </div> <?php
} 
?>

		<h1 class="entry-title"><?php the_title(); ?></h1>

		<div class="entry-meta">
			<?php $loc = get_field('place_location'); echo $loc['address']; ?><br/>
			<?php if (get_field('place_visit_boolean') == TRUE) { ?> 
				Last visit: <?php the_field('place_visit_date'); ?>
			<?php } ?>

			<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
			<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'nuthemes' ), __( '1 Comment', 'nuthemes' ), __( '% Comments', 'nuthemes' ) ); ?></span>
			<?php endif; ?>
		<!-- .entry-meta --></div>
	<!-- .entry-header --></header>

	<div class="clearfix entry-content">
		<?php the_content(); ?>
		<p class="lead"><?php the_field('place_line'); ?></p>
		<p><?php the_field('place_description'); ?></p>
		<p><?php the_field('place_uri'); ?></p>
		<?php 
		$tags = get_field('place_tag');
		if( $tags ): ?> 
			<ul class="tags">
			<?php foreach( $tags as $tag ): ?>
				<li><?php echo get_term_by('id', $tag, 'post_tag')->name; ?></li>
			<?php endforeach; ?>
			</ul>
		<?php endif; ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'nuthemes' ),
				'after'  => '</div>',
			) );
		?>
	<!-- .entry-content --></div>

	<footer class="entry-meta entry-footer">
		<?php if ( 'post' == get_post_type() ) : ?>
			<?php
				$categories_list = get_the_category_list( __( ', ', 'nuthemes' ) );
				if ( $categories_list && nuthemes_categorized_blog() ) :
			?>
			<span class="cat-links">
				<?php printf( __( '%1$s', 'nuthemes' ), $categories_list ); ?>
			</span>
			<?php endif; ?>

			<?php
				$tags_list = get_the_tag_list( '', __( ', ', 'nuthemes' ) );
				if ( $tags_list ) :
			?>
			<span class="tags-links">
				<?php printf( __( '%1$s', 'nuthemes' ), $tags_list ); ?>
			</span>
			<?php endif; ?>
		<?php endif; ?>
		<?php nuthemes_posted_on(); ?>
		<?php nuthemes_posted_by(); ?>
		<?php edit_post_link( __( 'Edit', 'nuthemes' ), '<span class="edit-link">', '</span>' ); ?>
	<!-- .entry-footer --></footer>
<!-- #post-<?php the_ID(); ?> --></article>