<?php

namespace Drupal\portail\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\portail\Constante\PassConstante;
use Drupal\portail\Constante\ThemeConstante;
use Drupal\portail\Utils\QueryUtils;

const VALIDITE = 'field_validite_pass';

/**
 * Class PassController
 * @package Drupal\portail\Controller
 */
class PassController extends ControllerBase
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
  public function getAllPassInternet()
  {
    try {
      $nids = QueryUtils::getNodesFromType('pass_internet');
      $nodes = \Drupal\node\Entity\Node::loadMultiple($nids);
      $allPassInternet = [];
      $allErrors = [];

      if ($nodes) {
        foreach ($nodes as $node) {
          $pass = [
            PassConstante::TITLE => $node->getTitle(),
            PassConstante::MONTANT => $node->get('field_montant_pass')->value,
            PassConstante::VOLUME => $node->get('field_volume_pass')->value,
            PassConstante::VALIDITE => $node->get(VALIDITE)->value,
            PassConstante::INFO => $node->get('field_info_supplementaire_pass')->value,
            PassConstante::RESTRICTION => $node->get('field_restrictions_pass')->value,
            PassConstante::POIDS => $node->get('field_poids_pass')->value
          ];
          if($node->get(VALIDITE)->value == 'Jour') {
            $allPassInternet['jour'][] = $pass;
          }
          elseif ($node->get(VALIDITE)->value == 'Nuit') {
            $allPassInternet['nuit'][] = $pass;
          }
          elseif ($node->get(VALIDITE)->value == 'Semaine') {
            $allPassInternet['semaine'][] = $pass;
          }
          elseif ($node->get(VALIDITE)->value == 'Jours') {
            $allPassInternet['jours'][] = $pass;
          }
          else {
            $allPassInternet['mois'][] = $pass;
          }
        }
      }

    }
    catch (\Exception $e) {
      $allErrors = $e->getMessage();
    }

    return [
      ThemeConstante::THEME => ThemeConstante::LIST_PASS,
      ThemeConstante::ALLPASS => $allPassInternet,
      ThemeConstante::ERRORS => $allErrors
    ];
  }
}
