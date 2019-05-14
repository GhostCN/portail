<?php

namespace Drupal\portail\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\portail\Constante\MainWindowConstante;
use Drupal\portail\Constante\ActualiteConstante;
use Drupal\portail\Utils\QueryUtils;
use Drupal\node\Entity\Node;
use Drupal\image\Entity\ImageStyle;

/**
 * Class MainWindowController
 * @package Drupal\portail\Controller
 */
class MainWindowController extends ControllerBase
{

  /**
   * MainWindowController constructor.
   */
  public function __construct()
  {
  }

  /**
   * Retourne les fenêtres principales
   * @return array
   */
  public function getAllMainWindow() {
    $nids = QueryUtils::getNodesFromType('main_window');
    $nodes = Node::loadMultiple($nids);
    $allMainWindow = [];

    if ($nodes) {
      foreach ($nodes as $node) {
        $allMainWindow[] = [
          MainWindowConstante::TITLE => $node->getTitle(),
          MainWindowConstante::RESUME => $node->get('field_main_window_resume')->value,
          MainWindowConstante::POIDS => $node->get('field_main_window_poids')->value,
          MainWindowConstante::URL => $node->get('field_main_window_url')->value,
          MainWindowConstante::IMAGE => $node->get('field_main_window_image')->entity->getFileUri()//ImageStyle::load(MainWindowConstante::STYLE)->buildUrl($node->get('field_main_window_image')->entity->getFileUri())
        ];
      }
    }

    usort($allMainWindow,
      function ($a, $b) {
        return strcmp($a[MainWindowConstante::POIDS], $b[MainWindowConstante::POIDS]);
      }
    );

    return $allMainWindow;
  }

  /**
   * Récupere les différents slide
   * @return array
   */
  public function getSliders() {
    $nids = QueryUtils::getNodesFromType('slider');
    $nodes = Node::loadMultiple($nids);
    $sliders = [];

    if ($nodes) {
      foreach ($nodes as $node) {
        $image = '';
        if($node->get('field_slider_image')->entity) {
          $image = $node->get('field_slider_image')->entity->getFileUri();
        }
        $sliders[] = [
          MainWindowConstante::TITLE => $node->getTitle(),
          MainWindowConstante::LIEN => $node->get('field_slider_lien')->uri,
          MainWindowConstante::TEXTE_LIEN => $node->get('field_slider_lien')->title,
          'titre_principal' => $node->get('field_slide_titre_principal')->value,
          MainWindowConstante::IMAGE => $image//ImageStyle::load(MainWindowConstante::STYLE_1740_720)->buildUrl($node->field_slider_image->entity->getFileUri())
        ];
      }
    }

    return $sliders;
  }


  /**
   * Afficher evenement
   * @return array
   */
  public function getEvent() {
    $nids = QueryUtils::getNodesFromType('compte_a_rebours');
    $nodes = Node::loadMultiple($nids);
    $event = [];

    if ($nodes) {
      foreach ($nodes as $node) {
        $event[] = [


          MainWindowConstante::ICONE => $node->get('field_icone')->entity->getFileUri(),
          MainWindowConstante::DATE_EN_LIGNE => $node->get('field_date_en_ligne')->value,
          MainWindowConstante::DATE_FIN => $node->get('field_date_fin')->value,
          MainWindowConstante::LIEN_BUTTON => $node->get('field_lien_du_bouton')->value,
          MainWindowConstante::STATUS => $node->get('status')->value,
          MainWindowConstante::POURCENTAGE_BONUS => $node->get('field_pourcentage_bonus')->value,
          MainWindowConstante::PRIX_BONUS => $node->get('field_prix_bonus')->value,
        ];
      }
    }

    return $event;
  }

  /**
   * get All Phones
   * @return array
   */
  public function getAllPhone() {
    $nids = QueryUtils::getNodesFromType('page_d_actualites_smartphone');
    $nodes = Node::loadMultiple($nids);
    $phones = [];

    if ($nodes) {
      foreach ($nodes as $node) {
        $image = '';
        if($node->get('field_image_secondaire')->entity) {
          $image = $node->get('field_image_secondaire')->entity->getFileUri();
        }
        $phones[] = [
          ActualiteConstante::PRIX => $node->get('field_actualite_smartphone_prix')->value,
          ActualiteConstante::PRIX_ANCIEN => $node->get('field_ancien_prix')->value,
          ActualiteConstante::FLASH => $node->get('field_vente_flash')->value,
          ActualiteConstante::TITLE => $node->getTitle(),
          ActualiteConstante::ID => $node->get('nid')->value,
          ActualiteConstante::REDUCTION => $node->get('field_reduction')->value,
          ActualiteConstante::IMAGE => $image,
        ];
      }
    }

    usort($phones,
      function ($a, $b) {
        return strcmp($b[ActualiteConstante::FLASH], $a[ActualiteConstante::FLASH]);
      }
    );

    return $phones;
  }

    /**
   * Retourne les actualité à la une
   * @return array
   * @throws \Exception
   */
  public function getActu()
  {

    $values = [
      'type' => "page_actualite",
      'field_actu_ala_une' => 1,
    ];
    $nodes = \Drupal::entityTypeManager()->getListBuilder('node')->getStorage()->loadByProperties($values);

      $images = [];
      $desc = [];
      $titre = [];
      $uri = [];
      $actu = [];
      $lien = [];

      if ($nodes) {
        foreach ($nodes as $node) {
          if($node->get('field_image_actu_ala_une')->entity) {
            $images[] = $node->get('field_image_actu_ala_une')->entity->getFileUri();
          }
            $desc[] = $node->get('field_desc_actu_ala_une')->value;
            $titre[] = $node->get('field_titre_actu_ala_une')->value;
            $lien[] = $node->get('field_titre_lien_a_la_une')->value;
            $uri[] = $node->get('nid')->value;
        }

      }

        $actu[] = [
          "image" => $images,
          "desc" => $desc,
          "titre" => $titre,
          "lien" => $lien,
          "uri" => $uri,
        ];

    return $actu;
  }

}
