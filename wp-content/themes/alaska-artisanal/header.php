<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Header Template
 *
 *
 * @file           header.php
 * @package        Responsive 
 * @author         Emil Uzelac 
 * @copyright      2003 - 2013 ThemeID
 * @license        license.txt
 * @version        Release: 1.3
 * @filesource     wp-content/themes/responsive/header.php
 * @link           http://codex.wordpress.org/Theme_Development#Document_Head_.28header.php.29
 * @since          available since Release 1.0
 */
?>
<!doctype html>
<!--[if !IE]>      <html class="no-js non-ie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9 ]>    <html class="no-js ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>

<meta charset="<?php bloginfo('charset'); ?>" />
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">

<title><?php wp_title('&#124;', true, 'right'); ?></title>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<link href='https://fonts.googleapis.com/css?family=Cardo:400,400italic,700' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,300italic,700' rel='stylesheet' type='text/css'>

<?php wp_enqueue_style('responsive-style', get_stylesheet_uri(), false, '1.9.3.2');?>

<?php wp_head(); ?>

<!--HOME SLIDES-->

<script type="text/javascript">
	jQuery(window).load(function() {
		jQuery('.flexslider').flexslider({
			animation: "slide",
			controlNav: false,
			slideshowSpeed: 4000
		});
	  });
</script>

<script type="text/javascript">
	jQuery(function() {
	  jQuery('a[title]').tipsy({html: true });
  	});
</script>

</head>

<body <?php body_class(); ?>>
                 
<?php responsive_container(); // before container hook ?>
<div id="container" class="hfeed">

	<div class="top-header">
    
    	<div class="top-header-left">
        
       		<ul>
            	<li><?php echo get_option('topheadertext'); ?></li>
                <!--<li><a href="" target="_blank"><i class="icon-facebook"></i></a></li>
                <li><a href="" target="_blank"><i class="icon-twitter"></i></a></li>
                <li><a href="" target="_blank"><i class="icon-pinterest"></i></a></li>
                <li class="signupmailtop"><a href="#" data-reveal-id="newsletter-signup" target="_blank"><i class="icon-heart"></i> &nbsp;SIGN UP FOR OUR EMAIL LIST</a></li>-->
          	</ul>
                
        
        <!--/top-header-left--></div>
        
        <div class="top-header-right">
        
        	<?php global $woocommerce; ?>
        
        	<a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>"><i class="icon-shopping-cart"></i> &nbsp;<?php echo $woocommerce->cart->get_cart_total(); ?></a>
        
        <!--/top-header-right--></div>
        
        <div class="clear"></div>
    
    <!--/top-header--></div>
         
    <?php responsive_header(); // before header hook ?>
    <div id="header">
    
    	<div style="text-align: center; margin: 40px 0;"><a href="<?php bloginfo ('url'); ?>"><img src="<?php bloginfo ('template_directory'); ?>/images/logo.png" alt="Alaska Artisanal Logo" /></a></div>

		<?php responsive_header_top(); // before header content hook ?>
    
        <?php if (has_nav_menu('top-menu', 'responsive')) { ?>
	        <?php wp_nav_menu(array(
				    'container'       => '',
					'fallback_cb'	  =>  false,
					'menu_class'      => 'top-menu',
					'theme_location'  => 'top-menu')
					); 
				?>
        <?php } ?>
        
    <?php responsive_in_header(); // header hook ?>
    
    <?php get_sidebar('top'); ?>
				<?php wp_nav_menu(array(
				    'container'       => 'div',
						'container_class'	=> 'main-nav',
						'fallback_cb'	  =>  'responsive_fallback_menu',
						'theme_location'  => 'header-menu')
					); 
				?>
                
            <?php if (has_nav_menu('sub-header-menu', 'responsive')) { ?>
	            <?php wp_nav_menu(array(
				    'container'       => '',
					'menu_class'      => 'sub-header-menu',
					'theme_location'  => 'sub-header-menu')
					); 
				?>
            <?php } ?>

			<?php responsive_header_bottom(); // after header content hook ?>
    </div><!-- end of #header -->
    <?php responsive_header_end(); // after header container hook ?>
    
	<?php responsive_wrapper(); // before wrapper container hook ?>
    <div id="wrapper" class="clearfix">
		<?php responsive_wrapper_top(); // before wrapper content hook ?>
		<?php responsive_in_wrapper(); // wrapper hook ?>