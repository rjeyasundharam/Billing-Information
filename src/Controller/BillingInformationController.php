<?php

namespace Drupal\billing_info\Controller;

use Drupal\billing_info\Utility\DescriptionTemplateTrait;

/**
 * Controller routines for block example routes.
 */
class BillingInformationController {
  use DescriptionTemplateTrait;

  /**
   * {@inheritdoc}
   */
  protected function getModuleName() {
    return 'billing_info';
  }

}
