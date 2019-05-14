<?php

namespace Drupal\portail\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\portail\Constante\OffreConstante;
use Drupal\portail\Constante\ThemeConstante;
use Drupal\portail\Utils\QueryUtils;
use Drupal\image\Entity\ImageStyle;

/**
 * Class PassController
 * @package Drupal\portail\Controller
 */
class JamonoController extends ControllerBase
{
  /**
   * PassController constructor.
   */
  public function __construct()
  {
  }

  /**
   * Retourne tous les pass internet actifs
   * @return array
   * @throws \Exception
   */
  public function getNewScool()
  {

    $out = [
      ThemeConstante::THEME => ThemeConstante::JAMONO_NEW_SCOOL,
      //ThemeConstante::PAGE_CACHE => array(ThemeConstante::PAGE_CONTEXTS => [ThemeConstante::PAGE_URL_QUERY], ThemeConstante::MAX_AGE => 0)
    ];
    return $out;
  }
}
