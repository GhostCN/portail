<?php

namespace Drupal\portail\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\portail\Constante\TerangaConstante;
use Drupal\portail\Constante\ThemeConstante;
use Drupal\portail\Utils\QueryUtils;
use Drupal\node\Entity\Node;


/**
 * Class IllimixController
 * @package Drupal\portail\Controller
 */
class TerangaController extends ControllerBase
{
  /**
   * TerangaController constructor.
   */
  public function __construct()
  {
  }

  /**
   * Retourne la page Teranga
   * @return array
   * @throws \Exception
   */
  public function getAll()
  {

    $nids = QueryUtils::getNodesFromType(TerangaConstante::TERANGA);
    $node = Node::load(end($nids));

    $forfaits = $this->getForfaits($node);

    $offres = $this->getOffres($node);

    return [
        ThemeConstante::THEME => ThemeConstante::HUB_TERANGA,
        TerangaConstante::OFFRES => $offres,
        TerangaConstante::FORFAITS =>$forfaits
    ];
  }


  public function getOffres($node){
    $offres = [];

    if($node){
      foreach ($node->get('field_offre_teranga') as $f) {
        $offre = Node::load($f->target_id);

        $description = [];

        foreach ($offre->get("field_description_teranga") as $desc) {
          $description [] = $desc->value;
        }

        $offres [] = [
          "title" => $offre->getTitle(),
          TerangaConstante::IMAGE => $offre->get('field_image_teranga')->entity->getFileUri(),
          "resume" => $offre->get("field_resume_teranga")->value,
          "description" => $description,
          "link" => strtolower(str_replace(" ", "-", $offre->getTitle()))."-".$offre->nid->value
        ];

      }
    }

    return $offres;

  }


  public function getForfaits($node){
    $forfaits = [];
    $avec_eng = [];
    $sans_eng = [];

    if($node){
      foreach ($node->get('field_forfaits_internet_teranga') as $forfait) {
        $f = Node::load($forfait->target_id);

        if($f){

          $item = [
            "data" => $f->getTitle(),
            "prix" => $f->get("field_prix_forfait")->value,
            "validite" => $f->get("field_validite_du_forfait")->value,
          ];

          $f->get("field_engagement")->value ? $avec_eng [] = $item : $sans_eng [] = $item;
        }
      }

      $forfaits = ["avec" => $avec_eng, "sans" => $sans_eng];
    }

    return $forfaits;
  }


  public function getDetail($id)
  {

    $nids = QueryUtils::getNodesFromType(TerangaConstante::TERANGA);
    $node = Node::load(end($nids));

    $forfaits = $this->getForfaits($node);

    $teranga = Node::load(end(explode('-',$id)));

    if(!$teranga){
      return $this->redirect("teranga");
    }

    $liberty = $this->getLiberty($teranga);
    $premium = $this->getPremium($teranga);

    if(!$liberty && !$premium){
      return $this->redirect("teranga");
    }

    $content = $liberty ? $liberty : $premium;
    $theme = $liberty ? ThemeConstante::TERANGA_LIBERTY : ThemeConstante::TERANGA_PREMIUM;

    return [
        ThemeConstante::THEME => $theme,
        ThemeConstante::CONTENT => $content,
        TerangaConstante::FORFAITS =>$forfaits
    ];
  }

  public function getLiberty($teranga){
    $content = [];

    foreach($teranga->get('field_template_de_page_liberty') as $l){

      $liberty = Node::load($l->target_id);

      if($liberty){

        $pass = [
          "appel" => $this->loadPass($liberty->get('field_prix_des_appels')),
          "autre_app" => $this->loadPass($liberty->get('field_autres_prix_des_appels')),
          "sms" => $this->loadPass($liberty->get('field_prix_de_sms_liberty')),
          "autre_sms" => $this->loadPass($liberty->get('field_autres_prix_des_sms')),
          "data" => $liberty->get('field_pr')->value
        ];

        $content = [
          TerangaConstante::TITRE => $liberty->getTitle(),
          "resume" => $liberty->get("field_resume_description")->value,
          "tarif" => $liberty->get("field_tarif_liberty")->value,
          "bandeau" => $liberty->get("field_bandeau_liberty")->entity->getFileUri(),
          TerangaConstante::IMAGE => $liberty->get("field_image_illustratif_liberty")->entity->getFileUri(),
          "descriptif" => $liberty->get("field_descriptif")->value,
          "avantages" => $liberty->get("field_avantages")->value,
          "pass" => $pass
        ];
      }
      else{
        return false;
      }
    }

    return $content;
  }

  public function loadPass($field){
    $pass = [];
    foreach($field as $ap){
      $prix_appels = Node::load($ap->target_id);

      $pass[] = [
        "prix" => $prix_appels->get("field_tarification")->value,
        "destination" => $prix_appels->getTitle()
      ];
    }

    return $pass;
  }

  public function getPremium($teranga){

    foreach($teranga->get('field_template_de_page_premium') as $p){
      $premium = Node::load($p->target_id);

      if($premium){
        $offre_sans = [];
        $offre_avec = [];

        foreach($premium->get("field_offre_sans_tel") as $s){
          $sans = Node::load($s->target_id);

          $offre_sans [] = $this->getPremiumSansTel($sans);
        }

        foreach($premium->get("field_offre_avec_tel") as $s){
          $avec = Node::load($s->target_id);
          $caracterique = [];

          foreach($avec->get("field_caracteristique_teranga") as $c){
            $sans = Node::load($c->target_id);

            $caracterique = $this->getPremiumSansTel($sans);
          }

          $offre_avec[] = [
            "caracteristique" => $caracterique,
            TerangaConstante::IMAGE => $avec->get('field_image_telephone_teranga')->entity->getFileUri(),
            TerangaConstante::TITRE => $avec->getTitle(),
            "ecran" => $avec->get("field_ecran")->value,
            "connectivite" => $avec->get("field_connectivite")->value,
            "couleur" => $avec->get("field_couleurs")->value,
            "appareil_photo" => $avec->get("field_appareil_photo")->value,
            "memoire" => $avec->get("field_memoire")->value,
            "ram" => $avec->get("field_ram")->value,
            "ios" => $avec->get("field_ios")->value,
            "poids" => $avec->get("field_poids")->value,
            "batterie" => $avec->get("field_batterie")->value
          ];

        }

        return [
          "offre_sans" => $offre_sans,
          "offre_avec" => $offre_avec,
          TerangaConstante::TITRE => $teranga->getTitle(),
          "sub_title" => $premium->getTitle()
        ];
      }
      else{
        return false;
      }
    }
  }

  public function getPremiumSansTel($sans){
    $durre = 12;
    if($sans->get("field_forfait_24_mois")->value){
      $durre = 24;
    }

    return [
      TerangaConstante::TITRE => $sans->getTitle(),
      "tarif_ht" => $sans->get("field_tarif_ht")->value,
      "tarif_ttc" => $sans->get("field_tarif_ttc")->value,
      "bonus_vers_orange" => $sans->get("field_bonus_vers_orange")->value,
      "forfait_postionne" => $sans->get("field_forfait_total_positionne")->value,
      "internet_mobile" => $sans->get("field_internet_mobile")->value,
      "sms_orange" => $sans->get("field_sms_orange")->value,
      "illimite_vers_orange" =>$sans->get("field_ndeg_illimite_vers_orange")->value,
      "autre" => $sans->get("field_autre")->value,
      "duree" => $durre
    ];
  }
}
