<?php

namespace Drupal\ubc_content_items\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ContentItemEntityTypeForm.
 */
class ContentItemEntityTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $content_item_entity_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $content_item_entity_type->label(),
      '#description' => $this->t("Label for the Content Item type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $content_item_entity_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\ubc_content_items\Entity\ContentItemEntityType::load',
      ],
      '#disabled' => !$content_item_entity_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $content_item_entity_type = $this->entity;
    $status = $content_item_entity_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Content Item type.', [
          '%label' => $content_item_entity_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Content Item type.', [
          '%label' => $content_item_entity_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($content_item_entity_type->toUrl('collection'));
  }

}
