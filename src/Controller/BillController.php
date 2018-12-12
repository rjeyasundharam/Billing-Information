<?php

namespace Drupal\billing_info\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\HttpFoundation\Request;
/**
 * Class MydataController.
 *
 * @package Drupal\mydata\Controller
 */
class BillController extends ControllerBase {

  /**
   * Display.
   *
   * @return string
   *   Return Hello string.
   */
  public $serverid;
  // ...
  public function display($user_id){
      
      $header_table = array(
          'particular'=>    t('Particular'),
          'information' => t('Information'),
      );
      //select records from table
       $query = \Drupal::database()->select('billing_info', 'm');
      $query->fields('m', ['user_id','first_name','second_name','coupon'])->condition('user_id',$user_id);
      $results = $query->execute()->fetchAll();
      $rows=array();
      foreach($results as $data){
          $rows[] = array(
              'particular'=>    t('User Id'),
              'information' => $data->user_id,
            );
          $rows[] = array(
              'particular'=>    t('First Name'),
              'information' => $data->first_name,
            );
          $rows[] = array(
              'particular'=>    t('Second Name'),
              'information' => $data->second_name,
            );
          $rows[] = array(
              'particular'=>    t('Coupon'),
              'information' => $data->coupon,
            );
      }
      $form['table'] = [
            '#type' => 'table',
            '#header' => $header_table,
            '#rows' => $rows,
            '#empty' => t('No User Coupon Found'),
      ];
      return $form;
  }

}
