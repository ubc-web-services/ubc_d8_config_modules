<?php

namespace Drupal\ubc_content_items;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Language\LanguageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\ubc_content_items\Entity\ContentItemEntityInterface;

/**
 * Defines the storage handler class for Content Item entities.
 *
 * This extends the base storage class, adding required special handling for
 * Content Item entities.
 *
 * @ingroup ubc_content_items
 */
class ContentItemEntityStorage extends SqlContentEntityStorage implements ContentItemEntityStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(ContentItemEntityInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {content_item_entity_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {content_item_entity_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(ContentItemEntityInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {content_item_entity_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('content_item_entity_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
