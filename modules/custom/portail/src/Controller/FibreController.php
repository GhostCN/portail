<?php

namespace Drupal\portail\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Drupal\portail\Constante\FibreConstante;
use Drupal\portail\Constante\ThemeConstante;
use Drupal\portail\Constante\TvOrangeConstante;
use Drupal\portail\Utils\PortailUtils;
use Drupal\portail\Utils\QueryUtils;

/**
 * Class FibreController
 * @package Drupal\portail\Controller
 */
class FibreController extends ControllerBase
{
  /**
   * InternetController constructor.
   */
  public function __construct()
  {

  }

  /**
   * Retourne toutes les informations de la page home fibre
   * @return array
   * @throws \Exception
   */
  public function getAll()
  {

  try{

    $allErrors = [];
    $tarifs = $this->getOffreFibre();
    $options_inclus = $this->getOptionsInclus();
    $etapes = $this->getEtapeDeploiement();
    $faq = $this->getFaq();
    $slider = $this->getSlider_fibre();
    $bouquets = $this->getBouquet();

    }
    catch (\Exception $e) {
      $allErrors = $e->getMessage();
    }

    return [
      ThemeConstante::ERRORS => $allErrors,
      ThemeConstante::THEME => ThemeConstante::OFFRE_HOME_FIBRE,
      ThemeConstante::TARIFS_FIBRE => $tarifs,
      ThemeConstante::OPTIONS_INCLUS => $options_inclus,
      ThemeConstante::DEPLOIEMENT => $etapes,
      ThemeConstante::FAQ => $faq,
      ThemeConstante::OFFRE => 'home-fibre',
      ThemeConstante::SLIDER_TV => $slider,
      ThemeConstante::BOUQUETS_ORANGE => $bouquets,
      ThemeConstante::PAGE_CACHE => array(ThemeConstante::PAGE_CONTEXTS => [ThemeConstante::PAGE_URL_QUERY], ThemeConstante::MAX_AGE => 0)
    ];
  }

  /**
   * Retourne les tarifs de la page fibre
   * @return array
   * @throws \Exception
   */
  public function getOffreFibre()
  {

      $nids = QueryUtils::getNodesFromType(FibreConstante::TABLE_FIBRE);
      $nodes = Node::loadMultiple($nids);
      $tarifs = [];
      $options = [];

      if ($nodes) {
        foreach ($nodes as $node) {
          $options = [];
          foreach ($node->get('field_options_fibre') as $n) {
            $options[] = @$n->value;
          }

        }


        $tarifs[] = [
          FibreConstante::TITRE_FIBRE => $node->get('field_titre_fibre')->value,
          FibreConstante::TARIF_FIBRE => $node->get('field_tarif_fibre')->value,
          FibreConstante::OPTIONS_FIBRE => $options,
        ];
      }

    return $tarifs;
  }


/**
   * Retourne les options du bloc Inclus dans l'offre de page Fibre Home
   * @return array
   * @throws \Exception
   */
  public function getOptionsInclus()
  {

      $nids = QueryUtils::getNodesFromType(FibreConstante::TABLE_FIBRE);
      $nodes = Node::loadMultiple($nids);
      $options_telephone = [];
      $options_internet = [];
      $options_bouquet = [];
      $options = [];

      if ($nodes) {

        foreach ($nodes as $node) {

          foreach ($node->get('field_options_telephone') as $n) {
             $options_telephone[] = @$n->value;
          }

          foreach ($node->get('field_options_internet') as $n) {
             $options_internet[] = @$n->value;
          }

          foreach ($node->get('field_options_bouquet') as $n) {
             $options_bouquet[] = @$n->value;
          }

            $options[] = [
            FibreConstante::OPTIONS_TELEPHONE => $options_telephone,
            FibreConstante::OPTIONS_INTERNET => $options_internet,
            FibreConstante::OPTIONS_BOUQUET => $options_bouquet,
          ];
        }
      }

    return $options;
  }


   /**
   * Retourne déploiement de la Fibre en 4 étapes
   * @return array
   * @throws \Exception
   */
  public function getEtapeDeploiement()
  {

     $nids = QueryUtils::getNodesFromType(FibreConstante::TABLE_FIBRE);
     $nodes = Node::loadMultiple($nids);
     $ids = [];
     $etapes = [];
     $titres = [];
     $titres_2 = [];
     $icons = [];
     $descriptions = [];

     //Get All fields bloc deploiement
     foreach ($nodes as $node) {
       foreach($node->get('field_etapes_de_deploiement') as $option_n){
        $ids[] = @$option_n->target_id;
       }
     }

     for ($i=0; $i < count($ids) ; $i++) {
      if(!empty($ids[$i])){
        $node = Node::load($ids[$i]);
        $etapes[] = $node->get(FibreConstante::TITLE)->value;
        $titres[] = $node->get('field_titre')->value;
        $titres_2[] = $node->get('field_titre_2')->value;
        $descriptions[] = $node->get('body')->value;
        $icons[] = $node->get('field_icone_')->entity->getFileUri();
        }
     }

    return  $etapes_deploiement[] = [
            FibreConstante::ETAPES => $etapes,
            FibreConstante::TITRES => $titres,
            FibreConstante::TITRES_2 => $titres_2,
            FibreConstante::DESCRIPTIONS => $descriptions,
            FibreConstante::ICONS => $icons,
          ];
  }


   /**
   * Retourne la FAQ
   * @return array
   * @throws \Exception
   */
  public function getFaq()
  {



     $nids = QueryUtils::getNodesFromType(FibreConstante::TABLE_FIBRE);
     $nodes = Node::loadMultiple($nids);
     $ids = [];
     $questions = [];
     $reponses = [];

     //Get All Fields FAQ
     foreach ($nodes as $node) {
       foreach($node->get('field_faq') as $option_n){
        $ids[] = @$option_n->target_id;
       }
     }

     for ($i=0; $i < count($ids) ; $i++) {
        if(!empty($ids[$i])){
          $node = Node::load($ids[$i]);
          $questions[] = $node->get(FibreConstante::TITLE)->value;
          $reponses[] = $node->get('body')->value;
        }
     }

    return  $faq[] = [
            FibreConstante::QUESTIONS => $questions,
            FibreConstante::REPONSES => $reponses,
          ];
  }


/**
   * Retourne les slides de la page fibre
   * @return array
   * @throws \Exception
   */
  public function getSlider_fibre()
  {

    $values = [
      'type' => "slider_tv",
    ];
    $nodes = \Drupal::entityTypeManager()->getListBuilder('node')->getStorage()->loadByProperties($values);

      $images_slider = [];
      $titres_slider = [];
      $categories_slider = [];
      $slider_fibre = [];

      if ($nodes) {
        foreach ($nodes as $node) {
            $titres_slider[] = $node->get(FibreConstante::TITLE)->value;
            $images_slider[] = $node->get('field_image_slider')->entity->getFileUri();
            $categories_slider[] = $node->get('field_c')->value;

        }

        $slider_fibre[] = [
          TvOrangeConstante::IMAGES_SLIDER => $images_slider,
          TvOrangeConstante::TITRES_SLIDER => $titres_slider,
          TvOrangeConstante::CATEGORIES_SLIDER => $categories_slider,
        ];
      }

    return $slider_fibre;
  }

    /**
   * Retourne les bouquets tv orange
   * @return array
   * @throws \Exception
   */
  public function getBouquet()
  {

    $values = [
      'type' => "bouquet_orange",
      'field_a_la_une' => 1,
    ];
    $nodes = \Drupal::entityTypeManager()->getListBuilder('node')->getStorage()->loadByProperties($values);

      $images = [];

      if ($nodes) {
        foreach ($nodes as $node) {
            $images[] = $node->get('field_logo')->entity->getFileUri();

        }
        $bouquet[] = [
          TvOrangeConstante::LOGO_BOUQUET => $images,
        ];
      }

    return $bouquet;
  }

}
