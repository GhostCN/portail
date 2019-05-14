<?php

namespace Drupal\portail\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\portail\Constante\PassConstante;
use Drupal\portail\Constante\ThemeConstante;
use Drupal\portail\Utils\QueryUtils;
use Drupal\node\Entity\Node;


/**
 * Class TerangaLibertyController
 * @package Drupal\portail\Controller
 */
class TerangaLibertyController extends ControllerBase
{
  /**
   * TerangaLibertyController constructor.
   */
  public function __construct()
  {
  }

  /**
   * Retourne la page Teranga liberty
   * @return array
   * @throws \Exception
   */
  public function getAll($id)
  {

    $teranga = Node::load(end(explode('-',$id)));

    $liberty = $this->getLiberty($teranga);

    if(!$liberty){
      return $this->redirect("teranga");
    }

    $content = $liberty;

    return [
        ThemeConstante::THEME => ThemeConstante::TERANGA_LIBERTY,
        ThemeConstante::CONTENT => $content,
    ];
  }

  public function getLiberty($teranga){
    $content = [];

    foreach($teranga->get('field_template_de_page_liberty') as $l){

      $liberty = Node::load($l->target_id);

      if($liberty){
        $content = [
          "titre" => $liberty->getTitle(),
          "resume" => $liberty->get("field_resume_description")->value,
          "tarif" => $liberty->get("field_tarif_liberty")->value,
          "bandeau" => $liberty->get("field_bandeau_liberty")->entity->getFileUri(),
          "image" => $liberty->get("field_image_illustratif_liberty")->entity->getFileUri(),
          "descriptif" => $liberty->get("field_descriptif")->value,
          "avantages" => $liberty->get("field_avantages")->value
        ];
      }
      else{
        return false;
      }
    }

    return $content;

        
  }
}
