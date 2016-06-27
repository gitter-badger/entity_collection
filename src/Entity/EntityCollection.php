<?php

namespace Drupal\entity_collection\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\Core\Plugin\DefaultSingleLazyPluginCollection;
use Drupal\entity_collection\Annotation\EntityCollectionStorage;
use Drupal\entity_collection\Plugin\EntityCollectionListStyleInterface;
use Drupal\entity_collection\Plugin\EntityCollectionRowDisplayInterface;
use Drupal\entity_collection\Plugin\EntityCollectionStorageInterface;

/**
 * Defines the Entity collection entity.
 *
 * @ConfigEntityType(
 *   id = "entity_collection",
 *   label = @Translation("Entity Collection"),
 *   handlers = {
 *     "list_builder" = "Drupal\entity_collection\EntityCollectionListBuilder",
 *     "form" = {
 *       "add" = "Drupal\entity_collection\Form\EntityCollectionForm",
 *       "edit" = "Drupal\entity_collection\Form\EntityCollectionForm",
 *       "delete" = "Drupal\entity_collection\Form\EntityCollectionDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\entity_collection\EntityCollectionHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "entity_collection",
 *   admin_permission = "administer site configuration",
 *   links = {
 *     "canonical" = "/admin/structure/entity_collection/{entity_collection}",
 *     "add-form" = "/admin/structure/entity_collection/add",
 *     "edit-form" = "/admin/structure/entity_collection/{entity_collection}/edit",
 *     "delete-form" = "/admin/structure/entity_collection/{entity_collection}/delete",
 *     "collection" = "/admin/structure/entity_collection"
 *   },
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   config_export = {
 *     "label",
 *     "storage",
 *     "storage_settings",
 *     "list_style",
 *     "list_style_settings",
 *     "row_display",
 *     "row_display_settings",
 *   }
 * )
 *
 * @Note: take a look at EntityWithPluginCollectionInterface
 */
class EntityCollection extends ConfigEntityBase implements EntityCollectionInterface, EntityWithPluginCollectionInterface {

  /**
   * The Entity collection ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Entity collection label.
   *
   * @var string
   */
  protected $label;


  /**
   * The storage plugin id.
   *
   * @var string
   */
  protected $storage;

  /**
   * The storage plugin settings
   *
   * @var array
   */
  protected $storage_settings;

  /**
   * Storage lazy plugin collection.
   *
   * @var \Drupal\Core\Plugin\DefaultSingleLazyPluginCollection
   */
  protected $storage_collection;


  /**
   * The List Style plugin id.
   *
   * @var string
   */
  protected $list_style;

  /**
   * The list style plugin settings
   *
   * @var array
   */
  protected $list_style_settings;

  /**
   * List style lazy plugin collection.
   *
   * @var \Drupal\Core\Plugin\DefaultSingleLazyPluginCollection
   */
  protected $list_style_collection;

  /**
   * The List Style plugin id.
   *
   * @var string
   */
  protected $row_display;

  /**
   * The Row Display plugin settings
   *
   * @var array
   */
  protected $row_display_settings;

  /**
   * List style lazy plugin collection.
   *
   * @var \Drupal\Core\Plugin\DefaultSingleLazyPluginCollection
   */
  protected $row_display_collection;


  /**
   * Contains the contexts for this collection
   *
   * @var array
   */
  protected $contexts = [];


  /**
   * @return mixed
   */
  public function getStorage() {
    return $this->storagePluginCollection()->get($this->storage);
  }

  /**
   * @param EntityCollectionStorageInterface $storage
   */
  public function setStorage(EntityCollectionStorageInterface $storage) {
    $this->storage = $storage;
  }

  /**
   * @return EntityCollectionListStyleInterface
   */
  public function getListStyle() {
    return $this->listStylePluginCollection()->get($this->list_style);
  }

  /**
   * @param EntityCollectionListStyleInterface $list_style
   */
  public function setListStyle(EntityCollectionListStyleInterface $list_style) {
    $this->list_style = $list_style;
  }

  /**
   * @return EntityCollectionRowDisplayInterface
   */
  public function getRowDisplay() {
    return $this->rowDisplayPluginCollection()->get($this->row_display);
  }

  /**
   * @param EntityCollectionRowDisplayInterface $row_display
   */
  public function setRowDisplay(EntityCollectionRowDisplayInterface $row_display) {
    $this->row_display = $row_display;
  }

  /**
   * {@inheritdoc}
   */
  public function getContexts() {
    return $this->contexts;
  }

  /**
   * {@inheritdoc}
   */
  public function setContexts(array $contexts) {
    $this->contexts = $contexts;
  }

  /**
   * {@inheritdoc}
   */
  public function getTree() {
    // TODO: Implement getTree() method.
  }

  /**
   * Returns Storage plugin collection.
   *
   * @return \Drupal\Core\Plugin\DefaultSingleLazyPluginCollection
   *   The storage plugin collection.
   */
  private function storagePluginCollection() {
    if (!$this->storage_collection) {
      $this->storage_settings['entity_collection_id'] = $this->id();
      $this->storage_collection = new DefaultSingleLazyPluginCollection(\Drupal::service('plugin.manager'), $this->storage, $this->storage_settings);
    }
    return $this->storage_collection;
  }

  /**
   * Returns List Style plugin collection.
   *
   * @return \Drupal\Core\Plugin\DefaultSingleLazyPluginCollection
   *   The List Style plugin collection.
   */
  private function listStylePluginCollection() {
    if (!$this->list_style_collection) {
      $this->list_style_settings['entity_collection_id'] = $this->id();
      $this->list_style_collection = new DefaultSingleLazyPluginCollection(\Drupal::service('plugin.manager'), $this->list_style, $this->list_style_settings);
    }
    return $this->list_style_collection;
  }

  /**
   * Returns Row Display plugin collection.
   *
   * @return \Drupal\Core\Plugin\DefaultSingleLazyPluginCollection
   *   The Row Display plugin collection.
   */
  private function rowDisplayPluginCollection() {
    if (!$this->row_display_collection) {
      $this->row_display_settings['entity_collection_id'] = $this->id();
      $this->row_display_collection = new DefaultSingleLazyPluginCollection(\Drupal::service('plugin.manager'), $this->row_display, $this->row_display_settings);
    }
    return $this->row_display_collection;
  }

}
