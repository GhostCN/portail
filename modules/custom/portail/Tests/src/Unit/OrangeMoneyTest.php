<?php

namespace Drupal\Tests\portail\Unit;

use Drupal\Tests\portail\Mock\TestUtils;
use Drupal\Tests\UnitTestCase;
use Drupal\portail\Controller\OrangeMoneyController;
use Drupal\portail\Constante\ThemeConstante;
use Drupal\Tests\portail\Unit\PromoTest;
use Symfony\Component\HttpFoundation\Request;

class OrangeMoneyTest extends UnitTestCase {

  protected $orangeMonyController;
  protected $mockClass;
  public function setUp() {
    parent::setUp();
    $this->orangeMonyController = new OrangeMoneyController();
    $this->mockClass = new TestUtils();
    $container = $this->mockClass->getEntityQueryContainer($this, 'orange_money');
    $entityTypeRepository = $this->prophesize('\Drupal\Core\Entity\EntityTypeRepositoryInterface');
    $container->set('entity_type.repository', $entityTypeRepository->reveal());
    \Drupal::setContainer($container);
  }

  /**
   * @covers::getAll
   */
  public function testGetAll() {
    $request = new Request();
    $result = $this->orangeMonyController->getAll($request);
    $this->assertArrayHasKey(ThemeConstante::THEME, $result);
    $this->assertArrayHasKey(ThemeConstante::SLIDER_OM, $result);
    $this->assertArrayHasKey(ThemeConstante::FAQ_OM, $result);

  }

}
