<?php

namespace Drupal\ubc_content_items\Form;

use Drupal\Core\Database\Connection;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a form for deleting a Content Item revision.
 *
 * @ingroup ubc_content_items
 */
class ContentItemEntityRevisionDeleteForm extends ConfirmFormBase {


  /**
   * The Content Item revision.
   *
   * @var \Drupal\ubc_content_items\Entity\ContentItemEntityInterface
   */
  protected $revision;

  /**
   * The Content Item storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $ContentItemEntityStorage;

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $connection;

  /**
   * Constructs a new ContentItemEntityRevisionDeleteForm.
   *
   * @param \Drupal\Core\Entity\EntityStorageInterface $entity_storage
   *   The entity storage.
   * @param \Drupal\Core\Database\Connection $connection
   *   The database connection.
   */
  public function __construct(EntityStorageInterface $entity_storage, Connection $connection) {
    $this->ContentItemEntityStorage = $entity_storage;
    $this->connection = $connection;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $entity_manager = $container->get('entity_type.manager');
    return new static(
      $entity_manager->getStorage('content_item_entity'),
      $container->get('database')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'content_item_entity_revision_delete_confirm';
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return t('Are you sure you want to delete the revision from %revision-date?', ['%revision-date' => \Drupal::service('date.formatter')->format($this->revision->getRevisionCreationTime())]);
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('entity.content_item_entity.version_history', ['content_item_entity' => $this->revision->id()]);
  }

  /**
   * {@inheritdoc}
   */
  public function getConfirmText() {
    return t('Delete');
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $content_item_entity_revision = NULL) {
    if (!$this->ContentItemEntityStorage instanceof \Drupal\Core\Entity\RevisionableStorageInterface) {
      throw new \LogicException('The content_item_entity storage must implement RevisionableStorageInterface.');
    }
    $this->revision = $this->ContentItemEntityStorage->loadRevision($content_item_entity_revision);
    $form = parent::buildForm($form, $form_state);

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    if (!$this->ContentItemEntityStorage instanceof \Drupal\Core\Entity\RevisionableStorageInterface) {
      throw new \LogicException('The content_item_entity storage must implement RevisionableStorageInterface.');
    }
    $this->ContentItemEntityStorage->deleteRevision($this->revision->getRevisionId());

    $this->logger('content')->notice('Content Item: deleted %title revision %revision.', ['%title' => $this->revision->label(), '%revision' => $this->revision->getRevisionId()]);
    $this->messenger()->addStatus(t('Revision from %revision-date of Content Item %title has been deleted.', ['%revision-date' => \Drupal::service('date.formatter')->format($this->revision->getRevisionCreationTime()), '%title' => $this->revision->label()]));
    $form_state->setRedirect(
      'entity.content_item_entity.canonical',
      ['content_item_entity' => $this->revision->id()]
    );
    if ($this->connection->query('SELECT COUNT(DISTINCT vid) FROM {content_item_entity_field_revision} WHERE id = :id', [':id' => $this->revision->id()])->fetchField() > 1) {
      $form_state->setRedirect(
        'entity.content_item_entity.version_history',
        ['content_item_entity' => $this->revision->id()]
      );
    }
  }

}
