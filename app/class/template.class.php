<?php
namespace MyB;
use MyB\DB as DB;
use MyB\Query as Query;
use MyB\Permalink as Link;

use Throwable;

class Template extends templateSettings {
	private $template;
	private $file;
	protected $values = [];
	private static $instance;
	private $db;
	private $realpaths;
	protected $extraFunc;

	public function __construct($options = array("template" => "simple"), $globalVars = array()) {
		$this->db = DB::init();
		$this->template = $options['template'];
		$realpath = realpath('./');
		$this->realpaths = realpath('./');

		$this->blogSettings();
	}

	private function themePath($file) {
		return $this->realpaths . DIRECTORY_SEPARATOR . 'src/themes' . DIRECTORY_SEPARATOR . $this->template . DIRECTORY_SEPARATOR . $file;
	}

	public static function get($options = null) {
		if (!isset($instance)) {
			$object = __CLASS__;
			if($options){
				self::$instance = new $object($options);
			}else{
				self::$instance = new $object();
			}
		}
		return self::$instance;
	}

	public function setVar($name = "*", $value = null) {
		return $this->values["%" . $name . "%"] = $value;
	}

	public function getVar($name) {
		if (isset($this->values["%" . $name . "%"])) {
			return $this->values["%" . $name . "%"];
		}
		return false;
	}

	private function replaceVars() {
		$file = $this->getVar("*");
		foreach ($this->values as $var => $value) {
			$file = @str_replace($var, $value, $file);
		}
		$this->setVar("*", $file);
	}

	public function __set($name, $value) {
		return $this->setVar($name, $value);
	}

	public function var(string $name, $value = null){
		return $this->setVar($name, $value);
	}

	static function svar(string $name, $value = null){
		return self::get(null)->setVar($name, $value);
	}

	public function __get($name) {
		return $this->getVar($name);
	}

	private function load($file) {
		$filepath = pathinfo($file, PATHINFO_DIRNAME);
		$file = pathinfo($file, PATHINFO_FILENAME);
		$support = ['.html', '.htm', '.xhtml', '.myb'];
		foreach ($support as $ext) {
			$filepath = $this->themePath($filepath . DIRECTORY_SEPARATOR . $file . $ext);
			if (is_file($filepath)) {
				return file_get_contents($filepath);
			}
		}
		return exit("File '$file' not found.");
	}

	private function add($file) {
		$filepath = pathinfo($file, PATHINFO_DIRNAME);
		$file = pathinfo($file, PATHINFO_FILENAME);
		$support = ['.html', '.htm', '.xhtml', '.php', '.myb', '.php5'];
		foreach ($support as $ext) {
			$filepath = $this->themePath($filepath . DIRECTORY_SEPARATOR . $file . $ext);
			if (is_file($filepath)) {
				ob_start();
				@require $filepath;
				$file = ob_get_contents();
				ob_end_clean();
				return $file;
			}
		}
		return false;
	}

	private function php($code = null) {
		$file = $code ? $code : $this->getVar('*');
		$pattern = "#<php>(.*?)</php>#s";
		if (preg_match_all($pattern, $file, $results, PREG_SET_ORDER)) {
			foreach ($results as &$php) {
				ob_start();
				try {
					eval($php[1]);
				} catch (Throwable $t) {
					echo <<<EOD
                <p class='myb__error_t'>$t</p>
              EOD;
				}
				$phpcode = ob_get_contents();
				ob_end_clean();
				if ($phpcode) {
					$file = str_replace($php[0], $phpcode, $file);
				} else {
					$file = str_replace($php[0], '<p class="myb__error_php_stat">Falied to add php statement.</p>', $file);
				}
			}
			return $this->setVar('*', $file);
		}
		return false;
	}

	private function import($file = null) {
		$file = $file ? $file : $this->getVar('*');
		$pattern = "#import ['\"](.*)['\"];#";
		if (preg_match_all($pattern, $file, $results, PREG_SET_ORDER)) {
			foreach ($results as &$import) {
				if ($fileadd = $this->load($import[1])) {
					$file = str_replace($import[0], $fileadd, $file);
				} else {
					$file = str_replace($import[0], "<p class='myb__error_imp'><h3>Error</h3>File '<em>$import[1]</em>' not found on 'import' statement.</p>", $file);
				}
			}
		}

		preg_match_all($pattern, $file, $results, PREG_SET_ORDER);

		if (empty($results)) {
			return $this->setVar('*', $file);
		} else {
			return $this->import($file);
		}
	}

	private function require($file = null){
		$file = $file ? $file : $this->getVar('*');
		$pattern = "#require ['\"](.*)['\"];#";
		if (preg_match_all($pattern, $file, $results, PREG_SET_ORDER)) {
			foreach ($results as &$require) {
				if ($fileadd = $this->add($require[1])) {
					$file = str_replace($require[0], $fileadd, $file);
				} else {
					$file = str_replace($require[0], "<p class='myb__error_req'><h3>Error</h3>File '<em>$require[1]</em>' not found on 'require' statement.</p>", $file);
				}
			}
		}

		preg_match_all($pattern, $file, $results, PREG_SET_ORDER);

		if (empty($results)) {
			return $this->setVar('*', $file);
		} else {
			return $this->require($file);
		}
	}

	private function include($file = null){
		$file = $file ? $file : $this->getVar('*');
		$pattern = "#<%include ['\"](.*)['\"];%>#";
		if (preg_match_all($pattern, $file, $results, PREG_SET_ORDER)) {
			foreach ($results as &$require) {
				$turned = $require[1];
				$file = str_replace($require[0], $require[1], $file);
			}
		}

		preg_match_all($pattern, $file, $results, PREG_SET_ORDER);

		return false;
		if (empty($results)) {
			return $this->setVar('*', $file);
		} else {
			return $this->require($file);
		}
	}

	private function getDeclaration(): bool {
		return false;
	}

	private function loop($file = null, Array $loop_array = array()) {
		$file = $file ? $file : $this->getVar('*');
		$pattern = "@<loop (?P<var>[a-zA-Z]+) in (?P<array>[a-zA-Z]+)>\s*(\s*.*?\s*)</loop>@si";
		preg_match_all($pattern, $file, $results, PREG_SET_ORDER);
		foreach ($results as $result) {
			$results = array();
			if ($array = $this->getVar($result['array'])) {
				foreach ($array as $item) {
					preg_match_all("@%$result[var]:(?P<variable>[a-zA-Z]+)%@s", $result[3], $replacement, PREG_SET_ORDER);
					$varToRep = array();
					$varRep = array();
					foreach ($replacement as $rep) {
						$varToRep[] = $rep[0];
						if(isset($item[$rep[1]])){
              $varRep[] = $item[$rep[1]];
            }else{
              $varRep[] = $rep[0];
            }
					}
					$results[] = str_replace($varToRep, $varRep, $result[3]);
				}
				krsort($results);
				$file = str_replace($result[3], implode("", $results), $file);
				$file = preg_replace("@<loop (?<var>[a-zA-Z]+) in (?<array>[a-zA-Z]+)>@s", "", $file);
				$file = preg_replace("@</loop>@s", "", $file);
			}
		}
		return $file = $this->setVar("*", $file);
	}

	private function if($file){
		$file = $file ? $file : $this->getVar('*');
		$pattern = "@<if (?<primaryCondition>[a-zA-Z]+) (?<condition>[<-=-=->]+) (?P<secondaryCondition>[a-zA-Z]+)>\s*(\s*.*?\s*)</endif>@si";
		preg_match_all($pattern, $file, $results, PREG_SET_ORDER);
	}

	private function catch($file = null){
		$db = DB::init();
		$file = $file ? $file : $this->getVar('*');
		$pattern2 = "#<%catch ['\"](?<variable>[a-zA-Z]+)['\"] from ['\"](?<content>[-a-z]+)['\"][^>]+(?<attributes>.*?)%>([\w\W]*?)<%catch%>#";
		$pattern = "#<Catch ['\"](?<variable>[a-zA-Z]+)['\"] from ['\"](?<content>[-a-z]+)['\"][^>]+(?<attributes>.*?)>([\w\W]*?)</Catch>#";
		preg_match_all($pattern, $file, $catches, PREG_SET_ORDER);
		if(!$catches)return false;
		foreach($catches as $catch){
			switch($catch['content']){
				case 'posts':
					$query = Query::posts([
						"limit" => 10 
					]);
					break;
				case 'single-post':
					if(isset($_REQUEST['postDate']) && isset($_REQUEST['postName'])){
						$postDate = date("Y-m", strtotime($_REQUEST['postDate']));
						$postName = $_REQUEST['postName'];
						$query = Query::posts([
							"date" => $postDate,
							"term" => $postName,
							"limit" => 1
						]);
					}
					break;
				case 'posts-by-cat':
					$cat = $_REQUEST['cat'];

					if(sizeof($cat) > 1){
						$query = Query::posts([
							"cat" => [
								$cat[0],
								"child" => $cat[1]
							],
							"limit" => 10
						]);
					}else{
						$query = Query::posts([
							"cat" => $cat[0],
							"limit" => 10
						]);
					}
					break;
				case 'category':
					$query = Query::category();
					break;
				case 'posts-by-tag':
					$tag = $_REQUEST['tag'];
					$sql = "SELECT * FROM `posts` as post INNER JOIN `post_tags` as tag on post.id = tag.post_id and tag.name = '$tag'";
					break;
				case 'tags':
					$query = Query::tags();
					break;
				case 'search-posts':
					$searchTerm = $_GET['q'];
					$query = Query::posts([
						"search" => $searchTerm
					]);
					$countResults = sizeof($query);
					$this->__set('search:term', $searchTerm);
					$this->__set('search:results', $countResults);
					break;
				default:
					$not_match_method = "This method not found, please check MyBlog Documentation";
			}

			/*
			$catchMode = $this->catchMode($catch['attributes']);

			if(array_key_exists('mode', $catchMode)){
				switch($catchMode['mode']){
					case 'latest':
						$sql .= " ORDER BY date DESC";
						break; 
				}
				$sql .= "";
			}

			if(array_key_exists('limit', $catchMode)){
				$limit = $catchMode['limit'];
				$sql .= " LIMIT $limit";
			}

			if(array_key_exists('category', $catchMode)){
				$cat = $catchMode['category'];
				#null
			}

			if(array_key_exists('tag', $catchMode)){
				$tag = $catchMode['category'];
				#null
			}*/

			$rep = [];
			if(!isset($query))return;
			foreach($query as $result){
				$rep[] = preg_replace_callback("@%$catch[variable]:(?<var>[a-zA-Z]+)%@", function($m) use($result){
					switch($m[1]){
						case 'url':
							$return = $this->generate_url($result);
							break;
						case 'date':
							$return = $this->generate_date_format($result['date']);
							break;
						default:
							if(!isset($result[$m[1]])){
								$return = $m[0];
							}else{
								$return = $result[$m[1]];
							}
					}

					return $return;
				}, $catch[4]);
			}

			if(!empty($rep)){
				krsort($rep);
				$rep = preg_replace("#<%not catch%>(.*?)<%not catch%>#s",null, $rep);
				$res = str_replace($catch[4], implode(null, $rep), $file);
				$file = $res;
			}else{
				if(preg_match("#<%not catch%>(?<msg>(.*?))<%not catch%>#s", $catch[4], $rep)){
					$file = str_replace($catch[4], $rep["msg"], $file);
				}else{
					$file = str_replace($catch[4], null, $file);
				}
			}
		}
		$pet2 = "#<%catch ['\"](?<variable>[a-zA-Z]+)['\"] from ['\"](?<content>[-a-z]+)['\"][^>]+%>(.*?)<%catch%>#s";
		$pet = "#<Catch ['\"](?<variable>[a-zA-Z]+)['\"] from ['\"](?<content>[-a-z]+)['\"][^>]+>(.*?)</Catch>#s";
		$file = preg_replace($pet, "$3", $file);
		return $file = $this->setVar("*", $file);
	}

	private function catchMode($tag): array
	{
		$catchMode = array();
		$attrArr = explode(" ", $tag);
		array_shift($attrArr);
		foreach($attrArr as $attr){
			$pattern = "#(?<name>[a-zA-Z]+)=['\"](?<value>[a-zA-Z0-9,.]+)['\"]#";
			preg_match($pattern, $attr, $attrRes);
			if($attrRes){
				$catchMode[strtolower($attrRes['name'])] = strtolower($attrRes['value']);
			}
		}
		return $catchMode;
	}

	private function generate_url(Array $data){
		if(array_key_exists('date', $data)){
			$url = Link::Post($data);
		}else{
			$url = Link::Category($data);
		}
		return $url;
	}

	private function generate_date_format($date): string
	{
		$date = strtotime($date);
		return date('d/m/Y H:i', $date);
	}

	private function get_post_by_url()
	{
		return null;
	}

	private function widgets(){
		return false;
	}

	private function textLimit($file = null){
		$file = $file ? $file : $this->getVar('*');
		$pattern = "/text::limit\\(['\"](?<text>.*?)['\"],[^>](?<length>[0-9]{0,4})\\)/s";
		if(preg_match_all($pattern, $file, $match, PREG_SET_ORDER)){
			foreach($match as $result){
				$limited = \MyB\Text::limit($result['text'], $result['length']);
				$file = str_replace($result[0], $limited, $file);
			}
		}
		return $this->setVar("*", $file);
	}

	private function templateFunctions($file = null){
		$file = $file ? $file : $this->getVar('*');
		$pattern = "/(<type>[a-z])::(<function>[a-z])\\((?<args>.*?)\\)/si";
		if(preg_match_all($pattern, $file, $match, PREG_SET_ORDER)){
			foreach($match as $result){
				switch($result['type']){
					default:
						$a = 'b';
				}
			}
		}
		return $this->setVar("*", $file);
	}

	public function render($file = 'teste.html', $var = '*') {
		$file = $this->load($file);
		return $this->setVar($var, $file);
	}

	public function __destruct() {
		$this->import();
		$this->require();
		$this->include();
		$this->php();
		$this->loop();
		$this->catch();
		$this->widgets();
		$this->replaceVars();
		$this->textLimit();
		$this->templateFunctions();

		/*foreach($this->extraFuncs as $extraFunc){
			eval('$this->'."${extraFunc}()");
		}*/

		$page = $this->getVar('*');
		if ($page) {
			return exit($page);
		}
	}

	public static function error($e) {
		return exit($e);
	}
}
