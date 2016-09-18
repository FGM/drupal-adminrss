<?php

namespace Drupal\adminrss\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a Plugin annotation object for AdminRSS feed plugins.
 *
 * Plugin Namespace: Plugin\AdminRss\Feed.
 *
 * For a working example:
 *
 * @see \Drupal\adminrss\Plugin\AdminRss\Feed\NodeFeed
 * @see plugin_api
 *
 * @Annotation
 */
class AdminRssFeed extends Plugin {

  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * The title of the plugin.
   *
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   */
  public $title;

  /**
   * The description of the plugin.
   *
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   */
  public $description;

}
