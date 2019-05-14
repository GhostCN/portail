<?php
  
namespace Drupal\Tests\portail\Unit;

use Drupal\Tests\portail\Mock\TestUtils;
use Drupal\Tests\UnitTestCase;
use Drupal\portail\Controller\OffreController;
use Drupal\portail\Constante\ThemeConstante;
use Drupal\portail\Constante\OffreConstante;
use Drupal\portail\Utils\PortailUtils;
use Drupal\portail\Utils\QueryUtils;
use Drupal\node\Entity\Node;

class DetailOffreFamilyTest extends UnitTestCase {

  protected $offreController;
  protected $mockClass;
  public function setUp() {
    parent::setUp();
    $this->offreController = new OffreController();
    $this->mockClass = new TestUtils();
    $container = $this->mockClass->getEntityQueryContainer($this, OffreConstante::TABLE_FAMILY);
    $entityTypeRepository = $this->prophesize('\Drupal\Core\Entity\EntityTypeRepositoryInterface');
    $container->set('entity_type.repository', $entityTypeRepository->reveal());
    \Drupal::setContainer($container);
  }

  /**
   * @covers::getDetailFamily
   */
  public function testGetDetailFamily() {
    @$result = $this->offreController->getDetailFamily();
    $this->assertArrayHasKey(OffreConstante::PRIX_APPEL, $result[0]);
    $this->assertArrayHasKey(OffreConstante::PRIX_SMS, $result[0]);
    $this->assertArrayHasKey(OffreConstante::SEDDO_PASS, $result[0]);
    $this->assertArrayHasKey(OffreConstante::NOM_PHONE, $result[0]);
    $this->assertArrayHasKey(OffreConstante::TYPE_PHONE, $result[0]);
    $this->assertArrayHasKey(OffreConstante::IMAGE_PHONE, $result[0]);
    $this->assertArrayHasKey(OffreConstante::DESCRIPTION_PHONE, $result[0]);
    $this->assertArrayHasKey(OffreConstante::PRIX_PHONE, $result[0]);
    $this->assertArrayHasKey(OffreConstante::LIEN_DETAIL, $result[0]);
    $this->assertArrayHasKey(OffreConstante::LIEN_ACHAT, $result[0]);

  }

}
