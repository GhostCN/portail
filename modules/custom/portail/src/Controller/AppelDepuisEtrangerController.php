<?php

namespace Drupal\portail\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Drupal\portail\Constante\AppelDepuisEtrangerConstante;
use Drupal\portail\Constante\ThemeConstante;
use Drupal\portail\Utils\QueryUtils;
use Drupal\image\Entity\ImageStyle;

/**
 * Class PassInternationauxController
 * @package Drupal\portail\Controller
 */
class AppelDepuisEtrangerController extends ControllerBase
{
  /**
   * OffreController constructor.
   */
  public function __construct()
  {

  }

  /**
   * Retourne toutes les informations de la page appel depuis l'étranger
   * @return array
   * @throws \Exception
   */
  public function getAll($pays)
  {

    try{

    if($pays == ""){
     $pays = $this->getIdByNom('france');
    }

    $country = $this->getPays();
    $tbl_pass = $this->getPass($pays);

    $values = [
      'type' => "zone_pays_orange",
    ];
    $nodes = \Drupal::entityTypeManager()->getListBuilder('node')->getStorage()->loadByProperties($values);

      $appel_vers_senegal = "";
      $appel_international = "";
      $envoi_sms = "";
      $data = "";
      $appel_local = "";
      $reception_appel = "";
      $reception_sms = "";
      $allErrors = [];
      $pass = [];

      if ($nodes) {
        foreach ($nodes as $node) {
          foreach($node->get("field_pays_de") as $n){
             if($n->target_id == $pays){
              $appel_vers_senegal = $node->get("field_appel_vers_senegal")->value;
              $appel_international = $node->get("field_appel_international")->value;
              $envoi_sms = $node->get("field_envoi_sms")->value;
              $data = $node->get("field_data_ko")->value;
              $appel_local = $node->get("field_appel_local")->value;
              $reception_appel = $node->get("field_reception_appel")->value;
              $reception_sms = $node->get("field_reception_sms")->value;
              break;
             }
          }

        }
    }
  }
    catch (\Exception $e) {
      $allErrors = $e->getMessage();
    }

    $pass['appel_vers_senegal'] = $appel_vers_senegal;
    $pass['appel_international'] = $appel_international;
    $pass['envoi_sms'] = $envoi_sms;
    $pass['data'] = $data;
    $pass['appel_local'] = $appel_local;
    $pass['reception_appel'] = $reception_appel;
    $pass['reception_sms'] = $reception_sms;

    return [
      ThemeConstante::ERRORS => $allErrors,
      ThemeConstante::INFOS_PASS => $pass,
      ThemeConstante::PAYS => $country,
      ThemeConstante::PASS => $tbl_pass,
      ThemeConstante::THEME => ThemeConstante::APPEL_DEPUIS_ETRANGER,
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
      'type' => AppelDepuisEtrangerConstante::PASS_PAR_PAYS,
    ];
    $nodes = \Drupal::entityTypeManager()->getListBuilder('node')->getStorage()->loadByProperties($values);

      $pays = [];

      if ($nodes) {
        foreach ($nodes as $node) {
              $pays['id'][] = $node->get("nid")->value;
              $pays['pays'][] = $node->get(AppelDepuisEtrangerConstante::TITLE)->value;
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
     $ids_voix = [];
     $ids_data = [];

     $values = [
      'type' => AppelDepuisEtrangerConstante::PASS_PAR_PAYS,
       'nid' => $id,
    ];
    $nodes = \Drupal::entityTypeManager()->getListBuilder('node')->getStorage()->loadByProperties($values);
      $pass = [];

      if ($nodes) {
        foreach ($nodes as $node) {

          $nom_pays = $node->get(AppelDepuisEtrangerConstante::TITLE)->value;
          foreach($node->get("field_pass_data") as $option_n){
            $ids_data[] = @$option_n->target_id;
           }

           foreach($node->get("field_pass_voix") as $option_n){
            $ids_voix[] = @$option_n->target_id;
           }

        }

      $pass['pass_data'][] = $this->getPassData($ids_data);   
      $pass['pass_voix'][] = $this->getPassVoix($ids_voix);
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
      'type' => AppelDepuisEtrangerConstante::PASS_PAR_PAYS,
       AppelDepuisEtrangerConstante::TITLE => $pays,
    ];
    $nodes = \Drupal::entityTypeManager()->getListBuilder('node')->getStorage()->loadByProperties($values);

      if ($nodes) {
        foreach ($nodes as $node) {
          $id_pays = $node->get("nid")->value;
        }
    }

    return $id_pays;
  }


/**
   * Retourne Data
   * @return array
   * @throws \Exception
   */
  public function getPassData($ids_data){

    $pass_data = [];
    for ($i=0; $i < count($ids_data) ; $i++) {
      if(!empty($ids_data[$i])){
        $node = Node::load($ids_data[$i]);
        if($node) {
          $pass_data['connexion_data'][] = $node->get("field_connexion")->value;
          $pass_data['valabilite_data'][] = $node->get("field_valabilite_data")->value;
          $pass_data['prix_data'][] = $node->get(AppelDepuisEtrangerConstante::TITLE)->value;
        }
      }
    }

    return $pass_data;

  }


  /**
   * Retourne Data
   * @return array
   * @throws \Exception
   */
  public function getPassVoix($ids_voix){

    $pass_voix = [];
    for ($i=0; $i < count($ids_voix) ; $i++) {
      if(!empty($ids_voix[$i])){

        $node = Node::load($ids_voix[$i]);
        if($node) {
          $pass_voix['appel_voix'][] = $node->get("field_appel")->value;
          $pass_voix['sms_voix'][] = $node->get("field_sms")->value;
          $pass_voix['valabilite_voix'][] = $node->get("field_valabilite")->value;
          $pass_voix['prix_voix'][] = $node->get(AppelDepuisEtrangerConstante::TITLE)->value;
        }
      }
      
      }

      return $pass_voix;

  }


}
