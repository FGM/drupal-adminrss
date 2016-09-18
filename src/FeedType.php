<?php

namespace Drupal\adminrss;

use Drupal\Component\Utility\Unicode;
use Drupal\Core\ParamConverter\ParamConverterInterface;
use Symfony\Component\Routing\Route;

/**
 * Class FeedType is the param converter for AdminRSS feed types.
 */
class FeedType implements ParamConverterInterface {
  const TYPE = 'adminrss:feed_type';
  const NAME = 'feed';

  /**
   * Converts path variables to their corresponding objects.
   *
   * @param mixed $value
   *   The raw value.
   * @param mixed $definition
   *   The parameter definition provided in the route options.
   * @param string $name
   *   The name of the parameter.
   * @param array $defaults
   *   The route defaults array.
   *
   * @return mixed|null
   *   The converted parameter value.
   */
  public function convert($value, $definition, $name, array $defaults) {
    $class = __NAMESPACE__ . '\\' . Unicode::ucfirst($value) . 'Feed';
    if (!class_exists($class)) {
      return NULL;
    }

    return new $class();
  }

  /**
   * Determines if the converter applies to a specific route and variable.
   *
   * @param mixed $definition
   *   The parameter definition provided in the route options.
   * @param string $name
   *   The name of the parameter.
   * @param \Symfony\Component\Routing\Route $route
   *   The route to consider attaching to.
   *
   * @return bool
   *   TRUE if the converter applies to the passed route and parameter, FALSE
   *   otherwise.
   */
  public function applies($definition, $name, Route $route) {
    $ret = isset($definition['type']) && $definition['type'] === static::TYPE && $name === static::NAME;
    return $ret;
  }

}
