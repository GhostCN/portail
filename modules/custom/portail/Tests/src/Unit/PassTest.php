<?php

namespace Drupal\Tests\portail\Unit;

use Drupal\Tests\portail\Mock\TestUtils;
use Drupal\Tests\UnitTestCase;
use Drupal\portail\Controller\PassController;
use Drupal\portail\Constante\ThemeConstante;
use Drupal\portail\Constante\PassConstante;

class PassTest extends UnitTestCase {

  protected $passController;
  protected $mockClass;
  public function setUp() {
    parent::setUp();
    $this->passController = new PassController();
    $this->mockClass = new TestUtils();
    $container = $this->mockClass->getEntityQueryContainer($this, 'pass_internet');
    $entityTypeRepository = $this->prophesize('\Drupal\Core\Entity\EntityTypeRepositoryInterface');
    $container->set('entity_type.repository', $entityTypeRepository->reveal());
    \Drupal::setContainer($container);
  }

  /**
   * @covers::getAllPassInternet
   */
  public function testGetAllPassInternet() {
    $result = $this->passController->getAllPassInternet();
    $this->assertArrayHasKey(ThemeConstante::THEME, $result);
    $this->assertEquals(ThemeConstante::LIST_PASS, $result[ThemeConstante::THEME]);
    $this->assertArrayHasKey(ThemeConstante::ALLPASS, $result);

    $this->assertArrayHasKey(PassConstante::TITLE, $result[ThemeConstante::ALLPASS]['mois'][0]);
    $this->assertArrayHasKey(PassConstante::MONTANT, $result[ThemeConstante::ALLPASS]['mois'][0]);
    $this->assertArrayHasKey(PassConstante::VOLUME, $result[ThemeConstante::ALLPASS]['mois'][0]);
    $this->assertArrayHasKey(PassConstante::VALIDITE, $result[ThemeConstante::ALLPASS]['mois'][0]);
    $this->assertArrayHasKey(PassConstante::INFO, $result[ThemeConstante::ALLPASS]['mois'][0]);
    $this->assertArrayHasKey(PassConstante::RESTRICTION, $result[ThemeConstante::ALLPASS]['mois'][0]);
    $this->assertArrayHasKey(PassConstante::POIDS, $result[ThemeConstante::ALLPASS]['mois'][0]);

  }

}
