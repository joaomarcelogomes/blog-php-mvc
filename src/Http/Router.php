<?php

namespace Source\Http;
use \Closure;
use \Exception;
use \ReflectionFunction;

class Router {

  /**
   * url completa da raíz do projeto
   * @var string
   */
  private string $url = '';

  /**
   * prefixo comum de todas as rotas;
   * exemplo: em uma url "localhost:8000/mvc/rotas" -> prefixo comum é "/mvc";
   * @var string
   */
  private string $prefix = '';
  /**
   * indice de rotas
   * @var array
   */
  private array $routes = [];
  /**
   * instância da Request
   * @var Request
   */
  private Request $request;

  public function __construct(string $url){
    $this->request = new Request($this);
    $this->url     = $url;
    $this->setPrefix();
  }
  /**
   * responsável por setar o prefixo da rota
   */
  private function setPrefix(): void {
   $parsedUrl = parse_url($this->url);

   $this->prefix = $parsedUrl['path'] ?? '';
  }
  /**
   * adiciona uma rota na classe
   * @param string $method
   * @param string $route
   * @param array  $params
   */
  private function addRoute(string $method, string $route, array $params = []): void {
    //procura uma função anonima nos parametros(response), caso encontre, seta ela numa chave 'controller'
    foreach ($params as $key => $value) {
      if($value instanceof Closure) {
        $params['controller'] = $value;
        unset($params[$key]);
        continue;
      }
    }
    //variaveis da rota
    $params['variables'] = [];

    //padrão de validação das variaveis das rotas
    $patternVariable = '/{(.*?)}/'; //pega todas as variáveis que cheguem na rota através de /{a}/

    if(preg_match_all($patternVariable,$route,$matches)) {
      //substituição de variaveis (remoção das "{}");
      $route = preg_replace($patternVariable,'(.*?)',$route);
      //Seta as variáveis já parseadas sem as "{}"; o $matches[0] possui as variaveis ainda com as "{}";
      $params['variables'] = $matches[1];
    }

    //padrao de validaçao da url
    $patternRoute = '/^'.str_replace('/','\/',$route).'$/';

    //add a rota na classe
    $this->routes[$patternRoute][$method] = $params;
  }

  /**
   * método que fatia a uri no prefixo
   * @return string
   */
  private function getUri(): string {
   //uri da request
   $uri = $this->request->getUri();

   //fatia a uri com o prefixo
   $xUri = strlen($this->prefix) ? explode($this->prefix,$uri) : [$uri];
   return end($xUri);
  }

  /**
   * retorna os dados da nossa rota atual
   * @return array
   */
  private function getRoute(): array {
    $uri = $this->getUri();
    $httpMethod = $this->request->getMethod();
    //valida as rotas
    foreach ($this->routes as $patternRoute => $method) {
      //confere se a uri bate com o regex de validação
      if(preg_match($patternRoute,$uri,$matches)){
        //confere se rota possui o  método
        if(isset($method[$httpMethod])){
          //remove a primeira posição de matches (uri);
          unset($matches[0]);

          //variaveis processadas
          $keys = $method[$httpMethod]['variables'];
          $method[$httpMethod]['variables'] = array_combine($keys,$matches);
          $method[$httpMethod]['variables']['request'] = $this->request;

          //retorno dos parametros da rota
          return $method[$httpMethod];
        }
        //Método não encontrado;
        throw new Exception('Método não permitido!', 405);
      }
    }
    //Caso nenhuma uri bata com o padrão de validação
    throw new Exception('Url não encontrada!', 404);
  }

  public function run(): Response {
    try {
      //obtem a rota atual
      $route = $this->getRoute();
      //verifica o controlador
      if(!isset($route['controller'])) {
        throw new Exception('Url não pode ser processada', 500);
      }
      //argumentos da função
      $args = [];

      //Reflection para ordenar os parametros da função
      $controllers = new ReflectionFunction($route['controller']);
      //ordenação acontece aqui
      foreach ($controllers->getParameters() as $parameter) {
        //pega o nome do parâmetro
        $name = $parameter->getName();
        //seta o parâmetro na variável de array $args criada anteriormente.
        $args[$name] = $route['variables'][$name];
      }
      //retorno como execução da função presente na rota (Response)
      return call_user_func_array($route['controller'],$args);
    } catch (Exception $e) {
      return new Response($e->getCode(), $e->getMessage());
    }

  }

  /**
   * responsável por definir uma rota de get
   * @param  string   $route
   * @param  array    $params
   * @return Response
   */
  public function get(string $route, array $params = []) {
    return $this->addRoute('GET', $route, $params);
  }

  public function post(string $route, array $params = []) {
    return $this->addRoute('POST', $route, $params);
  }

  public function put(string $route, array $params = []) {
    return $this->addRoute('PUT', $route, $params);
  }

  public function delete(string $route, array $params = []) {
    return $this->addRoute('DELETE', $route, $params);
  }
}
