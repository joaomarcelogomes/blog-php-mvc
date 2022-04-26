<?php

namespace Source\Controller;
use \Source\UI\View;
use \Source\Service\PostService;
use \Source\Model\Post;

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
        'id'      => $post->getId(),
        'title'   => $post->getTitle(),
        'content' => substr($post->getContent(), 0, 500) . '...',
        'date'    => strftime('%d de %B de %Y', strtotime($post->getDate())),
        'img'     => $post->getImg()
      ]);
    }
    //retorna o conteúdo renderizado
    return $content;
  }

  /**
   * método responsável por retornar um post específico através do id
   * @param  int $id
   * @return Post
   */
  public static function getPost($id): string {
    $post = self::getService()->load($id);
    $content = View::render('pages/posts/post', [
      'title'   => $post->getTitle(),
      'date'    => strftime('%B %d, %Y', strtotime($post->getDate())),
      'img'     => $post->getImg(),
      'content' => $post->getContent()
    ]);

    return parent::getPage($post->getTitle(), $content);
  }

}
