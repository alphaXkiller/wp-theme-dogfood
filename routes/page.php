<?php

function _format_page_obj($raw_post) {
    $post_id = $raw_post->ID;
    $page = (object) [
      'ID'             => $post_id,
      'title'          => $raw_post->post_title,
      'content'        => apply_filters('the_content', $raw_post->post_content),
      'slug'           => $raw_post->post_name,
      'featured_image' => get_the_post_thumbnail_url($post_id),
      'hero_content'   => get_field("hero_content"),
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
