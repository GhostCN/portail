<?php

namespace Drupal\portail\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\portail\Constante\PassConstante;
use Drupal\portail\Constante\ThemeConstante;
use Drupal\portail\Utils\QueryUtils;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class OrangeMoneyController
 * @package Drupal\portail\Controller
 */
class OrangeMoneyController extends ControllerBase
{

  const EMAIL_PART = 'partenaires.orangemoney@orange-sonatel.com';
  const PRENOM = 'prenom';
  const NOM = 'nom';
  const EMAIL = 'email';
  const TEL = 'tel';
  const MESSAGE = 'message';
  /**
   * TVOrangeController constructor.
   */
  public function __construct()
  {
  }

  /**
   * Retourne la page orange money
   * @return array
   * @throws \Exception
   */
  public function getAll(Request $request)
  {

      $nids = QueryUtils::getNodesFromType('orange_money');
      $node = Node::load(end($nids));
      $notif = null;

      if($request->get(self::PRENOM) && $request->get(self::NOM) && $request->get(self::TEL) && $request->get(self::EMAIL)) {
        $mailManager = \Drupal::service('plugin.manager.mail');
        $module = 'portail';
         $key = 'partenaire';

         $to = self::EMAIL_PART;
         //$to = 'papemor.coundoul@orange-sonatel.com';
         $params[self::MESSAGE] = '<b>Prénom: </b>'.$request->get(self::PRENOM).'<br>';
         $params[self::MESSAGE] .= '<b>Nom: </b>'.$request->get(self::NOM).'<br>';
         $params[self::MESSAGE] .= '<b>Email: </b>'.$request->get(self::EMAIL).'<br>';
         $params[self::MESSAGE] .= '<b>Tel: </b>'.$request->get(self::TEL).'<br>';

         $params[self::PRENOM] = $request->get(self::PRENOM);
         $params[self::NOM] = $request->get(self::NOM);
         $langcode = \Drupal::currentUser()->getPreferredLangcode();
         $send = true;
         $result = $mailManager->mail($module, $key, $to, $langcode, $params, NULL, $send);
         if ($result['result'] === true) {
           $notif = 'Demande enregistrée! Merci de votre confiance!';
         }
         else {
           $notif = 'Demande non prise en compte, veuillez reessayer.';
         }
      }
      $faqs = [];
      $sliders = [];

      if($node){
          foreach ($node->get('field_faq_orange_money') as $faq) {
              $n = Node::load($faq->target_id);
              if($n){
                  $faqs[] = ['question' => $n->getTitle(), "reponse" => $n->get('body')->value];
              }
          }

          foreach ($node->get('field_slider') as $slider){
              $n = Node::load($slider->target_id);
              if($n){
                  $sliders[] = [
                      'astuce' => $n->get('field_astuce')->value,
                      'image' => $n->get('field_image_slider_om')->entity->getFileUri(),
                      'lien' => $n->get('field_lien_decouvrir')->value,
                  ];
              }
          }

      }

    return [
      ThemeConstante::THEME => ThemeConstante::ORANGE_MONEY,
        ThemeConstante::SLIDER_OM => $sliders,
        ThemeConstante::FAQ_OM => $faqs,
        '#notif' => $notif
    ];
  }

}
