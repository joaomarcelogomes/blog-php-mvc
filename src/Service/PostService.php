<?php

namespace Source\Service;

use \Source\Model\Post;
use \Source\Utils\DB\AccessClass;
use \Source\Utils\DB\Connection;
use \PDO;

class PostService implements ServiceContract {

  private AccessClass $dao;

  public function __construct(){
   $this->dao = new AccessClass('post', new Connection);
  }

  public function create($post): int {
    return $this->dao->insert([
      'title'   => $post->getTitle(),
      'content' => $post->getContent(),
      'date'    => date('Y-m-s H:i:s')
    ]);
  }

  public function list(string $order = null, string $limit = null, string $fields = '*'): array {
    return $this->dao->select(null,$order,$limit,$fields)->fetchAll(PDO::FETCH_CLASS, Post::class);
  }

  public function load(int $id): Post {
    return $this->dao->select('id='.$id)->fetchObject(Post::class);
  }

  public function update(int $id, array $values): bool {
    return $this->dao->update($id,$values);
  }

  public function delete(int $id): bool {
    return $this->dao->delete($id);
  }
}
