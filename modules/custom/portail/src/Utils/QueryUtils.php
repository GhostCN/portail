<?php

namespace Drupal\portail\Utils;

/**
 * Class QueryUtil
 * @package Drupal\portail\Utils
 */
class QueryUtils {

  /**
 * Retourne tous les pass internet actifs
 * @retrun array
 */
  static function getNodesFromType($type) {

    return \Drupal::entityQuery('node')->condition('type',$type)->condition('status', 1)->execute();
  }

  static function getNodesFromTypeAndFields($type, $fields, $isFieldExist = false) {
    $query = \Drupal::entityQuery('node')->condition('type',$type)->condition('status', 1);
    if($isFieldExist){
      $query->notExists($isFieldExist);
    }
    foreach ($fields as $key => $value){
      $query->condition($key, $value);
    }
    return $query->execute();
  }
}
