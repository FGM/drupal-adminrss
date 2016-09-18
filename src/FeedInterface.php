<?php

namespace Drupal\adminrss;

/**
 * Interface FeedInterface describes AdminRSS feed methods.
 */
interface FeedInterface {

  /**
   * The feed type.
   *
   * @return string
   *   Like "node" or "comment".
   */
  public function type();

}
