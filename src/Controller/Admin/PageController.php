<?php

namespace Source\Controller\Admin;
use \Source\UI\View;

class PageController {

  /**
   * método responsável por retornar o conteúdo da view de admin
   * @param  string $title
   * @param  string $content
   * @return string
   */
  public static function getPage($title,$content): string {
    return View::render('admin/page', [
      'title'   => $title,
      'content' => $content,
    ]);
  }

}
