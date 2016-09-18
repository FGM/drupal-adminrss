<?php

namespace Drupal\adminrss\Controller;

use Drupal\adminrss\FeedInterface;
use Drupal\Core\Controller\ControllerBase;

/**
 * Class FeedController provides the controller for the main AdminRSS route.
 */
class FeedController extends ControllerBase {

  /**
   * The controller for the AdminRSS main route.
   *
   * @return string
   *   Return Hello string.
   */
  public function feedAction(FeedInterface $feed, $token) {
    return [
      '#type' => 'markup',
      '#markup' => $this->t("Feed type: @type", ['@type' => $feed->type()]),
    ];
  }

}
