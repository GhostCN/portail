<?php

namespace Drupal\Tests\portail\Unit;

use Drupal\Tests\portail\Mock\TestUtils;
use Drupal\Tests\UnitTestCase;
use Drupal\portail\Controller\MainWindowController;
use Drupal\portail\Constante\MainWindowConstante;

class SliderTestTest extends UnitTestCase {

  protected $mainController;
  protected $mockClass;


  public function setUp() {
    parent::setUp();
    $this->mainController = new MainWindowController();
    $this->mockClass = new TestUtils();
    $container = $this->mockClass->getEntityQueryContainer($this, 'slider');
    $entityTypeRepository = $this->prophesize('\Drupal\Core\Entity\EntityTypeRepositoryInterface');
    $container->set('entity_type.repository', $entityTypeRepository->reveal());
    \Drupal::setContainer($container);
  }

  /**
   * @covers::getSliders
   */
  public function testGetSliders() {

    $result = $this->mainController->getSliders();

    $this->assertArrayHasKey(MainWindowConstante::TITLE, $result[0]);
    $this->assertArrayHasKey(MainWindowConstante::LIEN, $result[0]);
    $this->assertArrayHasKey(MainWindowConstante::TEXTE_LIEN, $result[0]);
    $this->assertArrayHasKey(MainWindowConstante::IMAGE, $result[0]);

  }

}
