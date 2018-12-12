<?php


namespace Drupal\billing_info\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a block with a simple text.
 *
 * @Block(
 *   id = "my_block_example_block",
 *   admin_label = @Translation("Billing Information Block"),
 * )
 */
class CouponBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    return \Drupal::formBuilder()->getForm('Drupal\\billing_info\\Form\\CouponForm');
  }

}