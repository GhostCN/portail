<?php

namespace Drupal\portail\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\portail\Constante\ThemeConstante;
use Symfony\Component\HttpFoundation\Response;
use Drupal\Core\Render\Renderer;

/**
 * Class ContactController
 * @package Drupal\portail\Controller
 */
class MenuController extends ControllerBase
{
  /**
   * ContactController constructor.
   */
  public function __construct()
  {
  }

  /**
   * Retourne le header du portail
   * @return array
   */
  public function getHeader()
  {
    return [
      ThemeConstante::THEME => ThemeConstante::HEADER,
    ];
  }

  /**
   * Retourne le footer du portail
   * @return Response
   */
  public function getFooter()
  {
    $main_menu = \Drupal::menuTree()->load('main', new \Drupal\Core\Menu\MenuTreeParameters());
    //Generate array
    generateMainMenuTree($menu_tree, $main_menu);

    $output = array(
      'page' => array(
        ThemeConstante::THEME => ThemeConstante::FOOTER,
        ThemeConstante::FOOTERMENU => $menu_tree,
      )
    );
    $html = \Drupal::service('renderer')->renderRoot($output);
    $response = new Response();
    $response->setContent($html);

    return $response;
  }
}
