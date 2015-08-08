<?php

/**
 * @file
 * Contains \Drupal\hello_world\Form\HelloWorldConfigForm.
 */

namespace Drupal\hello_world\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\node\Entity\NodeType;

/**
 * Configure where you want to append "hello world".
 */
class HelloWorldConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return array('hello_world');
  }

  /**
   * {@inheritdoc}
   */
  public function getFormID() {
    return 'hello_world_hello_world_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $types = array();
    foreach (NodeType::loadMultiple() as $type) {
      $types[$type->get('type')] = $type->get('name');
    }

    $config = \Drupal::config('hello_world.settings');
    $form['types'] = array(
      '#type' => 'checkboxes',
      '#title' => t('Content types'),
      '#description' => t('Content types where you want to append \'Hello world\''),
      '#options' => $types,
      '#default_value' => $config->get('types'),
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = \Drupal::getContainer()->get('config.factory')->getEditable('hello_world.settings');
    $config->set('types', $form_state->getValue('types'))->save();

    parent::submitForm($form, $form_state);
  }

}
