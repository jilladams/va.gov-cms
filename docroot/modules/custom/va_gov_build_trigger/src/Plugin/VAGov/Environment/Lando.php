<?php

namespace Drupal\va_gov_build_trigger\Plugin\VAGov\Environment;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\va_gov_build_trigger\Environment\EnvironmentPluginBase;
use Drupal\va_gov_build_trigger\Form\LandoBuildTriggerForm;
use Drupal\va_gov_build_trigger\WebBuildCommandBuilder;
use Drupal\va_gov_build_trigger\WebBuildStatusInterface;
use Drupal\va_gov_build_trigger\Command\CommandRunner;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Lando Plugin for Environment.
 *
 * @Environment(
 *   id = "lando",
 *   label = @Translation("Lando")
 * )
 */
class Lando extends EnvironmentPluginBase {
  use CommandRunner;
  use QueueHelper;

  /**
   * The queue storage manager.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $queueLoader;

  /**
   * {@inheritDoc}
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    LoggerInterface $logger,
    WebBuildStatusInterface $webBuildStatus,
    WebBuildCommandBuilder $webBuildCommandBuilder,
    EntityStorageInterface $queueLoader
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $logger, $webBuildStatus, $webBuildCommandBuilder);
    $this->queueLoader = $queueLoader;
  }

  /**
   * {@inheritDoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('logger.factory')->get('va_gov_build_trigger'),
      $container->get('va_gov.build_trigger.web_build_status'),
      $container->get('va_gov.build_trigger.web_build_command_builder'),
      $container->get('entity_type.manager')->getStorage('advancedqueue_queue')
    );
  }

  /**
   * {@inheritDoc}
   */
  public function triggerFrontendBuild(string $front_end_git_ref = NULL) : void {
    // phpcs:ignore
    // See issue https://github.com/department-of-veterans-affairs/va.gov-cms/issues/8796
    $message = $this->t('Build not dispatched because the content build is not currently working on ddev.');
    $this->messenger()->addStatus($message);
    $this->logger->info($message);
    return;

    /** @var \Drupal\advancedqueue\Entity\QueueInterface $queue */
    $queue = $this->queueLoader->load('command_runner');

    // A new command variable since the rebuild commands has been queued.
    $commands = $this->webBuildCommandBuilder->buildCommands($front_end_git_ref);
    $this->queueCommands($commands, $queue);

    $this->messenger()->addStatus('A request to rebuild the front end has been submitted.');
  }

  /**
   * {@inheritDoc}
   */
  public function contentEditsShouldTriggerFrontendBuild(): bool {
    return FALSE;
  }

  /**
   * {@inheritDoc}
   */
  public function getBuildTriggerFormClass() : string {
    return LandoBuildTriggerForm::class;
  }

}
