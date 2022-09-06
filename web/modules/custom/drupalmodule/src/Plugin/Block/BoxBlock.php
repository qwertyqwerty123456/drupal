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
use Drupal\file\Entity\File;
use Drupal\media\Entity\Media;

/**
 * Provides a block with header and text editor
 *
 * @Block(
 *   id = "bootcamp_box_block",
 *   admin_label = @Translation("bootcamp_box_block"),
 * )
 */
class BoxBlock extends BlockBase
{

    public const MINUTE_DIVIDER = 60;

    /**
     * Add fields from configuration to page
     *
     * {@inheritdoc}
     */
    public function build(): array
    {
        $config = $this->getConfiguration();

        $mediaBackgroundImage = Media::load($config['background_image']);
        $mediaHeaderImage = Media::load($config['header_image']);
        $backgroundImageId = $mediaBackgroundImage->getSource()->getSourceFieldValue($mediaBackgroundImage);
        $headerImageId = $mediaHeaderImage->getSource()->getSourceFieldValue($mediaHeaderImage);

        $lastUpdateInMinutes = floor((time() - $config['last_update']) / self::MINUTE_DIVIDER);

        return [
            '#background_image' =>
                [
                    'url' => (File::load($backgroundImageId))->getFileUri(),
                    'alt' => $mediaBackgroundImage->field_media_image->alt
                ],
            '#header_image' =>
                [
                    'url' => (File::load($headerImageId))->getFileUri(),
                    'alt' => $mediaHeaderImage->field_media_image->alt
                ],
            '#header' => $config['header'],
            '#description' => $config['description']['value'],
            '#last_update' => $lastUpdateInMinutes
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


        $form['background_image'] = [
            '#type' => 'media_library',
            '#allowed_bundles' => ['image'],
            '#title' => t('Background image'),
            '#default_value' => !empty($config['background_image'])
                ? $config['background_image']
                : [],
            '#weight' => 999,
        ];

        $form['header_image'] = [
            '#type' => 'media_library',
            '#allowed_bundles' => ['image'],
            '#title' => t('Header image'),
            '#default_value' => !empty($config['header_image'])
                ? $config['header_image']
                : [],
            '#weight' => 999,
        ];


        $form['header'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Header'),
            '#default_value' => $config['header'] ?? '',
        ];

        $form['description'] = [
            '#type' => 'text_format',
            '#allowed_formats' => ['restricted_html' => 'restricted_html'],
            '#title' => $this->t('Description'),
            '#default_value' => $config['description']['value'] ?? '',
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
        $this->configuration['description'] = $form_state->getValue('description');
        $this->configuration['background_image'] = $form_state->getValue('background_image');
        $this->configuration['header_image'] = $form_state->getValue('header_image');
        $this->configuration['last_update'] = time();
    }
}