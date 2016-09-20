<?php

namespace Drupal\adminrss\Form;

use Drupal\adminrss\AdminRss;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\Query\QueryFactory;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;
use Drupal\Core\Routing\RouteProviderInterface;
use Drupal\views\Entity\View;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class AdminRssSettingsForm is the AdminRSS configuration form.
 */
class AdminRssSettingsForm extends ConfigFormBase {
  const FEED_PLUGIN = 'feed';

  /**
   * The query.factory service.
   *
   * @var \Drupal\Core\Entity\Query\QueryFactory
   */
  protected $entityQuery;

  /**
   * The router.route_provider service.
   *
   * @var \Drupal\Core\Routing\RouteProviderInterface
   */
  protected $routeProvider;

  /**
   * AdminRssSettingsForm constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   *   The config.factory service.
   * @param \Drupal\Core\Entity\Query\QueryFactory $entityQuery
   *   The query.factory service.
   * @param \Drupal\Core\Routing\RouteProviderInterface $routeProvider
   *   The router.route_provider service.
   */
  public function __construct(ConfigFactoryInterface $configFactory, QueryFactory $entityQuery, RouteProviderInterface $routeProvider) {
    parent::__construct($configFactory);
    $this->entityQuery = $entityQuery;
    $this->routeProvider = $routeProvider;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $configFactory = $container->get('config.factory');
    $entityQuery = $container->get('entity.query');
    $routeProvider = $container->get('router.route_provider');
    return new static($configFactory, $entityQuery, $routeProvider);
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      AdminRss::CONFIG,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'admin_rss_settings_form';
  }

  /**
   * Reducer: build all possible feed links for a given view.
   *
   * A view can expose multiple AdminRSS feeds, although none of the built-in
   * views do, so expose them all.
   *
   * @param array $carry
   *   A carry (accumulator) for links
   * @param \Drupal\views\Entity\View $view
   *   The view from which to fetch links
   * @param $token
   *   The current access token.
   *
   * @return array
   *   The resulting value for the carry.
   *
   * @see AdminRssSettingsForm::getFeedLinks()
   */
  public function linksFromView(array $carry, View $view, $token) {
    $tokenParam = ['adminrss_token' => $token];
    $displays = $view->get('display');
    $options = [
      'absolute' => TRUE,
      'attributes' => [],
    ];

    foreach ($displays as $displayId => $display) {
      if ($display['display_plugin'] !== static::FEED_PLUGIN) {
        continue;
      }

      // Assumes a single route will always match. Does it need more checks ?
      $path = $display['display_options']['path'];
      $routeCollection = $this->routeProvider->getRoutesByPattern($path);
      $routes = reset($routeCollection);
      $routeName = key($routes);

      $title = $display['display_title'];
      $options['attributes']['title'] = $display['display_options']['display_description'];

      $link = Link::createFromRoute($title, $routeName, $tokenParam, $options);
    }

    $carry[] = $link;
    return $carry;
  }

  /**
   * Get AdminRSS feed links.
   *
   * @param string $token
   *   The access token.
   *
   * @return array
   *   An array of links to each AdminRSS view.
   */
  public function getFeedLinks($token) {
    $viewIds = $this->entityQuery
      ->get('view')
      ->condition('tag', 'AdminRSS')
      ->execute();
    $views = View::loadMultiple($viewIds);

    $linkBuilder = function ($carry, View $view) use ($token) {
      return $this->linksFromView($carry, $view, $token);
    };
    $viewLinks = array_reduce($views, $linkBuilder, []);

    return $viewLinks;
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(AdminRss::CONFIG);
    $token = $config->get(AdminRss::TOKEN);
    $feedLinks = $this->getFeedLinks($token);

    $form[AdminRss::TOKEN] = array(
      '#default_value' => $token,
      '#description' => t('This is the token that will be required in order to get access to the AdminRSS feeds.'),
      '#maxlength' => 255,
      '#required' => TRUE,
      '#size' => 50,
      '#title' => $this->t('Admin RSS Token'),
      '#type' => 'textfield',
      '#weight' => -5,
    );

    if (!empty($feedLinks)) {
      $form['feeds'] = array(
        '#type' => 'details',
        '#title' => $this->t('Admin RSS Feeds locations'),
        '#description' => $this->t('Copy and paste these links to your RSS aggregator.'),
        '#open' => TRUE,
      );

      $form['feeds']['links'] = array(
        '#theme' => 'item_list',
        '#items' => $feedLinks,
      );
    }

    $form = parent::buildForm($form, $form_state);
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->configFactory()
      ->getEditable(AdminRss::CONFIG)
      ->set(AdminRss::TOKEN, $form_state->getValue(AdminRss::TOKEN))
      ->save();
  }

}
