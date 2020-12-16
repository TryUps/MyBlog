<?php

namespace MyB;

class View {
	public static function Use ($name, Array $req = null) {
		return include_once dirname(__FILE__) . '/../views/' . $name . '/index.php';
	}
}
