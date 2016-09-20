<?php

namespace Drupal\adminrss\Plugin\AdminRss\Feed;

/**
 * Interface FeedInterface describes the methods present on AdminRSS feeds.
 */
interface FeedInterface {

  /**
   * Build and output a feed of administrative items.
   *
   * Builder emits data and does not return any content.
   */
  public function feed();

  /**
   * The feed type.
   *
   * @return string
   *   Like "node" or "comment".
   */
  public function type();

}
