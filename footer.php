<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Devana
 */

?>

	</div><!-- #content -->

	<div class="site-brands wrapp">
		<?php dynamic_sidebar( 'Brands' ); ?>
	</div>
	<footer id="colophon" class="site-footer">
		<div class="site-footer-menu">
			<!-- <?php dynamic_sidebar( 'Brands' ); ?> -->
		</div>
		<div class="wrapp site-social">
			<i class="icon-instagram"></i>
			<i class="icon-facebook-squared"></i>
			<i class="icon-twitter"></i>
			<i class="icon-youtube"></i>
			<i class="icon-pinterest"></i>
		</div>
		<div class="site-info wrapp">
			<p class="copy">&copy 2014-<?php echo date('Y '); bloginfo('name'); ?></p>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
