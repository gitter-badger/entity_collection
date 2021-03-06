<?php

namespace Drupal\entity_collection\Plugin;


use Drupal\entity_collection\Entity\EntityCollection;
use Drupal\entity_collection\Entity\EntityCollectionInterface;
use Drupal\entity_collection\TreeNodeInterface;

/**
 * Defines an interface for EntityCollection Storage plugins.
 */
interface StorageInterface extends EntityCollectionPluginBaseInterface {

  /**
   * Stores an entity collection in the backend.
   *
   * @param EntityCollectionInterface $collection
   *   The collection to which the content belongs.
   * @param TreeNodeInterface $tree
   *   The Tree to be saved
   */
  public function store(EntityCollectionInterface $collection, TreeNodeInterface $tree);

  /**
   * Retrieve the content of a collection.
   *
   * @param EntityCollectionInterface $collection
   *   The collection to which the content belongs.
   */
  public function load(EntityCollectionInterface $collection);
  
  /**
   * Remove all content in the entity collection.
   *
   * @param EntityCollectionInterface $collection
   */
  public function truncate(EntityCollectionInterface $collection);
}
