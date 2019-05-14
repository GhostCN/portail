<?php

namespace Drupal\portail\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\portail\Constante\PassConstante;
use Drupal\portail\Constante\ThemeConstante;
use Drupal\portail\Utils\QueryUtils;


/**
 * Class OrangeAichaController
 * @package Drupal\portail\Controller
 */
class OrangeAichaController extends ControllerBase
{
  /**
   * ContactController constructor.
   */
  public function __construct()
  {
  }

  /**
   * Retourne la page contact
   * @return array
   * @throws \Exception
   */
  public function getAll()
  {

    return [
        ThemeConstante::THEME => ThemeConstante::ORANGE_AICHA,
    ];
  }
}
