<?php

namespace Drupal\drupalmodule\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class ThankYouPageSettingsForm extends ConfigFormBase
{

    public function getFormId(): string
    {
        return 'drupalmodule_admin_settings';
    }

    protected function getEditableConfigNames()
    {
        return [
            'drupalmodule.thankyou_page_settings_form',
        ];
    }


    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $config = $this->config('drupalmodule.thankyou_page_settings_form');

        $form['thank_text'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Текст'),
            '#default_value' => $config->get('thank_text'),
        );

        return parent::buildForm($form, $form_state);
    }


    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $this->configFactory->getEditable('drupalmodule.thankyou_page_settings_form')
            ->set('thank_text', $form_state->getValue('thank_text'))->save();

        parent::submitForm($form, $form_state);
    }
}