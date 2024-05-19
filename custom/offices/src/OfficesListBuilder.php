<?php

namespace Drupal\offices;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;

class OfficesListBuilder extends EntityListBuilder {

  public function buildHeader() {
    $header['name'] = $this->t('Office Name');
    $header['county'] = $this->t('County');
    $header['address'] = $this->t('Address');
    $header['phone'] = $this->t('Phone');
    $header['email'] = $this->t('Email');
    return $header + parent::buildHeader();
  }

  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\offices\Entity\Offices */
    $row['name'] = $entity->toLink();
    $row['county'] = $entity->get('county')->value;
    $row['address'] = $entity->get('address')->value;
    $row['phone'] = $entity->get('phone')->value;
    $row['email'] = $entity->get('email')->value;
    return $row + parent::buildRow($entity);
  }
}
