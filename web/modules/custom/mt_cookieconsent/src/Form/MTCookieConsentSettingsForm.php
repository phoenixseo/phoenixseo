<?php

namespace Drupal\mt_cookieconsent\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class MTCookieConsentSettingsForm.
 *
 * @package Drupal\mt_cookieconsent\Form
 *
 * @ingroup mt_cookieconsent
 */
class MTCookieConsentSettingsForm extends ConfigFormBase {

  /**
   * Returns a unique string identifying the form.
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'MTCookieConsent_settings';
  }

  /**
   * Form constructor.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return array
   *   The form structure.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $config = $this->config('mt_cookieconsent.settings');

    $form['theme_select'] = [
      '#title' => $this->t('Layout'),
      '#type' => 'select',
      '#options' => [
        'block' => 'block',
        'edgeless' => 'edgeless',
        'classic' => 'classic',
      ],
      '#required' => TRUE,
      '#default_value' => $config->get('theme_select', 1),
    ];
    $form['alert_message'] = [
      '#title' => $this->t('Message'),
      '#type' => 'textarea',
      '#required' => TRUE,
      '#default_value' => $config->get('alert_message', 1),
      '#placeholder' => $this->t('Enter the alert message.'),
    ];
    $form['target_url'] = [
      '#title' => $this->t('Target URL'),
      '#type' => 'url',
      '#required' => TRUE,
      '#default_value' => $config->get('target_url', 1),
      '#placeholder' => $this->t('Target URL'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * Form submission handler.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('mt_cookieconsent.settings')
      ->set('theme_select', $form_state->getValue('theme_select'))
      ->set('alert_message', $form_state->getValue('alert_message'))
      ->set('target_url', $form_state->getValue('target_url'))
      ->save();

    parent::submitForm($form, $form_state);

  }

  /**
   * Gets the configuration names that will be editable.
   *
   * @return array
   *   An array of configuration object names that are editable if called in
   *   conjunction with the trait's config() method.
   */
  protected function getEditableConfigNames() {
    return [
      'mt_cookieconsent.settings',
    ];
  }
}
