<?php

namespace Drupal\portail\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\portail\Constante\PassConstante;
use Drupal\portail\Constante\ThemeConstante;
use Drupal\portail\Utils\QueryUtils;


/**
 * Class ContactController
 * @package Drupal\portail\Controller
 */
class ContactController extends ControllerBase
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
        ThemeConstante::THEME => ThemeConstante::CONTACT,
    ];
  }
}
