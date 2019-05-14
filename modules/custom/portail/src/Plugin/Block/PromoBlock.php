<?php
namespace Drupal\portail\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\portail\Constante\ThemeConstante;
use Drupal\portail\Controller\MainWindowController;


/**
 * Provides a 'Promo' block.
 *
 * @Block(
 *  id = "promo_block",
 *  admin_label = @Translation("Promo block"),
 *  category = @Translation("Orange")
 * )
 */
class PromoBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $mainWindows = new MainWindowController();
    return [
      '#theme' => 'promo_block',
      '#events' => $mainWindows->getEvent(),
      ThemeConstante::PAGE_CACHE => [ThemeConstante::PAGE_CONTEXTS => ['url.path', ThemeConstante::PAGE_URL_QUERY], ThemeConstante::MAX_AGE => 0]
    ];
  }

}
