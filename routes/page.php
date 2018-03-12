<?php

function _format_page_obj($raw_post) {
    $post_id = $raw_post->ID;

    function get_yoast_pages($post_id){
      $yoastMeta = array(
        'yoast_wpseo_focuskw'               => get_post_meta( $post_id, '_yoast_wpseo_focuskw', true  ),
        'yoast_wpseo_title'                 => get_post_meta( $post_id, '_yoast_wpseo_title', true  ),
        'yoast_wpseo_metadesc'              => get_post_meta( $post_id, '_yoast_wpseo_metadesc', true  ),
        'yoast_wpseo_linkdex'               => get_post_meta( $post_id, '_yoast_wpseo_linkdex', true  ),
        'yoast_wpseo_metakeywords'          => get_post_meta( $post_id, '_yoast_wpseo_metakeywords', true  ),
        'yoast_wpseo_meta_robots_noindex'   => get_post_meta( $post_id, '_yoast_wpseo_meta-robots-noindex', true  ),
        'yoast_wpseo_meta_robots_nofollow'  => get_post_meta( $post_id, '_yoast_wpseo_meta-robots-nofollow', true  ),
        'yoast_wpseo_meta_robots_adv'       => get_post_meta( $post_id, '_yoast_wpseo_meta-robots-adv', true  ),
        'yoast_wpseo_canonical'             => get_post_meta( $post_id, '_yoast_wpseo_canonical', true  ),
        'yoast_wpseo_redirect'              => get_post_meta( $post_id, '_yoast_wpseo_redirect', true  ),
        'yoast_wpseo_opengraph_title'       => get_post_meta( $post_id, '_yoast_wpseo_opengraph-title', true  ),
        'yoast_wpseo_opengraph_description' => get_post_meta( $post_id, '_yoast_wpseo_opengraph-description', true  ),
        'yoast_wpseo_opengraph_image'       => get_post_meta( $post_id, '_yoast_wpseo_opengraph-image', true  ),
        'yoast_wpseo_twitter_title'         => get_post_meta( $post_id, '_yoast_wpseo_twitter-title', true  ),
        'yoast_wpseo_twitter_description'   => get_post_meta( $post_id, '_yoast_wpseo_twitter-description', true  ),
        'yoast_wpseo_twitter_image'         => get_post_meta( $post_id, '_yoast_wpseo_twitter-image', true  )
      );

        return $yoastMeta;
    }

    $page = (object) [
      'ID'             => $post_id,
      'title'          => $raw_post->post_title,
      'content'        => apply_filters('the_content', $raw_post->post_content),
      'slug'           => $raw_post->post_name,
      'featured_image' => get_the_post_thumbnail_url($post_id),
      'hero_content'   => get_field("hero_content", $post_id),
      'meta'           => get_yoast_pages($post_id),
    ];
    return $page;
}



function getPageBySlug($request) {
  $args = array(
    'post_type' => 'page',
    'name'      => $request['slug'],
    'status'    => 'publish'
  );

  $query_result = new WP_Query($args);
  if (is_null($query_result->post)) {
    $err_code = 'Not Found';
    $err_msg = 'page ('.$request['slug'].') not found.';
    return new WP_Error($err_code, $err_msg, array('status' => 404));
  } else {
    return _format_page_obj($query_result->post);
  }
}

function registerPageRoutes() {
  register_rest_route(ENDPOINT_V1, '/page/(?P<slug>[a-zA-Z0-9-]+)', array(
    'method' => 'GET',
    'callback' => 'getPageBySlug'
  ));
}

?>
