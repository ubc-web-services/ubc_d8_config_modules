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
class HomepageForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ubc_layout_config_homepage';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'ubc_layout_config.ubc_homepage_settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, Request $request = NULL) {
    $config = $this->config('ubc_layout_config.ubc_homepage_settings');
    $form['#prefix'] = '<div id="ubc-layout-modal-form">';
    $form['#suffix'] = '</div>';

    // Select.
    $form['layout'] = [
      '#type' => 'select',
      '#title' => $this->t('Choose a layout for the homepage'),
      '#options' => [
        'classic' => $this->t('Classic CLF'),
        'stacked' => $this->t('Stacked Content regions'),
        'parallax' => $this->t('Parallax Content regions'),
      ],
      '#empty_option' => $this->t('-choose a layout-'),
      '#default_value' => $config->get('layout'),
    ];

    $form['styles'] = [
      '#type' => 'details',
      '#title' => t('Style Settings'),
    ];

    // Primary Colour.
    $form['styles']['colour_primary'] = array(
      '#type' => 'color',
      '#title' => $this->t('Primary Colour'),
      '#default_value' => $config->get('colour_primary'),
      '#description' => $this->t('The primary theme colour. This is usually determined by the colour the unit uses to identify itself.'),
    );

     // Secondary Colour.
     $form['styles']['colour_secondary'] = array(
      '#type' => 'color',
      '#title' => $this->t('Secondary Colour'),
      '#default_value' => $config->get('colour_secondary'),
      '#description' => $this->t('The secondary theme colour. This should be complementary to the primary colour and will be used as an accent.'),
    );

    // Button Styles.
    $form['styles']['button_style'] = [
      '#type' => 'radios',
      '#title' => t('Button Style'),
      '#options' => [
        0 => $this->t('<button class="normal-button">Normal Button</button>'),
        1 => $this->t('<button class="strange-button">Strange Button</button>'),
        2 => $this->t('<button class="other-button">Other Button</button>'),
        3 => $this->t('<button class="weird-button">Weird Button</button>')
      ],
      '#default_value' => $config->get('button_style'),
    ];
    
    // Text.
    $form['styles']['your_message'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Your message'),
      '#default_value' => $config->get('your_message'),
      '#description' => $this->t('Some text.'),
    );

    // Select.
    $form['styles']['favorite'] = [
      '#type' => 'select',
      '#title' => $this->t('Favorite color'),
      '#options' => [
        'red' => $this->t('Red'),
        'blue' => $this->t('Blue'),
        'green' => $this->t('Green'),
      ],
      '#empty_option' => $this->t('-none-'),
      '#default_value' => $config->get('favorite'),
    ];

    // Radios.
    $form['is_active'] = [
      '#type' => 'radios',
      '#title' => t('Poll status'),
      '#options' => [0 => $this->t('Closed'), 1 => $this->t('Active')],
      '#default_value' => $config->get('is_active'),
    ];

    // CheckBoxes.
    $form['tests_taken'] = [
      '#type' => 'checkboxes',
      '#options' => ['SAT' => t('SAT '), 'ACT' => t('ACT')],
      '#title' => $this->t('What standardized tests did you take?'),
      '#default_value' => $config->get('tests_taken'),
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
    $this->config('ubc_layout_config.ubc_homepage_settings')
      ->set('layout', $values['layout'])
      ->set('your_message', $values['your_message'])
      ->set('button_style', $values['button_style'])
      ->set('colour_primary', $values['colour_primary'])
      ->set('colour_secondary', $values['colour_secondary'])
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
      $layout = $form_state->getValue('layout');
      $layout_class = 'layout_is_' . $layout;
      $message = t('You specified a message of %title.', ['%title' => $title]);
      $layout_choice = t(' Your homepage will be displayed in a %layout layout.', ['%layout' => $layout]);
      $content = [
        '#type' => 'html_tag',
        '#tag' => 'p',
        '#value' => $message . $layout_choice,
      ];
      $response->addCommand(new HtmlCommand('#ubc-layout-message', $content));
      $response->addCommand(new HtmlCommand('#ubc-layout-preview', $layout_class));
      $response->addCommand(new CloseModalDialogCommand());
    }
    return $response;
  }
}
