<?php

namespace Drupal\Tests\portail\Unit;

use Drupal\Tests\portail\Mock\TestUtils;
use Drupal\Tests\UnitTestCase;
use Drupal\portail\Controller\OffreController;
use Drupal\portail\Constante\OffreConstante;
use Drupal\Tests\portail\Unit\PromoTest;

class OffreTest extends UnitTestCase {

  protected $offreController;
  protected $mockClass;
  public function setUp() {
    parent::setUp();
    $this->offreController = new OffreController();
    $this->mockClass = new TestUtils();
    $container = $this->mockClass->getEntityQueryContainer($this, 'offre_mobile');
    $entityTypeRepository = $this->prophesize('\Drupal\Core\Entity\EntityTypeRepositoryInterface');
    $container->set('entity_type.repository', $entityTypeRepository->reveal());
    \Drupal::setContainer($container);
  }

  /**
   * @depends testGetAllPromo
   */
  public function testGetAllOffre($promos) {
    $result = $this->offreController->getAllOffre();
    $this->assertArrayHasKey(OffreConstante::TITLE, $result[0]);
    $this->assertArrayHasKey(OffreConstante::TEXTE, $result[0]);
    $this->assertArrayHasKey(OffreConstante::IMAGE, $result[0]);

  }

}
