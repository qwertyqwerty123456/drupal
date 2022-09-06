<?php

/**
 * @file
 * Contains \Drupal\bootcampmodule\Plugin\Block\TextBlock.
 */


namespace Drupal\bootcampmodule\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Access\AccessResultReasonInterface;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a block with header and text editor
 *
 * @Block(
 *   id = "bootcamp_text_block",
 *   admin_label = @Translation("bootcamp_text_block"),
 * )
 */
class TextBlock extends BlockBase
{
    /**
     * Add fields from configuration to page
     *
     * {@inheritdoc}
     */
    public function build(): array
    {
        $config = $this->getConfiguration();

        return [
            '#text' => $config['text'],
            '#header' => $config['header']
        ];
    }

    /**
     * Access settings
     *
     * {@inheritdoc}
     */
    protected function blockAccess(AccountInterface $account)
    {
        return AccessResult::allowedIfHasPermission($account, 'access content');
    }

    /**
     * Set fields in block settings page
     *
     * {@inheritdoc}
     */
    public function blockForm($form, FormStateInterface $form_state): array
    {
        $config = $this->getConfiguration();

        $form['header'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Header'),
            '#default_value' => $config['header'] ?? '',
        ];

        $form['text'] = [
            '#type' => 'text_format',
            '#allowed_formats' => ['restricted_html' => 'restricted_html'],
            '#title' => $this->t('Content'),
            '#default_value' => $config['text']['value'] ?? '',
        ];

        return $form;
    }

    /**
     * Action, when user save block configuration
     *
     * {@inheritdoc}
     */
    public function blockSubmit($form, FormStateInterface $form_state)
    {
        $this->configuration['header'] = $form_state->getValue('header');
        $this->configuration['text'] = $form_state->getValue('text');
    }
}