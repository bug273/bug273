<?php

/**
 * @file
 * template.php
 */



function bug273_preprocess_image_style(&$vars) {
          $vars['attributes']['class'][] = 'img-thumbnail'; // can be 'img-rounded', 'img-circle', or 'img-thumbnail'
}


/**
* Para cambiar el Id del termino y que muestre el nombre en vez del numero
*
* viene de aqui: http://bri-space.com/content/drupal-7-views-contextual-filters-create-summary-taxonomy-terms


function bug273_preprocess_views_view_summary(&$vars){
  if($vars['view']->name == '[galerias]' && $vars['view']->current_display == '[galeria_general]') {
    $items = array();
    foreach($vars['rows'] as $result){
      if(is_numeric($result->link)){
        $term_object = taxonomy_term_load($result->link);
        $result->link = $term_object->name;
        $items[] = $result;
      } else {
        // Lo utilizamos si no  hay valores
        $items[] = $result;
      }
    }
    $vars['rows'] = $items;
  }
  if($view->name == 'galerias') print "<h2>" . $view->name . "</h2>";
}
*/
