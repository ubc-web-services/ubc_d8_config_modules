<?php

namespace Drupal\ubc_content_items;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Content Item entities.
 *
 * @ingroup ubc_content_items
 */
class ContentItemEntityListBuilder extends EntityListBuilder {


  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Content Item ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\ubc_content_items\Entity\ContentItemEntity */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.content_item_entity.edit_form',
      ['content_item_entity' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
