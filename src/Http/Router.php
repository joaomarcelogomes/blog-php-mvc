<?php

namespace Source\Http;

use \Exception;
use \Closure;
use \ReflectionFunction;

class Router {

  /**
   * request
   * @var Request
   */
  private Request $request;

  /**
   * url de rota
   * @var string
   */
  private string $url;

  /**
   * prefixo comum de todas as rotas
   * @var string
   */
  private string $prefix;

  /**
   * rotas
   * @var array
   */
  private array $routes = [];

  public function __construct(string $url){
    $this->request = new Request();
    $this->url = $url;
    $this->setPrefix();
  }
  /**
   * método responsável por parsear a url e verificar se há um prefixo comum, caso não, seta como vazio
   */
  private function setPrefix(): void {
    $parsedUrl = parse_url($this->url);

    $this->prefix = $parsedUrl['path'] ?? '';
  }
  /**
   * método responsável por adicionar uma rota no router
   * @param string $method
   * @param string $route
   * @param array  $params
   */
  private function addRoute($method, $route, $params = []): void {
    // procura função anonima na rota e caso exista, seta ela em uma chave 'controller';
    foreach($params as $key => $value) {
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

    //regex de validação de url
    $regPatternUrl = '/^'.str_replace('/','\/',$route).'$/';
    //adiciona rota;
    $this->routes[$regPatternUrl][$method] = $params;
  }

  /**
   * método responsável por retornar uri cortada no prefixo
   * @return string
   */
  private function getUri(): string {
    //uri da request
    $uri = $this->request->getUri();
    //caso haja prefixo, corta a uri no mesmo
    $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];
    //retorna a uri, sem o prefixo
    return end($xUri);
  }
  /**
   * método responsável por validar as rotas e retorná-las, em caso de sucesso
   * @return array
   */
  private function getRoute(): array {
    //uri cortada
    $uri = $this->getUri();
    //método http da request
    $httpMethod = $this->request->getMethod();

    foreach ($this->routes as $patternRoute => $method) {
      //confere se a URI bate com o padrão, ou seja, se ela existe
      if(preg_match($patternRoute,$uri,$matches)) {
        //confere se o método está de acordo com a request
        if(isset($method[$httpMethod])) {
          unset($matches[0]);
          //variaveis processadas
          $keys = $method[$httpMethod]['variables'];
          $method[$httpMethod]['variables'] = array_combine($keys,$matches);
          $method[$httpMethod]['variables']['request'] = $this->request;

          return $method[$httpMethod];
        }
        //lança exception caso o método não esteja de acordo
        throw new Exception('Método não permitido!', 405);
      }
      //lança exception caso a url não bata
      throw new Exception('Url não encontrada', 404);
    }
  }

  /**
   * método responsável por executar o roteamento e retornar uma response
   * @return Response
   */
  public function run(): Response {
    try {
      //pega as rotas
      $route = $this->getRoute();

      //caso não haja função de execução(response) lança uma nova exception
      if(!isset($route['controller'])) throw new Exception('A url não pôde ser processada', 500);
      //argumentos de função
      $args = [];

      //Reflection para ordenar os parametros da função
      $controllers = new ReflectionFunction($route['controller']);
      //ordenação de controllers acontece aqui
      foreach ($controllers->getParameters() as $parameter) {
        //pega o nome do parâmetro
        $param = $parameter->getName();
        //seta o parâmetro na variável de array $args criada anteriormente.
        $args[$param] = $route['variables'][$param];
      }
      //retorno como execução da função presente na rota (Response)
      return call_user_func_array($route['controller'],$args);
    } catch (Exception $ex) {
      //lança exception no browser
      return new Response($ex->getCode(),$ex->getMessage());
    }
    }

  public function get(string $route, array $params = []) {
    return $this->addRoute('GET', $route, $params);
  }

}
