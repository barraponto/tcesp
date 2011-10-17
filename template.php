<?php 

function tcesp_preprocess_page($vars) {
  drupal_set_html_head('<link href="http://fonts.googleapis.com/css?family=Amaranth:400" rel="stylesheet" type="text/css">');
  $vars['head'] .= drupal_get_html_head();
  if (!empty($vars['node'])) {
    $vars['meta_type'] = $vars['node']->type;
    if (theme_get_setting('toggle_node_info_' . $vars['node']->type)) {
      $vars['meta_date'] = format_date($vars['node']->created, 'custom', 'j \d\e F \d\e Y');
    }
  }
}

function tcesp_preprocess_block($vars) {
  if ($vars['block']->region == 'header') {
    $vars['block']->subject = '<span>' . $vars['block']->subject . '</span>';
  }
}

function tcesp_preprocess_comment($vars) {
  //foto do comentador não está suportado no tema
  $vars['picture'] = FALSE;
  $vars['meta_date'] = format_date($vars['comment']->timestamp, 'custom', 'j \d\e F \d\e Y');
  $vars['meta_author'] = theme('username', $vars['comment']);
}


/* reimplementando o theme_username para tirar o '(not verified)' */
function tcesp_username($object) {

  if ($object->uid && $object->name) {
    // Shorten the name when it is too long or it will break many tables.
    if (drupal_strlen($object->name) > 20) {
      $name = drupal_substr($object->name, 0, 15) . '...';
    }
    else {
      $name = $object->name;
    }

    if (user_access('access user profiles')) {
      $output = l($name, 'user/' . $object->uid, array('attributes' => array('title' => t('View user profile.'))));
    }
    else {
      $output = check_plain($name);
    }
  }
  else if ($object->name) {
    // Sometimes modules display content composed by people who are
    // not registered members of the site (e.g. mailing list or news
    // aggregator modules). This clause enables modules to display
    // the true author of the content.
    if (!empty($object->homepage)) {
      $output = l($object->name, $object->homepage, array('attributes' => array('rel' => 'nofollow')));
    }
    else {
      $output = check_plain($object->name);
    }

  }
  else {
    $output = check_plain(variable_get('anonymous', t('Anonymous')));
  }

  return $output;
}
?>
