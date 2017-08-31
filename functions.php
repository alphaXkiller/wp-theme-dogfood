<?php
  require_once ('config.php');
  require_once ('routes/index.php');

  function add_menu_support() {
        add_theme_support( 'menus'  );
  }
  add_action( 'after_setup_theme', 'add_menu_support'  );
