<?php

namespace Source\Controller\Admin;

use \Source\UI\View;
use \Source\Service\PostService;
use \Source\Service\AdminService;
use \Source\Model\Post;
use \Source\Model\Admin;
use \Source\Utils\Session\Admin\Login;

/**
 * classe responsável por controlar o painel de administração
 */
class AdminController extends PageController {

  /**
   * método responsável por instanciar o service e retorná-lo
   * @return PostService
   */
  private static function getPostService(): PostService {
    return new PostService();
  }

  /**
   * método responsável por instanciar o service e retorná-lo
   * @return AdminService
   */
  private static function getService(): AdminService {
    return new AdminService();
  }

  /**
   * método responsável por renderizar a página home de admin
   * @return string
   */
  public static function getHomeAdmin(): string {
    //pega o conteúdo da home
    $content = View::render('admin/home', [
      'admin' => Login::getLogged()['name'],
      'posts' => self::getPostList()
    ]);
    //retorna a página renderizada
    return parent::getPage('Admin', $content);
  }

  /**
   * método responsável por renderizar a listagem de posts na home admin
   * @return string
   */
  public static function getPostList(): string {
    //nova instancia de service
    $service = new PostService();
    $posts = '';
    //preenche lista de posts
    foreach ($service->list('id DESC') as $post) {
      $posts .= View::render('admin/post-item', [
        'post-id'      => $post->getId(),
        'post-title'   => $post->getTitle(),
        'post-date'    => date('d/m/Y à\s H:i:s', strtotime($post->getDate())),
        'post-content' => substr($post->getContent(), 0, 500) . '...',
      ]);
    }
    //renderiza a página de lista de posts
    $content = View::render('admin/post-list', [
      'post' => $posts
    ]);
    //retorna a página de lista de posts
    return $content;
  }

  /**
   * método responsável pela inserção de um novo artigo
   * @param  Request $request
   * @return string
   */
  public static function createAdmin($request = null): string {
    if(isset($request)) {
      //pega o array de variáveis post
      $vars = $request->getPostVars();
      //verifica se as senhas coincidem
      if($vars['password'] != $vars['password-confirmation'])
        $request->getRouter()->redirect('/admin/new_user');

      //cria nova instancia de admin
      $obAdmin = new Admin();
      $obAdmin->setName($vars['name']);
      $obAdmin->setEmail($vars['email']);
      $obAdmin->setPassword($vars['password']);

      //insere o registro no banco
      self::getService()->create($obAdmin);
      //redireciona para a página de administração após a execução da ação
      $request->getRouter()->redirect('/admin');
    }
    //renderiza a página de registro
    $content = View::render('admin/user/new-user');

    //retorna a página generica com o conteúdo
    return parent::getPage('Novo usuário', $content);
  }

  /**
   * método responsável pela inserção de um novo artigo
   * @param  Request $request
   * @return string
   */
  public static function createPost($request = null): string {
    if(isset($request)) {
      //pega o array de variáveis do método post
      $vars = $request->getPostVars();
      //cria uma nova instancia de postagem com as variáveis recebidas
      $obPost = new Post();
      $obPost->setTitle($vars['title']);
      $obPost->setContent($vars['content']);
      //salva a imagem no arquivo resources/upload e seta a mesma no objeto de post;
      $obPost->setImg(self::getImgUploaded());
      //insere o registro no banco
      self::getPostService()->create($obPost);
      //redireciona para a página de administração após a execução da ação
      $request->getRouter()->redirect('/admin');
    }
    //renderiza a página de registro
    $content = View::render('admin/posts/register');

    //retorna a página generica com o conteúdo
    return parent::getPage('Nova postagem', $content);
  }

  public static function updatePost($id, $request = null): string {
    //chama o objeto do banco
    $obPostToUpdate = self::getPostService()->load($id);
    //renderiza a página de registro
    $content = View::render('admin/posts/update', [
      'id'           => $obPostToUpdate->getId(),
      'post-img'     => $obPostToUpdate->getImg(),
      'post-title'   => $obPostToUpdate->getTitle(),
      'post-content' => $obPostToUpdate->getContent()
    ]);

    if(isset($request)) {
      //pega o array de variáveis post
      $vars = $request->getPostVars();
      //seta as propriedades no objeto recuperado;
      $obPostToUpdate->setTitle($vars['title']);
      $obPostToUpdate->setContent($vars['content']);
      //salva a imagem no arquivo resources/upload e seta a mesma no array em 'img';
      //caso o usuário não tenha upado nenhuma imagem, pega a imagem que já existia no objeto
      $img = in_array('.', str_split(self::getImgUploaded())) ? self::getImgUploaded() : $obPostToUpdate->getImg();
      $obPostToUpdate->setImg($img);
      //altera o registro no banco
      self::getPostService()->update($obPostToUpdate);
      //redireciona para a página de administração após a execução da ação
      $request->getRouter()->redirect('/admin');
    }

    //retorna a página generica com o conteúdo
    return parent::getPage('Editar postagem', $content);
  }

  public static function deletePost($id, $request = null): string {
    //chama o objeto do banco
    $obToUpdate = self::getPostService()->load($id);
    //renderiza a página de registro
    $content = View::render('admin/posts/delete', [
      'id'           => $id,
      'post-title'   => $obToUpdate->getTitle(),
    ]);

    if(isset($request)) {
      //deleta o registro no banco
      self::getPostService()->delete($id);
      //redireciona para a página de administração após a execução da ação
      $request->getRouter()->redirect('/admin');
    }

    //retorna a página generica com o conteúdo
    return parent::getPage('Excluir postagem', $content);
  }

  /**
   * método responsável por salvar a imagem upada em uma nova pasta e retornar esse caminho para o banco
   * @return string (caminho de acesso à imagem)
   */
  private static function getImgUploaded(): string {
    //busca a imagem na array de files
    $img = $_FILES['post_img'];
    //pega a extensão dessa imagem
    $extension = mb_strtolower(substr($img['name'],-5));

    //cria um novo nome baseado no tempo unix atual hashificado
    $newName = md5(time()) .$extension;

    //pega o diretório onde os arquivos serão salvos
    $dir = __DIR__.'/../../../resources/upload/';

    //move a imagem em questão para o diretório
    move_uploaded_file($img['tmp_name'], $dir.$newName);
    //retorna o caminho imagem;
    return 'resources/upload/'.$newName;
  }

}
