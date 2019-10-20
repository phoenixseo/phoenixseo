<?php
namespace Drupal\mt_countdown\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'MTCountDown' Block.
 *
 * @Block(
 *   id = "mt_countdown",
 *   admin_label = @Translation("Count Down"),
 *   category = @Translation("More than Themes"),
 * )
 */
class MTCountDownBlock extends BlockBase implements BlockPluginInterface {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = \Drupal::config('mt_countdown.settings');
    $data = [];
    $data['title'] = $config->get('title');
    $data['prompt_message'] = $config->get('prompt_message');
    $data['days_to'] = $config->get('days_to');
    $data['target_url'] = $config->get('target_url');
    $data['dismiss_text'] = $config->get('dismiss_text');
    // Theme settings.
    $predefined_palettes = $config->get('predefined_palettes');
    switch ($predefined_palettes) {
      case 0:
        $predefined_palettes = '';
        break;

      case 1:
        $predefined_palettes = 'custom-theme';
        break;

      case 2:
        $predefined_palettes = 'dark-yellow';
        break;

      case 3:
        $predefined_palettes = 'light-green';
        break;

      case 4:
        $predefined_palettes = 'dark-green';
        break;
    }
    $data['predefined_palettes'] = $predefined_palettes ? $predefined_palettes : 'mt-count-down-theme';
    // Color settings.
    $data['background'] = $config->get('background');
    $data['title_color'] = $config->get('title_color');
    $data['message_color'] = $config->get('message_color');
    $data['notes_color'] = $config->get('notes_color');
    $data['button_background'] = $config->get('button_background');
    $data['button_color'] = $config->get('button_color');
    return [
      '#theme' => 'mt_countdown',
      '#data' => $data,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $config = $this->getConfiguration();

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['mt_countdown_block_settings'] = $form_state->getValue('mt_countdown_block_settings');
  }
}
