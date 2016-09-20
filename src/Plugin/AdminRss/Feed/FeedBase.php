<?php

namespace Drupal\adminrss\Plugin\AdminRss\Feed;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class FeedBase is the base class for AdminRSS feeds.
 */
abstract class FeedBase implements FeedInterface {
  const TYPE = 'base';

  /**
   * {@inheritdoc}
   */
  public function type() {
    return static::TYPE;
  }

}
