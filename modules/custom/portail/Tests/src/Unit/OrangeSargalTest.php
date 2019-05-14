<?php

namespace Drupal\Tests\portail\Unit;

use Drupal\Tests\portail\Mock\TestUtils;
use Drupal\Tests\UnitTestCase;
use Drupal\portail\Controller\SargalController;
use Drupal\portail\Constante\ThemeConstante;
use Drupal\Tests\portail\Unit\PromoTest;

class SargalTest extends UnitTestCase {

  protected $orangeSargalController;
  protected $mockClass;
  public function setUp() {
    parent::setUp();
    $this->orangeSargalController = new SargalController();
    $this->mockClass = new TestUtils();
    $container = $this->mockClass->getEntityQueryContainer($this, 'orange_sargal');
    $entityTypeRepository = $this->prophesize('\Drupal\Core\Entity\EntityTypeRepositoryInterface');
    $container->set('entity_type.repository', $entityTypeRepository->reveal());
    \Drupal::setContainer($container);
  }

  /**
   * @covers::getAll
   */
  public function testGetAll() {
    $result = $this->orangeSargalController->getAll();
    $this->assertArrayHasKey(ThemeConstante::THEME, $result);
    $this->assertArrayHasKey(ThemeConstante::CADEAU_SARGAL, $result);
    $this->assertArrayHasKey(ThemeConstante::FAQ_SARGAL, $result);

  }

}
