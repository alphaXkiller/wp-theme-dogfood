<?php
function show_email_verified_column($column) {
  $column['email_verified'] = 'Email Verified';

  return $column;
}

function show_email_verified($val, $column_name, $user_id) {
  $verified = get_user_meta($user_id, 'email_verified', true);

  if ($column_name == 'email_verified') {
    return $verified == '1' ? '1' : '0';
  } else {
    return '0';
  }
}

add_filter('manage_users_columns', 'show_email_verified_column');
add_filter('manage_users_custom_column', 'show_email_verified', 10, 3);
