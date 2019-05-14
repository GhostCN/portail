<?php

namespace Drupal\portail\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Drupal\portail\Constante\PassConstante;
use Drupal\portail\Constante\ThemeConstante;
use Drupal\portail\Utils\QueryUtils;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class OrangeActuController
 * @package Drupal\portail\Controller
 */
class OrangeActuController extends ControllerBase
{
  /**
   * OrangeActuController constructor.
   */
  public function __construct()
  {
  }

  /**
   * Retourne la page hub actu
   * @return array
   * @throws \Exception
   */
  public function getAll()
  {
    $nids = QueryUtils::getNodesFromTypeAndFields('page_actualite', ['field_portail_magik' => 1]);
    $nodes = Node::loadMultiple($nids);
    $actus = [];

    foreach ($nodes as $node) {
      $actus[] = [
        'id' => $node->get('nid')->value,
        'image' => $node->get('field_image_actu_ala_une')->entity->getFileUri(),
        'titre' => $node->getTitle(),
        'resume' => $node->get('field_desc_actu_ala_une')->value
      ];
    }
    return [
      ThemeConstante::THEME => ThemeConstante::HUB_ACTU,
      '#actus' => $actus
    ];
  }

  public function subscribe(Request $request) {
    $num = trim($request->request->get('tel'));
    $service = $request->request->get('duree').$request->request->get('service');

    //encode credentials
    $credentials = base64_encode('imimobile:imimobile123');

    //generate access token
    $date = \DateTime::createFromFormat('U.u', microtime(TRUE))->format('YdmHisu');
    $token = substr($date, 0, -3);

    //generate signature
    $salt = '';
    for($i =0; $i<strlen($token);$i++) {
      if($i%2 == 0) {
        $salt.=$token[$i];
      }
    }
    $query = '{"ROOT":{"REQ":"SUB","MSISDN":"221'.$num.'","SVCID":"'.$service.'","CHANNEL":"CCAPI"}}';
    $body = "REQBODY=".$query."&SALT=".$salt;
    $signature = hash('sha512',$body);

    $http = \Drupal::httpClient();
    $response = $http->post('https://ft-cms.imimobile.net/SubAPI/payment/SubUser/', [
      'verify' => false,
      'auth'=> ['imimobile','imimobile123'],
      'json' => json_decode($query, true),
      'headers' => [
        'Authorisation' => 'Basic '.$credentials,
        'Content-Type' => 'application/json',
        'X-Imi-Reqinit' => $token ,
        'X-Imi-Signature' => $signature,
        'X-Forwardip' => '41.208.143.211'
      ],
      ]);

    $result = json_decode($response->getBody())->ROOT->SERVICE->STATUS;
    $tab_result = explode('|', $result);
    $node = Node::create([
      'type' => 'enregistrement',
      'title' => $num,
      'field_service' => $service,
      'field_resultat' => $result
    ]);
    $node->save();
    return new JsonResponse(['status' => $tab_result[1], 'message' => $tab_result[2]]);

  }

  public function String2Hex($string){
    $hex='';
    for ($i=0; $i < strlen($string); $i++){
      $hex .= dechex(ord($string[$i]));
    }
    return $hex;
  }

}
