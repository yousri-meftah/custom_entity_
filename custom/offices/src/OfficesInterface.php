<?php

declare(strict_types=1);

namespace Drupal\offices;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining an offices entity type.
 */
interface OfficesInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
