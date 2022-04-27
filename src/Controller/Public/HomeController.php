<?php

namespace Source\Controller\Public;
use \Source\Utils\DB\Pagination;
use \Source\UI\View;

class HomeController extends PageController {

  /**
   * método responsável por renderizar a home
   * @return string
   */
  public static function getHome(): string {
    $content = View::render('pages/home', [
      'posts' => PostController::getPosts(6),
    ]);

   return parent::getPage('Home', $content);
  }

}
