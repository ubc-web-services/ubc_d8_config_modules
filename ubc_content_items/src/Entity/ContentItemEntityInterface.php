<?php

namespace Drupal\ubc_content_items\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Content Item entities.
 *
 * @ingroup ubc_content_items
 */
interface ContentItemEntityInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Content Item name.
   *
   * @return string
   *   Name of the Content Item.
   */
  public function getName();

  /**
   * Sets the Content Item name.
   *
   * @param string $name
   *   The Content Item name.
   *
   * @return \Drupal\ubc_content_items\Entity\ContentItemEntityInterface
   *   The called Content Item entity.
   */
  public function setName($name);

  /**
   * Gets the Content Item creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Content Item.
   */
  public function getCreatedTime();

  /**
   * Sets the Content Item creation timestamp.
   *
   * @param int $timestamp
   *   The Content Item creation timestamp.
   *
   * @return \Drupal\ubc_content_items\Entity\ContentItemEntityInterface
   *   The called Content Item entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Content Item published status indicator.
   *
   * Unpublished Content Item are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Content Item is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Content Item.
   *
   * @param bool $published
   *   TRUE to set this Content Item to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\ubc_content_items\Entity\ContentItemEntityInterface
   *   The called Content Item entity.
   */
  public function setPublished($published);

  /**
   * Gets the Content Item revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Content Item revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\ubc_content_items\Entity\ContentItemEntityInterface
   *   The called Content Item entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Content Item revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Content Item revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\ubc_content_items\Entity\ContentItemEntityInterface
   *   The called Content Item entity.
   */
  public function setRevisionUserId($uid);

}
