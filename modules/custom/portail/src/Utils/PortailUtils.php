<?php

namespace Drupal\portail\Utils;

/**
 * Class QueryUtil
 * @package Drupal\portail\Utils
 */
class PortailUtils {

  /**
   * To sanitize a string
   * @param $value
   * @return mixed
   */
  public static function sanitizeString($value)
  {
    $value = preg_replace('/\-+_/', '-', strtolower(preg_replace(array('/[^a-zA-Z0-9_-]+/', '/^-/', '/-$/'), '', str_replace(array(' ', "'", '/', '}', '{', '(', ')', '!', '?', ';', ':', ',', '<', '>', '&', '#', '%'), '-', trim($value)))));
    return trim(preg_replace('/-+/', '-', $value), '-');
  }
}
