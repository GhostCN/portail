<?php

namespace Drupal\portail\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\portail\Constante\HelpConstante;
use Drupal\portail\Utils\QueryUtils;
use Drupal\image\Entity\ImageStyle;

/**
 * Class HelpController
 * @package Drupal\portail\Controller
 */
class HelpController extends ControllerBase
{

  /**
   * HelpController constructor.
   */
  public function __construct()
  {
  }

  /**
   * @return array
   */
  public function getAllHelp() {
    $nids = QueryUtils::getNodesFromType('besoin_d_aide');
    $nodes = \Drupal\node\Entity\Node::loadMultiple($nids);
    $allMainWindow = [];

    if ($nodes) {
      foreach ($nodes as $node) {
        $allMainWindow[] = [
          HelpConstante::TITLE => $node->getTitle(),
          HelpConstante::INFO => $node->get('field_help_informations')->value,
          HelpConstante::LIEN => $node->get('field_help_lien')->value,
          HelpConstante::IMAGE => $node->get('field_help_image')->entity->getFileUri()//ImageStyle::load(HelpConstante::STYLE)->buildUrl($node->field_help_image->entity->getFileUri())
        ];
      }
    }

    return $allMainWindow;
  }

}
