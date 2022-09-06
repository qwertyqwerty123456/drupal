<?php

namespace Drupal\drupalmodule\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a block with a simple text.
 *
 * @Block(
 *   id = "drupalbook_text_block_block",
 *   admin_label = @Translation("Textblock"),
 * )
 */
class TextBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->getConfiguration();

    return [
        '#header' => $config['header'],
        '#text' => $config['text']
        
    ];
  }

  /**
   * {@inheritdoc}
   */
  protected function blockAccess(AccountInterface $account) {
    return AccessResult::allowedIfHasPermission($account, 'access content');
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $config = $this->getConfiguration();

    $form['header'] = [
        '#type' => 'textfield',
        '#title' => $this->t('header'),
        '#default_value' => $config['header'] ?? '',
    ];

    $form['text'] = [
        '#type' => 'text_format',
        '#allowed_formats' => ['basic_html' => 'basic_html'],
        '#title' => $this->t('Content'),
        '#default_value' => isset($config['text']['value']) ? $config['text']['value'] : '',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['header'] = $form_state->getValue('header');
    $this->configuration['text'] = $form_state->getValue('text');
  }
}