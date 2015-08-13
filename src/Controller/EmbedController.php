<?php

/**
 * @file
 * Contains \Drupal\embed\Controller\EmbedController.
 */

namespace Drupal\embed\Controller;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Controller\ControllerBase;
use Drupal\embed\Ajax\EmbedInsertCommand;
use Drupal\filter\FilterFormatInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Returns responses for Embed module routes.
 */
class EmbedController extends ControllerBase {

  /**
   * Returns an Ajax response to generate preview of an entity.
   *
   * Expects the the HTML element as GET parameter.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request object.
   * @param \Drupal\filter\FilterFormatInterface $filter_format
   *   The filter format.
   *
   * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
   *   Throws an exception if 'value' parameter is not found in the request.
   *
   * @return \Symfony\Component\HttpFoundation\Response
   *   The preview of the embedded item specified by the data attributes.
   */
  public function preview(Request $request, FilterFormatInterface $filter_format) {
    $text = $request->get('value');
    if ($text == '') {
      throw new NotFoundHttpException();
    }

    $output = check_markup($text, $filter_format->id());
    $response = new AjaxResponse();
    $response->addCommand(new EmbedInsertCommand($output));
    return $response;
  }

}