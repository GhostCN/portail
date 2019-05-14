<?php

namespace Drupal\Tests\portail\Unit;

use Drupal\Tests\portail\Mock\TestUtils;
use Drupal\Tests\UnitTestCase;
use Drupal\portail\Controller\TerangaController;
use Drupal\portail\Constante\ThemeConstante;
use Drupal\portail\Constante\TerangaConstante;
use Symfony\Component\HttpFoundation\Request;

class TerangaTest extends UnitTestCase {

  protected $terangaController;
  protected $mockClass;
  public function setUp() {
    parent::setUp();
    $this->terangaController = new TerangaController();
    $this->mockClass = new TestUtils();
    $container = $this->mockClass->getEntityQueryContainer($this, 'offres_teranga');
    $entityTypeRepository = $this->prophesize('\Drupal\Core\Entity\EntityTypeRepositoryInterface');
    $container->set('entity_type.repository', $entityTypeRepository->reveal());
    \Drupal::setContainer($container);
  }

  /**
   * @covers::getAll
   */
  public function testGetAll() {
    $request = new Request();
    $result = $this->terangaController->getAll($request);
    $this->assertArrayHasKey(ThemeConstante::THEME, $result);
    $this->assertArrayHasKey(TerangaConstante::OFFRES, $result);
    $this->assertArrayHasKey(TerangaConstante::FORFAITS, $result);

  }

  /**
   * @covers::getDetail
   */
  public function getDetail() {
    $request = new Request();
    $result = $this->terangaController->getDetail($request);
    $this->assertArrayHasKey(ThemeConstante::THEME, $result);
    $this->assertArrayHasKey(TerangaConstante::CONTENT, $result);
    $this->assertArrayHasKey(TerangaConstante::FORFAITS, $result);

  }

}
