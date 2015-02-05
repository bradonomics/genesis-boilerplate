<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme info (you can change it if you like)
define( 'CHILD_THEME_NAME', __( 'Genesis Boilerplate', 'geneplate' ) );
define( 'CHILD_THEME_URL', 'http://github.com/bradonomics/genesis-boilerplate/' );
define( 'CHILD_THEME_VERSION', '0.4' );

//* Include Google Fonts
add_action( 'wp_enqueue_scripts', 'geneplate_enqueue_scripts' );
function geneplate_enqueue_scripts() {
  wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Railway', array(), CHILD_THEME_VERSION );
}

//* Add HTML5 markup structure
add_theme_support( 'html5' );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add Structural Wraps
add_theme_support( 'genesis-structural-wraps', array( 'header', 'footer-widgets' ) );

//* Remove Edit Link
add_filter( 'edit_post_link', '__return_false' );

//* Remove Comment Reply Script
add_action( 'wp_enqueue_scripts', 'remove_comment_scripts' );
function remove_comment_scripts() {
  wp_dequeue_script( 'comment-reply' );
}

//* Remove WordPress version
remove_action( 'wp_head', 'wp_generator' );  

//* Unregister layout settings
  //* Remove the comment line to activate the removal of any layouts you don't intend to use.
// genesis_unregister_layout( 'full-width-content' );
// genesis_unregister_layout( 'content-sidebar' );
// genesis_unregister_layout( 'sidebar-content' );
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );

//* Remove RSD Link in Header
remove_action( 'wp_head', 'rsd_link' );

//* Unregister Sidebars
  //* Remove the comment line to activate the removal of the sidebars if you don't intend to use them.
// unregister_sidebar( 'sidebar' );
// unregister_sidebar( 'sidebar-alt' );

//* Remove unused Genesis Widgets
  //* Add a comment to block or remove the line to deactivate the removal of any widgets you'd like to use.
add_action( 'widgets_init', 'remove_genesis_widgets', 20 );
function remove_genesis_widgets() {
  unregister_widget( 'Genesis_Featured_Page' );
  unregister_widget( 'Genesis_Featured_Post' );
  unregister_widget( 'Genesis_User_Profile_Widget' );
}

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

//* Register after-entry widget area
genesis_register_sidebar( array(
	'id'			=> 'after-entry',
	'name'			=> __( 'After Entry', 'geneplate' ),
	'description'	=> __( 'This is the after post section.', 'geneplate' ),
) );

//* Add 3-Column Footer Widget Area
add_theme_support( 'genesis-footer-widgets', 3 );

//* Change the footer text
remove_action( 'genesis_footer', 'genesis_do_footer' );
add_action( 'genesis_footer', 'geneplate_footer' );
function geneplate_footer() {
	?>
	<p><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a> &copy; <?php echo date('Y') ?> &middot; <a href="http://github.com/bradonomics/genesis-boilerplate/" rel="nofollow">Built using Genesis Boilerplate</a></p>
	<?php
}

//* Add wrap inside entry-content div in case full-width images are needed.
add_action( 'genesis_entry_content', 'entry_content_wrap_open', 1 );
function entry_content_wrap_open() {
    echo '<div class="wrap">';
}

add_action( 'genesis_entry_content', 'entry_content_wrap_close', 25 );
function entry_content_wrap_close() {
    echo '</div>';
}

//* Add wrap inside sidebar div.
add_action( 'genesis_before_sidebar_widget_area', 'sidebar_wrap_open' );
function sidebar_wrap_open() {
    echo '<div class="wrap">';
}

add_action( 'genesis_after_sidebar_widget_area', 'sidebar_wrap_close' );
function sidebar_wrap_close() {
    echo '</div>';
}
