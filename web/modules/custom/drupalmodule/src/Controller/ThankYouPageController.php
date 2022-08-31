<?php


/**
 * @return
 * Contains \Drupal\drupalmodule\Controller\ThankYouPageController.
 */

namespace Drupal\drupalmodule\Controller;

class ThankYouPageController
{
    public function content() 
    {
        $first_text='Спасибо за заявку!';
        $config = \Drupal::config('drupalmodule.thankyou_page_settings_form');
        $text = $config->get('thank_text');
        $val = $text ? $text : $first_text;
        $element = array(
            '#markup' => sprintf('<h2>%s</h2>',$val),
        );
        return $element;
    }

}