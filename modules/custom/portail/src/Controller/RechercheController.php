<?php

namespace Drupal\portail\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Drupal\portail\Constante\RechercheConstante;
use Drupal\portail\Constante\ThemeConstante;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class ContactController
 * @package Drupal\portail\Controller
 */
class RechercheController extends ControllerBase
{
  /**
   * ContactController constructor.
   */
  public function __construct()
  {
  }

  /**
   * Retourne la page recherche
   * @return array
   * @throws \Exception
   */
  public function getAll(Request $request)
  {
    $keywords = explode(" ", strtolower($request->get('q')));

    //Search on Products and Services
    $produits_services = [];

    $route_provider = \Drupal::service('router.route_provider');

    /* @var \Drupal\Core\Routing\RouteProviderInterface $route_provider */
    foreach (RechercheConstante::ROUTES as $route) {
      $r = $route_provider->getRouteByName($route);
      $title = strtolower($r->getDefault('_title'));
      foreach ($keywords as $key) {
        if(preg_match("/\b$key\b/", $title)) {
          if(!$produits_services[$r->getPath()]) {
            $produits_services[$r->getPath()] = [RechercheConstante::TITLE => $r->getDefault('_title'), 'summary' => $r->getDefault('_summary'), RechercheConstante::COUNT => 0, 'path' => $r->getPath(), 'product' => $r->getDefault('_product')];
          }
          else {
            $produits_services[$r->getPath()][RechercheConstante::COUNT] += 1;
          }
        }
      }
    }

    usort($produits_services,
      function ($a, $b) {
        return strcmp($b[RechercheConstante::COUNT], $a[RechercheConstante::COUNT]);
      }
    );




    // Search on FAQ
    $faqs = [];
    $node_ids = \Drupal::entityQuery('node')
      ->condition('type','faq', 'STARTS_WITH')
      ->execute();

    $nodes = Node::loadMultiple($node_ids);
    foreach ($nodes as $node) {
      $title = strtolower($node->getTitle());
      foreach ($keywords as $key) {
        if(preg_match("/\b$key\b/", $title)) {
          if(!$faqs[$node->nid->value]) {
            $faqs[$node->nid->value] = [RechercheConstante::TITLE => $node->getTitle(), 'content' => $node->body->value, RechercheConstante::COUNT => 0, 'type' => $node->type->value];
          }
          else {
            $faqs[$node->nid->value][RechercheConstante::COUNT] += 1;
          }
        }
      }
    }

    usort($faqs,
      function ($a, $b) {
        return strcmp($b[RechercheConstante::COUNT], $a[RechercheConstante::COUNT]);
      }
    );

    try {

      //search on Twitter
      $settings = [
        'oauth_access_token' => RechercheConstante::TWITTER_OAUTH_ACCESS_TOKEN,
        'oauth_access_token_secret' => RechercheConstante::TWITTER_OAUTH_ACCESS_TOKEN_SECRET,
        'consumer_key' => RechercheConstante::TWITTER_CONSUMER_KEY,
        'consumer_secret' => RechercheConstante::TWITTER_CONSUMER_SECRET_KEY
      ];

      $tweets = [];
      $communautes = [];

      $twitter = new \TwitterAPIExchange($settings);

      $url = 'https://api.twitter.com/1.1/search/tweets.json';
      $getfield = '?q="from:orange_sn ' . $request->get('q') . '"&lang=fr&count=100';
      $requestMethod = 'GET';

      $response = $twitter->setGetfield($getfield)
        ->buildOauth($url, $requestMethod)
        ->performRequest();

      $result = json_decode($response);
      foreach ($result->statuses as $r) {
        $tweets[] = ['text' => $r->text, 'screen_name' => $r->user->screen_name, 'username' => $r->user->name, 'url' => $r->entities->urls{0}->url, 'logo' => $r->user->profile_image_url_https];
      }

      //Communauté
      $getfieldCom = '?q="' . $request->get('q') . '"&lang=fr&count=100';

      $response = $twitter->setGetfield($getfieldCom)
        ->buildOauth($url, $requestMethod)
        ->performRequest();

      $result = json_decode($response);
      $accounts = ['agencecaractere', 'SupportOrange', 'obs_senegal'];

      foreach ($result->statuses as $r) {
        if (in_array($r->user->screen_name, $accounts)) {
          $communautes[] = ['text' => $r->text, 'screen_name' => $r->user->screen_name, 'username' => $r->user->name, 'url' => $r->entities->urls{0}->url, 'logo' => $r->user->profile_image_url_https];
        }
      }
    }
    catch (\Exception $e) {
      $tweets[] = ['text' => $e->getMessage()];
    }




    //search on Youtube
    $videos = [];
    $url = 'https://www.googleapis.com/youtube/v3/search?q='.implode("+", $keywords).'&order=relevance&part=snippet&type=video&maxResults=10&key='.RechercheConstante::GOOGLE_DEVELOPPER_KEY.'&channelId='.RechercheConstante::ID_CHANNEL.'&videoEmbeddable=true';
    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, $url);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($c);
    $data_result = json_decode($response);
    foreach ($data_result ->items as $item) {
      $videos[] = ['videoId' => $item->id->videoId, RechercheConstante::TITLE => $item->snippet->title, 'description' => $item->snippet->description,
        'medium' => $item->snippet->thumbnails->medium->url, 'default' => $item->snippet->thumbnails->default->url];
    }

    $elements = count($tweets) + count($videos) + count($faqs) + count($produits_services);

    return [
      ThemeConstante::THEME => ThemeConstante::RECHERCHE,
      '#tweets' => $tweets,
      '#communautes' => $communautes,
      '#videos' => $videos,
      '#produits' => $produits_services,
      '#faqs' => $faqs,
      '#query' => $request->get('q'),
      '#elements' => $elements,
      ThemeConstante::PAGE_CACHE => [ThemeConstante::PAGE_CONTEXTS => ['url.path', ThemeConstante::PAGE_URL_QUERY], ThemeConstante::MAX_AGE => 0]
    ];
  }
}
