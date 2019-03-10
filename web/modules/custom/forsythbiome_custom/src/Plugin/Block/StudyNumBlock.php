<?php

namespace Drupal\forsythbiome_custom\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a block to manage the Study Numbers for a Participant.
 *
 * @Block(
 *   id = "studynumblock",
 *   admin_label = @Translation("Study Numbers Block"),
 * )
 */
class StudyNumBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {

    $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
    $name = $user->get('name')->value;
    $uid= $user->get('uid')->value;

    $displaytext = '<p>Username: ' .$name .'</p><p>User Id: ' .$uid .'</p>';
    $displayform = \Drupal::formBuilder()->getForm('Drupal\forsythbiome_custom\Form\StudyNumForm');

    return [
        //'#markup' => $this->t('This is a simple block!'),
        $displayform,
    ];

  }

  /**
   * {@inheritdoc}
   */
  protected function blockAccess(AccountInterface $account) {
    return AccessResult::allowedIfHasPermission($account, 'access content');
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $config = $this->getConfiguration();

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['studynum_block_settings'] = $form_state->getValue('studynum_block_settings');
  }
}