<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Gavrylivka_School
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'gavrylivka-school' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="header-container">
			<div class="site-branding">
				<?php
				if ( has_custom_logo() ) :
					the_custom_logo();
				else :
					?>
                    <div class="logo-placeholder">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/school.svg" alt="phone">
                    </div>
				<?php endif; ?>
				
				<div class="site-info">
					<?php
					if ( is_front_page() && is_home() ) :
						?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<?php
					else :
						?>
						<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
						<?php
					endif;
					$gavrylivka_school_description = get_bloginfo( 'description', 'display' );
					if ( $gavrylivka_school_description ) :
						?>
						<p class="site-description"><?php echo $gavrylivka_school_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
					<?php endif; ?>
				</div>
			</div><!-- .site-branding -->

			<nav id="site-navigation" class="main-navigation">
				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
					<span class="hamburger-line"></span>
					<span class="hamburger-line"></span>
					<span class="hamburger-line"></span>
					<span class="screen-reader-text"><?php esc_html_e( 'Меню', 'gavrylivka-school' ); ?></span>
				</button>
				
				<div class="nav-menu-wrapper">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'menu-1',
							'menu_id'        => 'primary-menu',
							'container'      => false,
							'menu_class'     => 'nav-menu',
							'fallback_cb'    => false,
						)
					);
					?>
					
					<!-- Mobile contact button -->
					<a href="mailto:gavrilovkanvk2016@ukr.net" class="mobile-contact-button">
						<span class="contact-icon">
							<img src="<?php echo get_template_directory_uri(); ?>/assets/img/mail.svg" alt="mail">
						</span>
						<span class="contact-text">Зв'язатися з нами</span>
					</a>
				</div>
			</nav><!-- #site-navigation -->

			<div class="header-contact">
				<a href="mailto:gavrilovkanvk2016@ukr.net" class="contact-button phone-button">
					<span class="contact-icon">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/mail.svg" alt="mail">
                    </span>
					<span class="contact-text">Зв'язатися</span>
				</a>
			</div><!-- .header-contact -->
		</div><!-- .header-container -->
	</header><!-- #masthead -->
