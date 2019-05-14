<?php

namespace Drupal\Tests\portail\Unit;

use Drupal\Tests\portail\Mock\TestUtils;
use Drupal\Tests\UnitTestCase;
use Drupal\portail\Controller\AssistanceController;
use Drupal\portail\Constante\ThemeConstante;

class AssistanceTest extends UnitTestCase {

  protected $assistanceController;
  protected $mockClass;
  public function setUp() {
    parent::setUp();
    $this->assistanceController = new AssistanceController();
    $this->mockClass = new TestUtils();
  }

  /**
   * @covers::getAll
   */
  public function testGetAll() {
    $result = $this->assistanceController->getAll();
    $this->assertArrayHasKey(ThemeConstante::THEME, $result);

  }

  /**
   * @covers::__construct
   */
  public function testConstruct() {
    $this->assertTrue(true);
  }

}
