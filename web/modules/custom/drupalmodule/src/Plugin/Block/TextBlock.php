<?php


namespace Drupal\drupalmodule\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

class TextBlock extends BlockBase
{

    public function build(): array
    {
        $config = $this->getConfiguration();

        return [
            '#header' => $config['header'],
            '#text' => $config['text']
            
        ];
    }

    protected function blockAccess(AccountInterface $account)
    {
        return AccessResult::allowedIfHasPermission($account, 'access content');
    }

    public function blockForm($form, FormStateInterface $form_state): array
    {
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

    public function blockSubmit($form, FormStateInterface $form_state)
    {
        $this->configuration['header'] = $form_state->getValue('header');
        $this->configuration['text'] = $form_state->getValue('text');
    }
}