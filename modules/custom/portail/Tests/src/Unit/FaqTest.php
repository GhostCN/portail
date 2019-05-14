<?php

namespace Drupal\Tests\portail\Unit;

use Drupal\Tests\portail\Mock\TestUtils;
use Drupal\Tests\UnitTestCase;
use Drupal\portail\Controller\FibreController;
use Drupal\portail\Constante\ThemeConstante;
use Drupal\portail\Constante\FibreConstante;

class FaqTest extends UnitTestCase {

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
   * @covers::getFaq
   */
  public function testGetFaq() {
    $result = $this->fibreController->getFaq();
     $this->assertArrayHasKey(FibreConstante::QUESTIONS, $result);
     $this->assertArrayHasKey(FibreConstante::REPONSES, $result);

  }

}
