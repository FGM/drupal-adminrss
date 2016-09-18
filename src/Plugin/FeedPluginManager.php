<?php

namespace Drupal\adminrss\Plugin;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;

/**
 * Manages aggregator plugins.
 *
 * @see \Drupal\adminrss\Annotation\AdminRssFeed
 * @see plugin_api
 */
class FeedPluginManager extends DefaultPluginManager {

  /**
   * Constructs a FeedPluginManager object.
   *
   * @param string $type
   *   The plugin type, for example node or comment.
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler.
   */
  public function __construct($type, \Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    $type_annotations = array(
      'Feed' => 'Drupal\adminrss\Annotation\AdminRssFeed',
    );
    $plugin_interfaces = array(
      'Feed' => 'Drupal\adminrss\Plugin\AdminRss\Feed\FeedInterface',
    );

    parent::__construct("Plugin/adminrss/$type", $namespaces, $module_handler, $plugin_interfaces[$type], $type_annotations[$type]);
    $this->setCacheBackend($cache_backend, 'adminrss_' . $type . '_plugins');
  }

}
