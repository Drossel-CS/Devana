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
	<div class="instagram-gallery wrapper">
		<?php echo do_shortcode( '[insta-gallery id="1"]' ); ?>  <!-- instagram shortcode -->
	</div>
	
	<div class="site-brands wrapp">
		<div class="heading-center">
			značky naších šiat
		</div>
		<?php dynamic_sidebar( 'Brands' ); ?>
	</div>
	<!-- ´ -->
	<footer id="colophon" class="site-footer">
		<!-- <div class="wrapp site-newsletter">
			
		</div> -->
		<!-- <div class="site-footer-menu wrapp">
			<?php dynamic_sidebar( 'footer-menu-1' ); ?>
			<?php dynamic_sidebar( 'footer-menu-2' ); ?>
			<?php dynamic_sidebar( 'footer-menu-3' ); ?>
			<?php dynamic_sidebar( 'footer-menu-4' ); ?>
		</div> -->
		<div class="wrapp site-social">
			<i class="icon-instagram"></i>
			<i class="icon-facebook-squared"></i>
			<!-- <i class="icon-twitter"></i> -->
			<!-- <i class="icon-youtube"></i> -->
			<i class="icon-pinterest"></i>
		</div>
		<div class="site-info wrapp">
			<p class="copy">&copy <?php echo date('Y '); bloginfo('name'); ?>, Všetky práva vyhradené | Všeobecné podmienky</p>
			<p class="author">zrobil <a href="https://www.drossel.sk" target="_blank">Drossel</a></p>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
