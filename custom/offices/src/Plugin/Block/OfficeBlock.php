<?php

namespace Drupal\offices\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Views;
use Drupal\Core\Database\Database;

/**
 * Provides an 'Office' Block.
 *
 * @Block(
 *   id = "office_block",
 *   admin_label = @Translation("Office Block"),
 * )
 */
class OfficeBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->getConfiguration();
    $countries = !empty($config['countries']) ? $config['countries'] : [];
    $offices = $this->getOfficesByCountry($countries);
    return [
      '#theme' => 'officeBlock',
      '#content' => $offices,
      '#countries' => $countries,
      '#attached' => [
        'library' => [
          'offices/filter', // This will attach the custom JavaScript file
        ],
        'drupalSettings' => [
          'offices' => [
            'officesByCountry' => $offices,
          ],
        ],
      ],
    ];
  }
  protected function getOfficesByCountry($selected_countries) {
    $offices_by_country = [];
    if (empty($selected_countries)) {
      return $offices_by_country;
    }

    $database = \Drupal::database();
    $query = $database->select('offices', 'o')
      ->fields('o', ['county', 'name', 'address__value', 'phone', 'email'])
      ->condition('county', $selected_countries, 'IN')
      ->orderBy('county', 'ASC');
    $results = $query->execute();

    foreach ($results as $result) {
      $offices_by_country[$result->county][] = [
        'name' => $result->name,
        'address' => $result->address__value,
        'phone' => $result->phone,
        'email' => $result->email,
      ];
    }

    return $offices_by_country;
  }
  
  

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);
    $config = $this->getConfiguration();
    $options = $this->getCountryOptions();

    $form['countries'] = [
      '#type' => 'select',
      '#title' => $this->t('Countries'),
      '#description' => $this->t('Select one or more countries to filter offices.'),
      '#options' => $options,
      '#default_value' => isset($config['countries']) ? $config['countries'] : [],
      '#multiple' => TRUE,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->setConfigurationValue('countries', $form_state->getValue('countries'));
  }

  /**
   * Get options for the country select field.
   */
  protected function getCountryOptions() {
    $options = [];
    $database = Database::getConnection();
    $query = $database->select('offices', 'o')
      ->fields('o', ['county'])
      ->distinct()
      ->orderBy('county', 'ASC');
    $results = $query->execute();

    foreach ($results as $result) {
      $options[$result->county] = $result->county;
    }

    return $options;
  }
}
