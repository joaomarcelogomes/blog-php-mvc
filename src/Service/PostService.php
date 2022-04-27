<?php

namespace Source\Service;

use \Source\Model\Post;
use \Source\Utils\DB\AccessClass;
use \Source\Utils\DB\Connection;
use \PDO;

/**
 * classe de serviço para o model de Postagem
 */
class PostService {

  /**
   * objeto de acesso ao banco de dados
   * @var AccessClass
   */
  private AccessClass $dao;

  /**
   * método construtor responsável por instanciar DAO
   */
  public function __construct(){
   $this->dao = new AccessClass('post', new Connection);
  }
  /**
   * implementação do método responsável pela inserção no banco
   * @param  Post $post
   * @return int
   */
  public function create(array $post = []): int {
    return $this->dao->insert([
      'title'   => $post['title'],
      'content' => $post['content'],
      'img'     => $post['img'],
      'date'    => date('Y-m-d H:i:s')
    ]);
  }

  /**
   * implementação do método de listagem
   * @param  string $order
   * @param  string $limit
   * @param  string $fields
   * @return array
   */
  public function list(string $order = null, string $limit = null, string $fields = '*'): array {
    return $this->dao->select(null,$order,$limit,$fields)->fetchAll(PDO::FETCH_CLASS, Post::class);
  }
  /**
   * implementação do método de busca de 1 registro
   * @param  int  $id
   * @return Post
   */
  public function load(int $id): Post {
    return $this->dao->select('id='.$id)->fetchObject(Post::class);
  }
  /**
   * implementação do método de atualização
   * @param  int   $id
   * @param  array $values
   * @return bool
   */
  public function update(int $id, array $values): bool {
    return $this->dao->update($id,$values);
  }
  /**
   * implementação do método de remoção de registro
   * @param  int  $id
   * @return bool
   */
  public function delete(int $id): bool {
    return $this->dao->delete($id);
  }
}
