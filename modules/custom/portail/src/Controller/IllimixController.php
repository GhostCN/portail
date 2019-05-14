<?php

namespace Drupal\portail\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\portail\Constante\PassConstante;
use Drupal\portail\Constante\ThemeConstante;
use Drupal\portail\Utils\QueryUtils;


/**
 * Class IllimixController
 * @package Drupal\portail\Controller
 */
class IllimixController extends ControllerBase
{
  /**
   * TVOrangeController constructor.
   */
  public function __construct()
  {
  }

  /**
   * Retourne la page illimix
   * @return array
   * @throws \Exception
   */
  public function getAll()
  {

    return [
        ThemeConstante::THEME => ThemeConstante::ILLIMIX,
    ];
  }
}
