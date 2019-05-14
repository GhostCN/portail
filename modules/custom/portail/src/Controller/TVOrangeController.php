<?php

namespace Drupal\portail\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\portail\Constante\PassConstante;
use Drupal\portail\Constante\ThemeConstante;
use Drupal\portail\Constante\TvOrangeConstante;
use Drupal\portail\Utils\PortailUtils;
use Drupal\portail\Utils\QueryUtils;
use Drupal\node\Entity\Node;


/**
 * Class TVOarangeController
 * @package Drupal\portail\Controller
 */
class TVOrangeController extends ControllerBase
{
  /**
   * TVOrangeController constructor.
   */
  public function __construct()
  {
  }

  /**
   * Retourne la page TV Orange
   * @return array
   * @throws \Exception
   */
  public function getAll()
  {

  try{

    $slider = [];
    $bouquets = [];
    $allErrors = [];

    @$slider = $this->getSlider();
    $bouquets = $this->getBouquetOrange();

    }
    catch (\Exception $e) {
      $allErrors = $e->getMessage();
    }


    return [
      ThemeConstante::THEME => ThemeConstante::TV_ORANGE,
      ThemeConstante::SLIDER_TV => $slider,
      ThemeConstante::BOUQUETS_ORANGE => $bouquets,
      ThemeConstante::ERRORS => $allErrors
    ];
  }


  /**
   * Retourne les slides
   * @return array
   * @throws \Exception
   */
  public function getSlider()
  {

    $values = [
      'type' => "page_tv_orange",
    ];
    $nodes = \Drupal::entityTypeManager()->getListBuilder('node')->getStorage()->loadByProperties($values);

      $images = [];
      $titres = [];
      $categories = [];
      $ids = [];

      if ($nodes) {

      //Get All fields slider
     foreach ($nodes as $node) {
       foreach($node->get('field_slider_tv') as $option_n){
        $ids[] = @$option_n->target_id;
       }
     }

     for ($i=0; $i < count($ids) ; $i++) {
      if(!empty($ids[$i])){
            $node = Node::load($ids[$i]);
            $titres[] = @$node->get('title')->value;
            $images[] = @$node->get('field_image_slider')->entity->getFileUri();
            $categories[] = @$node->get('field_c')->value;
          }
        }

        $slider[] = [
          TvOrangeConstante::IMAGES_SLIDER => $images,
          TvOrangeConstante::TITRES_SLIDER => $titres,
          TvOrangeConstante::CATEGORIES_SLIDER => $categories,
        ];
      }

    return $slider;
  }


  /**
   * Retourne les bouquets tv orange
   * @return array
   * @throws \Exception
   */
  public function getBouquetOrange()
  {

    $values = [
      'type' => "page_tv_orange",
    ];
    $nodes = \Drupal::entityTypeManager()->getListBuilder('node')->getStorage()->loadByProperties($values);

      $images = [];
      $titres = [];
      $categories = [];
      $une = [];
      $ids = [];

      if ($nodes) {

        //Get All fields Bouquet TV
         foreach ($nodes as $node) {
           foreach($node->get('field_b') as $option_n){
            $ids[] = @$option_n->target_id;
           }
         }

        for ($i=0; $i < count($ids) ; $i++) {
          if(!empty($ids[$i])){
            $node = Node::load($ids[$i]);
            $titres[] = $node->get('title')->value;
            $images[] = $node->get('field_logo')->entity->getFileUri();
            $categories[] = $node->get('field_categorie')->value;
            $une[] = $node->get('field_a_la_une')->value;
          }

        }

        $bouquet[] = [
          TvOrangeConstante::LOGO_BOUQUET => $images,
          TvOrangeConstante::TITRES_BOUQUET => $titres,
          TvOrangeConstante::CATEGORIES_BOUQUET => $categories,
          TvOrangeConstante::UNE_BOUQUET => $une,
        ];
      }

    return $bouquet;
  }

}
