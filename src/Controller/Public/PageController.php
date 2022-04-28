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

  /**
   * método responsável por renderizar a seção de paginação do site
   * @param  Request $request
   * @param  Pagination $pagination
   * @return string
   */
  public static function getPagination($request, $pagination): string {
    //pega o array de páginas
    $pages = $pagination->getPages();
    //caso possua apenas uma página, retorna string vazia (sem botão)
    if(count($pages) <= 1) return '';
    //pega a url do site
    $url = $request->getRouter()->getCurrentUrl();
    //pega os parametros de query da request
    $queryParams = $request->getQueryParams();
    //inicia variavel de links
    $links = '';
    foreach ($pages as $page) {
      //remove a chave 'currentPage' dos queryParams
      $queryParams['page'] = $page['page'];
      //monta um novo link com os parametros de página
      $link = $url.'?'.http_build_query($queryParams);
      //renderiza o botão de link
      $links .= View::render('pages/pagination/link', [
        'link' => $link,
        'page' => $page['page']
      ]);
    }
    //retorna a seção de paginação pronta
    return View::render('pages/pagination/box', [
      'pages' => $links,
    ]);
  }

}
