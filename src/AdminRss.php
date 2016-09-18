<?php

namespace Drupal\adminrss;

/**
 * Class AdminRss contains constants used at various places in the module.
 */
class AdminRss {

  /**
   * Cache id for feed information.
   */
  const CID = 'adminrss:feed-info';

  const CONFIG = 'adminrss.settings';

  const TOKEN = 'token';

  /**
   * The main feed route.
   */
  const ROUTE_MAIN = 'adminrss.feed_controller_feedAction';

  /**
   * The settings route.
   */
  const ROUTE_SETTINGS = 'adminrss.admin_rss_settings_form';

}
