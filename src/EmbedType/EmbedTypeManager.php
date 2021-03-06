<?php

/**
 * @file
 * Contains \Drupal\embed\EmbedTypeManager.
 */

namespace Drupal\embed\EmbedType;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;

/**
 * Provides an Embed type plugin manager.
 *
 * @see \Drupal\embed\Annotation\EmbedType
 * @see \Drupal\embed\EmbedType\EmbedTypeInterface
 */
class EmbedTypeManager extends DefaultPluginManager {

  /**
   * Constructs a EmbedTypeManager object.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct('Plugin/EmbedType', $namespaces, $module_handler, 'Drupal\embed\EmbedType\EmbedTypeInterface', 'Drupal\embed\Annotation\EmbedType');
    $this->alterInfo('embed_type_plugins');
    $this->setCacheBackend($cache_backend, 'embed_type_plugins');
  }

  /**
   * Provides a list of plugins suitable for form options.
   *
   * @return array
   *   An array of valid plugin labels, keyed by plugin ID.
   */
  public function getDefinitionOptions() {
    $options = array_map(function ($definition) {
      return (string) $definition['label'];
    }, $this->getDefinitions());
    natsort($options);
    return $options;
  }

}
