<?php

class Proyects {
	private $self_file = 'proyect_core.php';
	private $mysqli = false;
	private $session = false;
	
	public function __construct($m) { $this->mysqli = $m; }
	
	public function set_session_obj($obj) { $this->session = $obj; }
	
	public function get_proyect($page, $items_per_page) {
		$page = stripslashes($page);
		$items_per_page = stripslashes($items_per_page);
		
		if($page == 0 || $page == 1)
			$x = 0;
		else
			$x = ($items_per_page * ($page-1));
		$y = $items_per_page;
		$q = $this->query("SELECT * FROM pf_proyect ORDER BY id ASC LIMIT $x,$y", 'get_proyect()');
		return $q;
	}
	
	public function search_p($string, $page, $items_per_page) {
		$s = "%$string%";
		
		if($page == 0 || $page == 1)
			$x = 0;
		else
			$x = ($items_per_page * ($page-1));
		$y = $items_per_page;

		$prepared = $this->prepare("SELECT * FROM pf_proyect WHERE id LIKE ? OR nombre LIKE ? OR descripcion LIKE ? ORDER BY id DESC LIMIT $x,$y", 'search_p()');
		$this->bind_param($prepared->bind_param('sss', $s, $s, $s), 'search_p()');
		$this->execute($prepared, 'search_p()');
		
		$result = $prepared->get_result();
		return $result;
	}
	
	public function count_proyects() {
		$res = $this->query("SELECT COUNT(*) as c FROM pf_proyect", 'count_proyects()');
		$obj = $res->fetch_object();
		return $obj->c;
	}

	public function count_items() {
		$res = $this->query("SELECT COUNT(*) as c FROM pf_items", 'count_items()');
		$obj = $res->fetch_object();
		return $obj->c;
	}

	public function count_proyect_search($string) {
		$string = "%$string%";
		$prepared = $this->prepare("SELECT COUNT(*) as c FROM pf_proyect WHERE id LIKE ? OR nombre LIKE ? OR descripcion LIKE ? ", 'count_proyect_search()');
		$this->bind_param($prepared->bind_param('sss', $string, $string, $string), 'count_proyect_search()');
		$this->execute($prepared, 'count_proyect_search()');
		
		$result = $prepared->get_result();
		$row = $result->fetch_object();
		
		return $row->c;
	}
	
	public function get_proyect_name($id) {
		$prepared = $this->prepare("SELECT nombre FROM pf_proyect WHERE id=?", 'get_proyect_name()');
		$this->bind_param($prepared->bind_param('i', $id), 'get_proyect_name()');
		$this->execute($prepared, 'get_proyect_name()');
		
		$result = $prepared->get_result();

		$row = $result->fetch_object();
		return $row->nombre;
	}
	
	public function delete_proyect($proyidd) {
		$prepared = $this->prepare("DELETE FROM pf_proyect WHERE id=?", 'delete_proyect()');
		$this->bind_param($prepared->bind_param('i', $proyidd), 'delete_proyect()');
		$this->execute($prepared, 'delete_proyect()');
		return true;
	}
	
	public function get_proys_dropdown() {
		$q = $this->query("SELECT id, nombre FROM pf_proyect", 'get_proys_dropdown()');
		return $q;
	}

	public function get_items_dropdown() {
		$q = $this->query("SELECT id, name, qty FROM pf_items", 'get_items_dropdown()');
		return $q;
	}
	
	public function new_proy($nombre, $descripcion) {
				
		$prepared = $this->prepare("INSERT INTO pf_proyect (nombre,descripcion) VALUES (?,?)", 'new_proy()');
		$this->bind_param($prepared->bind_param('ss', $nombre, $descripcion), 'new_proy()');
		$this->execute($prepared, 'new_proy()');
		return true;
	}
	
	public function edit_proyect($proyidd, $nombre, $descripcion) {
		$prepared = $this->prepare("UPDATE pf_proyect SET nombre=?, descripcion=? WHERE id=?", 'edit_proyect()');
		$this->bind_param($prepared->bind_param('ssi', $nombre, $descripcion, $proyidd), 'edit_proyect()');
		$this->execute($prepared, 'edit_proyect()');
		return true;
	}
	public function get_proyectss($proyidd) {
		$res = $this->query("SELECT * FROM pf_proyect WHERE id=$proyidd", 'get_proyectss()');
		$obj = $res->fetch_object();
		return $obj;
	}
	
	
	/***
	  *  Private functions
	  *
	***/
	private function prepare($query, $func) {
		$prepared = $this->mysqli->prepare($query);
		if(!$prepared)
			die("Couldn't prepare query. inc/{$this->self_file} - $func");
		return $prepared;
	}
	private function bind_param($param, $func) {
		if(!$param)
			die("Couldn't bind parameters. inc/{$this->self_file} - $func");
		return $param;
	}
	private function execute($prepared, $func) {
		$exec = $prepared->execute();
		if(!$exec)
			die("Couldn't execute query. inc/{$this->self_file} - $func");
		return $exec;
	}
	private function query($query, $func) {
		$q = $this->mysqli->query($query);
		if(!$q)
			die("Couldn't run query. inc/{$this->self_file} - $func");
		return $q;
	}
	public function __destruct() {
		if(is_resource($this->mysqli) && get_resource_type($this->mysqli) == 'mysql link')
			$this->mysqli->close();
	}
}

$_proys = new Proyects($mysqli);