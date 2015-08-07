<?php

//* Detect plugins
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

//* Check for plugins that ouput open graph data
if ( is_plugin_active( 'wordpress-seo/wp-seo.php' ) || is_plugin_active( 'seo-ultimate/seo-ultimate.php' ) || is_plugin_active( 'all-in-one-seo-pack/all_in_one_seo_pack.php' ) || is_plugin_active( 'wp-facebook-open-graph-protocol/wp-facebook-ogp.php' ) || is_plugin_active( 'wonderm00ns-simple-facebook-open-graph-tags/wonderm00n-open-graph.php' ) || is_plugin_active( 'platinum-seo-pack/platinum_seo_pack.php' ) ) {

    return;

}
else {

//* Call the First Image in a Post (Used in the Open Graph Call Below)
function catch_first_image() {
    global $post, $posts;
    $first_img = '';
    ob_start();
    ob_end_clean();
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
    $first_img = $matches [1] [0];

    if ( empty( $first_img ) ) {
        $first_img = get_theme_mod( 'geneplate_cover_image' );
    }

    return $first_img;

}

//* Call the featured image or the first image function above
function og_image() {
    global $post, $posts;

    if( has_post_thumbnail( $post->ID ) ) {
        $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' )[0];
    }
    else {
        $img_src = catch_first_image();
    }

}

//* Get a description
function og_description() {
    global $post, $posts;

    //* Call the description, Genesis first then WordPress
    $genesis_description = genesis_get_custom_field( '_genesis_description' );

    if ( !empty( $genesis_description ) ) {
        $open_graph_description = $genesis_description;
    }

    return $open_graph_description;

    if ( !empty( $open_graph_description ) ) {
      if ( has_excerpt( $post->ID ) ) {
          $open_graph_description = strip_tags( get_the_excerpt() );
      }
      else {
          $open_graph_description = str_replace( "\r\n", ' ' , substr( strip_tags( strip_shortcodes( $post->post_content ) ), 0, 160 ) );
      }
    }

    return $open_graph_description;

}

//* Add Open Graph meta tag to Head
add_action( 'genesis_meta', 'meta_do_opengraph' );
function meta_do_opengraph(){ ?>
<meta property="og:image" content="<?php echo $img_src; ?>">
<meta property="og:title" content="<?php echo the_title(); ?>">
<meta property="og:url" content="<?php echo the_permalink(); ?>">
<meta property="og:description" content="<?php echo $open_graph_description; ?>"><?php  echo "\n";
}

}

// TODO: Check that this open graph image call does all the options listed (all the ifs).
