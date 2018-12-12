<?php

namespace Drupal\billing_info\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Re-populate a dropdown based on form state.
 */

 
class CouponForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'coupon_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['coupon'] = array(
      '#type' => 'textfield',
      '#title' => t('Coupon Code:'),
      '#required' => TRUE,
      '#ajax' => [
        'event' => 'change',
        'callback' => '::checkcoupon',
        'wrapper' => 'notify-box',
      ],
    );
    $form['container'] = [
      '#type' => 'container',
      '#attributes' => ['id' => 'notify-box'],
    ];
    $form['container']['box'] = [
      '#type' => 'markup',
      '#markup' => '',
    ];


    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#ajax' => [
        'callback' => '::promptCallback',
        'wrapper' => 'coupon-code',
      ],
      '#value' => $this->t('Apply Coupon'),
    ];
    return $form;
  }
  public function submitForm(array &$form, FormStateInterface $form_state) {
  }

  public function checkcoupon(array &$form, FormStateInterface $form_state) {
    // In most cases, it is recommended that you put this logic in form
    // generation rather than the callback. Submit driven forms are an
    // exception, because you may not want to return the form at all.
    $coupon=$form_state->getValue('coupon');
    $element = $form['container'];
    if($coupon=="First"){
      $element['box']['#markup'] = "Coupon valid";
    }
    else{
      $element['box']['#markup'] = "Coupon invalid, Enter Correct Coupon-code";
    }
    return $element;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
         $name = $form_state->getValue('coupon');
          if($coupon=="First"){
             $form_state->setErrorByName('Coupon', $this->t('Coupon is invalid'));
          }
         
    parent::validateForm($form, $form_state);
  }



  public function promptCallback(array &$form, FormStateInterface $form_state) {
    $coupon=$form_state->getValue('coupon');

    if($coupon=="First"){
      $a['coupon'] = array(
      '#type' => 'textfield',
      '#name' => 'coupon',
      '#attributes' => ['id' => 'coupon-code'],
      '#required' => TRUE,
      '#value' => $coupon,
      );  
    }
    else{
      $a['coupon'] = array(
      '#type' => 'textfield',
      '#name' => 'coupon',
      '#attributes' => ['id' => 'coupon-code'],
      '#required' => TRUE,
      );
    }
    return $a; 
    
  }
}

?>