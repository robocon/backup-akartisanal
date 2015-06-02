<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Theme's Functions and Definitions
 *
 *
 * @file           functions.php
 * @package        Responsive 
 * @author         Emil Uzelac 
 * @copyright      2003 - 2013 ThemeID
 * @license        license.txt
 * @version        Release: 1.2.1
 * @filesource     wp-content/themes/responsive/includes/functions.php
 * @link           http://codex.wordpress.org/Theme_Development#Functions_File
 * @since          available since Release 1.0
 */
?>
<?php
/*
 * Globalize Theme options
 */
$responsive_options = responsive_get_options();

/*
 * Hook options
 */
//add_action('admin_init', 'responsive_theme_options_init');
//add_action('admin_menu', 'responsive_theme_options_add_page');


	add_filter( 'woocommerce_enqueue_styles', '__return_false' );

	function wp_enqueue_woocommerce_style(){
		wp_register_style( 'woocommerce', get_stylesheet_directory_uri() . '/css/woocommerce.css' );
	if ( class_exists( 'woocommerce' ) ) {
		wp_enqueue_style( 'woocommerce' );
		}
	}
	add_action( 'wp_enqueue_scripts', 'wp_enqueue_woocommerce_style' );

/**
 * Retrieve Theme option settings
 */
function responsive_get_options() {
  // Globalize the variable that holds the Theme options
  global $responsive_options;
  // Parse array of option defaults against user-configured Theme options
  $responsive_options = wp_parse_args( get_option( 'responsive_theme_options', array() ), responsive_get_option_defaults() );
  // Return parsed args array
  return $responsive_options;
}

/**
 * Responsive Theme option defaults
 */
function responsive_get_option_defaults() {
  $defaults = array(
    'breadcrumb' => false,
    'cta_button' => false,
    'front_page' => 1,
    'home_headline' => false,
    'home_subheadline' => false,
    'home_content_area' => false,
    'cta_text' => false,
    'cta_url' => false,
    'featured_content' => false,
    'google_site_verification' => '',
    'bing_site_verification' => '',
    'yahoo_site_verification' => '',
    'site_statistics_tracker' => '',
    'twitter_uid' => '',
    'facebook_uid' => '',
    'linkedin_uid' => '',
    'youtube_uid' => '',
    'stumble_uid' => '',
    'rss_uid' => '',
    'google_plus_uid' => '',
    'instagram_uid' => '',
    'pinterest_uid' => '',
    'yelp_uid' => '',
    'vimeo_uid' => '',
    'foursquare_uid' => '',
    'responsive_inline_css' => '',
    'responsive_inline_js_head' => '',
    'responsive_inline_css_js_footer' => '',
    'static_page_layout_default' => 'content-sidebar-page',
    'single_post_layout_default' => 'content-sidebar-page',
    'blog_posts_index_layout_default' => 'content-sidebar-page',
  );
  return apply_filters( 'responsive_option_defaults', $defaults );
}

/**
 * Fire up the engines boys and girls let's start theme setup.
 */
//add_action('after_setup_theme', 'responsive_setup');

if (!function_exists('responsive_setup')):

    function responsive_setup() {

        global $content_width;

        /**
         * Global content width.
         */
        if (!isset($content_width))
            $content_width = 550;

        /**
         * Responsive is now available for translations.
         * Add your files into /languages/ directory.
		 * @see http://codex.wordpress.org/Function_Reference/load_theme_textdomain
         */
	    load_theme_textdomain('responsive', get_template_directory().'/languages');

            $locale = get_locale();
            $locale_file = get_template_directory().'/languages/$locale.php';
            if (is_readable( $locale_file))
	            require_once( $locale_file);
						
        /**
         * Add callback for custom TinyMCE editor stylesheets. (editor-style.css)
         * @see http://codex.wordpress.org/Function_Reference/add_editor_style
         */
        add_editor_style();

        /**
         * This feature enables post and comment RSS feed links to head.
         * @see http://codex.wordpress.org/Function_Reference/add_theme_support#Feed_Links
         */
        add_theme_support('automatic-feed-links');

        /**
         * This feature enables post-thumbnail support for a theme.
         * @see http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
         */
        add_theme_support('post-thumbnails');

		/**
		 * This feature enables woocommerce support for a theme.
		 * @see http://www.woothemes.com/2013/02/last-call-for-testing-woocommerce-2-0-coming-march-4th/
		 */
		add_theme_support( 'woocommerce' );

        /**
         * This feature enables custom-menus support for a theme.
         * @see http://codex.wordpress.org/Function_Reference/register_nav_menus
         */	
        register_nav_menus(array(
			'top-menu'         => __('Top Menu', 'responsive'),
	        'header-menu'      => __('Header Menu', 'responsive'),
	        'sub-header-menu'  => __('Sub-Header Menu', 'responsive'),
			'footer-menu'      => __('Footer Menu', 'responsive'),
			'shop-menu'      => __('Shop Menu', 'responsive'),
		    )
	    );

		if ( function_exists('get_custom_header')) {
			
        add_theme_support('custom-background');
		
		} else {
		
		// < 3.4 Backward Compatibility
		
		/**
         * This feature allows users to use custom background for a theme.
         * @see http://codex.wordpress.org/Function_Reference/add_custom_background
         */
		
        add_custom_background();
		
		}

		// WordPress 3.4 >
		if (function_exists('get_custom_header')) {
			
		add_theme_support('custom-header', array (
	        // Header image default
	       'default-image'			=> get_template_directory_uri() . '/images/default-logo.png',
	        // Header text display default
	       'header-text'			=> false,
	        // Header image flex width
		   'flex-width'             => true,
	        // Header image width (in pixels)
	       'width'				    => 300,
		    // Header image flex height
		   'flex-height'            => true,
	        // Header image height (in pixels)
	       'height'			        => 100,
	        // Admin header style callback
	       'admin-head-callback'	=> 'responsive_admin_header_style'));
		   
		// gets included in the admin header
        function responsive_admin_header_style() {
            ?><style type="text/css">
                .appearance_page_custom-header #headimg {
					background-repeat:no-repeat;
					border:none;
				}
             </style><?php
        }		  
	   
	    } else {
		   
        // Backward Compatibility
		
		/**
         * This feature adds a callbacks for image header display.
		 * In our case we are using this to display logo.
         * @see http://codex.wordpress.org/Function_Reference/add_custom_image_header
         */
        define('HEADER_TEXTCOLOR', '');
        define('HEADER_IMAGE', '%s/images/default-logo.png'); // %s is the template dir uri
        define('HEADER_IMAGE_WIDTH', 300); // use width and height appropriate for your theme
        define('HEADER_IMAGE_HEIGHT', 100);
        define('NO_HEADER_TEXT', true);
		
		
		// gets included in the admin header
        function responsive_admin_header_style() {
            ?><style type="text/css">
                #headimg {
	                background-repeat:no-repeat;
                    border:none !important;
                    width:<?php echo HEADER_IMAGE_WIDTH; ?>px;
                    height:<?php echo HEADER_IMAGE_HEIGHT; ?>px;
                }
             </style><?php
         }
         
		 add_custom_image_header('', 'responsive_admin_header_style');
		
	    }
			
		// While upgrading set theme option front page toggle not to affect old setup.
		$responsive_options = get_option( 'responsive_theme_options' );
		if( $responsive_options && isset( $_GET['activated'] ) ) {
		
			// If front_page is not in theme option previously then set it.
			if( !isset( $responsive_options['front_page'] )) {
			
				// Get template of page which is set as static front page
				$template = get_post_meta( get_option( 'page_on_front' ), '_wp_page_template', true );
				
				// If static front page template is set to default then set front page toggle of theme option to 1
				if( 'page' == get_option( 'show_on_front' ) && $template == 'default' ) {
					$responsive_options['front_page'] = 1;
				}
				else {
					$responsive_options['front_page'] = 0;
				}
				update_option( 'responsive_theme_options', $responsive_options );
			}
		}
    }

endif;

/**
 * Set a fallback menu that will show a home link.
 */
 
function responsive_fallback_menu() {
	$args = array(
		'depth'       => 0,
		'sort_column' => 'menu_order, post_title',
		'menu_class'  => 'menu',
		'include'     => '',
		'exclude'     => '',
		'echo'        => false,
		'show_home'   => true,
		'link_before' => '',
		'link_after'  => ''
	);
	$pages = wp_page_menu( $args );
	$prepend = '<div class="main-nav">';
	$append = '</div>';
	$output = $prepend.$pages.$append;
	echo $output;
}

/**
 * This function removes .menu class from custom menus
 * in widgets only and fallback's on default widget lists
 * and assigns new unique class called .menu-widget
 * 
 * Marko Heijnen Contribution
 *
 */
class responsive_widget_menu_class {
	public function __construct() {
		add_action( 'widget_display_callback', array( $this, 'menu_different_class' ), 10, 2 );
	}
 
	public function menu_different_class( $settings, $widget ) {
		if( $widget instanceof WP_Nav_Menu_Widget )
			add_filter( 'wp_nav_menu_args', array( $this, 'wp_nav_menu_args' ) );
 
		return $settings;
	}
 
	public function wp_nav_menu_args( $args ) {
		remove_filter( 'wp_nav_menu_args', array( $this, 'wp_nav_menu_args' ) );
 
		if( 'menu' == $args['menu_class'] )
			$args['menu_class'] = 'menu-widget';
 
		return $args;
	}
}
new responsive_widget_menu_class();

/**
 * Removes div from wp_page_menu() and replace with ul.
 */
function responsive_wp_page_menu ($page_markup) {
    preg_match('/^<div class=\"([a-z0-9-_]+)\">/i', $page_markup, $matches);
        $divclass = $matches[1];
        $replace = array('<div class="'.$divclass.'">', '</div>');
        $new_markup = str_replace($replace, '', $page_markup);
        $new_markup = preg_replace('/^<ul>/i', '<ul class="'.$divclass.'">', $new_markup);
        return $new_markup; }

add_filter('wp_page_menu', 'responsive_wp_page_menu');

/**
 * wp_title() Filter for better SEO.
 *
 * Adopted from Twenty Twelve
 * @see http://codex.wordpress.org/Plugin_API/Filter_Reference/wp_title
 *
 */
if (!function_exists('responsive_post_meta_data') && ! defined( 'AIOSEOP_VERSION' ) ) :

	function responsive_wp_title( $title, $sep ) {
		global $paged, $page;

		if ( is_feed() )
			return $title;

		// Add the site name.
		$title .= get_bloginfo( 'name' );

		// Add the site description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			$title = "$title $sep $site_description";

		// Add a page number if necessary.
		if ( $paged >= 2 || $page >= 2 )
			$title = "$title $sep " . sprintf( __( 'Page %s', 'responsive' ), max( $paged, $page ) );

		return $title;
	}
	add_filter( 'wp_title', 'responsive_wp_title', 10, 2 );

endif;

/**
 * Filter 'get_comments_number'
 * 
 * Filter 'get_comments_number' to display correct 
 * number of comments (count only comments, not 
 * trackbacks/pingbacks)
 *
 * Chip Bennett Contribution
 */
function responsive_comment_count( $count ) {  
	if ( ! is_admin() ) {
		global $id;
		$comments_by_type = &separate_comments(get_comments('status=approve&post_id=' . $id));
		return count($comments_by_type['comment']);
	} else {
		return $count;
	}
}
add_filter('get_comments_number', 'responsive_comment_count', 0);

/**
 * wp_list_comments() Pings Callback
 * 
 * wp_list_comments() Callback function for 
 * Pings (Trackbacks/Pingbacks)
 */
function responsive_comment_list_pings( $comment ) {
	$GLOBALS['comment'] = $comment;
?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo comment_author_link(); ?></li>
<?php }

/**
 * Sets the post excerpt length to 40 words.
 * Adopted from Coraline
 */
function responsive_excerpt_length($length) {
    return 40;
}

add_filter('excerpt_length', 'responsive_excerpt_length');

/**
 * Returns a "Read more" link for excerpts
 */
function responsive_read_more() {
    return '<div class="read-more"><a href="' . get_permalink() . '">' . __('Read more &#8250;', 'responsive') . '</a></div><!-- end of .read-more -->';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and responsive_read_more_link().
 */
function responsive_auto_excerpt_more($more) {
    return '<span class="ellipsis">&hellip;</span>' . responsive_read_more();
}

add_filter('excerpt_more', 'responsive_auto_excerpt_more');

/**
 * Adds a pretty "Read more" link to custom post excerpts.
 */
function responsive_custom_excerpt_more($output) {
    if (has_excerpt() && !is_attachment()) {
        $output .= responsive_read_more();
    }
    return $output;
}

add_filter('get_the_excerpt', 'responsive_custom_excerpt_more');


/**
 * This function removes inline styles set by WordPress gallery.
 */
function responsive_remove_gallery_css($css) {
    return preg_replace("#<style type='text/css'>(.*?)</style>#s", '', $css);
}

add_filter('gallery_style', 'responsive_remove_gallery_css');

/**
 * This function removes default styles set by WordPress recent comments widget.
 */
function responsive_remove_recent_comments_style() {
	global $wp_widget_factory;
	if ( isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments']) )
		remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
//add_action( 'widgets_init', 'responsive_remove_recent_comments_style' );

/**
 * This function prints post meta data.
 *
 * Ulrich Pogson Contribution 
 *
 */
if (!function_exists('responsive_post_meta_data')) :

function responsive_post_meta_data() {
	printf( __( '<span class="%1$s">Posted on </span>%2$s<span class="%3$s"> by </span>%4$s', 'responsive' ),
	'meta-prep meta-prep-author posted', 
	sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="timestamp updated">%3$s</span></a>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_html( get_the_date() )
	),
	'byline',
	sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
		get_author_posts_url( get_the_author_meta( 'ID' ) ),
		sprintf( esc_attr__( 'View all posts by %s', 'responsive' ), get_the_author() ),
		esc_attr( get_the_author() )
		)
	);
}
endif;

/**
 * This function removes WordPress generated category and tag atributes.
 * For W3C validation purposes only.
 * 
 */
function responsive_category_rel_removal ($output) {
    $output = str_replace(' rel="category tag"', '', $output);
    return $output;
}

add_filter('wp_list_categories', 'responsive_category_rel_removal');
add_filter('the_category', 'responsive_category_rel_removal');

/**
 * Breadcrumb Lists
 * Allows visitors to quickly navigate back to a previous section or the root page.
 *
 * Adopted from Dimox
 *
 */
if (!function_exists('responsive_breadcrumb_lists')) :

function responsive_breadcrumb_lists() {

	/* === OPTIONS === */
	$text['home']     = __('Home','responsive'); // text for the 'Home' link
	$text['category'] = __('Archive for %s','responsive'); // text for a category page
	$text['search']   = __('Search results for: %s','responsive'); // text for a search results page
	$text['tag']      = __('Posts tagged %s','responsive'); // text for a tag page
	$text['author']   = __('View all posts by %s','responsive'); // text for an author page
	$text['404']      = __('Error 404','responsive'); // text for the 404 page

	$showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
	$showOnHome  = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
	$delimiter   = ' <span class="chevron">&#8250;</span> '; // delimiter between crumbs
	$before      = '<span class="breadcrumb-current">'; // tag before the current crumb
	$after       = '</span>'; // tag after the current crumb
	/* === END OF OPTIONS === */

	global $post, $paged, $page;
	$homeLink = home_url('/');
	$linkBefore = '<span typeof="v:Breadcrumb">';
	$linkAfter = '</span>';
	$linkAttr = ' rel="v:url" property="v:title"';
	$link = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;

	if ( is_front_page()) {

		if ($showOnHome == 1) echo '<div class="breadcrumb-list"><a href="' . $homeLink . '">' . $text['home'] . '</a></div>';

	} else {

		echo '<div class="breadcrumb-list" xmlns:v="http://rdf.data-vocabulary.org/#">' . sprintf($link, $homeLink, $text['home']) . $delimiter;

		if ( is_home() ) {
			if ($showCurrent == 1) echo $before . get_the_title( get_option('page_for_posts', true) ) . $after;

		} elseif ( is_category() ) {
			$thisCat = get_category(get_query_var('cat'), false);
			if ($thisCat->parent != 0) {
				$cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
				$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
				$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
				echo $cats;
			}
			echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;

		} elseif ( is_search() ) {
			echo $before . sprintf($text['search'], get_search_query()) . $after;

		} elseif ( is_day() ) {
			echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
			echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
			echo $before . get_the_time('d') . $after;

		} elseif ( is_month() ) {
			echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
			echo $before . get_the_time('F') . $after;

		} elseif ( is_year() ) {
			echo $before . get_the_time('Y') . $after;

		} elseif ( is_single() && !is_attachment() ) {
			if ( get_post_type() != 'post' ) {
				$post_type = get_post_type_object(get_post_type());
				$slug = $post_type->rewrite;
				printf($link, $homeLink . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
				if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;
			} else {
				$cat = get_the_category(); $cat = $cat[0];
				$cats = get_category_parents($cat, TRUE, $delimiter);
				if ($showCurrent == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
				$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
				$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
				echo $cats;
				if ($showCurrent == 1) echo $before . get_the_title() . $after;
			}

		} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
			$post_type = get_post_type_object(get_post_type());
			echo $before . $post_type->labels->singular_name . $after;

		} elseif ( is_attachment() ) {
			$parent = get_post($post->post_parent);
			$cat = get_the_category($parent->ID); $cat = $cat[0];
			$cats = get_category_parents($cat, TRUE, $delimiter);
			$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
			$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
			echo $cats;
			printf($link, get_permalink($parent), $parent->post_title);
			if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;

		} elseif ( is_page() && !$post->post_parent ) {
			if ($showCurrent == 1) echo $before . get_the_title() . $after;

		} elseif ( is_page() && $post->post_parent ) {
			$parent_id  = $post->post_parent;
			$breadcrumbs = array();
			while ($parent_id) {
				$page_child = get_page($parent_id);
				$breadcrumbs[] = sprintf($link, get_permalink($page_child->ID), get_the_title($page_child->ID));
				$parent_id  = $page_child->post_parent;
			}
			$breadcrumbs = array_reverse($breadcrumbs);
			for ($i = 0; $i < count($breadcrumbs); $i++) {
				echo $breadcrumbs[$i];
				if ($i != count($breadcrumbs)-1) echo $delimiter;
			}
			if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;

		} elseif ( is_tag() ) {
			echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;

		} elseif ( is_author() ) {
	 		global $author;
			$userdata = get_userdata($author);
			echo $before . sprintf($text['author'], $userdata->display_name) . $after;

		} elseif ( is_404() ) {
			echo $before . $text['404'] . $after;

		}if ( get_query_var('paged') ) {
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
			echo $delimiter . sprintf( __( 'Page %s', 'responsive' ), max( $paged, $page ) );
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
		}

		echo '</div>';

	}
} // end responsive_breadcrumb_lists

endif;

    /**
     * A safe way of adding JavaScripts to a WordPress generated page.
     */
    if (!is_admin())
        add_action('wp_enqueue_scripts', 'responsive_js');

    if (!function_exists('responsive_js')) {

        function responsive_js() {
			// JS at the bottom for fast page loading. 
			// except for Modernizr which enables HTML5 elements & feature detects.
			wp_enqueue_script('modernizr', get_template_directory_uri() . '/js/responsive-modernizr.js', array('jquery'), '2.6.1', false);
      wp_enqueue_script('responsive-scripts', get_template_directory_uri() . '/js/responsive-scripts.js', array('jquery'), '1.2.3', true);
			wp_enqueue_script('responsive-plugins', get_template_directory_uri() . '/js/responsive-plugins.js', array('jquery'), '1.2.3', true);
        }

    }

    /**
     * A comment reply.
     */
        function responsive_enqueue_comment_reply() {
    if ( is_singular() && comments_open() && get_option('thread_comments')) { 
            wp_enqueue_script('comment-reply'); 
        }
    }

    add_action( 'wp_enqueue_scripts', 'responsive_enqueue_comment_reply' );

    /**
     * Theme Options Support and Information
     */	
    function responsive_theme_support () {
    ?>
	
	<div class="upgrade-callout">
		<p><img src="<?php echo get_template_directory_uri() ;?>/includes/images/chimp.png" alt="CyberChimps" />
			<?php printf( __( 'Welcome to %1$s! Learn more about our other', 'responsive' ) . ' <a href="%2$s" target="_blank" title="%3$s">%3$s</a> ' . __( 'today.', 'responsive' ),
			apply_filters( 'cyberchimps_current_theme_name', 'Responsive' ),
			apply_filters( 'cyberchimps_upgrade_link', 'http://cyberchimps.com' ),
			apply_filters( 'cyberchimps_upgrade_pro_title', 'Responsive Themes' )
			); ?>	
		</p>
		<div class="social-container">
			<div class="social">
				<a href="https://twitter.com/cyberchimps" class="twitter-follow-button" data-show-count="false" data-size="small">Follow @cyberchimps</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			</div>
			<div class="social">
				<iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fcyberchimps.com%2F&amp;send=false&amp;layout=button_count&amp;width=200&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:200px; height:21px;" allowTransparency="true"></iframe>
			</div>
		</div>
	</div>
	
	<div id="info-box-wrapper" class="grid col-940">
		<div class="info-box notice">

			<a class="button" href="<?php echo esc_url(__('http://themeid.com/docs/','responsive')); ?>" title="<?php esc_attr_e('Documentation', 'responsive'); ?>" target="_blank">
			<?php printf(__('Documentation','responsive')); ?></a>

			<a class="button button-primary" href="<?php echo esc_url(__('http://themeid.com/support/','responsive')); ?>" title="<?php esc_attr_e('Theme Support', 'responsive'); ?>" target="_blank">
			<?php printf(__('Theme Support','responsive')); ?></a>

			<a class="button" href="<?php echo esc_url(__('https://webtranslateit.com/en/projects/3598-Responsive-Theme','responsive')); ?>" title="<?php esc_attr_e('Translate', 'responsive'); ?>" target="_blank">
			<?php printf(__('Translate','responsive')); ?></a>

			<a class="button" href="<?php echo esc_url(__('http://themeid.com/showcase/','responsive')); ?>" title="<?php esc_attr_e('Showcase', 'responsive'); ?>" target="_blank">
			<?php printf(__('Showcase','responsive')); ?></a>

			<a class="button" href="<?php echo esc_url(__('http://themeid.com/themes/','responsive')); ?>" title="<?php esc_attr_e('More Themes', 'responsive'); ?>" target="_blank">
			<?php printf(__('More Themes','responsive')); ?></a>

		</div>
	</div>

    <?php }
 
    add_action('responsive_theme_options','responsive_theme_support');

	 
    /**
     * WordPress Widgets start right here.
     */
    function responsive_widgets_init() {

        register_sidebar(array(
            'name' => __('Main Sidebar', 'responsive'),
            'description' => __('Area 1 - sidebar.php', 'responsive'),
            'id' => 'main-sidebar',
            'before_title' => '<div class="widget-title">',
            'after_title' => '</div>',
            'before_widget' => '<div id="%1$s" class="widget-wrapper %2$s">',
            'after_widget' => '</div>'
        ));

        register_sidebar(array(
            'name' => __('Right Sidebar', 'responsive'),
            'description' => __('Area 2 - sidebar-right.php', 'responsive'),
            'id' => 'right-sidebar',
            'before_title' => '<div class="widget-title">',
            'after_title' => '</div>',
            'before_widget' => '<div id="%1$s" class="widget-wrapper %2$s">',
            'after_widget' => '</div>'
        ));
				
        register_sidebar(array(
            'name' => __('Left Sidebar', 'responsive'),
            'description' => __('Area 3 - sidebar-left.php', 'responsive'),
            'id' => 'left-sidebar',
            'before_title' => '<div class="widget-title">',
            'after_title' => '</div>',
            'before_widget' => '<div id="%1$s" class="widget-wrapper %2$s">',
            'after_widget' => '</div>'
        ));
		
        register_sidebar(array(
            'name' => __('Left Sidebar Half Page', 'responsive'),
            'description' => __('Area 4 - sidebar-left-half.php', 'responsive'),
            'id' => 'left-sidebar-half',
            'before_title' => '<div class="widget-title">',
            'after_title' => '</div>',
            'before_widget' => '<div id="%1$s" class="widget-wrapper %2$s">',
            'after_widget' => '</div>'
        ));
		
        register_sidebar(array(
            'name' => __('Right Sidebar Half Page', 'responsive'),
            'description' => __('Area 5 - sidebar-right-half.php', 'responsive'),
            'id' => 'right-sidebar-half',
            'before_title' => '<div class="widget-title">',
            'after_title' => '</div>',
            'before_widget' => '<div id="%1$s" class="widget-wrapper %2$s">',
            'after_widget' => '</div>'
        ));

        register_sidebar(array(
            'name' => __('Home Widget 1', 'responsive'),
            'description' => __('Area 6 - sidebar-home.php', 'responsive'),
            'id' => 'home-widget-1',
            'before_title' => '<div id="widget-title-one" class="widget-title-home"><h3>',
            'after_title' => '</h3></div>',
            'before_widget' => '<div id="%1$s" class="widget-wrapper %2$s">',
            'after_widget' => '</div>'
        ));

        register_sidebar(array(
            'name' => __('Home Widget 2', 'responsive'),
            'description' => __('Area 7 - sidebar-home.php', 'responsive'),
            'id' => 'home-widget-2',
            'before_title' => '<div id="widget-title-two" class="widget-title-home"><h3><a href="#" data-reveal-id="newsletter-signup">',
            'after_title' => '</a></h3></div>',
            'before_widget' => '<div id="%1$s" class="widget-wrapper %2$s">',
            'after_widget' => '</div>'
        ));

        register_sidebar(array(
            'name' => __('Home Widget 3', 'responsive'),
            'description' => __('Area 8 - sidebar-home.php', 'responsive'),
            'id' => 'home-widget-3',
            'before_title' => '<div id="widget-title-three" class="widget-title-home"><h3>',
            'after_title' => '</h3></div>',
            'before_widget' => '<div id="%1$s" class="widget-wrapper %2$s">',
            'after_widget' => '</div>'
        ));

        register_sidebar(array(
            'name' => __('Gallery Sidebar', 'responsive'),
            'description' => __('Area 9 - sidebar-gallery.php', 'responsive'),
            'id' => 'gallery-widget',
            'before_title' => '<div class="widget-title">',
            'after_title' => '</div>',
            'before_widget' => '<div id="%1$s" class="widget-wrapper %2$s">',
            'after_widget' => '</div>'
        ));
		
        register_sidebar(array(
            'name' => __('Colophon Widget', 'responsive'),
            'description' => __('Area 10 - sidebar-colophon.php', 'responsive'),
            'id' => 'colophon-widget',
            'before_title' => '<div class="widget-title">',
            'after_title' => '</div>',
            'before_widget' => '<div id="%1$s" class="colophon-widget widget-wrapper %2$s">',
            'after_widget' => '</div>'
        ));
		
        register_sidebar(array(
            'name' => __('Top Widget', 'responsive'),
            'description' => __('Area 11 - sidebar-top.php', 'responsive'),
            'id' => 'top-widget',
            'before_title' => '<div class="widget-title">',
            'after_title' => '</div>',
            'before_widget' => '<div id="%1$s" class="%2$s">',
            'after_widget' => '</div>'
        ));
    }
	
    add_action('widgets_init', 'responsive_widgets_init');
	
/*SHORTCODES*/
	/*break*/
	function sClear( $atts, $content = null ) {
		return '<div class="clear">' . do_shortcode( $content ) . '</div>';
	}
	add_shortcode('clear', 'sClear');
	
	/*break*/
	function sTwoThirdLast( $atts, $content = null ) {
		return '<div class="grid col-620 fit floater">' . do_shortcode( $content ) . '</div>';
	}
	add_shortcode('two_thirds_last', 'sTwoThirdLast');
	
	/*break*/
	function sTwoThird( $atts, $content = null ) {
		return '<div class="grid col-620 floater">' . do_shortcode( $content ) . '</div>';
	}
	add_shortcode('two_thirds', 'sTwoThird');
	
	/*break*/
	function sOneThird( $atts, $content = null ) {
		return '<div class="grid col-300 floater">' . do_shortcode( $content ) . '</div>';
	}
	add_shortcode('one_third', 'sOneThird');
	
	/*break*/
	function sOneThirdLast( $atts, $content = null ) {
		return '<div class="grid col-300 fit floater">' . do_shortcode( $content ) . '</div>';
	}
	add_shortcode('one_third_last', 'sOneThirdLast');
	
	/*break*/
	function sOneHalf( $atts, $content = null ) {
		return '<div class="grid col-460">' . do_shortcode( $content ) . '</div>';
	}
	add_shortcode('one_half', 'sOneHalf');
	
	/*break*/
	function sOneHalfLast( $atts, $content = null ) {
		return '<div class="grid col-460 fit">' . do_shortcode( $content ) . '</div>';
	}
	add_shortcode('one_half_last', 'sOneHalfLast');
	
	/*break*/
	function sDashedBorder( $atts, $content = null ) {
		return '<div class="dashed-border">' . do_shortcode( $content ) . '</div>';
	}
	add_shortcode('dashed_border', 'sDashedBorder');
	
	/*break*/
	function sBorder( $atts, $content = null ) {
		return '<div class="border-light">' . do_shortcode( $content ) . '</div>';
	}
	add_shortcode('border', 'sBorder');
	
	add_image_size( 'front-page-slide', 1200, 400, false );
		
/**
* Front Page function starts here. The Front page overides WP's show_on_front option. So when show_on_front option changes it sets the themes front_page to 0 therefore displaying the new option
*/
		
function responsive_front_page_override( $new, $orig ) {
	global $responsive_options;
	
	if( $orig !== $new ) {
		$responsive_options['front_page'] = 0;
		
		update_option( 'responsive_theme_options', $responsive_options );
	}
	return $new;
}
add_filter( 'pre_update_option_show_on_front', 'responsive_front_page_override', 10, 2 );

/**
* Funtion to add CSS class to body
*/
function responsive_add_class( $classes ) {
	
	// Get Responsive theme option.
	global $responsive_options;
	if( $responsive_options['front_page'] == 1 && is_front_page() ) {
		$classes[] = 'front-page';
	}
	
	return $classes;
}

//WOOCOMMERCE CART

add_filter( 'body_class','responsive_add_class' );

// Change number or products per row to 3
add_filter('loop_shop_columns', 'loop_columns');
if (!function_exists('loop_columns')) {
	function loop_columns() {
		return 3; // 3 products per row
	}
}

//add_action( 'pre_get_posts', 'custom_pre_get_posts_query' );
 
function custom_pre_get_posts_query( $q ) {
 
	if ( ! $q->is_main_query() ) return;
	if ( ! $q->is_post_type_archive() ) return;
	
	if ( ! is_admin() ) {
 
		$q->set( 'tax_query', array(array(
			'taxonomy' => 'product_cat',
			'field' => 'slug',
			'terms' => array( 'single-products' ), // Don't display products in the single products category on the shop page
			'operator' => 'NOT IN'
		)));
	
	}
 
	remove_action( 'pre_get_posts', 'custom_pre_get_posts_query' );
 
}

// Redefine woocommerce_output_related_products()
function woocommerce_output_related_products() {
woocommerce_related_products(3,3); // Display 3 products in rows of 3
}

?>
<?php

//Custom Theme Settings
//add_action('admin_menu', 'add_gcf_interface');

function add_gcf_interface() {
	add_options_page('Global Custom Fields', 'Global Custom Fields', '8', 'functions', 'editglobalcustomfields');
}

function editglobalcustomfields() {
	?>
	<div class='wrap'>
	<h2>Global Custom Fields</h2>
	<form method="post" action="options.php">
	<?php wp_nonce_field('update-options') ?>

	<p><strong>Header - Top Left Text:</strong><br />
	<input type="text" name="topheadertext" size="45" value="<?php echo get_option('topheadertext'); ?>" /></p>
	
	<?php /*<p><strong>Amazon ID:</strong><br />
	<input type="text" name="amazonid" size="45" value="<?php echo get_option('amazonid'); ?>" /></p>

	<p><strong>Today's Featured Website:</strong><br />
	<input type="text" name="todaysite" size="45" value="<?php echo get_option('todaysite'); ?>" /></p>

	<p><strong>Welcome Text:</strong><br />
	<textarea name="welcomemessage" cols="100%" rows="7"><?php echo get_option('welcomemessage'); ?></textarea></p>*/ ?>

	<p><input type="submit" name="Submit" value="Update Options" /></p>

	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="page_options" value="topheadertext" />

	</form>
	</div>
	<?php
}

/**
 * Add the field to the checkout
 **/
//add_action('woocommerce_after_order_notes', 'my_custom_checkout_field');

function my_custom_checkout_field( $checkout ) {

    echo '<div id="my_custom_checkout_field"><h2>'.__('Gift Note').'</h2>';

    woocommerce_form_field( 'gift-note', array(
        'type'          => 'textarea',
        'class'         => array('gift-note form-row-wide'),
        'label'         => __('Add a gift note if you are sending this as a gift.'),
        'placeholder'       => __('Enter your note here...'),
        ), $checkout->get_value( 'gift-note' ));

    echo '</div>';

}


add_filter( 'woocommerce_shipping_fields' , 'custom_override_checkout_fields' );

// Our hooked in function - $fields is passed via the filter!
function custom_override_checkout_fields( $fields ) {
    
    $fields['shipping_giftnotes'] = array(
         'label'     => '<h2>'.__('Gift Note').'</h2>Add a gift note if you are sending this as a gift.',
    'placeholder'   => 'Enter your note here...',
    'required'  => false,
    'class'     => array('form-row-wide'),
    'clear'     => true,
    'type'=>'textarea'
        );
     return $fields;
}

/**
 * Update the order meta with field value
 **/
//add_action('woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta');/

function my_custom_checkout_field_update_order_meta( $order_id ) {
    if ($_POST['gift-note']) update_post_meta( $order_id, 'Gift Note', esc_attr($_POST['gift-note']));
}


/**
 * Add the field to the checkout
 **/
//add_action('woocommerce_after_order_notes', 'custom_ship_date_field');

function custom_ship_date_field( $checkout ) {

    echo '<div id="custom_ship_date_field"><h2>'.__('Ship Date').'</h2>';

    woocommerce_form_field( 'custom-ship-date', array(
        'type'          => 'text',
        'class'         => array('custom-ship-date form-row-wide'),
        'label'         => __('Would like us to ship this on a particular date? Enter below.'),
        'placeholder'       => __('Enter date here...'),
        ), $checkout->get_value( 'custom-ship-date' ));

    echo '</div>';

}

add_filter( 'woocommerce_shipping_fields' , 'custom_override_checkout_fields_date' );

// Our hooked in function - $fields is passed via the filter!
function custom_override_checkout_fields_date( $fields ) {
    
    $fields['shipping_deliverydate'] = array(
         'label'     => '<h2>'.__('Set Estimated Delivery Date').'</h2> If this field is blank, your order will ship as soon as possible. If you would like your purchase to arrive on an estimated future date, enter your desired estimated delivery date below. Please see our <a href="http://alaskaartisanal.com/terms-and-conditions/" target="_blank">Shipping Policy</a> page for more.',
    'placeholder'   => '',
    'required'  => false,
    'class'     => array('form-row-wide'),
    'clear'     => true,
    'type'=>'text'
        );
     return $fields;
}

/**
 * Show date picker
 */
function deliverydate_datepicker(){
    wp_enqueue_script( 'deliverydate-datepicker', get_template_directory_uri() . '/js/deliverydate-datepicker.js', array('jquery'));
}
add_action('shipping_deliverydate_datepicker', 'deliverydate_datepicker');


/**
 * Update the order meta with field value
 **/
//add_action('woocommerce_checkout_update_order_meta', 'custom_ship_date_field_update_order_meta');

function custom_ship_date_field_update_order_meta( $order_id ) {
    if ($_POST['custom-ship-date']) update_post_meta( $order_id, 'Ship Date', esc_attr($_POST['custom-ship-date']));
}





add_action('init','remove_notes',100);
function remove_notes() { 
    remove_action( 'wc_ms_shipping_package_block', array( WC_MS_Notes, 'render_note_form'), 10, 2 );

    remove_action( 'woocommerce_checkout_update_order_meta', array( WC_MS_Notes, 'store_order_notes'), 20, 2 );

    // Modify the packages, shipping methods and addresses in the session
    remove_filter( 'wc_ms_checkout_session_packages', array( WC_MS_Notes, 'apply_notes_to_packages' ), 30 );
    //add_filter('wc_ms_checkout_session_packages','spa',30);
    add_filter('wc_ms_shipping_package_block','show_notes',10,2);
    add_filter('woocommerce_admin_shipping_fields', 'order_admin_shipping_fields');
    add_filter('wc_tradegecko_new_order_query','set_order_export_data',10,2);
}
function set_order_export_data($data,$order_id) { 
    	$order = WC_Compat_TG::wc_get_order( (int) $order_id );

        $notes = '';
	if ( $order->shipping_delivery_date != null && strlen( $order->shipping_delivery_date ) > 0)
		$notes .= "Delivery Date: " . $order->shipping_delivery_date . "\n";
	if ( $order->shipping_giftnotes != null && strlen( $order->shipping_giftnotes) > 0)
		$notes .= "Gift notes: " . $order->shipping_giftnotes;
	if (strlen($notes) > 0)
		$data['order']['notes'] = $notes;
        return $data;

}
function order_admin_shipping_fields($addr) { 
    $addr['giftnotes'] = array(
                                    'label' => __( 'Gift Notes', 'woocommerce' ),
                                    'show'	=> true
                                    );
    $addr['deliverydate'] = array(
								'label' => __( 'Delivery Date', 'woocommerce' ),
								'show'	=> true
								);
return $addr;
}
function show_notes($x, $package) { 
    echo "";
    if (isset($package['full_address']['giftnotes'])) { 
        echo "Gift Notes:<br />";
        echo $package['full_address']['giftnotes'] . "<br /><br />";
    }
    if (isset($package['full_address']['deliverydate'])) { 
        echo "<br />Delivery Date:<br />";
        echo $package['full_address']['deliverydate'] . "<br /><br />";
    }
    echo "<br />";
}




add_action('add_meta_boxes', 'remove_shipping_meta',100);
function remove_shipping_meta() { 
remove_meta_box( 'wc_multiple_shipping','shop_order','normal');
}


add_action('woocommerce_before_add_to_cart_form','add_product_bundle_heading');
function add_product_bundle_heading() { 
	echo "<hr/><h2>Individual Product Details</h2>";
}