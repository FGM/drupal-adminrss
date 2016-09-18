<?php

namespace Drupal\adminrss\Form;

use Drupal\adminrss\AdminRss;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;

/**
 * Class AdminRssSettingsForm is the AdminRSS configuration form.
 */
class AdminRssSettingsForm extends ConfigFormBase {

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
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(AdminRss::CONFIG);
    $token = $config->get(AdminRss::TOKEN);

    // Settings form is a good place to reset the implementations cache.
    $plugins = adminrss_get_feed_info(TRUE);

    $form[AdminRss::TOKEN] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Admin RSS Token'),
      '#required' => TRUE,
      '#description' => t('This is the token that will be required in order to get access to the AdminRSS feeds.'),
      '#size' => 50,
      '#maxlength' => 255,
      '#default_value' => $token,
      '#weight' => -5,
    );

    if (!empty($plugins)) {
      $form['feeds'] = array(
        '#type' => 'details',
        '#title' => $this->t('Admin RSS Feeds locations'),
        '#description' => $this->t('Copy and paste these links to your RSS aggregator.'),
      );
      $items = array();
      foreach ($plugins as $name => $plugin) {
        $items[] = Link::createFromRoute($plugin['title'], AdminRss::ROUTE_MAIN, [
          'feed' => $name,
          'token' => $token,
        ], [
          'absolute' => TRUE,
          'attributes' => [
            'title' => $plugin['description'],
          ],
        ]);
      }

      $form['feeds']['links'] = array(
        '#theme' => 'item_list',
        '#items' => $items,
      );

      $moduleHandler = \Drupal::moduleHandler();
      // Inject per-feed settings.
      foreach ($plugins as $name => $plugin) {
        if (!empty($plugin['configure'])) {
          $hook = "adminrss_feed_settings_{$name}";
          $form["{$name}-settings"] = array(
            '#type' => 'details',
            '#title' => $plugin['label'],
          ) + $moduleHandler->invokeAll($hook);
        }
      }
    }

    $form = parent::buildForm($form, $form_state);
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
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
