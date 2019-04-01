<?php

namespace Drupal\ubc_content_items\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Content Item entities.
 */
class ContentItemEntityViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.

    return $data;
  }

}
