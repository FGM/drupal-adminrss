<?php

namespace Drupal\adminrss\Controller;

use Drupal\adminrss\Plugin\AdminRss\Feed\FeedInterface;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class FeedController provides the controller for the main AdminRSS route.
 */
class FeedController extends ControllerBase {

  /**
   * The controller for the AdminRSS main route.
   *
   * Access control and type validity is performed by the param converter and
   * access_check, so there is no access or existence check to perform.
   *
   * @param \Drupal\adminrss\Plugin\AdminRss\Feed\FeedInterface $feed
   *
   * @return string
   *   The RSS feed response.
   */
  public function feedAction(FeedInterface $feed) {
    $output = $feed->feed();

    $headers = [
      'Content-Type' => 'application/rss+xml; charset=utf-8',
    ];

    $response = new Response($output, Response::HTTP_OK, $headers);
    return $response;
  }

}
