<?php

namespace Drupal\ubc_share_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'DefaultBlock' block.
 *
 * @Block(
 *  id = "default_block",
 *  admin_label = @Translation("Share block"),
 * )
 */
class DefaultBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [] + parent::defaultConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['platforms_to_share_with'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Platforms to share with'),
      '#description' => $this->t('Select the social media platforms you&#039;d like to use for sharing content from the widget.'),
      '#options' => [
        'twitter' => $this->t('Add a Twitter share link'),
        'facebook' => $this->t('Add a Facebook share link'),
        'linkedin' => $this->t('Add a Linkedin share link'),
        'reddit' => $this->t('Add a Reddit share link'),
        'email' => $this->t('Add an email share link'),
        'pinterest' => $this->t('Add a Pinterest share link'),
      ],
      '#default_value' => $this->configuration['platforms_to_share_with'],
      '#weight' => '10',
    ];
    $form['share_site_url'] = [
      '#type' => 'textfield',
      '#title' => $this-> t('The site url [format as: sitename.ubc.ca].'),
      '#description' =>  $this->t('Some description.'),
      '#default_value' => $this->configuration['share_site_url'],
      '#weight' => '11',
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['platforms_to_share_with'] = $form_state->getValue('platforms_to_share_with');
    $this->configuration['share_site_url'] = $form_state->getValue('share_site_url');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    // Do something.
    $config = $this->getConfiguration();
    return [
      '#description' => 'UBC Share buttons',
      '#theme' => 'ubc_share_block',
      '#twitter' => $config['platforms_to_share_with']['twitter'],
      '#facebook' => $config['platforms_to_share_with']['facebook'],
      '#pinterest' => $config['platforms_to_share_with']['pinterest'],
      '#linkedin' => $config['platforms_to_share_with']['linkedin'],
      '#reddit' => $config['platforms_to_share_with']['reddit'],
      '#email' => $config['platforms_to_share_with']['email'],
      '#share_site_url' => $config['share_site_url'],
    ];
  }

}
