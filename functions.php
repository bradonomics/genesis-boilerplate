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

//* Include Google fonts, responsive menu icon, dashicons; remove comment-reply script.
add_action( 'wp_enqueue_scripts', 'geneplate_enqueue_scripts' );
function geneplate_enqueue_scripts() {
  wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Railway', array(), CHILD_THEME_VERSION );
  wp_enqueue_script( 'responsive-menu-icon', get_bloginfo( 'stylesheet_directory' ) . '/js/responsive-menu.js', array( 'jquery' ), CHILD_THEME_VERSION );
  wp_enqueue_style( 'dashicons' );
  wp_dequeue_script ( 'comment-reply' );
}

//* Move child theme stylesheet to the end of the line so it takes precedence over plugin stylesheets.
remove_action( 'genesis_meta', 'genesis_load_stylesheet' );
add_action( 'wp_enqueue_scripts', 'genesis_enqueue_main_stylesheet', 999 );

//* Add HTML5 markup structure
add_theme_support( 'html5' );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add Structural Wraps
add_theme_support( 'genesis-structural-wraps', array( 'header', 'footer-widgets', 'footer' ) );

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

//* Include Open Graph Data
include_once( get_stylesheet_directory() . '/inc/open_graph.php' );

/************* CONTENT AREA *************/

//* Add wrap inside entry-content div in case full-width images are needed.
add_action( 'genesis_entry_content', 'entry_content_wrap_open', 1 );
add_action( 'genesis_entry_content', 'entry_content_wrap_close', 25 );
function entry_content_wrap_open() {
    echo '<div class="wrap">';
}
function entry_content_wrap_close() {
    echo '</div>';
}

//* Add a 'iframe-embed' div around videos and such for responsive designs
add_filter('the_content', 'iframe_responsive_wrapper');
function iframe_responsive_wrapper($content) {

  $pattern = '~<iframe.*</iframe>|<embed.*</embed>~';
  preg_match_all($pattern, $content, $matches);

  foreach ($matches[0] as $match) {
    $wrappedframe = '<div class="iframe-embed">' . $match . '</div>';
    $content = str_replace($match, $wrappedframe, $content);
  }

  return $content;

}

//* Register after-entry widget area
genesis_register_sidebar( array(
	'id'			=> 'after-entry',
	'name'			=> __( 'After Entry', 'geneplate' ),
	'description'	=> __( 'This is the after post section.', 'geneplate' ),
) );

//* Hooks after-entry widget area to single posts
add_action( 'genesis_entry_footer', 'geneplate_after_entry' );
function geneplate_after_entry() {
  if ( ! is_singular( 'post' ) )
    return;
    genesis_widget_area( 'after-entry', array(
      'before' => '<div class="after-entry widget-area"><div class="wrap">',
      'after'  => '</div></div>',
    ) );
}


/************* SIDEBARS AND WIDGETS *************/

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
