<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Devana
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="Drossel | CREATIVE STUDIO">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
	<link href="https://fonts.googleapis.com/css?family=Great+Vibes" rel="stylesheet">
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'devana' ); ?></a>

	<header id="masthead" class="site-header">
	<div class="site-branding wrapp">
		
		<div class="site-header-group">
			<div class="shopingbag"></div>
			<div class="site-header-logo logo">
				<?php the_custom_logo();?>
			</div>
			<div class="site-header-burger burger">
				<button class="hamburger hamburger--spin menu-toggle" type="button">
					<span class="hamburger-box">
					<span class="hamburger-inner"></span>
					</span>
				</button>
			</div>
		</div>
		<div class="heading-center"><?php echo bloginfo('description');?></div>
		<div class="site-header-primary-nav wrapp">
			<nav id="site-navigation" class="main-navigation">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
					'menu_class' => 'menu-items',
				) );
				?>
				<!-- <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'vesna' ); ?></button> -->
				
			</nav><!-- #site-navigation -->
		</div>
		</div><!-- .site-branding -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
