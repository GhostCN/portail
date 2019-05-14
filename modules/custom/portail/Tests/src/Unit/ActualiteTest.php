<?php
//
//namespace Drupal\Tests\portail\Unit;
//
//use Drupal\Tests\portail\Mock\TestUtils;
//use Drupal\portail\Controller\ActualiteController;
//use Drupal\Tests\UnitTestCase;
//
//class ActualiteTest extends UnitTestCase
//{
//  protected $actuCtrl;
//  protected $mockClass;
//
//
//  public function setUp() {
//    parent::setUp();
//    $this->actuCtrl = new ActualiteController();
//    $this->mockClass = new TestUtils();
//    $container = $this->mockClass->getEntityQueryContainer($this, 'page_actualite');
//    $entityTypeRepository = $this->prophesize('\Drupal\Core\Entity\EntityTypeRepositoryInterface');
//    $container->set('entity_type.repository', $entityTypeRepository->reveal());
//    \Drupal::setContainer($container);
//  }
//
//  /**
//   * @covers::getAll
//   */
//  public function testGetAll() {
//    $result = $this->actuCtrl->getAll(1);
//  }
//}
