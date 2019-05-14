<?php

namespace Drupal\portail\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\portail\Constante\PassConstante;
use Drupal\portail\Constante\ThemeConstante;
use Drupal\portail\Utils\QueryUtils;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ActuVideoController
 * @package Drupal\portail\Controller
 */
class ActuVideoController extends ControllerBase
{
  /**
   * ActuVideoController constructor.
   */
  public function __construct()
  {
  }

  /**
   * Retourne la page actu vidéo de charactère
   * @return Response
   * @throws \Exception
   */
  public function getAll()
  {

    $output = array(
      'page' => array(
        ThemeConstante::THEME => ThemeConstante::ACTU_VIDEO
      )
    );
    $html = \Drupal::service('renderer')->renderRoot($output);
    $response = new Response();
    $response->setContent($html);

    return $response;
  }


  /**
   * @return array
   */
  public function findanPage() {
    return [
      ThemeConstante::THEME => ThemeConstante::FINDAN
      ];
  }

}
