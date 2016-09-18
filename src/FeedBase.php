<?php

namespace Drupal\adminrss;

/**
 * Class FeedBase is the base class for AdminRSS feeds.
 */
class FeedBase implements FeedInterface {
  const TYPE = 'base';

  /**
   * {@inheritdoc}
   */
  public function type() {
    return static::TYPE;
  }

}
