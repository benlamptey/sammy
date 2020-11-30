<?php

namespace Drupal\sammy_invoice\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Defines a form that configures forms module settings.
 */
class Home extends ControllerBase {


  public function build() {
    return [
      '#theme' => 'home',
      '#content' => [],
    ];
  }

}
