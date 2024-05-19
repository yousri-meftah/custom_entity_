<?php

namespace Drupal\offices\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

class OfficesForm extends ContentEntityForm {

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);

    return $form;
  }

  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;
    $status = $entity->save();

    if ($status) {
      $this->messenger()->addMessage($this->t('Saved the %label Office.', ['%label' => $entity->label()]));
    } else {
      $this->messenger()->addMessage($this->t('The %label Office was not saved.', ['%label' => $entity->label()]));
    }

    $form_state->setRedirect('entity.offices.collection');
  }
}
