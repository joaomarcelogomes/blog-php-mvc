<?php

namespace Source\Controller;
use \Source\UI\View;
use \Source\Service\PostService;

class PostController extends PageController {

  /**
   * método responsável por instanciar o service e retorná-lo
   * @return PostService
   */
  private static function getService(): PostService {
    return new PostService();
  }

  /**
   * método responsável por renderizar a listagem de posts
   * @param  array $posts
   * @return string
   */
  public static function getPosts(): string {
    //listagem de posts
    $posts = self::getService()->list();
    //renderiza o conteúdo de posts
    foreach ($posts as $post) {
      $content .= View::render('pages/posts/posts', [
        'title'   => $post->getTitle(),
        'content' => $post->getContent(),
        'date'    => $post->getDate()
      ]);
    }
    //retorna o conteúdo renderizado
    return $content;
  }

}
