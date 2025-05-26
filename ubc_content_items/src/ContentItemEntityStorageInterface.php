<?php

namespace Drupal\ubc_content_items;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface ContentItemEntityStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Content Item revision IDs for a specific Content Item.
   *
   * @param \Drupal\ubc_content_items\Entity\ContentItemEntityInterface $entity
   *   The Content Item entity.
   *
   * @return int[]
   *   Content Item revision IDs (in ascending order).
   */
  public function revisionIds(ContentItemEntityInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Content Item author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Content Item revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\ubc_content_items\Entity\ContentItemEntityInterface $entity
   *   The Content Item entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(ContentItemEntityInterface $entity);

  /**
   * Unsets the language for all Content Item with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
