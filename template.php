<?php 
function tcesp_preprocess_page($vars) {
  drupal_set_html_head('<link href="http://fonts.googleapis.com/css?family=Amaranth:700" rel="stylesheet" type="text/css">');
  $vars['head'] .= drupal_get_html_head();
}
