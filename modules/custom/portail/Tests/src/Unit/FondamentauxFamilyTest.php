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

class FondamentauxFamilyTest extends UnitTestCase {

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
   * @covers::getFondamentauxFamily
   */
  public function testGetFondamentauxFamily() {
    @$result = $this->offreController->getFondamentauxFamily();
    $this->assertArrayHasKey(OffreConstante::DESC_FOND, $result);
    $this->assertArrayHasKey(OffreConstante::ICONS_FOND, $result);
  }

}
