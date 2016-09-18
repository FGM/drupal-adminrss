<?php

namespace Drupal\adminrss\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the adminrss module.
 */
class FeedControllerTest extends WebTestBase {
  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return array(
      'name' => "adminrss FeedController's controller functionality",
      'description' => 'Test Unit for module adminrss and controller FeedController.',
      'group' => 'Other',
    );
  }

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
  }

  /**
   * Tests adminrss functionality.
   */
  public function testFeedController() {
    // Check that the basic functions of module adminrss.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via App Console.');
  }

}
