<?php

namespace Source\Controller\Public;
use \Source\UI\View;
use \Source\Service\PostService;
use \Source\Model\Post;
use \Source\Utils\DB\Pagination;

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
  public static function getPosts(int $limit, $request, &$pagination): string {
    //pega página atual
    $queryParams = $request->getQueryParams();
    $actualPage = $queryParams['page'] ?? 1;
    //nova instancia de classe de paginação
    $pagination = new Pagination(self::getService()->countItems(), $limit, $actualPage);
    //listagem de posts
    $posts = self::getService()->list('id DESC', $pagination->getLimit());

    $content = '';
    //renderiza o conteúdo de posts
    foreach ($posts as $post) {
      $content .= View::render('pages/posts/post-list', [
        'id'      => $post->getId(),
        'title'   => $post->getTitle(),
        'content' => substr($post->getContent(), 0, 500) . '...',
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
    //busca o post no banco através do id
    $post = self::getService()->load($id);
    //renderiza a página de post com o post retornado
    $content = View::render('pages/posts/post', [
      'title'   => $post->getTitle(),
      'date'    => strftime('%B %d, %Y', strtotime($post->getDate())),
      'content' => $post->getContent(),
      'img'     => $post->getImg(),
    ]);
    //retorna página montada
    return parent::getPage($post->getTitle(), $content);
  }

}
