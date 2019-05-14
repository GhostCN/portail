<?php

namespace Drupal\portail\Controller;


use Drupal\Core\Controller\ControllerBase;
use Drupal\portail\Constante\PortailConstante;
use Drupal\portail\Constante\EligibiliteConstante;
use Drupal\portail\Constante\ThemeConstante;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class EligibiliteController
 * @package Drupal\portail\Controller
 */
class EligibiliteController extends ControllerBase
{
  /**
   * EligibiliteController constructor.
   */
  public function __construct()
  {
  }

  public function initializeTestEligibilite(Request $request) {

    try {
      //traitement du type de device
      $theme = ThemeConstante::TEST_ELIGIBILITE;
      $is_mobile = false;
      $user_agent = $request->headers->get('user-agent');
      $mobiles = ['Android', 'webOS', 'iPhone', 'iPod', 'BlackBerry', 'IEMobile', 'Opera Mini'];
      foreach ($mobiles as $mobile) {
        if (preg_match("/" . $mobile . "/i", $user_agent)) {
          $theme = ThemeConstante::TEST_ELIGIBILITE_MOB;
          $is_mobile = true;
          break;
        }
      }


      $step = 1;
      $eligible = false;
      $service = \Drupal::httpClient();
      $request_type = '';
      $code_gps = '';

      //si $type_client => test d'éligibilté et passage à l'étape 2
      if ($request->get('test_eligibilite')) {

        $step = 2;
        $theme = $this->getMobileTheme($is_mobile, ThemeConstante::NON_ELIGIBLE_MOB);

        $code_gps = $request->get(PortailConstante::CODE_GPS);
        $type_client = $request->get(PortailConstante::TYPE_CLIENT);
        $url = PortailConstante::SERVICE_URL;
        $data = $this->getDataForTestingEligibilite($request);
        if (empty($data)){
          return (new Response('', 500))->send();
        }

        $response = $service->post($url, ['form_params' => $data]);

        $result = json_decode($response->getBody())->RESPONSE;

        if ($result == PortailConstante::CLIENT_ELIGIBLE) {
          $eligible = true;
          $theme = $this->getMobileTheme($is_mobile, ThemeConstante::ELIGIBLE_MOB);
        }
      } //Inscription ou Pré-commande
      elseif ($request->get('eligible')) {
        $theme = $this->getMobileTheme($is_mobile, ThemeConstante::SOUSCRIPTION_MOB);
        $step = 3;
        $code_gps = $request->get(PortailConstante::CODE_GPS);
        $type_client = $request->get(PortailConstante::TYPE_CLIENT);
        if ($request->get('eligible') == "oui") {
          $request_type = 'inscription';
        } else {
          $request_type = 'pre-commande';
        }
      } elseif ($request->get(PortailConstante::REQUEST_TYPE)) {
        $theme = $this->getMobileTheme($is_mobile, ThemeConstante::CONFIRMATION_MOB);
        $step = 4;
      }

      if ($request->get('confirmation')) {

        $data =
          [
            'code' => PortailConstante::CODE,
            'signature' => $this->getKey(),
            PortailConstante::TYPE_CLIENT => $request->get(PortailConstante::TYPE_CLIENT),
            PortailConstante::REQUEST_TYPE => $request->get(PortailConstante::REQUEST_TYPE),
            'nom' => $request->get('nom'),
            'prenom' => $request->get('prenom'),
            'email' => $request->get('email'),
            'adresse' => $request->get('adresse'),
            'numero_fixe' => $request->get('numero_fixe'),
            'numero_mobile' => $request->get('numero_mobile'),
            'est_client' => $request->get('est_client'),
            'raison_sociale' => 'raison_sociale'
          ];

        if ($request_type == 'pre-commande') {
          $data['solution_fibre'] = 'home';
        } else {
          $data['code_gps'] = $request->get(PortailConstante::CODE_GPS);
        }

        $url = PortailConstante::SERVICE_URL;

        $response = json_decode($service->post($url, ['form_params' => $data])->getBody());

      }

    }
    catch (\Exception $e) {
      return ['#markup' => '<p>'.$e->getMessage().'</p>'];
    }

    return [
      ThemeConstante::THEME => $theme,
      ThemeConstante::ELIGIBLE => $eligible,
      ThemeConstante::STEP => $step,
      ThemeConstante::REQUEST_TYPE => $request_type,
      ThemeConstante::TYPE_CLIENT => $type_client,
      ThemeConstante::CODE_GPS => $code_gps,
      ThemeConstante::PAGE_CACHE => array(ThemeConstante::PAGE_CONTEXTS => [ThemeConstante::PAGE_URL_QUERY], ThemeConstante::MAX_AGE => 0)
    ];
  }

  /**
   * Retourne les données de test d'éligibilté
   * @param Request $request
   * @return array
   */
  public function getDataForTestingEligibilite (Request $request) {
    $type_client = $request->get(PortailConstante::TYPE_CLIENT);
    $num_client = $request->get('num_client');
    $code_gps = $request->get(PortailConstante::CODE_GPS);
    $tab_gps = explode(',', $code_gps);
    if ((intval($num_client) == 1) || (!in_array($type_client, ['b2c','b2b','pro'])) || (!$this->validateLatLong($tab_gps[0], $tab_gps[1])) ) {
      //$data = (new Response('', 500))->send();
      return [];
    }
    $code = PortailConstante::CODE;
    $request_type = 'test_eligible';
    $signature = $this->getKey();

    return [
      'signature' => $signature,
      'num_client' => $num_client,
      PortailConstante::CODE_GPS => $code_gps,
      PortailConstante::TYPE_CLIENT => $type_client,
      PortailConstante::REQUEST_TYPE => $request_type,
      'code' => $code,
    ];
  }

  /**
   * Validates a given coordinate
   *
   * @param float|int|string $lat Latitude
   * @param float|int|string $long Longitude
   * @return bool `true` if the coordinate is valid, `false` if not
   */
  function validateLatLong($lat, $long) {
    return preg_match('/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?),[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/', $lat.','.$long);
  }

  /**
   * Retourne la signature du webservice
   * @return string
   */
  public function getKey() {
    $cle_secrete = PortailConstante::CLE_SECRETE;
    $cle_bin = @pack('H*',$cle_secrete);
    $algo = "SHA512";
    $code = "senefibre";
    $message = "cle_secrete=$cle_secrete&code=$code";

    return strtoupper(hash_hmac(strtolower($algo),$message,$cle_bin));
  }

  /**
   * Retourne le theme mobile sollcité
   * @param $is_mobile
   * @param $theme_mob
   * @param string $theme_desktop
   * @return string
   */
  public function getMobileTheme($is_mobile, $theme_mob, $theme_desktop = ThemeConstante::TEST_ELIGIBILITE) {
    if($is_mobile) {
      $theme = $theme_mob;
    }
    else {
      $theme = $theme_desktop;
    }
    return $theme;
  }

}
