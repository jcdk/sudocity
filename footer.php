<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Nu Themes
 */
?>
			</div>
		<!-- #main --></div>

		<footer id="footer" class="site-footer" role="contentinfo">
			<div class="container">
				<div class="row">
					<div class="col-sm-6 site-info">
						&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>.
					<!-- .site-info --></div>

					<div class="col-sm-6 site-credit">
						
					<!-- .site-credit --></div>
				</div>
			</div>
		<!-- #footer --></footer>

		<?php wp_footer(); ?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-51863917-1', 'auto');
  ga('require', 'displayfeatures');
  ga('send', 'pageview');

</script>
	</body>
</html>