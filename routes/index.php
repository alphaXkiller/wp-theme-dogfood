<?php

require_once ('product.php');
require_once ('page.php');

add_action('rest_api_init', 'product_routes');
