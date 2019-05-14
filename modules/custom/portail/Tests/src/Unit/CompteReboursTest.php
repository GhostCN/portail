<?php

namespace Drupal\Tests\portail\Unit;

use Drupal\Tests\portail\Mock\TestUtils;
use Drupal\Tests\UnitTestCase;
use Drupal\portail\Controller\MainWindowController;
use Drupal\portail\Constante\MainWindowConstante;

class CompteReboursTest extends UnitTestCase {

  protected $mainController;
  protected $mockClass;


  public function setUp() {
    parent::setUp();
    $this->mainController = new MainWindowController();
    $this->mockClass = new TestUtils();
    $container = $this->mockClass->getEntityQueryContainer($this, 'compte_a_rebours');
    $entityTypeRepository = $this->prophesize('\Drupal\Core\Entity\EntityTypeRepositoryInterface');
    $container->set('entity_type.repository', $entityTypeRepository->reveal());
    \Drupal::setContainer($container);
  }

  

  /**
   * @covers::getEvent
   */
  public function testGetEvent() {

    $result = $this->mainController->getEvent();

    $this->assertEquals($result[0]['pourcentage'], 'value');
    $this->assertArrayHasKey(MainWindowConstante::POURCENTAGE_BONUS, $result[0]);
    $this->assertArrayHasKey(MainWindowConstante::PRIX_BONUS, $result[0]);
  }

}
