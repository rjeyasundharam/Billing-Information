<?php
namespace Drupal\billing_info\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;
/**
 * Class MydataForm.
 *
 * @package Drupal\mydata\Form
 */
class BillingInformationForm extends FormBase {
/**
   * {@inheritdoc}
   */
  public $coupon_code;

  public function getFormId() {
    return 'my_form';
  }
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $conn = Database::getConnection();
     $record = array();
    if (isset($_GET['num'])) {
        $query = $conn->select('billing_info', 'm')
            ->condition('user_id', $_GET['num'])
            ->fields('m');
        $record = $query->execute()->fetchAssoc();
    }
    
    $form['first_name'] = array(
      '#type' => 'textfield',
      '#title' => t('First Name'),
      '#required' => TRUE,
       //'#default_values' => array(array('id')),
      '#default_value' => (isset($record['first_name']) && $_GET['num']) ? $record['first_name']:'',
      );
    $form['second_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Second Name'),
      '#required' => TRUE,
       //'#default_values' => array(array('id')),
      '#default_value' => (isset($record['second_name']) && $_GET['num']) ? $record['second_name']:'',
      );
    $form['coupon'] = array(
      '#type' => 'textfield',
      '#title' => t('Coupon'),
      '#attributes' => ['id' => 'coupon-code'],
      '#required' => TRUE,
      );
    $form['submit'] = [
        '#type' => 'submit',
        '#value' => 'save',
        //'#value' => t('Submit'),
    ];
    return $form;
  }

  /**
    * {@inheritdoc}
    */
  public function validateForm(array &$form, FormStateInterface $form_state) {
         $name = $form_state->getValue('first_name');
          if(preg_match('/[^A-Za-z]/', $name)) {
             $form_state->setErrorByName('first_name', $this->t('your name must in characters without space'));
          }
          if(preg_match('/[^A-Za-z]/', $name)) {
             $form_state->setErrorByName('second_name', $this->t('your name must in characters without space'));
          }
    parent::validateForm($form, $form_state);
  }
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $field=$form_state->getValues();
    $first_name=$field['first_name'];
    $second_name=$field['second_name'];
    print_r($field);
    $coupon=$field['coupon'];
    if (isset($_GET['num'])) {
          $field  = array(
              'first_name'   => $first_name,
              'second_name'   => $second_name,
              'coupon' => $coupon,
          );
          $query = \Drupal::database();
          $query->update('billing_info')
              ->fields($field)
              ->condition('user_id', $_GET['num'])
              ->execute();
          drupal_set_message("Your Delivered within 3 days");
          $form_state->setRedirect('billing_info.display_table_controller_display');
      }
       else
       {
            $field  = array(
              'first_name'   => $second_name,
              'second_name'   => $first_name,
              'coupon' => $coupon,
            );
           $query = \Drupal::database();
           $query ->insert('billing_info')
               ->fields($field)
               ->execute();
           drupal_set_message("Your Delivered within 3 days");
           $form_state->setRedirect('billing_info.display_table_controller_display');
       }
  }
   public function promptCallback(array $form, FormStateInterface $form_state) {
    $coupon=$form_state->getValue('coupon');

    if($coupon=="First"){
      $a['coupon'] = array(
      '#type' => 'textfield',
      '#name' => 'coupon',
      '#attributes' => ['id' => 'coupon-code'],
      '#required' => TRUE,
      '#value' => 'First',
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