<?php

namespace Drupal\portail\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Drupal\portail\Constante\OffreConstante;
use Drupal\portail\Constante\ThemeConstante;
use Drupal\portail\Constante\PassConstante;
use Drupal\portail\Utils\QueryUtils;
use Drupal\image\Entity\ImageStyle;

/**
 * Class OffreController
 * @package Drupal\portail\Controller
 */
class OffreController extends ControllerBase
{
  /**
   * OffreController constructor.
   */
  public function __construct()
  {
  }

  /**
   * Retourne tous les pass internet actifs
   * @return array
   * @throws \Exception
   */
  public function getAllOffre()
  {
    try {
      $nids = QueryUtils::getNodesFromType('offre_mobile');
      $nodes = Node::loadMultiple($nids);
      $offres = [];
      $allErrors = [];

      //récupération des promos et bons plans
      $promos = $this->getAllPromo();


      if ($nodes) {
        foreach ($nodes as $node) {
          $descriptions = [];
          foreach ($node->get('field_offre_mobile_description') as $n) {
            $descriptions[] = @$n->value;
          }

          $offres[] = [
            OffreConstante::TITLE => $node->getTitle(),
            OffreConstante::RESUME => $node->field_offre_mobile_resume->value,
            OffreConstante::DETAILS => $node->field_offre_mobile_details->value,
            OffreConstante::IMAGE => $node->field_offre_mobile_image->entity->getFileUri(),//ImageStyle::load(OffreConstante::STYLE_1140_735)->buildUrl($node->field_offre_mobile_image->entity->getFileUri()),
            OffreConstante::DESCRIPTIONS => $descriptions,
            OffreConstante::ID => $node->field_url->value .'-'. $node->nid->value,
            OffreConstante::URL => $node->field_url->value
          ];
        }
      }
    }
    catch (\Exception $e) {
      $allErrors = $e->getMessage();
    }

    return [
      ThemeConstante::THEME => ThemeConstante::OFFRE_MOBILE,
      ThemeConstante::OFFRES => $offres,
      ThemeConstante::PROMOS => $promos,
      ThemeConstante::ERRORS => $allErrors,
      ThemeConstante::PAGE_CACHE => array(ThemeConstante::PAGE_CONTEXTS => [ThemeConstante::PAGE_URL_QUERY], ThemeConstante::MAX_AGE => 0)
    ];
  }


  /**
   * Retourne tous les promos et bons plans sans offre spécifique
   * @return array
   */
  public function getAllPromo() {
    $promo_ids = QueryUtils::getNodesFromTypeAndFields('promo_bon_plan', [], 'field_promo_offre_concernee');
    $promo_nodes = Node::loadMultiple($promo_ids);
    $promos = [];
    if($promo_nodes) {
      foreach ($promo_nodes as $node) {
        $promos[] = [
          OffreConstante::TITLE => $node->getTitle(),
          OffreConstante::TEXTE => $node->get('field_promo_texte')->value,
          OffreConstante::LIEN => $node->get('field_promo_lien')->value,
          OffreConstante::IMAGE => $node->get('field_promo_image')->entity->getFileUri()//ImageStyle::load(OffreConstante::STYLE_760_760)->buildUrl($node->field_promo_image->entity->getFileUri()),
        ];
      }
    }

    return $promos;
  }

  /**
   * Détails d'une offre
   * @param $id
   * @return array
   */
  public function getOffre($id) {
    $tab = explode('-',$id);
    $id = end($tab);
    $node = Node::load($id);

    $appel_offre = $node->get('field_offre_mobile_appel_offre')->value;
    $sms_offre = $node->get('field_offre_mobile_sms_offre')->value;

    //recupération des pass internet spécifiques à l'offre
    $nids = QueryUtils::getNodesFromTypeAndFields('pass_internet', ['field_offre_concernee_pass' => $id]);
    $nodes = Node::loadMultiple($nids);
    $allPassInternet = $this->getPassInternetOffre($nodes);


    //recupération des promos et bons plans spécifiques à l'offre
    $nids = QueryUtils::getNodesFromTypeAndFields('promo_bon_plan', ['field_promo_of fre_concernee' => $id]);
    $promo_nodes = Node::loadMultiple($nids);
    $promos = $this->getPromoBonPlan($promo_nodes);

    //recupération des prix des appels
    $appels = $this->getCallPrice($node);

    //recupération des prix des SMS
    $sms = $this->getSmsPrice($node);

    //recupération des avantages de l'offre
    $avantages = $this->getAvantageOffre($node);

    //recupération des questions fréquentes sur l'offre
    $questions = $this->getFaqOffre($node);

    //recupération des illimixs de l'offre
    $illimixs = $this->getIllimixOffre($node);


    $title = $node->getTitle();
    $title_array = explode(' ', $title);
    $nbr_elts = count($title_array);
    if($nbr_elts > 1) {
      $title1 = $title_array[0];
      $title2 = implode(' ', array_slice($title_array,1));
    }
    else {
      $title1 = 'Offre';
      $title2 = $title;
    }

    $nids = QueryUtils::getNodesFromType('offre_mobile');
    $nodes = Node::loadMultiple($nids);




    if ($nodes) {
      foreach ($nodes as $node) {
        if($node->get('nid')->value != $id) {
          $offres[] = [
            OffreConstante::TITLE => $node->getTitle(),
            OffreConstante::URL => $node->get('field_url')->value . '-' . $node->get('nid')->value
          ];
        }
      }
    }

    return [
      ThemeConstante::THEME => ThemeConstante::DETAILS_OFFRE,
      ThemeConstante::AVANTAGES => $avantages,
      ThemeConstante::ILLIMIXS => $illimixs,
      ThemeConstante::QUESTIONS => $questions,
      ThemeConstante::SMS => $sms,
      ThemeConstante::APPELS => $appels,
      ThemeConstante::APPEL_OFFRE => $appel_offre,
      ThemeConstante::SMS_OFFRE => $sms_offre,
      ThemeConstante::PROMOS => $promos,
      ThemeConstante::ALLPASS => $allPassInternet,
      ThemeConstante::TITLE => $title,
      ThemeConstante::TITLE1 => $title1,
      ThemeConstante::TITLE2 => $title2,
      ThemeConstante::OFFRES => $offres,
    ];

  }

  /**
   * Retourne toutes les informations de la page offre family
   * @return array
   * @throws \Exception
   */
  public function getOffreFamily() {

    try{
    $allErrors = [];
    $tarifs = $this->getDetailFamily();
    $fondamentaux = $this->getFondamentauxFamily();
    $souscrire = $this->getSouscrireFamily();
    $faq = $this->getFaqFamily();
    }
    catch (\Exception $e) {
      $allErrors = $e->getMessage();
    }

    return [
      ThemeConstante::ERRORS => $allErrors,
      ThemeConstante::THEME => ThemeConstante::OFFRE_FAMILY,
      ThemeConstante::TARIFS_FAMILY => $tarifs,
      ThemeConstante::FONDAMENTAUX => $fondamentaux,
      ThemeConstante::SOUSC_FAMILY => $souscrire,
      ThemeConstante::FAQ_FAMILY => $faq,

    ];

  }

  /**
   * Retourne les valeurs de la page family
   * @return array
   * @throws \Exception
   */
  public function getDetailFamily()
  {

      $nids = QueryUtils::getNodesFromType(OffreConstante::TABLE_FAMILY);
      $nodes = Node::loadMultiple($nids);

      $tarifs = [];
       if($nodes) {
        foreach ($nodes as $node) {
          $prix_appel =  $node->get('field_prix_appels')->value;
          $prix_sms = $node->get('field_prix_des_sms')->value;
          $seddo_bonus = $node->get('field_seddo_bonus')->value;
          $seddo_pass = $node->get('field_seddo_pass_internet')->value;
          $nom_phone = $node->get('field_nom_phone')->value;
          $type_phone = $node->get('field_type_phone')->value;
          $image_phone = $node->get('field_image_phone')->entity->getFileUri();
          $description_phone = $node->get('field_description_phone')->value;
          $prix_phone = $node->get('field_prix_phone')->value;
          $lien_detail = $node->get('field_lien_detail')->value;
          $lien_achat = $node->get('field_lien_achat')->value;
        }
      }
        $tarifs[] = [
          OffreConstante::PRIX_APPEL => $prix_appel,
          OffreConstante::PRIX_SMS => $prix_sms,
          OffreConstante::SEDDO_PASS => $seddo_bonus,
          OffreConstante::SEDDO_BONUS => $seddo_pass,
          OffreConstante::NOM_PHONE => $nom_phone,
          OffreConstante::TYPE_PHONE => $type_phone,
          OffreConstante::IMAGE_PHONE => $image_phone,
          OffreConstante::DESCRIPTION_PHONE => $description_phone,
          OffreConstante::PRIX_PHONE => $prix_phone,
          OffreConstante::LIEN_DETAIL => $lien_detail,
          OffreConstante::LIEN_ACHAT => $lien_achat
        ];


    return $tarifs;
  }

  /**
   * Retourne les fondamentaux de l'offre family
   * @return array
   * @throws \Exception
   */
  public function getFondamentauxFamily()
  {

   $nids = QueryUtils::getNodesFromType(OffreConstante::TABLE_FAMILY);
     $nodes = Node::loadMultiple($nids);
     $ids = [];
     $icons = [];
     $descriptions = [];
     $fondamentaux= [];

     foreach ($nodes as $node) {
       foreach($node->get('field_les_fondamentaux_de_l_offr') as $option_n){
        $ids[] = @$option_n->target_id;
       }
     }

     for ($i=0; $i < count($ids) ; $i++) {
      if(!empty($ids[$i])){
        $node = Node::load($ids[$i]);
        $descriptions[] = $node->get('field_detail_de_l_offre')->value;
        $icons[] = $node->get('field_icone_offre')->entity->getFileUri();
        }
     }


    return  $fondamentaux[] = [
            OffreConstante::DESC_FOND => $descriptions,
            OffreConstante::ICONS_FOND => $icons
          ];

  }

  /**
   * Retourne les fondamentaux de l'offre family
   * @return array
   * @throws \Exception
   */
  public function getSouscrireFamily()
  {
     $nids = QueryUtils::getNodesFromType(OffreConstante::TABLE_FAMILY);
     $nodes = Node::loadMultiple($nids);
     $ids = [];
     $titre_sousc = [];
     $etape_sousc = [];
     $description_sousc = [];

     //Get All fields bloc deploiement
     foreach ($nodes as $node) {
       foreach($node->get('field_souscrire_offre_family') as $option_n){
        $ids[] = @$option_n->target_id;
       }
     }

     for ($i=0; $i < count($ids) ; $i++) {
      if(!empty($ids[$i])){
        $node = Node::load($ids[$i]);
        $titre_sousc[] = $node->get('title')->value;
        $etape_sousc[] = $node->get('field_etape_souscription')->value;
        $description_sousc[] = $node->get('field_description_etapes')->value;
        }
     }

    return  $fondamentaux[] = [
            OffreConstante::TITRE_SOUSC => $titre_sousc,
            OffreConstante::ETAPE_SOUSC => $etape_sousc,
            OffreConstante::DESCRIPTION_SOUSC => $description_sousc
          ];
  }


  /**
   * Retourne la FAQ de l'offre family
   * @return array
   * @throws \Exception
   */
  public function getFaqFamily()
  {
     $nids = QueryUtils::getNodesFromType(OffreConstante::TABLE_FAMILY);
     $nodes = Node::loadMultiple($nids);
     $ids = [];
     $questions_fam = [];
     $reponses_fam = [];
     $faq_family = [];

     //Récupérer les champs de la FAQ_Family
     foreach ($nodes as $node) {
       foreach($node->get('field_faq_family') as $option_faq){
        $ids[] = @$option_faq->target_id;
       }
     }

     for ($i=0; $i < count($ids) ; $i++) {
        if(!empty($ids[$i])){
          $node = Node::load($ids[$i]);
          $questions_fam[] = $node->get('title')->value;
          $reponses_fam[] = $node->get('body')->value;
        }
     }

    return  $faq_family[] = [
            OffreConstante::QUESTIONS_FAMILY => $questions_fam,
            OffreConstante::REPONSES_FAMILY => $reponses_fam,
          ];
  }

  /**
   * Retourne le prix de tous les appels
   * @param $node
   * @return array
   */
  public function getCallPrice($node) {
    $appels = [];
    foreach ($node->get('field_offre_mobile_prix_appels') as $n){
      $appel = Node::load(@$n->target_id);
      $appels[] = ['titre_appel' => $appel->getTitle(), 'cout_appel' => $appel->get('field_appel_cout')->value];
    }
    return $appels;
  }


  /**
   * Retourne les promos et bons plans spécifiques à l'offre
   * @param $promo_nodes
   * @return array
   */
  public function getPromoBonPlan($promo_nodes) {
    $promos = [];
    if($promo_nodes) {
      foreach ($promo_nodes as $n) {
        $promos[] = [
          OffreConstante::TITLE => $n->getTitle(),
          OffreConstante::TEXTE => $n->get('field_promo_texte')->value,
          OffreConstante::LIEN => $n->get('field_promo_lien')->value,
          OffreConstante::IMAGE => ImageStyle::load(OffreConstante::STYLE_760_760)->buildUrl($n->field_promo_image->entity->getFileUri()),
        ];
      }
    }

    return $promos;
  }


  /**
   * Retourne le prix de tous les sms
   * @param $node
   * @return array
   */
  public function getSmsPrice($node) {
    $sms = [];
    foreach ($node->get('field_offre_mobile_prix_sms') as $n){
      $sm = Node::load(@$n->target_id);
      $sms[] = ['titre_sms' => $sm->getTitle(), 'cout_sms' => $sm->get('field_sms_cout')->value];
    }

    return $sms;
  }

  /**
   * Retourne les avantages de l'offre
   * @param $node
   * @return array
   */
  public function getAvantageOffre($node) {
    $avantages = [];
    foreach ($node->get('field_offre_mobile_avantage') as $n){
      $avantage = Node::load(@$n->target_id);
      $avantages[] = ['titre_avantage' => $avantage->getTitle(), 'desc_avantage' => $avantage->get('field_avantage_description')->value,
        'image_avantage' => $avantage->get('field_avantage_icon')->entity->getFileUri()];
    }

    return $avantages;
  }

  /**
   * Retourne les questions fréquentes sur l'offre
   * @param $node
   * @return array
   */
  public function getFaqOffre($node) {
    $questions = [];
    foreach ($node->get('field_offre_mobile_question') as $n){
      $question = Node::load(@$n->target_id);
      $questions[] = ['titre_question' => $question->getTitle(), 'reponse_question' => $question->get('field_faq_reponse')->value];
    }

    return $questions;
  }

  /**
   * Retourne les illimixs de l'offre
   * @param $node
   * @return array
   */
  public function getIllimixOffre($node) {
    $illimixs = [];
    foreach ($node->get('field_offre_mobile_illimix') as $n){
      $illimix = Node::load($n->target_id);
      $nbr_sms = $illimix->get('field_illimix_nombre_sms')->value;
      if($nbr_sms == 0) {
        $nbr_sms = 'Illimités';
      }
      $illimixs[] = ['cout_illimix' => intval($illimix->get('field_illimix_cout')->value), 'duree_appel_illimix' => $illimix->get('field_illimix_duree_appel')->value,
        'nombre_sms_illimix' => $nbr_sms, 'periode_utilisation_illimix' => $illimix->get('field_illimix_period_utilisation')->value,
        'validite_illimix' => $illimix->get('field_illimix_validite_jours')->value, 'volume_data_illimix' => $illimix->get('field_illimix_volume_data')->value];
    }

    return $illimixs;
  }


  /**
   * Retourne les pass internet de l'offre
   * @param $nodes
   * @return array
   */
  public function getPassInternetOffre($nodes) {
    $allPassInternet = [];
    if ($nodes) {
      foreach ($nodes as $n) {
        $pass = [
          PassConstante::TITLE => $n->getTitle(),
          PassConstante::MONTANT => $n->get('field_montant_pass')->value,
          PassConstante::VOLUME => $n->get('field_volume_pass')->value,
          PassConstante::VALIDITE => $n->get(PassConstante::FIELD_VALIDITE_PASS)->value,
          PassConstante::INFO => $n->get('field_info_supplementaire_pass')->value,
          PassConstante::RESTRICTION => $n->get('field_restrictions_pass')->value,
          PassConstante::POIDS => $n->get('field_poids_pass')->value
        ];
        if($n->get(PassConstante::FIELD_VALIDITE_PASS)->value == 'Jour') {
          $allPassInternet['jour'][] = $pass;
        }
        elseif ($n->get(PassConstante::FIELD_VALIDITE_PASS)->value == 'Semaine') {
          $allPassInternet['semaine'][] = $pass;
        }
        elseif ($n->get(PassConstante::FIELD_VALIDITE_PASS)->value == 'Jours') {
          $allPassInternet['jours'][] = $pass;
        }
        else {
          $allPassInternet['mois'][] = $pass;
        }
      }
    }

    return $allPassInternet;
  }
}
