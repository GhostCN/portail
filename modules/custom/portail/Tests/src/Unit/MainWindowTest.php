<?php

namespace Drupal\Tests\portail\Unit;

use Drupal\Tests\portail\Mock\TestUtils;
use Drupal\Tests\UnitTestCase;
use Drupal\portail\Controller\MainWindowController;
use Drupal\portail\Constante\MainWindowConstante;

class MainWindowTest extends UnitTestCase {

  protected $mainController;
  protected $mockClass;


  public function setUp() {
    parent::setUp();
    $this->mainController = new MainWindowController();
    $this->mockClass = new TestUtils();
    $container = $this->mockClass->getEntityQueryContainer($this, 'main_window');
    $entityTypeRepository = $this->prophesize('\Drupal\Core\Entity\EntityTypeRepositoryInterface');
    $container->set('entity_type.repository', $entityTypeRepository->reveal());
    \Drupal::setContainer($container);
  }

  /**
   * @covers::getAllMainWindow
   */
  public function testGetAllMainWindow() {
    $result = $this->mainController->getAllMainWindow();

    $this->assertArrayHasKey(MainWindowConstante::TITLE, $result[0]);
    $this->assertArrayHasKey(MainWindowConstante::RESUME, $result[0]);
    $this->assertArrayHasKey(MainWindowConstante::IMAGE, $result[0]);
    $this->assertArrayHasKey(MainWindowConstante::POIDS, $result[0]);
    $this->assertEquals("titre", $result[0][MainWindowConstante::TITLE]);
    $this->assertEquals("value", $result[0][MainWindowConstante::RESUME]);

  }

}
