<?php

namespace MyB;
use MyB\Error as Error;
use MyB\Permalink as Link;
use ReflectionMethod;

class Router {
	protected static $url;

	/* Routes Array */
	protected static $routes = array();

	private static function url($basename = null) {
		$url = $_SERVER['SCRIPT_NAME'];
		$url = rtrim(dirname($url), '/');
		$url = filter_var($url, FILTER_SANITIZE_URL);
		$url = trim(str_replace($url, '', $_SERVER['REQUEST_URI']), '');
		$url = urldecode($url);
		$url = strtok($url, '?');
		self::$url = $url;
		return self::$url;
	}

	public static function get($route = '/', $data = null, $action = null) {
		return self::create($route, $data, 'GET', $action);
	}

	public static function post($route = '/', $data = null, $action = null) {
		return self::create($route, $data, 'POST', $action);
	}

	public static function put($route = '/', $data = null, $action = null) {
		return self::create($route, $data, 'PUT', $action);
	}

	public static function delete($route = '/', $data = null, $action = null) {
		return self::create($route, $data, 'DELETE', $action);
	}

	private static function set($arr = array()) {
		return array_push(self::$routes, $arr);
	}

	public static function static($serve_path = '/', $serve_folder = '/public') {
		$static = [
			'route' => $serve_path . '/(.*?)',
			'action' => 'static',
			'data' => function ($req) use ($serve_folder) {
				$file = $req['params'][0];
				$folder = realpath(__DIR__ . '/../../' . $serve_folder);
				if ($ext = pathinfo($file, PATHINFO_EXTENSION)) {
					if (in_array($ext, ['html', 'php', 'json', 'xml', 'xhtml'])) {
						return die('error');
					}
					$file = $folder . '/' . $file;
					if (is_file($file)) {
						$type = mime_content_type($file);
						if ($type = 'text/plain') {
							switch ($ext) {
							case 'css':
								$type = 'text/css';
								break;
							case 'js':
								$type = 'text/javascript';
								break;
							default:
								$type = 'text/plain';
								break;
							}
						}
						if ($file = @file_get_contents($file)) {
							header("Content-Type: $type");
							return exit($file);
						} else {
							return die('error');
						}
					} else {
						return die('error');
					}
				} else {
					return die('error');
				}
			},
			'method' => 'get',
		];
		return self::set($static);
	}

	private static function create($route, $data, $method = ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS', 'PATCH', 'HEAD'], $action = null) {


		$pattern = "/:[a-zA-Z0-9]+/i";
		if (preg_match_all($pattern, $route, $matches, PREG_UNMATCHED_AS_NULL)) {
			foreach ($matches[0] as $match) {
				$expo = str_replace(':', '', $match);
				$route = str_replace($match, "(?'$expo'[^/]+)", $route);
			}
		}
		$route = array(
			"route" => $route,
			"data" => $data,
			"method" => $method,
			"action" => $action,
		);
		array_push(self::$routes, $route);

		return;
	}

	private static function exists($route) {
		foreach (self::$routes as $router) {
			if (in_array($route, $router)) {
				return true;
			}
			next(self::$routes);
		}
		return false;
	}

	private static function loadRoutes() {
		$rules = @file_get_contents(dirname(__FILE__) . "/../libs/router/routes.json");
		$rules = @json_decode($rules, true);
		$rules = $rules['routes'];
		foreach ($rules as $action => $rule) {
			self::create($rule, function ($req, $res) use ($action) {
				$_REQUEST['action'] = $action;
				require_once (dirname(__FILE__) . '/../libs/pages/page_router.php');
			}, ['get', 'post']);
		}
	}

	public static function init($options = array()) {
		$options = $options ? $options : false;
		$work = array('route' => false, 'method' => false);
		$url = self::url();
		$method = $_SERVER['REQUEST_METHOD'];
		foreach (self::$routes as $route) {
			if (preg_match("@^$route[route]$@", self::url(), $params, PREG_UNMATCHED_AS_NULL)) {
				$work['route'] = true;
				foreach ((array)$route['method'] as $allowedMethod) {
					if (strtolower($method) === strtolower($allowedMethod)) {
						header("Access-Control-Allow-Methods: $allowedMethod");
						array_shift($params);
						$requisition = [
							"params" => $params,
							"method" => $method,
							"action" => $route['action'],
						];
						$response = [];
						if (is_callable($route['data'])) {
							$work['method'] = true;
							return call_user_func_array($route['data'], array($requisition, $response));
						}
					}
				}
			}
		}
		if($work['route']){
			if($work['route']){
				return Error::Get(405);
			}
		}else{
			return Error::Get(404);
		}
	}

	/*public static function init(Array $options = null){
		$options = $options ? $options : false;
		$url = self::url();
		$method = $_SERVER['REQUEST_METHOD'];

		// Verificador de Rotas 
		$route_found = false;
		$method_found = false;

		foreach (self::$routes as $route){
			if (preg_match_all('#^' . $route['route'] . '$#', self::url(), $params, PREG_UNMATCHED_AS_NULL)) {
				$route_found = true;
				foreach ((array)$route['method'] as $allowedMethod) {
					if (strtolower($method) == strtolower($allowedMethod)) {
						array_shift($params);
						$method_found = true;
						$requisition = [
							"params" => $params,
						];
						$response = [];

						if (is_callable($route['data'])) {
							$work['method'] = true;
							return call_user_func_array($route['data'], array($requisition, $response));
						}else{
							return self::Error(404);
						}
					}
				}
			}
			if($route_found){
				break;
			}
		}

	}
	*/

	public static function onDestruct() {
		self::loadRoutes();
		return self::init();
	}
}

register_shutdown_function(function () {
	return Router::onDestruct();
});
