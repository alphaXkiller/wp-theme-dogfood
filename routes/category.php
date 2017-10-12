<?php

function getAllCategory() {
  $taxonomy     = 'product_cat';
  $orderby      = 'name';
  $show_count   = 0;      // 1 for yes, 0 for no
  $pad_counts   = 0;      // 1 for yes, 0 for no
  $hierarchical = 1;      // 1 for yes, 0 for no
  /* $title        = ''; */
  $empty        = 0;

  $args = array(
    'taxonomy'     => $taxonomy,
    'orderby'      => $orderby,
    'show_count'   => $show_count,
    'pad_counts'   => $pad_counts,
    'hierarchical' => $hierarchical,
    'title_li'     => $title,
    'hide_empty'   => $empty
  );

  $categories = get_categories($args);
  $brands = get_field_object('field_59bf367928320');

  if ($brands) {
    array_push($categories, $brands);
  }

  return $categories;
}

function registerCategoryRoutes() {
  register_rest_route(ENDPOINT_V1, '/category', array(
    'method' => 'GET',
    'callback' => 'getAllCategory'
  ));
}
