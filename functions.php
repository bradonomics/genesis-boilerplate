<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );


/************* REGISTER CHILD THEME *************/

//* Child theme info (you can change it if you like)
define( 'CHILD_THEME_NAME', __( 'Genesis Boilerplate', 'geneplate' ) );
define( 'CHILD_THEME_URL', 'http://github.com/bradonomics/genesis-boilerplate/' );
define( 'CHILD_THEME_VERSION', '0.0.0' );

/*
 * Versioning makes little sense with software like a
 * boilerplate theme. I started this project with a
 * version number but have decided to stop keeping
 * track; hence the 0.0.0 version number above. Make
 * sure you pull the latest from the github repo before
 * you start a new project.
 */

/************* THEME SUPPORT *************/

//* Include Google fonts, responsive menu icon and dashicons and remove comment-reply script.
add_action( 'wp_enqueue_scripts', 'geneplate_enqueue_scripts' );
function geneplate_enqueue_scripts() {
  wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Railway', array(), CHILD_THEME_VERSION );
  wp_enqueue_style( 'dashicons' );

  wp_dequeue_script ( 'comment-reply' );

  //* Move jQuery before closing body tag.
  wp_deregister_script( 'jquery' );
  wp_enqueue_script( 'jquery', includes_url( '/js/jquery/jquery.js' ), false, NULL, true );

  //* To use jQuery Migrate uncomment the wp_register_script & wp_enqueue_script lines.
  wp_deregister_script( 'jquery-ui' );
//  wp_enqueue_script( 'jquery-ui', includes_url( '/js/jquery/jquery-migrate.min.js' ), false, NULL, true );

  wp_enqueue_script( 'responsive-menu-icon', get_bloginfo( 'stylesheet_directory' ) . '/js/responsive-menu.js', array( 'jquery' ), CHILD_THEME_VERSION, true );
}

//* Move child theme stylesheet to the end of the line so it takes precedence over plugin stylesheets.
remove_action( 'genesis_meta', 'genesis_load_stylesheet' );
add_action( 'wp_enqueue_scripts', 'genesis_enqueue_main_stylesheet', 999 );

//* Add HTML5 markup structure
add_theme_support( 'html5' );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for structural wraps (max-width has been added to most content-entry elements to allow for full-width images. If you don't need full-width images in your non-template posts and pages, you can add structural wrap in site-inner.)
add_theme_support( 'genesis-structural-wraps', array(
    'header',
//  'nav',
//  'subnav',
//  'site-inner',
    'footer-widgets',
    'footer'
) );

//* Remove Edit Link
add_filter( 'edit_post_link', '__return_false' );

//* Remove Emoji
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );


/************* UNREGISTER LAYOUTS AND WIDGETS *************/

//* Unregister layout settings
  //* Remove the comment line to activate the removal of any layouts you don't intend to use.
// genesis_unregister_layout( 'full-width-content' );
// genesis_unregister_layout( 'content-sidebar' );
// genesis_unregister_layout( 'sidebar-content' );
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );

//* Unregister Sidebars
  //* Remove the comment line to activate the removal of the sidebars if you don't intend to use them.
// unregister_sidebar( 'sidebar' );
unregister_sidebar( 'sidebar-alt' );
unregister_sidebar( 'header-right' );

//* Remove unused Genesis Widgets
  //* Add a comment to block or remove the line to deactivate the removal of any widgets you'd like to use.
add_action( 'widgets_init', 'remove_genesis_widgets', 20 );
function remove_genesis_widgets() {
  unregister_widget( 'Genesis_Featured_Page' );
  unregister_widget( 'Genesis_Featured_Post' );
  unregister_widget( 'Genesis_User_Profile_Widget' );
}


/************* HEAD *************/

//* Remove WordPress version
remove_action( 'wp_head', 'wp_generator' );

//* Remove RSD Link in Header
remove_action( 'wp_head', 'rsd_link' );


/************* CONTENT AREA *************/

//* Add a 'iframe-embed' div around videos and such for responsive designs
add_filter('the_content', 'iframe_responsive_wrapper');
function iframe_responsive_wrapper($content) {

  $pattern = '~<iframe.*</iframe>|<embed.*</embed>~';
  preg_match_all($pattern, $content, $matches);

  foreach ($matches[0] as $match) {
    $wrappedframe = '<div class="wrap"><div class="iframe-embed">' . $match . '</div></div>';
    $content = str_replace($match, $wrappedframe, $content);
  }

  return $content;

}

//* Add wrap divs around tables
add_filter('the_content', 'table_responsive_wrapper');
function table_responsive_wrapper($content) {

  $pattern = '/<table.*?<\/table>/si';
  preg_match_all($pattern, $content, $matches);

  foreach ($matches[0] as $match) {
    $wrappedframe = '<div class="wrap">' . $match . '</div>';
    $content = str_replace($match, $wrappedframe, $content);
  }

  return $content;

}

//* Add support for after entry widget
//add_theme_support( 'genesis-after-entry-widget-area' );


/************* SIDEBARS *************/

//* Add wrap inside sidebar div.
add_action( 'genesis_before_sidebar_widget_area', 'sidebar_wrap_open' );
add_action( 'genesis_after_sidebar_widget_area', 'sidebar_wrap_close' );
function sidebar_wrap_open() {
  echo '<div class="wrap">';
}
function sidebar_wrap_close() {
  echo '</div>';
}


/************* FOOTER WIDGETS *************/

//* Add 2, 3 or 4-Column Footer Widget Area
// add_theme_support( 'genesis-footer-widgets', 3 );


/************* FOOTER *************/

//* Custom footer text and copyright info
remove_action( 'genesis_footer', 'genesis_do_footer' );
add_action( 'genesis_footer', 'geneplate_footer' );
function geneplate_footer() {
  ?><p><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a> &copy; <?php echo date('Y') ?> &middot; <a href="http://github.com/bradonomics/genesis-boilerplate/" rel="nofollow">Built using Genesis Boilerplate</a></p><?php
}
