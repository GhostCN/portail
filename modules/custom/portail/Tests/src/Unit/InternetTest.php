<?php

namespace Drupal\Tests\portail\Unit;

use Drupal\Tests\portail\Mock\TestUtils;
use Drupal\Tests\UnitTestCase;
use Drupal\portail\Controller\InternetController;
use Drupal\portail\Constante\InternetConstante;

class InternetTest extends UnitTestCase {

  protected $internetController;
  protected $mockClass;
  public function setUp() {
    parent::setUp();
    $this->internetController = new InternetController();
    $this->mockClass = new TestUtils();
    $container = $this->mockClass->getEntityQueryContainer($this, 'internet_et_fixe');
    $entityTypeRepository = $this->prophesize('\Drupal\Core\Entity\EntityTypeRepositoryInterface');
    $container->set('entity_type.repository', $entityTypeRepository->reveal());
    \Drupal::setContainer($container);
  }

  /**
   * @covers::getAll
   */
  public function testGetAll() {
    $result = $this->internetController->getAll();
    $this->assertArrayHasKey(InternetConstante::TITLE, $result['#infos'][0]);

  }

}
