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
  public function create($post): int {
    return $this->dao->insert([
      'title'   => $post->getTitle(),
      'content' => $post->getContent(),
      'img'     => $post->getImg(),
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
   * método responsável por contar a quantidade de posts no banco
   * @param  string $where
   * @return int
   */
  public function countItems($where = null): int {
    return $this->dao->select($where,null,null,'COUNT(*) as total')
                     ->fetchObject()
                     ->total;
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
   * @param  Post $values
   * @return bool
   */
  public function update(Post $post): bool {
    return $this->dao->update($post->getId(),[
      'title'   => $post->getTitle(),
      'content' => $post->getContent(),
      'img'     => $post->getImg()
    ]);
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
