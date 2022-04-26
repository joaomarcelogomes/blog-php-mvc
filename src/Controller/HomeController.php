<?php

namespace Source\Controller;
use \Source\UI\View;

class HomeController extends PageController {

  /**
   * método responsável por renderizar a home
   * @return string
   */
  public static function getHome(): string {
    $content = View::render('pages/home', [
      'posts' => PostController::getPosts()
    ]);

   return parent::getPage('HOME', $content);
  }

}
