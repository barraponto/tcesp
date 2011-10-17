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
