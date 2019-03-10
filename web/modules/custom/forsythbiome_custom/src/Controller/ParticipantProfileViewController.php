<?php

namespace Drupal\forsythbiome_custom\Controller;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\Controller\EntityViewController;
use Drupal\profile\Controller\ProfileViewController;

/**
 * Defines a controller to render a single profile entity.
 */
class ParticipantProfileViewController extends ProfileViewController {

  /**
   * {@inheritdoc}
   */
  public function view(EntityInterface $profile, $view_mode = 'full', $langcode = NULL) {
    $build = [
        'profiles' => \Drupal::entityTypeManager()
            ->getViewBuilder($profile->getEntityTypeId())
            ->view($profile, $view_mode, $langcode),
    ];
    $build['#title'] = $profile->label();

    foreach ($profile->uriRelationships() as $rel) {
      // Set the profile path as the canonical URL to prevent duplicate content.
      $build['#attached']['html_head_link'][] = [
          [
              'rel' => $rel,
              'href' => $profile->toUrl($rel)->toString(),
          ],
          TRUE,
      ];

      if ($rel == 'canonical') {
        // Set the non-aliased canonical path as a default shortlink.
        $build['#attached']['html_head_link'][] = [
            [
                'rel' => 'shortlink',
                'href' => $profile->toUrl($rel, ['alias' => TRUE])->toString(),
            ],
            TRUE,
        ];
      }
      // NEW STUFF HERE
      $build['#attached']['#participants']['adult'] = null;
      $build['#attached']['#participants']['children'][0] = null;
    }
    return $build;
  }

}
