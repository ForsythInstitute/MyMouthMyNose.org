<?php

/**
 * @file
 * Contains \Drupal\forsythbiome_custom\Form\StudyNumForm.
 *
 * Add a form to save Study Numbers
 */

namespace Drupal\forsythbiome_custom\Form;

use Drupal\Core\Form\FormBase;
//use Drupal\Core\Form\FormInterface;
use Drupal\Core\Form\FormStateInterface;
//use \Drupal\user\Entity\Role;
//use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
//use Symfony\Component\DependencyInjection\ContainerInterface;
//use \Drupal\webform\WebformSubmissionInterface;

class StudyNumForm extends FormBase {

  /**
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'studynumform';
  }

  /**
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state, $participants = NULL) {

    //Loop through the participants array
    //For each row add a "study number" field to the form


    //If a $sid is provided then enable the form and check to see if there is a StudyNum saved.

    if (!isset($sid)) {
      //No SID provided - disable this form
      $sid = null;

      // Set the studynum to default value
      $studynumset = null;
      $studynum = null;

    } else {
      //We have a SID - check for a StudyNum
//      $submission = \Drupal\webform\WebformSubmissionInterface::load($sid);
      $submission = \Drupal::entityTypeManager()->getStorage('webform_submission')->load($sid);
      $subdata = $submission->getData();
      if (isset($subdata['study_number']) && !empty($subdata['study_number'])) {
        $studynumset = true;
        $studynum = $subdata['study_number'];
      } else {
        $studynumset = false;
        $studynum = null;
      }
//      $studynum = _getParticipantWebformStudyNumber($sid);
    }

//    $form['submissionid'] = [
//        '#type' => 'item',
//        '#markup' => $sid,
//    ];

    //Set the Submission ID as a value on the Form State object
//    $form_state->set('submission_id', $sid);

    if ($studynumset) {
      $form['existing_study_num'] = [
          '#type' => 'item',
          '#markup' => $this->t('Found Study Num: ') .$subdata['study_number'],
      ];
    } else {
      $form['existing_study_num'] = [
          '#type' => 'item',
          '#markup' => $this->t('No Study Num Found.'),
      ];
    }
    $form['studynum'] = array(
        '#type' => 'textfield',
        '#title' => $this->t('Assign Study Number to Participant SID #' .$sid),
        '#size' => 10,
        '#maxlength' => 6,
        '#value' => $studynum
    );
    $form['show'] = array(
        '#type' => 'submit',
        '#value' => 'Save'
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {

//    if (strpos($form_state['values']['studynum'], '.com') === FALSE ) {
//      $this->setFormError('email', $form_state, $this->t('This is not a .com email address.'));
//    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state, $sid = NULL) {

    foreach ($form_state->getValues() as $key => $value) {
      drupal_set_message('[sid: ' .$form_state->get('submission_id') .'] ' .$key . ': ' . $value);
    }
  }

  /**
   *  Get Webform Submission Study Number value
   */
  function _getParticipantWebformStudyNumber($sid) {

    $submission = \Drupal\webform\WebformSubmissionInterface::load($sid);
    $subdata = $submission->getData();
    $studynumset = (isset($subdata['study_number']) && !empty($subdata['study_number'])) ? TRUE : FALSE;
    $studynum = $studynumset ? $subdata['study_number'] : null;

    return $studynum;
  }

}