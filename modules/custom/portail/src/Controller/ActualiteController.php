<?php

namespace Drupal\portail\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Drupal\portail\Constante\ActualiteConstante;
use Drupal\portail\Constante\ThemeConstante;
use Drupal\portail\Utils\QueryUtils;
use Drupal\image\Entity\ImageStyle;
// require_once '../Block/AddToAnyBlock.php';


/**
 * Class PassInternationauxController
 * @package Drupal\portail\Controller
 */
class ActualiteController extends ControllerBase
{
  /**
   * OffreController constructor.
   */
  public function __construct()
  {
  }

  /**
   * Retourne toutes les informations de la page actualité
   * @return array
   * @throws \Exception
   */
  public function getAll($id)
  {
    $node = \Drupal::routeMatch()->getParameter('node');
    if (is_numeric($node)) {
      $node = Node::load($node);
    }
    $data = addtoany_create_entity_data($node);

    $allErrors = [];
    $chp_actualite = [];
    $ids = [];
    $ids_meme = [];

    try{
    $nids = \Drupal::entityQuery('node')
    ->condition('nid', $id)
    ->condition('type', ActualiteConstante::PAGE_ACTUALITE)
    ->execute();
    $nodes = \Drupal\node\Entity\Node::loadMultiple($nids);
    // $block = new AddToAnyBlock();
    // $addtoany = $block->build();
    if ($nodes) {
      //Get All fields bloc Souscription
     foreach ($nodes as $node) {
        // AddToAny 
        $chp_actualite['addtoany_html']              = \Drupal::token()->replace($data['addtoany_html'], ['node' => $node]); 
        $chp_actualite['link_url']                   = $data['link_url']; 
        $chp_actualite['link_title']                 = $data['link_title']; 
        $chp_actualite['button_setting']             = $data['button_setting']; 
        $chp_actualite['button_image']               = $data['button_image']; 
        $chp_actualite['universal_button_placement'] = $data['universal_button_placement']; 
        $chp_actualite['button_setting']             = $data['button_setting'];
        $chp_actualite['buttons_size']               = $data['buttons_size'];  

        $chp_actualite['nom_actu'][] = $node->get(ActualiteConstante::TITLE)->value;

        $chp_actualite['titre_actu'][] = $node->get('field_titre_actu')->value;

        $chp_actualite['titre_2_actu'][]  = $node->get('field_soustitre_actu')->value;

        $chp_actualite['desc_actu'][]  = $node->get('field_desc_actu')->value;

        $chp_actualite['souscription_actu'][]  = $node->get('field_souscrire_actu')->value;

        $chp_actualite['titre_bloc_actualite'][]  = $node->get('field_titre_bloc_actualite')->value;

        $chp_actualite['image_actu'][]  = $node->get('field_image_actu')->entity->getFileUri();

        $chp_actualite['la_une_actu'][]  = $node->get('field_actu_ala_une')->value;

        $chp_actualite['la_une_image_actu'][]  = $node->get('field_image_actu_ala_une')->value;

        $chp_actualite['la_une_desc_actu'][]  = $node->get('field_desc_actu_ala_une')->value;

        $chp_actualite['la_une_titres_actu'][]  = $node->get('field_titre_actu_ala_une')->value;

        $chp_actualite['code_ussd'][]  = $node->get('field_code_ussd')->value;

        $chp_actualite['service_magik'][]  = $node->get('field_service_magik')->value;
        
        $chp_actualite['orange_money'][]  = $node->get('field_orange_money')->value;


        foreach($node->get('field_bloc_actu') as $option_n){
          $ids[] = @$option_n->target_id;
         }

        foreach($node->get('field_meme_theme') as $option_n){
        $ids_meme[] = @$option_n->target_id;
        }

     }


     for ($i=0; $i < count($ids) ; $i++) {
      if(!empty($ids[$i])){

        $node = Node::load($ids[$i]);
        $chp_actualite['titre_bloc'][]  = $node->get(ActualiteConstante::TITLE)->value;

        $chp_actualite['icone_bloc'][] = $node->get('field_icone_bloc')->entity->getFileUri();

        $chp_actualite['description_bloc'][] = $node->get('body')->value;

        }
     }

     for ($i=0; $i < count($ids_meme) ; $i++) {
      if(!empty($ids_meme[$i])){
        $node = Node::load($ids_meme[$i]);
        $chp_actualite['titre_meme'][] = $node->get(ActualiteConstante::TITLE)->value;

        if($node->get('field_image_theme')->entity) {
        $chp_actualite['image_meme'][] = $node->get('field_image_theme')->entity->getFileUri();
      }

        $chp_actualite['lien_meme'][] = $node->get('field_bouton_theme')->value;

        }
     }

    }


  }
    catch (\Exception $e) {
      $allErrors = $e->getMessage();
  }
    return [
      ThemeConstante::ERRORS => $allErrors,
      ThemeConstante::CHP_ACTUALITE => $chp_actualite,
      ThemeConstante::THEME => ThemeConstante::ACTUALITE,
      ThemeConstante::PAGE_CACHE => array(ThemeConstante::PAGE_CONTEXTS => [ThemeConstante::PAGE_URL_QUERY])
    ];
  }

  public function getActuSmartphone($id) {
    $node = Node::load($id);
    if($node) {
      //get Title
      $titre = $node->getTitle();

      //get promo
      $promo = $node->get('field_promo')->value;

      //get  prix
      $prix = $node->get('field_actualite_smartphone_prix')->value;


      //get avis d'experts
      $avis = $this->getAvis($node);

      //get Caracteristiques
      $caracs =$this->getCaracteristiques($node);

      //get Description
      $desc = $node->get('body')->value;

      //get Titre description
      $descTitre = $node->get('field_description_titre')->value;

      //get Image
      $image = '';
      if($node->get('field_actualite_image_baniere')->entity) {
        $image = $node->get('field_actualite_image_baniere')->entity->getFileUri();
      }

      //get Image secondaire
      $imageSec = '';
      if($node->get('field_image_secondaire')->entity) {
        $imageSec = $node->get('field_image_secondaire')->entity->getFileUri();
      }

      //get Image banière
      $imageBan = '';
      if($node->get('field_image_top_baniere')->entity) {
        $imageBan = $node->get('field_image_top_baniere')->entity->getFileUri();
      }


      $reponse = ['titre' => $titre, 'promo' => $promo, 'prix' => $prix, 'avis' => $avis, 'caracteristiques' => $caracs, 'description' => $desc,
        'desc_titre' =>$descTitre, 'image' => $image, 'image_secondaire' => $imageSec, 'image_baniere' => $imageBan
        ];
    }

    return [
      ThemeConstante::THEME => ThemeConstante::ACTUALITE_SMARTPHONE,
      ThemeConstante::SMARTPHONE => $reponse
    ];
  }

  /**
   * Retourne les avis d'expert
   * @param $node
   * @return array
   */
  public function getAvis($node) {
    $reponse = [];
    foreach ($node->get('field_avis_d_experts') as $avis) {
      $av = Node::load($avis->target_id);
      $image = '';
      if($av->get('field_avis_expert_image')->entity) {
        $image = $av->get('field_avis_expert_image')->entity->getFileUri();
      }
      $reponse[] = ['image' => $image, 'texte' => $av->get('body')->value];
    }

    return $reponse;
  }


  /**
   * Retourne les caractéristiques d'un produit
   * @param $node
   * @return array
   */
  public function getCaracteristiques($node) {
    $reponse = [];
    foreach ($node->get('field_caracteristiques') as $carac) {
      $car = Node::load($carac->target_id);
      $reponse[] = ['titre' => $car->getTitle(), 'attributs' => $this->getAttributProduit($car)];
    }

    return $reponse;
  }


  /**
   * Retourne les attributs de produit
   * @param $node
   * @return array
   */
  public function getAttributProduit($node) {
    $reponse = [];
    foreach ($node->get('field_attributs_de_produit') as $attribut) {
      $at = Node::load($attribut->target_id);
      $icone = '';
      if($at->get('field_attribut_produit_icone')->entity) {
        $icone = $at->get('field_attribut_produit_icone')->entity->getFileUri();
      }
      $reponse[] = ['icone' => $icone, 'texte' => $at->get('body')->value];
    }

    return $reponse;
  }

}
