<?php

namespace Drupal\Tests\portail\Unit;

use Drupal\Tests\portail\Mock\TestUtils;
use Drupal\Tests\UnitTestCase;
use Drupal\portail\Controller\TVOrangeController;
use Drupal\portail\Constante\ThemeConstante;
use Drupal\portail\Constante\TvOrangeConstante;
use Drupal\portail\Utils\PortailUtils;
use Drupal\portail\Utils\QueryUtils;
use Drupal\node\Entity\Node;

class TvOrangeTest extends UnitTestCase {

  protected $tvorangeController;
  protected $mockClass;
  public function setUp() {
    parent::setUp();
    $this->tvorangeController = new TVOrangeController();
    $this->mockClass = new TestUtils();
    $container = $this->mockClass->getEntityQueryContainer($this, 'slider_tv');
    $entityTypeRepository = $this->prophesize('\Drupal\Core\Entity\EntityTypeRepositoryInterface');
    $container->set('entity_type.repository', $entityTypeRepository->reveal());
    \Drupal::setContainer($container);
  }

  /**
   * @covers::getSlider
   */
  public function testGetSlider() {
    @$result = $this->tvorangeController->getSlider();
    $this->assertArrayHasKey(TvOrangeConstante::IMAGES_SLIDER, $result[0]);
    $this->assertArrayHasKey(TvOrangeConstante::TITRES_SLIDER, $result[0]);
    $this->assertArrayHasKey(TvOrangeConstante::CATEGORIES_SLIDER, $result[0]);

  }

}
