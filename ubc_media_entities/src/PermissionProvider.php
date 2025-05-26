<?php

namespace Drupal\ubc_media_entities;

use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\media\Entity\MediaType;

/**
 * Provides dynamic permissions for media types.
 */
class PermissionProvider {
  use StringTranslationTrait;

  /**
   * Generates dynamic permissions for all media types.
   *
   * @return array
   *   An array of permissions.
   */
  public static function generateMediaPermissions() {
    $permissions = [];
    $media_types = MediaType::loadMultiple();

    foreach ($media_types as $media_type) {
      $type_id = $media_type->id();
      $type_label = $media_type->label();

      // Add 'view' permission for the media type.
      $permissions["view $type_id media"] = [
        'title' => t('View @type media', ['@type' => $type_label]),
        'description' => t('Allows users to view media of type @type.', ['@type' => $type_label]),
        'restrict access' => TRUE,
      ];

    }

    return $permissions;
  }

}
