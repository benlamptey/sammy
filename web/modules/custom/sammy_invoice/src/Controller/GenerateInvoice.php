<?php

namespace Drupal\sammy_invoice\Controller;

use Drupal\Core\Controller\ControllerBase;
use Mpdf\Mpdf;

/**
 * Defines a form that configures forms module settings.
 */
class GenerateInvoice extends ControllerBase {


  public function build($node) {
    $content = [];

    $mpdf = new Mpdf([
      'tempDir' => DRUPAL_ROOT . '/sites/default/files',
      'setAutoBottomMargin' => 'pad',
    ]);

    $content['invoice_number'] = $node->label();
    $invoice_start_date = $node->get('field_invoice_date')->first()->getValue();
    $invoice_end_date = $node->get('field_invoice_end_date')->first()->getValue();
    $start_timestamp = strtotime($invoice_start_date['value']);
    $end_timestamp = strtotime($invoice_end_date['value']);

    $start_date = \Drupal::service('date.formatter')->format($start_timestamp, 'custom', 'j/m/Y');
    $end_date = \Drupal::service('date.formatter')->format($end_timestamp, 'custom', 'j/m/Y');

    $content['invoice_start_date'] = $start_date;
    $content['invoice_end_date'] = $end_date;

    $filename = 'GRACE NANNY EMPLOYMENT - ' . $node->label();
    $pdf = [
      '#theme' => 'sammy-invoice',
      '#content' => $content
    ];
    $stylesheet = file_get_contents(drupal_get_path('module', 'sammy_invoice') . '/assets/css/policy-pdf.css');
    $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
    $mpdf->WriteHTML(render($pdf));
    $mpdf->Output($filename, 'I');
  }

}
