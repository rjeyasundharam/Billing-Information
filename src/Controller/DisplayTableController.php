<?php
namespace Drupal\billing_info\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;
use GuzzleHttp\Exception\RequestException;

/**
 * Class DisplayTableController.
 *
 * @package Drupal\mydata\Controller
 */
class DisplayTableController extends ControllerBase {
 
  
  public function getContent() {
    // First we'll tell the user what's going on. This content can be found
    // in the twig template file: templates/description.html.twig.
    // @todo: Set up links to create nodes and point to devel module.
    $build = [
      'description' => [
        '#theme' => 'billing_info_description',
        '#description' => 'foo',
        '#attributes' => [],
      ],
    ];
    return $build;
  }
  /**
   * Display.
   *
   * @return string
   *   Return Hello string.
   */
  public function display() {
    //create table header
    $header_table = array(
        'id'=>    t('SrNo'),
        'fname' => t('First Name'),
        'sname' => t('Second Name'),
        'Code' => t('Coupon Code'),
        'opt' => t('Delete'),
        'opt1' => t('Edit'),
        'opt2' => t('View'),
    );
      //select records from table
      $query = \Drupal::database()->select('billing_info', 'm');
      $query->fields('m', ['user_id','first_name','second_name','coupon']);
      $results = $query->execute()->fetchAll();
      $rows=array();
     
    foreach($results as $data){
        $delete = Url::fromUserInput('/billing_info/delete/'.$data->user_id);
        $edit   = Url::fromUserInput('/billing_info/formdata?num='.$data->user_id);
        $view   = Url::fromUserInput('/billing_info/billdetail/'.$data->user_id);
          $rows[] = array(
                'id' =>$data->user_id,
                'fname' => $data->first_name,
                'sname' => $data->second_name,
                'coupon' => $data->coupon,
                 \Drupal::l('Delete', $delete),
                 \Drupal::l('Edit', $edit),
                 \Drupal::l('view', $view),
            );
    }
    //display data in site
    $form['table'] = [
            '#type' => 'table',
            '#header' => $header_table,
            '#rows' => $rows,
            '#empty' => t('No Servers found'),
        ];
        return $form;
  }

}

?>