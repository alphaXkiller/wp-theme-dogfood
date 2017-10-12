<?php

function getBrands() {
  $brands = get_field_object('field_59bf367928320');

  return $brands;
}

function registerBrandRoutes() {
  register_rest_route(ENDPOINT_V1, '/brand', array(
    'method' => 'GET',
    'callback' => 'getBrands'
  ));
}
