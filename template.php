<?php 
function tcesp_preprocess_page($vars) {
  drupal_set_html_head('<link href="http://fonts.googleapis.com/css?family=Amaranth:400" rel="stylesheet" type="text/css">');
  $vars['head'] .= drupal_get_html_head();
}

function tcesp_preprocess_block($vars) {
  if ($vars['block']->region == 'header') {
    $vars['block']->subject = '<span>' . $vars['block']->subject . '</span>';
  }
}
