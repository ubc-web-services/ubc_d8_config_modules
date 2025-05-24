<?php

namespace Drupal\ubc_content_items\Controller;

use Drupal\Core\Link;
use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\ubc_content_items\Entity\ContentItemEntityInterface;
use Drupal\Core\Entity\RevisionableStorageInterface;

/**
 * Class ContentItemEntityController.
 *
 *  Returns responses for Content Item routes.
 */
class ContentItemEntityController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Content Item  revision.
   *
   * @param int $content_item_entity_revision
   *   The Content Item  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($content_item_entity_revision) {
    $storage = \Drupal::service('entity_type.manager')->getStorage('content_item_entity');
    if (!$storage instanceof RevisionableStorageInterface) {
      throw new \LogicException('Storage for content_item_entity must implement RevisionableStorageInterface.');
    }
    $content_item_entity = $storage->loadRevision($content_item_entity_revision);
    $view_builder = \Drupal::service('entity_type.manager')->getViewBuilder('content_item_entity');

    return $view_builder->view($content_item_entity);
  }

  /**
   * Page title callback for a Content Item  revision.
   *
   * @param int $content_item_entity_revision
   *   The Content Item  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($content_item_entity_revision) {
    $storage = \Drupal::service('entity_type.manager')->getStorage('content_item_entity');
    if (!$storage instanceof RevisionableStorageInterface) {
      throw new \LogicException('Storage for content_item_entity must implement RevisionableStorageInterface.');
    }
    $content_item_entity = $storage->loadRevision($content_item_entity_revision);
    return $this->t('Revision of %title from %date', ['%title' => $content_item_entity->label(), '%date' => \Drupal::service('date.formatter')->format($content_item_entity->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Content Item .
   *
   * @param \Drupal\ubc_content_items\Entity\ContentItemEntityInterface $content_item_entity
   *   A Content Item  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(ContentItemEntityInterface $content_item_entity) {
    $account = $this->currentUser();
    $langcode = $content_item_entity->language()->getId();
    $langname = $content_item_entity->language()->getName();
    $languages = $content_item_entity->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $storage = \Drupal::service('entity_type.manager')->getStorage('content_item_entity');
    if (!$storage instanceof RevisionableStorageInterface) {
      throw new \LogicException('Storage for content_item_entity must implement RevisionableStorageInterface.');
    }
    $content_item_entity_storage = $storage;

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $content_item_entity->label()]) : $this->t('Revisions for %title', ['%title' => $content_item_entity->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all content item revisions") || $account->hasPermission('administer content item entities')));
    $delete_permission = (($account->hasPermission("delete all content item revisions") || $account->hasPermission('administer content item entities')));

    $rows = [];

    $vids = $content_item_entity_storage->revisionIds($content_item_entity);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\ubc_content_items\ContentItemEntityInterface $revision */
      $revision = $content_item_entity_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $content_item_entity->getRevisionId()) {
          $link = Link::fromTextAndUrl($date, new Url('entity.content_item_entity.revision', ['content_item_entity' => $content_item_entity->id(), 'content_item_entity_revision' => $vid]));
        }
        else {
          $link = $content_item_entity->toLink($date)->toString();
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => \Drupal::service('renderer')->renderInIsolation($username),
              'message' => ['#markup' => $revision->getRevisionLogMessage(), '#allowed_tags' => Xss::getHtmlTagList()],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => $has_translations ?
              Url::fromRoute('entity.content_item_entity.translation_revert', ['content_item_entity' => $content_item_entity->id(), 'content_item_entity_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.content_item_entity.revision_revert', ['content_item_entity' => $content_item_entity->id(), 'content_item_entity_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.content_item_entity.revision_delete', ['content_item_entity' => $content_item_entity->id(), 'content_item_entity_revision' => $vid]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['content_item_entity_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
