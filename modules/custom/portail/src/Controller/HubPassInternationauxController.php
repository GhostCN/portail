<?php

namespace Drupal\portail\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\portail\Constante\PassConstante;
use Drupal\portail\Constante\ThemeConstante;
use Drupal\portail\Utils\QueryUtils;

/**
 * Class HubPassInternationauxController
 * @package Drupal\portail\Controller
 */
class HubPassInternationauxController extends ControllerBase
{
  /**
   * TVOrangeController constructor.
   */
  public function __construct()
  {
  }

  /**
   * Retourne la page Hub pass internationaux
   * @return array
   * @throws \Exception
   */
  public function getAll()
  {

    return [
      ThemeConstante::THEME => ThemeConstante::HUB_PASS_INTERNATIONAUX,
    ];
  }

}
