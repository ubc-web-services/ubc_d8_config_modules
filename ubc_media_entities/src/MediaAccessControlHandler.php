<?php

namespace Drupal\ubc_media_entities;

use Drupal\media\MediaAccessControlHandler as CoreMediaAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access control handler for media entities.
 */
class MediaAccessControlHandler extends CoreMediaAccessControlHandler
{

    /**
     * {@inheritdoc}
     */
    protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account)
    {
        // Check if the operation is 'view'.
        if ($operation === 'view') {
            // Example: Restrict 'view' based on media type and a custom permission.
            $media_type = $entity->bundle();
            if ($account->hasPermission("view $media_type media")) {
                return AccessResult::allowed();
            }
            else {
                return AccessResult::forbidden();
            }
        }

        // For other operations, fall back to the parent handler.
        return parent::checkAccess($entity, $operation, $account);
    }

    /**
     * {@inheritdoc}
     */
    protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = null)
    {
        // Allow creation of media if the user has a specific permission.
        return AccessResult::allowedIfHasPermission($account, "create $entity_bundle media");
    }
}
