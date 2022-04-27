<?php

namespace Source\Http\Middleware;

use \Source\Http\Response;
/**
 * fila de middlewares a serem executados
 */
class MiddlewareQueue {

  /**
  * middlewares comuns para todas as rotas;
  * @var array
  */
  private static array $default = [];

  /**
   * array de middlewares
   * @var array
   */
  private array $middlewares = [];

  /**
   * closure de execução da response na rota
   * @var Closure
   */
  private \Closure $responseMethod;

  /**
   * argumentos da closure de execução da response na rota
   * @var array
   */
  private array $responseMethodArgs = [];

  /**
   * mapeamento dos middlewares = ('alias' => classe correspondente)
   * @var array
   */
  private static array $map = [];

  public function __construct($middlewares, $responseMethod, $responseMethodArgs) {
   $this->middlewares        = array_merge(self::$default,$middlewares);
   $this->responseMethod     = $responseMethod;
   $this->responseMethodArgs = $responseMethodArgs;
  }

  /**
   * método responsável por definir o mapeamento dos nossos middlewares
   * @param array $map
   */
  public static function setMap($map): void {
   self::$map = $map;
  }

  /**
   * método responsável por definir o mapeamento dos nossos middlewares padrões
   * @param array $map
   */
  public static function setDefault($default): void {
   self::$default = $default;
  }

  /**
   * método responsável por chamar a proxima middleware da fila
   * @param  Request   $request
   * @return Response
   */
  public function next($request): Response {
    //verifica se existem middlewares para a rota, caso não, lança response;
    if(empty($this->middlewares))
      return call_user_func_array($this->responseMethod,$this->responseMethodArgs);

    //pega o primeiro middleware da fila e o remove;
    $middleware = array_shift($this->middlewares);

    //caso tal middleware não esteja mapeado na rota, lança exception;
    if(!isset(self::$map[$middleware]))
      throw new \Exception("Problema ao processar o middleware", 500);

    //cria uma nova instancia da classe
    $queue = $this;
    //método responsável por chamar o proximo middleware
    $next = function($request) use ($queue) {
      return $queue->next($request);
    };
    //executa o middleware e chama o próximo
    return (new self::$map[$middleware])->handle($request,$next);
  }
}
