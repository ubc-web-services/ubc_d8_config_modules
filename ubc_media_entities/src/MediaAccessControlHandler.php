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
            // Dynamically check permission based on media type.
            $media_type = $entity->bundle();
            $permission = "view $media_type media";

            // Grant access if the user has the permission.
            return AccessResult::allowedIfHasPermission($account, $permission);
        }

        // Fallback to parent handler for other operations.
        return parent::checkAccess($entity, $operation, $account);
    }

}
