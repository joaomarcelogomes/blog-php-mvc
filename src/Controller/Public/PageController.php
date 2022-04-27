<?php

namespace Source\Controller\Public;
use \Source\UI\View;

class PageController {

  /**
   * método responsável por retornar o conteúdo do footer da página
   * @return string
   */
  private static function getFooter(): string {
    return View::render('pages/footer');
  }

  /**
   * método responsável por retornar o conteúdo do header da página
   * @param  string $title
   * @return string
   */
  private static function getHeader($title): string {
    return View::render('pages/header', [
      'title' => $title
    ]);
  }
  /**
   * método responsável por retornar o conteúdo da view genérica
   * @param  string $title
   * @param  string $content
   * @return string
   */
  public static function getPage($title, $content): string {
    return View::render('pages/page', [
      'title'   => $title,
      'header'  => self::getHeader($title),
      'content' => $content,
      'footer'  => self::getFooter()
    ]);
  }

}
