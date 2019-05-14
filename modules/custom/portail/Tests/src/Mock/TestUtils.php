<?php

namespace Drupal\Tests\portail\Mock;

use Drupal\Core\DependencyInjection\ContainerBuilder;

class StdClassPersonalize extends \stdClass {

  public function getFileUri() {
    return 'url';
  }
}
/**
 * Class TestUtils
 * @package Drupal\Test\portail\Mock
 */
class TestUtils {

  public function __construct()
  {
  }


  /**
 * Retourne le container Drupal
 * @retrun object
 */
  public function getEntityQueryContainer($object, $type, $isFieldExist = false) {
    $container = new ContainerBuilder();

    $query = $object->getMock('\Drupal\Core\Entity\Query\QueryInterface');
    $query->expects($object->at(0))->method('condition')->with('type', $type)->willReturn($query);
    $query->expects($object->at(1))->method('condition')->with('status', 1)->willReturn($query);
    if($isFieldExist) {
      $query->expects($object->at(2))->method('notExists')->with($isFieldExist)->willReturn($query);
    }
    $query->expects($object->once())->method('execute')->willReturn([1, 2, 4]);





    $node_object = new \stdClass();
    $node_object->value = 'value';
    $node_object->uri = 'uri';
    $node_object->title = 'title';
    $node_object->entity = new StdClassPersonalize();

    $node = $object->getMock('\Drupal\node\NodeInterface');
    $node->expects($object->any())->method('getTitle')->willReturn('titre');
    $node->expects($object->any())->method('get')->with($object->anything())->willReturn($node_object);




    $storage = $object->getMock('\Drupal\Core\Entity\EntityStorageInterface');
    $storage->expects($object->any())->method('getQuery')->with('AND')->willReturn($query);

    $storage->expects($object->any())
      ->method('loadMultiple')
      ->with([1, 2, 4])
      ->willReturn(['node' =>$node]);


    $entityTypeManager = $object->getMock('\Drupal\Core\Entity\EntityTypeManagerInterface');
    $entityTypeManager->expects($object->any())->method('getStorage')->willReturn($storage);//->with('node')

    $container->set('entity_type.manager', $entityTypeManager);

    return $container;
  }
}
