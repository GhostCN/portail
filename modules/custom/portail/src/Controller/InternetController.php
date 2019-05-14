<?php

namespace Drupal\portail\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Drupal\portail\Constante\InternetConstante;
use Drupal\portail\Constante\ThemeConstante;
use Drupal\portail\Utils\PortailUtils;
use Drupal\portail\Utils\QueryUtils;

/**
 * Class InternetController
 * @package Drupal\portail\Controller
 */
class InternetController extends ControllerBase
{
  /**
   * InternetController constructor.
   */
  public function __construct()
  {

  }

  /**
   * Retourne tous les pass internet actifs
   * @return array
   * @throws \Exception
   */
  public function getAll()
  {

    try {
      $nids = QueryUtils::getNodesFromType('internet_et_fixe');
      $nodes = Node::loadMultiple($nids);
      $infos = [];
      $allErrors = [];


      if ($nodes) {
        foreach ($nodes as $node) {
          $options = [];
          foreach ($node->get('field_options') as $n) {
             $options[] = @$n->value;
          }
          $image = '';
          if($node->get('field_image')->entity) {
            $image = $node->get('field_image')->entity->getFileUri();
          }

          $infos[] = [
            InternetConstante::TITLE => $node->getTitle(),
            InternetConstante::DESCRIPTION => $node->get('body')->value,
            InternetConstante::OPTIONS => $options,
            InternetConstante::DUREE => $node->get('field_duree')->value,
            InternetConstante::PRIX => $node->get('field_prix')->value,
            InternetConstante::URL => PortailUtils::sanitizeString($node->getTitle()).'-'.$node->get('nid')->value,
            InternetConstante::IMAGE => $image,
            InternetConstante::TEMPLATE => $node->get('field_template')->value,
            InternetConstante::OFFRE_PHARE => $node->get('field_offre_phare')->value,
          ];
        }
      }
      usort($infos,
        function ($a, $b) {
          return strcmp($b[InternetConstante::OFFRE_PHARE], $a[InternetConstante::OFFRE_PHARE]);
        }
      );

    }
    catch (\Exception $e) {
      $allErrors = $e->getMessage();
    }

    $questions = $this->getClient();
    $images_bouquet = $this->getBouquet();
    return [
      ThemeConstante::THEME => ThemeConstante::INTERNET_FIXE,
      ThemeConstante::INFOS => $infos,
      ThemeConstante::IMAGES_BOUQUET => $images_bouquet,
      ThemeConstante::QUESTIONS => $questions,
      ThemeConstante::ERRORS => $allErrors,
      ThemeConstante::PAGE_CACHE => array(ThemeConstante::PAGE_CONTEXTS => [ThemeConstante::PAGE_URL_QUERY], ThemeConstante::MAX_AGE => 0)
    ];
  }

  /**
   * Retourne toutes les qst de nos clients
   * @return array
   * @throws \Exception
   */
  public function getClient()
  {
      $nids = QueryUtils::getNodesFromType('vous_etes_deja_client');
      $nodes = Node::loadMultiple($nids);
      $questions = [];

      if ($nodes) {
        foreach ($nodes as $node) {
          $questions[] = [
            InternetConstante::QUESTION_CLIENT => $node->getTitle(),
            InternetConstante::REPONSE_CLIENT => $node->get('body')->value,
          ];
        }
      }

    return $questions;
  }


  /**
   * Retourne les images du bouquet tv
   * @return array
   * @throws \Exception
   */
  public function getBouquet()
  {
      $nids = QueryUtils::getNodesFromType('bouquet_tv');
      $nodes = Node::loadMultiple($nids);
      $images = [];
      if ($nodes) {

        foreach ($nodes as $node) {
          $images[] = [
            InternetConstante::IMAGE_PRINCIPALE => $node->get('field_image_principale')->entity->getFileUri(),
            InternetConstante::IMAGE_BOUQUET1 => $node->get('field_image_bouquet_1')->entity->getFileUri(),
            InternetConstante::IMAGE_BOUQUET2 => $node->get('field_image_bouquet_2')->entity->getFileUri(),
            InternetConstante::IMAGE_BOUQUET3 => $node->get('field_image_bouquet_3')->entity->getFileUri(),
            InternetConstante::IMAGE_BOUQUET4 => $node->get('field_image_bouquet_4')->entity->getFileUri(),
            InternetConstante::IMAGE_BOUQUET5 => $node->get('field_image_bouquet_5')->entity->getFileUri(),
            InternetConstante::IMAGE_BOUQUET6 => $node->get('field_image_bouquet_6')->entity->getFileUri(),
          ];
        }
      }
    return $images;
  }

}
