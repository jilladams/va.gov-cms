<?php

namespace Drupal\va_gov_build_trigger\Service;

use Drupal\advancedqueue\Entity\QueueInterface;
use Drupal\advancedqueue\Job;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\State\StateInterface;

/**
 * BuildRequester service.
 */
class BuildRequester implements BuildRequesterInterface {

  public const VA_GOV_FRONTEND_VERSION = 'va_gov_build_trigger.frontend_version';

  /**
   * The content release queue entity.
   *
   * @var QueueInterface
   */
  protected $buildQueue;

  /**
   * The state management service.
   *
   * @var StateInterface
   */
  protected $state;

  /**
   * Construct a new BuildRequester.
   *
   * @param EntityTypeManagerInterface $entityTypeManager
   *   The entity_type.manager service.
   * @param StateInterface $state
   *   The state service.
   */
  public function __construct(EntityTypeManagerInterface $entityTypeManager, StateInterface $state) {
    $this->state = $state;
    $this->buildQueue = $entityTypeManager
      ->getStorage('advancedqueue_queue')
      ->load('content_release');
  }

  /**
   * {@inheritDoc}
   */
  public function requestFrontendBuild(string $reason) : void {
    $job = Job::create('va_gov_content_release_request', ['reason' => $reason]);
    $this->buildQueue->enqueueJob($job);
  }

  /**
   * {@inheritDoc}
   */
  public function switchFrontendVersion(string $commitish) : void {
    $this->state->set(self::VA_GOV_FRONTEND_VERSION, $commitish);
  }

  /**
   * {@inheritDoc}
   */
  public function resetFrontendVersion() : void {
    $this->state->delete(self::VA_GOV_FRONTEND_VERSION);
  }
}
