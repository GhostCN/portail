<?php

namespace Drupal\portail\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\portail\Constante\PassConstante;
use Drupal\portail\Constante\ThemeConstante;
use Drupal\portail\Utils\QueryUtils;


/**
 * Class AssistanceController
 * @package Drupal\portail\Controller
 */
class AssistanceController extends ControllerBase
{
  /**
   * AssistanceController constructor.
   */
  public function __construct()
  {
  }

  /**
   * Retourne la page assistance
   * @return array
   * @throws \Exception
   */
  public function getAll()
  {

    return [
        ThemeConstante::THEME => ThemeConstante::ASSISTANCE,
    ];
  }
}
