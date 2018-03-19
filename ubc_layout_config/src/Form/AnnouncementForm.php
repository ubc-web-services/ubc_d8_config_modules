<?php

namespace Drupal\ubc_layout_config\Form;

use Drupal\Core\Form\ConfigFormBase;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\CloseModalDialogCommand;
use Drupal\Core\Ajax\HtmlCommand;

/**
 * Defines a form that configures forms module settings.
 */
class AnnouncementForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ubc_layout_config_announcement';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'ubc_layout_config.ubc_announcement_settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, Request $request = NULL) {
    $config = $this->config('ubc_layout_config.ubc_announcement_settings');
    $form['#prefix'] = '<div id="ubc-layout-modal-form">';
    $form['#suffix'] = '</div>';
    $form['your_message'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Your message'),
      '#default_value' => $config->get('your_message'),
    );

    // Select.
    $form['favorite'] = [
      '#type' => 'select',
      '#title' => $this->t('Favorite color'),
      '#options' => [
        'red' => $this->t('Red'),
        'blue' => $this->t('Blue'),
        'green' => $this->t('Green'),
      ],
      '#empty_option' => $this->t('-none-'),
      '#default_value' => $config->get('favorite'),
      //'#description' => $this->t('Select, #type = select'),
    ];

    // Radios.
    $form['is_active'] = [
      '#type' => 'radios',
      '#title' => t('Poll status'),
      '#options' => [0 => $this->t('Closed'), 1 => $this->t('Active')],
      '#default_value' => $config->get('is_active'),
      //'#description' => $this->t('Radios, #type = radios'),
    ];

    // CheckBoxes.
    $form['tests_taken'] = [
      '#type' => 'checkboxes',
      '#options' => ['SAT' => t('SAT'), 'ACT' => t('ACT')],
      '#title' => $this->t('What standardized tests did you take?'),
      '#default_value' => $config->get('tests_taken'),
      //'#description' => 'Checkboxes, #type = checkboxes',
    ];

    // Group submit handlers in an actions element with a key of "actions" so
    // that it gets styled correctly, and so that other modules may add actions
    // to the form.
    $form['actions'] = [
      '#type' => 'actions',
    ];

    // Add a submit button that handles the submission of the form.
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#ajax' => [
        'callback' => '::ajaxSubmitForm',
        'event' => 'click',
      ],
    ];

    //return parent::buildForm($form, $form_state);
    return $form;
  }


  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $this->config('ubc_layout_config.ubc_announcement_settings')
      ->set('your_message', $values['your_message'])
      ->set('favorite', $values['favorite'])
      ->set('is_active', $values['is_active'])
      ->set('tests_taken', $values['tests_taken'])
      ->save();
  }

  /**
   * Implements the submit handler for the ajax call.
   *
   * @param array $form
   *   Render array representing from.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Current form state.
   *
   * @return \Drupal\Core\Ajax\AjaxResponse
   *   Array of ajax commands to execute on submit of the modal form.
   */
   public function ajaxSubmitForm(array &$form, FormStateInterface $form_state) {
    
        // At this point the submit handler has fired.
        // Clear the message set by the submit handler.
        drupal_get_messages();
    
        // We begin building a new ajax reponse.
        $response = new AjaxResponse();
        if ($form_state->getErrors()) {
          unset($form['#prefix']);
          unset($form['#suffix']);
          $form['status_messages'] = [
            '#type' => 'status_messages',
            '#weight' => -10,
          ];
          $response->addCommand(new HtmlCommand('#ubc-layout-modal-form', $form));
        }
        else {
          $title = $form_state->getValue('your_message');
          $message = t('You specified a message of %title.', ['%title' => $title]);
          $content = [
            '#type' => 'html_tag',
            '#tag' => 'p',
            '#value' => $message,
          ];
          $response->addCommand(new HtmlCommand('#ubc-layout-message', $content));
          $response->addCommand(new CloseModalDialogCommand());
        }
        return $response;
      }

}
