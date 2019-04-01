<?php

namespace Drupal\ubc_content_items;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Content Item entity.
 *
 * @see \Drupal\ubc_content_items\Entity\ContentItemEntity.
 */
class ContentItemEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\ubc_content_items\Entity\ContentItemEntityInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished content item entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published content item entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit content item entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete content item entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add content item entities');
  }

}
