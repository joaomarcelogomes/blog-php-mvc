<?php

namespace Source\Controller;
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
  public static function getPosts(int $limit): string {
    $pagination = new Pagination(self::getService()->countItems(), $limit, $_GET['page']);
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
    $post = self::getService()->load($id);
    $content = View::render('pages/posts/post', [
      'title'   => $post->getTitle(),
      'date'    => strftime('%B %d, %Y', strtotime($post->getDate())),
      'content' => $post->getContent(),
      'img'     => $post->getImg(),
    ]);

    return parent::getPage($post->getTitle(), $content);
  }

  /**
   * método responsável pela inserção de um novo artigo
   * @param  Request $request
   * @return string
   */
  public static function newPost($request = null): string {
    if(isset($request)) {
      //pega o array de variáveis post
      $vars = $request->getPostVars();
      //salva a imagem no arquivo resources/upload e seta a mesma no array em 'img';
      $vars['img'] = self::imgUpload();
      //insere o registro no banco
      self::getService()->create($vars);
    }
    //renderiza a página de registro
    $content = View::render('pages/posts/register');

    //retorna a página generica com o conteúdo
    return parent::getPage('Novo artigo', $content);
  }

  /**
   * método responsável por salvar a imagem upada em uma nova pasta e retornar esse caminho para o banco
   * @return string (caminho de acesso à imagem)
   */
  private static function imgUpload(): string {
    //busca a imagem na array de files
    $img = $_FILES['post_img'];
    //pega a extensão dessa imagem
    $extension = mb_strtolower(substr($img['name'],-4));
    //cria um novo nome baseado no tempo unix atual hashificado
    $newName = md5(time()) . $extension;

    //pega o diretório onde os arquivos serão salvos
    $dir = __DIR__.'/../../resources/upload/';

    //move a imagem em questão para o diretório
    move_uploaded_file($img['tmp_name'], $dir.$newName);
    //retorna o caminho imagem;
    return 'resources/upload/'.$newName;
  }

}
