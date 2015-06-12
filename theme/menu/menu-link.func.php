<?php
/**
* @file
* menu-link.func.php
*
* viene de aqui: http://webmar.com.au/blog/drupal-bootstrap-3-multilevel-submenus-hover
*
*/

/**
* Para sobreescribe el theme_menu_link().
**/

function bug273_menu_link(array $variables) {
  $element = $variables['element'];
  $sub_menu = '';

  if($element['#below']) {
    // Previene las funciones de los desplegables de ser añadidas al menu de gestion
    // por lo que no afecta al modulo de navegación
    if(($element['#original_link']['menu_name'] == 'management') && (module_exists('navbar'))) {
      $sub_menu = drupal_render($element['#below']);
    }
    // Aqui necesitamos cambiar de ==1 a >=1 para permitir los menus multinivel
    elseif ((!empty($element['#original_link']['depth'])) && ($element['#original_link']['depth'] >=1)) {
      // Añadimos nuestro propio wrapper
      unset($element['#below']['#theme_wrappers']);
      $sub_menu = '<ul class="dropdown_menu">' . drupal_render($element['#below']) . '</ul>';
      // Lo generamos como un dropdown estandard
      // El plugin smartmenus añade el signo de intercalación
      $element['#attributes']['class'][] = 'dropdown';
      $element['#localized_options']['html'] = TRUE;

      // Configura el disparador del dropdown
      $element['#localized_options']['attributes']['data-target'] = '#';
      $element['#localized_options']['attributes']['class'][] = 'dropdown-toggle';
      $element['#localized_options']['attributes']['data-toggle'] = 'dropdown';
    }
  }
  // En primary navigation menu, la clase 'active' no se configura En el menu activo
  // buscar en https://drupal.org/node/1896674
  if (($element['#href'] == $_GET['q'] || ($element['#href'] == '<front>' && drupal_is_front_page())) && (empty($element['#localized_options']['language']))) {
    $element['#attributes']['class'][] = 'active';
  }
  $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  return '<li>' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";

}
