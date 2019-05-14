<?php

namespace Drupal\Tests\portail\Unit;

use Drupal\Tests\portail\Mock\TestUtils;
use Drupal\Tests\UnitTestCase;
use Drupal\portail\Controller\FibreController;
use Drupal\portail\Constante\ThemeConstante;
use Drupal\portail\Constante\FibreConstante;

class EtapeDeploiementTest extends UnitTestCase {

  protected $fibreController;
  protected $mockClass;
  public function setUp() {
    parent::setUp();
    $this->fibreController = new FibreController();
    $this->mockClass = new TestUtils();
    $container = $this->mockClass->getEntityQueryContainer($this, 'tarifs_page_fibre');
    $entityTypeRepository = $this->prophesize('\Drupal\Core\Entity\EntityTypeRepositoryInterface');
    $container->set('entity_type.repository', $entityTypeRepository->reveal());
    \Drupal::setContainer($container);
  }

  /**
   * @covers::getOffreFibre
   */
  public function testGetEtapeDeploiement() {
    $result = $this->fibreController->getEtapeDeploiement();
     $this->assertArrayHasKey(FibreConstante::ETAPES, $result);
     $this->assertArrayHasKey(FibreConstante::TITRES, $result);

  }

}
