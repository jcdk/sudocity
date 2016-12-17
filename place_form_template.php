<?php
/**
 * The Template for displaying departure form.
 *
 * Template Name: Add Place Form
 */

acf_form_head(); ?>
<?php get_header(); ?>

	<div class="row">
		<main id="content">

			<div class="row">

				<div class="col-xs-12">

					<h2 style="padding-left:10px;"><?php the_title(); ?></h2>
					<p><?php the_content(); ?></p>

							<?php /* The loop */ ?>

							<?php if (is_user_logged_in()) : ?>

								<?php acf_form(array(
									'post_id'		=> 'new_post',
									'new_post'		=> array(
										'post_type'		=> 'place',
										'post_status'		=> 'publish'
									),
									'uploader' => 'basic',
									'return' => '/places/',
									'submit_value'		=> 'Add a place'
								)); ?>

							<?php else : ?>

								<?php acf_form(array(
									'post_id'		=> 'new_post',
									'fields'		=> array(
										'place_name',
										'place_location', 
										'place_uri',
										'place_type',
										'place_line'
									), 
									'new_post'		=> array(
										'post_type'		=> 'place',
										'post_status'		=> 'draft'
									),
									'uploader' => 'basic',
									'return' => '/place-thanks/',
									'submit_value' => 'Add a place'
								)); ?>

							<?php endif ; ?>
				</div>

			<!-- .row --></div>

		<!-- #content --></main>

	<!-- .row --></div>

<script type="text/javascript">
(function($) {
	
	// setup fields
	acf.do_action('append', $('#popup-id'));
	
})(jQuery);	
</script>

<?php
acf_enqueue_uploader();
?>

<?php get_footer(); ?>