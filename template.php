<?php 

function tcesp_theme() {
  return array(
    'search_theme_form' => array(
      'arguments' => array(
        'form' => NULL,
      ),
    ),
  );
}

function tcesp_preprocess_page($vars) {
  if (!empty($vars['node'])) {
    $vars['meta_type'] = node_get_types('name', $vars['node']);
    if (theme_get_setting('toggle_node_info_' . $vars['node']->type)) {
      $vars['meta_date'] = format_date($vars['node']->created, 'custom', 'j \d\e F \d\e Y');
    }
  }
  if (arg(0) == 'node' &! arg(1)) {
    $vars['body_classes'] .= ' page-node-node';
  }
  elseif (arg(0) != 'node') { 
    $vars['body_classes'] .= ' page-not-node';
  }
  $vars['page_bottom_block_count'] = 'blocks-' . count(block_list('page_bottom'));
}

function tcesp_preprocess_node($vars) {
  $vars['meta_type'] = node_get_types('name', $vars['node']);
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

function tcesp_search_theme_form($form) {

  $form['search_theme_form']['#attributes']['placeholder'] = 'Busca';

  return drupal_render($form);
}
