<?php

namespace Drupal\portail\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Drupal\portail\Constante\PassInternationauxConstante;
use Drupal\portail\Constante\ThemeConstante;
use Drupal\portail\Utils\QueryUtils;
use Drupal\image\Entity\ImageStyle;

/**
 * Class PassInternationauxController
 * @package Drupal\portail\Controller
 */
class PassInternationauxController extends ControllerBase
{
  /**
   * OffreController constructor.
   */
  public function __construct()
  {

  }

  /**
   * Retourne toutes les informations de la page Pass Internationaux
   * @return array
   * @throws \Exception
   */
  public function getAll($pays)
  {

    try{

    $appel = "";
    $sms = "";

    if($pays == ""){
     $pays = $this->getIdByNom('france');
    }

    $country = $this->getPays();
    $tbl_pass = $this->getPass($pays);

    $values = [
      'type' => "pass_internationaux",
    ];
    $nodes = \Drupal::entityTypeManager()->getListBuilder('node')->getStorage()->loadByProperties($values);
      $appel = "";
      $sms = "";
      $allErrors = [];
      $pass = [];

      if ($nodes) {
        foreach ($nodes as $node) {
          foreach($node->get("field_pay") as $n){
             if($n->target_id == $pays){
              $appel = $node->get("field_prix_appel")->value;
              $sms = $node->get("field_prix_sms")->value;
              break;
             }
          }

        }
    }
  }
    catch (\Exception $e) {
      $allErrors = $e->getMessage();
    }

    $pass[] = $appel;
    $pass[] = $sms;
    $pass[] = $pays;

    return [
      ThemeConstante::ERRORS => $allErrors,
      ThemeConstante::INFOS_PASS => $pass,
      ThemeConstante::PAYS => $country,
      ThemeConstante::PASS => $tbl_pass,
      ThemeConstante::THEME => ThemeConstante::PASS_INTERNATIONAUX,
      ThemeConstante::PAGE_CACHE => array(ThemeConstante::PAGE_CONTEXTS => [ThemeConstante::PAGE_URL_QUERY])
    ];
  }


   /**
   * Retourne tous les pays
   * @return array
   * @throws \Exception
   */
  public function getPays()
  {

    $values = [
      'type' => "pays",
    ];
    $nodes = \Drupal::entityTypeManager()->getListBuilder('node')->getStorage()->loadByProperties($values);

      $pays = [];

      if ($nodes) {
        foreach ($nodes as $node) {
              $pays['id'][] = $node->get("nid")->value;
              $pays['pays'][] = $node->get(PassInternationauxConstante::TITLE)->value;
        }
    }

    return $pays;
  }

/**
   * Retourne tous les pass par pays
   * @return array
   * @throws \Exception
   */
  public function getPass($id)
  {

     $nom_pays = "";
     $ids = [];
     $values = [
      'type' => "pays",
       'nid' => $id,
    ];
    $nodes = \Drupal::entityTypeManager()->getListBuilder('node')->getStorage()->loadByProperties($values);
      $pass = [];

      if ($nodes) {
        foreach ($nodes as $node) {
          $nom_pays = $node->get(PassInternationauxConstante::TITLE)->value;
          foreach($node->get("field_chp_pass") as $option_n){
            $ids[] = @$option_n->target_id;
           }
        }


    for ($i=0; $i < count($ids) ; $i++) {
      if(!empty($ids[$i])){
        $node = Node::load($ids[$i]);
        if($node) {
          $pass['nom'][] = $node->get(PassInternationauxConstante::TITLE)->value;
          $pass['duree'][] = $node->get("field_duree_pass")->value;
          $pass['prix'][] = $node->get("field_prix_pass")->value;
        }
      }
      }
      $pass['pays'][] = $nom_pays;
    }
    return $pass;
  }

  /**
   * Retourne l'id par le nom du pays
   * @return array
   * @throws \Exception
   */
  public function getIdByNom($pays)
  {

    $id_pays = "";
    $values = [
      'type' => "pays",
       PassInternationauxConstante::TITLE => $pays,
    ];
    $nodes = \Drupal::entityTypeManager()->getListBuilder('node')->getStorage()->loadByProperties($values);

      if ($nodes) {
        foreach ($nodes as $node) {
          $id_pays = $node->get("nid")->value;
        }
    }

    return $id_pays;
  }


}
