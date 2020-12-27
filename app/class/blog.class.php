<?php

namespace MyB;
use MyB\Permalink as Link;

class Blog {
	private $db;
	private $template;

	public function __construct(Array $options) {
		$this->db = $options['db'];
		$this->template = $options['template'];
		$this->action = $options['action'];
		$this->params = $options['params'];

		return $this->generate_template_variables();
	}

	public function generate_template_variables(): void
	{
		$blogname = $this->db->select("preferences", ["name" => "blog_name"]);
		$blogdesc = $this->db->select("preferences", ["name" => "blog_desc"]);
		$bloglang = $this->db->select("preferences", ["name" => "language"]);
		$this->template->var("blog:name", $blogname->value);
		$this->template->var("blog:desc", $blogdesc->value);
		$this->template->var("blog:url", Link::Home());
		$this->template->var("blog:lang", $bloglang->value);
		$this->template->var('blog:style', Link::Home() . 'static/style.css');
		$this->template->var("blog:url", Link::Home());
		$this->template->var("link:actual", Link::Actual());
		$this->template->var("feed", Link::Home() . "rss.xml");
		$this->template->var("static", Link::Home() . "static");
		$this->template->var("static:styles", Link::Home() . "static/css");
		$this->template->var("styles", Link::Home() . "static/css");
		$this->template->var("styles:default", Link::Home() . "static/css/style.css");
		$this->template->var("scripts", Link::Home() . "static/js/");
		return;
	}

	public function generate_template_functions() {
		return false;
	}

	private function renderHome() {
		return $this->template->render('index.html');
	}

	private function renderPost() {
		$postYear = $this->params['year'];
		$postMonth = $this->params['month'];
		$postName = $this->params['postname'];
		$postDate = "$postYear-$postMonth";
		if(isset($postDate, $postName) && !empty($postDate) || !empty($postName)){
			$_REQUEST['postDate'] = $postDate;
			$_REQUEST['postName'] = $postName;
			return $this->template->render('post.html');
		}else{
			return Error::get(404);
		}
	}

	private function renderPage() {
		$page = $this->params['page'];
		if(isset($this->params['page']) && !empty($this->params['page'])){
			echo 'aaa';
		}else{
			return Error::get(404);
		}
	}

	private function renderCat(){
		if(isset($this->params['cat']) && !empty($this->params['cat'])){
			$cat = explode('/', $this->params['cat']);
			$_REQUEST['cat'] = $cat;
			return $this->template->render('category.html');
		}else{
			$_REQUEST['cat'] = "myb__listing_categories:true";
			return Error::get(404);
		}
	}

	private function renderTag(){
		if(isset($this->params['tag']) && !empty($this->params['tag'])){
			$tag = $this->params['tag'];
			$_REQUEST['tag'] = $tag;
			return $this->template->render('tags.html');
		}else{
			$_REQUEST['tag'] = "myb__listing_tags:true";
			return Error::get(404);
		}
	}

	private function renderSearch(){
		if(isset($_GET['q']) && !empty($_GET['q'])){
			return $this->template->render('search.html');
		}else{
			$this->template->var("searchHome", true);
			return $this->template->render('search.html');
		}
	}

	private function renderStatic(){
		if(isset($this->params['file']) && !empty($this->params['file'])){
			$blog_template = Preferences::{'blog_template'}();
			return StaticFiles::{"./src/themes/$blog_template"}("./assets/".$this->params['file']);
		}else{
			return Error::get(404);
		}
	}

	public function __destruct() {
		switch ($this->action) {
			case 'home':
				return $this->renderHome();
				break;
			case 'post':
				return $this->renderPost();
				break;
			case 'page':
				return $this->renderPage();
				break;
			case 'category':
				return $this->renderCat();
				break;
			case 'tag':
				return $this->renderTag();
				break;
			case 'search':
				return $this->renderSearch();
				break;
			case 'static':
				return $this->renderStatic();
				break;
			default:
				return Error::get(404);
				break;
		}
	}
}
