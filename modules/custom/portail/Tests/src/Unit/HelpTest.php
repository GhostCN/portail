<?php

namespace Drupal\Tests\portail\Unit;

use Drupal\Tests\portail\Mock\TestUtils;
use Drupal\Tests\UnitTestCase;
use Drupal\portail\Controller\HelpController;
use Drupal\portail\Constante\HelpConstante;

class HelpTest extends UnitTestCase {

  protected $helpController;
  protected $mockClass;
  public function setUp() {
    parent::setUp();
    $this->helpController = new HelpController();
    $this->mockClass = new TestUtils();
    $container = $this->mockClass->getEntityQueryContainer($this, 'besoin_d_aide');
    $entityTypeRepository = $this->prophesize('\Drupal\Core\Entity\EntityTypeRepositoryInterface');
    $container->set('entity_type.repository', $entityTypeRepository->reveal());
    \Drupal::setContainer($container);
  }

  /**
   * @covers::getAllHelp
   */
  public function testGetAllHelp() {
    $result = $this->helpController->getAllHelp();
    $this->assertArrayHasKey(HelpConstante::TITLE, $result[0]);
    $this->assertArrayHasKey(HelpConstante::INFO, $result[0]);
    $this->assertArrayHasKey(HelpConstante::IMAGE, $result[0]);

  }

}
