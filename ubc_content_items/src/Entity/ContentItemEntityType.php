<?php

namespace Drupal\ubc_content_items\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Content Item type entity.
 *
 * @ConfigEntityType(
 *   id = "content_item_entity_type",
 *   label = @Translation("Content Item type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\ubc_content_items\ContentItemEntityTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\ubc_content_items\Form\ContentItemEntityTypeForm",
 *       "edit" = "Drupal\ubc_content_items\Form\ContentItemEntityTypeForm",
 *       "delete" = "Drupal\ubc_content_items\Form\ContentItemEntityTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\ubc_content_items\ContentItemEntityTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "content_item_entity_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "content_item_entity",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   revision_metadata_keys = {
 *     "revision_user" = "revision_user",
 *     "revision_created" = "revision_created",
 *     "revision_log_message" = "revision_log_message"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "description",
 *     "weight"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/content_item_entity_type/{content_item_entity_type}",
 *     "add-form" = "/admin/structure/content_item_entity_type/add",
 *     "edit-form" = "/admin/structure/content_item_entity_type/{content_item_entity_type}/edit",
 *     "delete-form" = "/admin/structure/content_item_entity_type/{content_item_entity_type}/delete",
 *     "collection" = "/admin/structure/content_item_entity_type"
 *   }
 * )
 */
class ContentItemEntityType extends ConfigEntityBundleBase implements ContentItemEntityTypeInterface {

  /**
   * The Content Item type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Content Item type label.
   *
   * @var string
   */
  protected $label;

}
