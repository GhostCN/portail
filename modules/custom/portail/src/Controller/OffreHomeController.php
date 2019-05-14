<?php

namespace Drupal\portail\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Drupal\node\Entity\Node;
use Drupal\portail\Constante\ThemeConstante;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\portail\Constante\HomePlusConstante;
use Drupal\portail\Constante\KeurguiBoxConstante;
use Drupal\portail\Controller\TVOrangeController;
use Drupal\portail\Controller\FibreController;
use Drupal\portail\Utils\PortailUtils;
use Drupal\portail\Utils\QueryUtils;

/**
 * Class OffreHomeController
 * @package Drupal\portail\Controller
 */
class OffreHomeController extends ControllerBase
{
  /**
   * OffreHomeController constructor.
   */
  public function __construct()
  {

  }

  /**
   * Retourne tous les pass internet actifs
   * @return array
   * @throws \Exception
   */
  public function getDetailsOffre($url)
  {

    $tarifs = [];
    $options = [];
    $offre_resume = [];
    $etapes_souscription = [];
    $comment_souscrire = [];
    $faq = [];
    $slider = [];
    $sld = new TVOrangeController();
    $bouquet = new FibreController();
    $slider = $sld->getSlider();
    $bouquets = $bouquet->getBouquet();


    $id = end(explode('-', $url));
    $offre = Node::load($id);
    $template = '';
    if($offre) {
      $template = $offre->get('field_template')->value;
    }
    if($template == 'fibre') {
      $url = Url::fromRoute('fibre-home')->getInternalPath();
      $response = new RedirectResponse('/'.$url);
      $response->send();
      return;
    }
    elseif ($template == 'keurguib') {

      $tarifs = $this->getOffreKeurguiBox();

      $options = $this->getPassKeurguiBox();

      $offre_resume = $this->getForfaitKeurguiBox();

       $etapes_souscription = $this->getSouscriptionKeurguiBox();

       $comment_souscrire = $this->getEtapesSouscriptionKeurguiBox();

       $faq = $this->getEtapesFaqKeurguiBox();

      $theme = ThemeConstante::OFFRE_KEURGUI_BOX;
      $title = ' Keurgui Box | Box 4G avec pass internet';
    }
    elseif ($template == 'home') {

     $tarifs = $this-> getOffre(HomePlusConstante::PAGE_HOME_SIMPLE, "field_options_home", "field_t", "field_tarif_internet");

      $options = $this->getOptionsInclus(HomePlusConstante::PAGE_HOME_SIMPLE, "field_options_tel_home", "field_options_internet_home", "field_options_bouquet_home");

      $offre_resume = $this->getOffreResume(HomePlusConstante::PAGE_HOME_SIMPLE, "field_offre_en_res", "body", HomePlusConstante::FIELD_ICONE_EN_RESUME);

      $etapes_souscription = $this->getEtapesSouscription(HomePlusConstante::PAGE_HOME_SIMPLE, "field_comment_souscrire", HomePlusConstante::FIELD_ICONS, HomePlusConstante::TITLE, HomePlusConstante::FIELD_ACTION, "body");
      $faq = $this->getFaq(HomePlusConstante::PAGE_HOME_SIMPLE, "field_faq_home");

      $theme = ThemeConstante::OFFRE_HOME_PLUS;

      $title = 'Offre ADSL Home Plus | Internet + TV + Téléphone';
    }
    elseif ($template == HomePlusConstante::PAGE_KEURGUI) {

     $tarifs = $this-> getOffre(HomePlusConstante::PAGE_KEURGUI, "field_options_keurgui", "field_titre_internet_keurgui", "field_tarif");

      $options = $this->getOptionsInclus(HomePlusConstante::PAGE_KEURGUI, "field_option_tel_inclus_k", "field_options_internet_inclus_k");

      $offre_resume = $this->getOffreResume(HomePlusConstante::PAGE_KEURGUI, "field_offre_en_resume", "body", HomePlusConstante::FIELD_ICONE_EN_RESUME);

      $etapes_souscription = $this->getEtapesSouscription(HomePlusConstante::PAGE_KEURGUI, "field_comment_souscrire_k", HomePlusConstante::FIELD_ICONS, HomePlusConstante::TITLE, HomePlusConstante::FIELD_ACTION, "body");
      $faq = $this->getFaq(HomePlusConstante::PAGE_KEURGUI, "field_faq_keurgui");

      $theme = ThemeConstante::OFFRE_HOME_PLUS;
      $title = 'Offre ADSL Keurgui | Internet + Téléphone';
    }
    else {

      $tarifs = $this->getOffre(HomePlusConstante::PAGE_HOME, "field_option_home_plus","field_titre_internet", "field_tarif_home_plus");

      $options = $this->getOptionsInclus(HomePlusConstante::PAGE_HOME, "field_options_tel_inclus", "field_options_internet_inclus_of", "field_options_bouquet_inclus");

      $offre_resume = $this->getOffreResume(HomePlusConstante::PAGE_HOME, "field_o", "body", HomePlusConstante::FIELD_ICONE_EN_RESUME);

      $etapes_souscription = $this->getEtapesSouscription(HomePlusConstante::PAGE_HOME, "field_commen", HomePlusConstante::FIELD_ICONS, HomePlusConstante::TITLE, HomePlusConstante::FIELD_ACTION, "body");

      $faq = $this->getFaq(HomePlusConstante::PAGE_HOME, "field_faq_home_plus");

      $theme = ThemeConstante::OFFRE_HOME_PLUS;

      $title = 'Offre ADSL Home | Internet + TV + Téléphone';
    }
    return [
      ThemeConstante::THEME => $theme,
      ThemeConstante::OFFRE => $url,
      ThemeConstante::TARIFS => $tarifs,
      ThemeConstante::OPTIONS_HHK => $options,
      ThemeConstante::OFFRE_RESUME => $offre_resume,
      ThemeConstante::SOUSCRIPTION => $etapes_souscription,
      ThemeConstante::COMMENT_SOUSCRIRE => $comment_souscrire,
      ThemeConstante::TEMPLATE => $template,
      ThemeConstante::FAQ_HHK => $faq,
      ThemeConstante::SLIDER_TV => $slider,
      ThemeConstante::BOUQUETS_ORANGE => $bouquets,
      ThemeConstante::TITLE => $title,
      ThemeConstante::PAGE_CACHE => array(ThemeConstante::PAGE_CONTEXTS => [ThemeConstante::PAGE_URL_QUERY], ThemeConstante::MAX_AGE => 0)
    ];
  }


  /**
   * Retourne les tarifs
   * @return array
   * @throws \Exception
   */
  public function getOffre($entity, $opt, $titre, $tarif)
  {

    $values = [
      'type' => $entity,
    ];
     $nodes = \Drupal::entityTypeManager()->getListBuilder('node')->getStorage()->loadByProperties($values);

      $tarifs = [];
      $options = [];

      if ($nodes) {
        foreach ($nodes as $node) {
          $options = [];
          foreach ($node->get($opt) as $n) {
            $options[] = @$n->value;
          }
      }

        $tarifs[] = [
          HomePlusConstante::TITRE_INTERNET => $node->get($titre)->value,
          HomePlusConstante::TARIF_INTERNET => $node->get($tarif)->value,
          HomePlusConstante::OPTIONS => $options,
        ];
      }

    return $tarifs;
  }


  /**
   * Retourne les options du bloc Inclus
   * @return array
   * @throws \Exception
   */
  public function getOptionsInclus($entity, $opt_tel, $opt_int, $opt_bou=null)
  {

    $values = [
      'type' => $entity,
    ];
    $nodes = \Drupal::entityTypeManager()->getListBuilder('node')->getStorage()->loadByProperties($values);

      $options_telephone = [];
      $options_internet = [];
      $options_bouquet = [];
      $options = [];

      if ($nodes) {

        foreach ($nodes as $node) {

          foreach ($node->get($opt_tel) as $n) {
             $options_telephone[] = @$n->value;
          }

          foreach ($node->get($opt_int) as $n) {
             $options_internet[] = @$n->value;
          }

          if(isset($opt_bou)){
            foreach ($node->get($opt_bou) as $n) {
               $options_bouquet[] = @$n->value;
            }
          }

            $options[] = [
            HomePlusConstante::OPTIONS_TELEPHONE => $options_telephone,
            HomePlusConstante::OPTIONS_INTERNET => $options_internet,
            HomePlusConstante::OPTIONS_BOUQUET => $options_bouquet,
          ];
        }
      }

    return $options;
  }


  /**
   * Retourne Les offres en résumés
   * @return array
   * @throws \Exception
   */
  public function getOffreResume($entity, $offre_res, $des, $icone)
  {

    $values = [
      'type' => $entity,
    ];
    $nodes = \Drupal::entityTypeManager()->getListBuilder('node')->getStorage()->loadByProperties($values);

     $ids = [];
     $icons = [];
     $description = [];

     //Get All fields bloc deploiement
     foreach ($nodes as $node) {
       foreach($node->get($offre_res) as $option_n){
        $ids[] = @$option_n->target_id;
       }
     }

     for ($i=0; $i < count($ids) ; $i++) {
      if(!empty($ids[$i])){
        $node = Node::load($ids[$i]);
        $description[] = $node->get($des)->value;
        if(!empty($node->get($icone)->entity)){
        $icons[] = $node->get($icone)->entity->getFileUri();
      }
        }
     }

    return  $resume[] = [
            HomePlusConstante::DESCRIPTION => $description,
            HomePlusConstante::ICONS => $icons,
          ];
  }


   /**
   * Retourne Les étapes de souscription
   * @return array
   * @throws \Exception
   */
  public function getEtapesSouscription($entity, $etapes, $icone, $option, $action, $desc)
  {

    $values = [
      'type' => $entity,
    ];
    $nodes = \Drupal::entityTypeManager()->getListBuilder('node')->getStorage()->loadByProperties($values);

     $ids = [];
     $options = [];
     $actions = [];
     $description = [];
     $icons = [];

     //Get All fields bloc deploiement
     foreach ($nodes as $node) {
       foreach($node->get($etapes) as $option_n){
        $ids[] = @$option_n->target_id;
       }
     }

     for ($i=0; $i < count($ids) ; $i++) {
      if(!empty($ids[$i])){
        $node = Node::load($ids[$i]);
        $description[] = $node->get($desc)->value;
        $actions[] = $node->get($action)->value;
        $options[] = $node->get($option)->value;

          if(!empty($node->get($icone)->entity)){
            $icons[] = $node->get($icone)->entity->getFileUri();
          }
        }
      }


      return  $souscription[] = [
            HomePlusConstante::DESCRIPTION_SOUSCRIPTION => $description,
            HomePlusConstante::ACTION_SOUSCRIPTION => $actions,
            HomePlusConstante::OPTION_SOUSCRIPTION => $options,
            HomePlusConstante::ICONS_SOUSCRIPTION => $icons,
          ];
  }


 /**
   * Retourne la FAQ
   * @return array
   * @throws \Exception
   */
  public function getFaq($entity, $field)
  {

    $values = [
      'type' => $entity,
    ];
    $nodes = \Drupal::entityTypeManager()->getListBuilder('node')->getStorage()->loadByProperties($values);

     $ids = [];
     $questions = [];
     $reponses = [];

     //Get All Fields FAQ
     foreach ($nodes as $node) {
       foreach($node->get($field) as $option_n){
        $ids[] = @$option_n->target_id;
       }
     }

     for ($i=0; $i < count($ids) ; $i++) {
        if(!empty($ids[$i])){
          $node = Node::load($ids[$i]);
          $questions[] = $node->get(HomePlusConstante::TITLE)->value;
          $reponses[] = $node->get('body')->value;
        }
     }

      return  $faq[] = [
            HomePlusConstante::QUESTION => $questions,
            HomePlusConstante::REPONSE => $reponses,
          ];
  }


   /**
   * Retourne les tarifs Keurgui Box
   * @return array
   * @throws \Exception
   */
  public function getOffreKeurguiBox()
  {

    $values = [
      'type' => KeurguiBoxConstante::PAGE_KEURGUI_BOX,
    ];
     $nodes = \Drupal::entityTypeManager()->getListBuilder('node')->getStorage()->loadByProperties($values);

      $tarifs = [];
      $options = [];

      if ($nodes) {
        foreach ($nodes as $node) {
          $options = [];
          foreach ($node->get("field_options_keurgui_box") as $n) {
            $options[] = @$n->value;
          }
      }

        $tarifs[] = [
          KeurguiBoxConstante::TARIF_KEURGUI => $node->get("field_tar")->value,
          KeurguiBoxConstante::OPTIONS_KEURGUI => $options,
        ];
      }
    return $tarifs;
  }


  /**
   * Retourne Les passes
   * @return array
   * @throws \Exception
   */
  public function getPassKeurguiBox()
  {

    $values = [
      'type' => KeurguiBoxConstante::PAGE_KEURGUI_BOX,
    ];
    $nodes = \Drupal::entityTypeManager()->getListBuilder('node')->getStorage()->loadByProperties($values);

     $ids = [];
     $pass = [];
     $tarif = [];
     $duree = [];

     //Get All fields bloc deploiement
     foreach ($nodes as $node) {
       foreach($node->get("field_pass") as $option_n){
        $ids[] = @$option_n->target_id;
       }
     }

     for ($i=0; $i < count($ids) ; $i++) {
      if(!empty($ids[$i])){
          $node = Node::load($ids[$i]);
          $pass[] = $node->get(HomePlusConstante::TITLE)->value;
          $tarif[] = $node->get("field_tarif_pass")->value;
          $duree[] = $node->get("field_duree_validite")->value;
        }
     }

    return  $pass[] = [
            KeurguiBoxConstante::PASS_KEURGUI_BOX => $pass,
            KeurguiBoxConstante::TARIF_PASS_KEURGUI_BOX => $tarif,
            KeurguiBoxConstante::DUREE_PASS_KEURGUI_BOX => $duree,
          ];
  }


/**
   * Retourne Les forfaits
   * @return array
   * @throws \Exception
   */
  public function getForfaitKeurguiBox()
  {

    $values = [
      'type' => KeurguiBoxConstante::PAGE_KEURGUI_BOX,
    ];
    $nodes = \Drupal::entityTypeManager()->getListBuilder('node')->getStorage()->loadByProperties($values);

     $ids = [];
     $titres = [];
     $credits = [];
     $tarif = [];
     $frais = [];
     $liens = [];

     //Get All fields bloc deploiement
     foreach ($nodes as $node) {
       foreach($node->get("field_forfait") as $option_n){
        $ids[] = @$option_n->target_id;
       }
     }

     for ($i=0; $i < count($ids) ; $i++) {
      if(!empty($ids[$i])){
          $node = Node::load($ids[$i]);
          $titres[] = $node->get(HomePlusConstante::TITLE)->value;
          $credits[] = $node->get("field_credit_telephonique")->value;
          $tarif[] = $node->get("field_tarif_forfait")->value;
          $frais[] = $node->get("field_frais_acces")->value;
          $liens[] = $node->get("field_lien")->value;
        }
     }
    return  $forfait[] = [
            KeurguiBoxConstante::TITRE_FORFAIT_KEURGUI_BOX => $titres,
            KeurguiBoxConstante::CREDIT_FORFAIT_KEURGUI_BOX => $credits,
            KeurguiBoxConstante::TARIF_FORFAIT_KEURGUI_BOX => $tarif,
            KeurguiBoxConstante::FRAIS_FORFAIT_KEURGUI_BOX => $frais,
            KeurguiBoxConstante::LIEN_FORFAIT_KEURGUI_BOX => $liens,
          ];
  }


  /**
   * Retourne Comment souscrire Keurgui Box
   * @return array
   * @throws \Exception
   */
  public function getSouscriptionKeurguiBox()
  {

    $values = [
      'type' => KeurguiBoxConstante::PAGE_KEURGUI_BOX,
    ];
    $nodes = \Drupal::entityTypeManager()->getListBuilder('node')->getStorage()->loadByProperties($values);

     $ids = [];
     $titres = [];
     $description = [];
     $icons = [];

     //Get All fields bloc deploiement
     foreach ($nodes as $node) {
       foreach($node->get("field_comment_souscrire_keurgui_") as $option_n){
        $ids[] = @$option_n->target_id;
       }
     }

     for ($i=0; $i < count($ids) ; $i++) {
      if(!empty($ids[$i])){
          $node = Node::load($ids[$i]);
          $titres[] = $node->get(HomePlusConstante::TITLE)->value;
          $description[] = $node->get("body")->value;
          if(!empty($node->get("field_icone_souscription_keurgui")->entity)){
            $icons[] = $node->get("field_icone_souscription_keurgui")->entity->getFileUri();
          }
        }
     }

    return  $souscription[] = [
            KeurguiBoxConstante::TITRE_SOUSCRIPTION_KEURGUI_BOX => $titres,
            KeurguiBoxConstante::DESCRIPTION_SOUSCRIPTION_KEURGUI_BOX => $description,
            KeurguiBoxConstante::ICONE_SOUSCRIPTION_KEURGUI_BOX => $icons,
          ];
  }


  /**
   * Retourne Les etapes de souscription Keurgui Box
   * @return array
   * @throws \Exception
   */
  public function getEtapesSouscriptionKeurguiBox()
  {

    $values = [
      'type' => KeurguiBoxConstante::PAGE_KEURGUI_BOX,
    ];
    $nodes = \Drupal::entityTypeManager()->getListBuilder('node')->getStorage()->loadByProperties($values);

     $ids = [];
     $titres = [];
     $description = [];
     $action = [];

     //Get All fields bloc deploiement
     foreach ($nodes as $node) {
       foreach($node->get("field_etapes_souscription") as $option_n){
        $ids[] = @$option_n->target_id;
       }
     }

     for ($i=0; $i < count($ids) ; $i++) {
      if(!empty($ids[$i])){
          $node = Node::load($ids[$i]);
          $titres[] = $node->get(HomePlusConstante::TITLE)->value;
          $description[] = $node->get("body")->value;
          $action[] = $node->get("field_action_keurgui_box")->value;
        }
     }

    return  $souscription[] = [
            KeurguiBoxConstante::TITRE_ETAPES_SOUSCRIPTION_KEURGUI_BOX => $titres,
            KeurguiBoxConstante::DESCRIPTION_ETAPES_SOUSCRIPTION_KEURGUI_BOX => $description,
            KeurguiBoxConstante::ACTION_ETAPES_SOUSCRIPTION_KEURGUI_BOX => $action,
          ];
  }


  /**
   * Retourne FAQ Keurgui BOX
   * @return array
   * @throws \Exception
   */
  public function getEtapesFaqKeurguiBox()
  {

    $values = [
      'type' => KeurguiBoxConstante::PAGE_KEURGUI_BOX,
    ];
    $nodes = \Drupal::entityTypeManager()->getListBuilder('node')->getStorage()->loadByProperties($values);

     $ids = [];
     $question = [];
     $reponse = [];

     //Get All fields bloc deploiement
     foreach ($nodes as $node) {
       foreach($node->get("field_faq_") as $option_n){
        $ids[] = @$option_n->target_id;
       }
     }

     for ($i=0; $i < count($ids) ; $i++) {
      if(!empty($ids[$i])){
          $node = Node::load($ids[$i]);
          $question[] = $node->get(HomePlusConstante::TITLE)->value;
          $reponse[] = $node->get("body")->value;
        }
     }

    return  $souscription[] = [
            KeurguiBoxConstante::QUESTION_FAQ_KEURGUI_BOX => $question,
            KeurguiBoxConstante::REPONSE_FAQ_KEURGUI_BOX => $reponse,
          ];
  }

}
