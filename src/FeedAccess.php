<?php

namespace Drupal\adminrss;

use Drupal\adminrss\Plugin\AdminRss\Feed\FeedInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Routing\Access\AccessInterface;

/**
 * Class FeedAccess provides acces checking to the feed route.
 */
class FeedAccess implements AccessInterface {

  /**
   * The module configuration.
   *
   * @var \Drupal\Core\Config\ImmutableConfig
   */
  protected $config;

  /**
   * FeedAccess constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   *   The config.factory service.
   */
  public function __construct(ConfigFactoryInterface $configFactory) {
    $this->config = $configFactory->get(AdminRss::CONFIG);
  }

  /**
   * Check access control to the feed.
   *
   * @param \Drupal\adminrss\FeedInterface $feed
   *   The feed instance. If the requested feed type is invalid, this method
   *   will not even be invoked, so there is no need to check this parameter.
   * @param string $token
   *   The access token.
   *
   * @return \Drupal\Core\Access\AccessResultInterface
   *   The access result for the feed.
   */
  public function access(FeedInterface $feed, $token) {
    $expectedToken = $this->config->get(AdminRss::TOKEN);
    $access = ($token === $expectedToken)
      ? AccessResult::allowed()
      : AccessResult::forbidden('Invalid token');
    return $access;
  }

}
