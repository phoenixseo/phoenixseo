<?php

namespace Drupal\mt_countdown\Form;

use Drupal;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class MTCountDownSettingsForm.
 *
 * @package Drupal\mt_countdown\Form
 *
 * @ingroup mt_countdown
 */
class MTCountDownSettingsForm extends ConfigFormBase {

  /**
   * Returns a unique string identifying the form.
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'MTCountDown_settings';
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

    $config = $this->config('mt_countdown.settings');
    $date = $config->get('expiration_date');
    $date_time = date("Y-m-d H:i:s", strtotime($date));

    $form['title'] = [
      '#title' => $this->t('Title'),
      '#type' => 'textfield',
      '#required' => TRUE,
      '#default_value' => $config->get('title'),
    ];
    $form['prompt_message'] = [
      '#title' => $this->t('Message'),
      '#type' => 'textarea',
      '#required' => TRUE,
      '#default_value' => $config->get('prompt_message'),
      '#placeholder' => $this->t('Enter the prompt message.'),
    ];
    $form['days_to'] = [
      '#title' => $this->t('Days To'),
      '#type' => 'textfield',
      '#required' => TRUE,
      '#default_value' => $config->get('days_to'),
    ];
    $form['expiration_date'] = [
      '#title' => $this->t('Expiration Date'),
      '#type' => 'datetime',
      '#required' => TRUE,
      '#date_date_format' => 'Y-m-d',
      '#date_time_format' => 'H:i:s',
      '#default_value' => DrupalDateTime::createFromFormat('Y-m-d H:i:s', $date_time, 'UTC'),
    ];
    $form['target_url'] = [
      '#title' => $this->t('Target URL'),
      '#type' => 'url',
      '#required' => TRUE,
      '#default_value' => $config->get('target_url'),
      '#placeholder' => $this->t('Target URL'),
    ];
    $form['dismiss_text'] = [
      '#title' => $this->t('Dismiss button text'),
      '#type' => 'textfield',
      '#required' => TRUE,
      '#default_value' => $config->get('dismiss_text'),
      '#placeholder' => $this->t('Got it!'),
    ];
    $form['inject_in_the_body'] = [
      '#prefix' => $this->t('Inject in the body'),
      '#type' => 'checkbox',
      '#required' => FALSE,
      '#default_value' => $config->get('inject_in_the_body'),
      '#suffix' => $this->t('Inject the count down component in the body element of the front page'),
    ];
    $form['predefined_palettes'] = [
      '#title' => $this->t('Choose a colour theme'),
      '#type' => 'select',
      '#required' => FALSE,
      '#default_value' => $config->get('predefined_palettes'),
      '#options' => [
        0 => $this->t('Theme'),
        1 => $this->t('Custom'),
        2 => $this->t('Dark Yellow'),
        3 => $this->t('Light Green'),
        4 => $this->t('Dark Green'),
      ],
    ];
    $form['background'] = [
      '#prefix' => $this->t('<strong>Create your own Pallete</strong>'),
      '#title' => $this->t('Background'),
      '#type' => 'color',
      '#required' => FALSE,
      '#default_value' => $config->get('background'),
    ];
    $form['title_color'] = [
      '#title' => $this->t('Title'),
      '#type' => 'color',
      '#required' => FALSE,
      '#default_value' => $config->get('title_color'),
    ];
    $form['message_color'] = [
      '#title' => $this->t('Message'),
      '#type' => 'color',
      '#required' => FALSE,
      '#default_value' => $config->get('message_color'),
    ];
    $form['notes_color'] = [
      '#title' => $this->t('Notes'),
      '#type' => 'color',
      '#required' => FALSE,
      '#default_value' => $config->get('notes_color'),
    ];
    $form['button_background'] = [
      '#title' => $this->t('Button colour'),
      '#type' => 'color',
      '#required' => FALSE,
      '#default_value' => $config->get('button_background'),
    ];
    $form['button_color'] = [
      '#title' => $this->t('Button text'),
      '#type' => 'color',
      '#required' => FALSE,
      '#default_value' => $config->get('button_color'),
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
    $this->config('mt_countdown.settings')
      ->set('title', $form_state->getValue('title'))
      ->set('prompt_message', $form_state->getValue('prompt_message'))
      ->set('days_to', $form_state->getValue('days_to'))
      ->set('expiration_date', $form_state->getValue('expiration_date')->format("Y-m-d H:i:s"))
      ->set('target_url', $form_state->getValue('target_url'))
      ->set('dismiss_text', $form_state->getValue('dismiss_text'))
      ->set('inject_in_the_body', $form_state->getValue('inject_in_the_body'))
      ->set('predefined_palettes', $form_state->getValue('predefined_palettes'))
      ->set('background', $form_state->getValue('background'))
      ->set('title_color', $form_state->getValue('title_color'))
      ->set('message_color', $form_state->getValue('message_color'))
      ->set('notes_color', $form_state->getValue('notes_color'))
      ->set('button_background', $form_state->getValue('button_background'))
      ->set('button_color', $form_state->getValue('button_color'))
      ->save();

    // Clear routing and links cache.
    Drupal::service("router.builder")->rebuild();

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
      'mt_countdown.settings',
    ];
  }
}
