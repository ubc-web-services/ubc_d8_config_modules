<?php

/**
 * @file
 * Contains \Drupal\ubc_layout_config\Controller\Overview.
 */

namespace Drupal\ubc_layout_config\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;

/**
 * Overview page controller for drupal.
 */
class Overview extends ControllerBase {

  /**
   * Lists the options provided by ubc_layout_config.
   */
  public function description() {
    // This library is required to facilitate the ajax modal form demo.
    $content['#attached']['library'][] = 'core/drupal.dialog.ajax';
    $content['intro'] = [
      '#markup' => '<p>' . $this->t('Settings to adjust the presentation of the Drupal content layouts.') . '</p>',
    ];

    // Create a list of links to the form examples.
    $content['links'] = [
      '#theme' => 'item_list',
      '#items' => [
        /*
        Link::createFromRoute($this->t('Simple Form'), 'fapi_example.simple_form'),
        */
        // Attributes are used by the core dialog libraries to invoke the modal.
        Link::createFromRoute(
          $this->t('General Settings'),
          'ubc_layout_config.ubc_general_settings',
           [],
           [
             'attributes' => [
               'class' => ['use-ajax'],
               'data-dialog-type' => 'modal',
               'data-dialog-options' => json_encode(array(
                'width' => 600,
              ))
             ],
           ]
        ),
        Link::createFromRoute(
          $this->t('Home Page Settings'),
          'ubc_layout_config.ubc_homepage_settings',
           [],
           [
             'attributes' => [
               'class' => ['use-ajax'],
               'data-dialog-type' => 'modal',
               'data-dialog-options' => json_encode(array(
                'width' => 600,
              ))
             ],
           ]
        ),
        Link::createFromRoute(
          $this->t('Landing Page Settings'),
          'ubc_layout_config.ubc_landing_page_settings',
           [],
           [
             'attributes' => [
               'class' => ['use-ajax'],
               'data-dialog-type' => 'modal',
               'data-dialog-options' => json_encode(array(
                'width' => 600,
              ))
             ],
           ]
        ),
        Link::createFromRoute(
          $this->t('Announcement Settings'),
          'ubc_layout_config.ubc_announcement_settings',
           [],
           [
             'attributes' => [
               'class' => ['use-ajax'],
               'data-dialog-type' => 'modal',
               'data-dialog-options' => json_encode(array(
                'width' => 600,
              ))
             ],
           ]
        ),
        Link::createFromRoute(
          $this->t('Page Settings'),
          'ubc_layout_config.ubc_page_settings',
           [],
           [
             'attributes' => [
               'class' => ['use-ajax'],
               'data-dialog-type' => 'modal',
               'data-dialog-options' => json_encode(array(
                'width' => 600,
              ))
             ],
           ]
        ),
      ],
    ];

    // The message container is used by the modal form example. It is an empty
    // tag that will be replaced by content.
    $content['message'] = [
      '#type' => 'container',
      '#attributes' => ['id' => 'ubc-layout-message'],
    ];
    // The message container is used to display a sample with the selected options
    // applied. It is an empty tag that will be replaced by content.
    $content['preview'] = [
      '#type' => 'container',
      '#attributes' => ['id' => 'ubc-layout-preview'],
    ];
    return $content;
  }

}
