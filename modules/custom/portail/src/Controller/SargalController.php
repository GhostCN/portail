<?php

namespace Drupal\portail\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\portail\Constante\PassConstante;
use Drupal\portail\Constante\ThemeConstante;
use Drupal\portail\Utils\QueryUtils;
use Drupal\node\Entity\Node;

/**
 * Class SargalController
 * @package Drupal\portail\Controller
 */
class SargalController extends ControllerBase
{
  /**
   * SargalController constructor.
   */
  public function __construct()
  {
  }

  /**
   * Retourne la page contact
   * @return array
   * @throws \Exception
   */
  public function getAll()
  {

    $nids = QueryUtils::getNodesFromType('orange_sargal');
    $node = Node::load(end($nids));

    $faqs = [];
    $cadeaux = [];

    if($node){
      foreach ($node->get('field_faq_os') as $faq) {
        $n = Node::load($faq->target_id);
        if($n){
            $faqs[] = ['question' => $n->getTitle(), "reponse" => $n->get('body')->value];
        }
      }

      foreach($node->get('field_type_de_cadeau_sargal') as $type_cadeau){

        $type = Node::load($type_cadeau->target_id);
        if($type){

            foreach ($type->get('field_cadeaux_sargal') as $cadeau){

                $c = Node::load($cadeau->target_id);
                $cadeaux[] = [
                    'points' => $c->getTitle(),
                    'cadeau' => $c->get('field_cadeau')->value,
                    'image' => $type->get('field_image_correspondant')->entity->getFileUri(),
                    'validite' => $c->get('field_validite')->value
                ];
            }

        }
      }
    }


    $points  = array_column($cadeaux, 'points');

    array_multisort($points, SORT_ASC, $cadeaux);

    return [
        ThemeConstante::THEME => ThemeConstante::SARGAL,
        ThemeConstante::CADEAU_SARGAL => $cadeaux,
        ThemeConstante::FAQ_SARGAL => $faqs,
    ];
  }
}
