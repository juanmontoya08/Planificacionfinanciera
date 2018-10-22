<?php

class Categories {
	private $self_file = 'categories_core.php';
	private $mysqli = false;
	private $session = false;
	
	public function __construct($m) { $this->mysqli = $m; }
	
	public function set_session_obj($obj) { $this->session = $obj; }
	
	public function get_cats($page, $plans_per_page) {
		$page = stripslashes($page);
		$plans_per_page = stripslashes($plans_per_page);
		
		if($page == 0 || $page == 1)
			$x = 0;
		else
			$x = ($plans_per_page * ($page-1));
		$y = $plans_per_page;
		$q = $this->query("SELECT * FROM pf_categoria ORDER BY id DESC LIMIT $x,$y", 'get_cats()');
		return $q;
	}
		public function get_category($category) {
		$q = $this->query('SELECT * FROM pf_factura WHERE categoria = "$category"', 'get_category()');
		return $q;
	}
	
	public function search($string, $page, $plans_per_page) {
		$s = "%$string%";
		
		if($page == 0 || $page == 1)
			$x = 0;
		else
			$x = ($plans_per_page * ($page-1));
		$y = $plans_per_page;

		$prepared = $this->prepare("SELECT * FROM pf_categoria WHERE id LIKE ? OR nombre LIKE ? OR descripcion LIKE ? OR fecha LIKE ? ORDER BY id DESC LIMIT $x,$y", 'search()');
		$this->bind_param($prepared->bind_param('sssss', $s, $s, $s, $s, $s), 'search()');
		$this->execute($prepared, 'search()');
		
		$result = $prepared->get_result();
		return $result;
	}
	
	public function count_cats() {
		$res = $this->query("SELECT COUNT(*) as c FROM pf_categoria", 'count_cats()');
		$obj = $res->fetch_object();
		return $obj->c;
	}

		public function general_warehouse_value() {
		$res = $this->query("SELECT SUM(cant_planificada) as s FROM pf_factura", 'general_warehouse_value()');
		$obj = $res->fetch_object();
		if($obj->s == '')
			return 0;
		return $this->parse_cost($obj->s);
	}
	
	public function count_cats_search($string) {
		$string = "%$string%";
		$prepared = $this->prepare("SELECT COUNT(*) as c FROM pf_categoria WHERE id LIKE ? OR nombre LIKE ? OR descripcion LIKE ? OR fecha LIKE ?", 'count_cats_search()');
		$this->bind_param($prepared->bind_param('sssss', $string, $string, $string, $string, $string), 'count_cats_search()');
		$this->execute($prepared, 'count_cats_search()');
		
		$result = $prepared->get_result();
		$row = $result->fetch_object();
		
		return $row->c;
	}
	
	public function get_category_name($id) {
		$prepared = $this->prepare("SELECT nombre FROM pf_categoria WHERE id=?", 'get_category_name()');
		$this->bind_param($prepared->bind_param('i', $id), 'get_category_name()');
		$this->execute($prepared, 'get_category_name()');
		
		$result = $prepared->get_result();
		$row = $result->fetch_object();
		
		return $row->nombre;
	}

	public function delete_cat($catid) {
		$prepared = $this->prepare("DELETE FROM pf_categoria WHERE id=?", 'delete_cat()');
		$this->bind_param($prepared->bind_param('i', $catid), 'delete_cat()');
		$this->execute($prepared, 'delete_cat()');
		return true;
	}
	
	public function get_cats_dropdown() {
		$q = $this->query("SELECT id,nombre FROM pf_categoria", 'get_cats_dropdown()');
		return $q;
	}
	
	public function new_cat($nombre, $desc) {
	$date = date_default_timezone_set('America/Bogota'); 
	$date= date('Y-m-d H:i:s');
		$prepared = $this->prepare("INSERT INTO pf_categoria(nombre, descripcion, fecha) VALUES(?,?,?)", 'new_cat()');
		$this->bind_param($prepared->bind_param('sss', $nombre, $desc, $date), 'new_cat()');
		$this->execute($prepared, 'new_cat()');
		return true;
	}
	
	public function edit_cat($catid, $nombre, $desc) {
		$prepared = $this->prepare("UPDATE pf_categoria SET nombre=?, descripcion=? WHERE id=?", 'edit_cat()');
		$this->bind_param($prepared->bind_param('ssi', $nombre, $desc, $catid), 'edit_cat()');
		$this->execute($prepared, 'edit_cat()');
		return true;
	}
	
	public function get_cat($catid) {
		$res = $this->query("SELECT * FROM pf_categoria WHERE id=$catid", 'get_cat()');
		$obj = $res->fetch_object();
		return $obj;
	}
	
		public function get_cat_reg_plans($catid) {
		$prepared = $this->prepare("SELECT COUNT(*) as c FROM pf_factura WHERE categoria=?", 'get_cat_reg_plans()');
		$this->bind_param($prepared->bind_param('i', $catid), 'get_cat_reg_plans()');
		$this->execute($prepared, 'get_cat_reg_plans()');
		
		$result = $prepared->get_result();
		$row = $result->fetch_object();
		return $row->c;
	}

	public function get_proy_reg_plans($proyidd) {
		$prepared = $this->prepare("SELECT COUNT(*) as c FROM pf_factura WHERE id_proyect=?", 'get_proy_reg_plans()');
		$this->bind_param($prepared->bind_param('i', $proyidd), 'get_proy_reg_plans()');
		$this->execute($prepared, 'get_proy_reg_plans()');
		
		$result = $prepared->get_result();
		$row = $result->fetch_object();
		return $row->c;
	}


	
	public function get_cat_tot_plans($catid) {
		$prepared = $this->prepare("SELECT SUM(archivo) as s FROM pf_factura WHERE categoria=?", 'get_cat_tot_plans()');
		$this->bind_param($prepared->bind_param('i', $catid), 'get_cat_tot_plans()');
		$this->execute($prepared, 'get_cat_tot_plans()');
		
		$result = $prepared->get_result();
		$row = $result->fetch_object();
		
		if($row->s == '')
			return 0;
		return $row->s;
	}

public function mensual_p($catid) {
		$prepared = $this->prepare("SELECT SUM(valor_total) as c FROM pf_factura WHERE categoria=?", 'mensual_p()');
		$this->bind_param($prepared->bind_param('i', $catid), 'mensual_p()');
		$this->execute($prepared, 'mensual_p()');

		$result = $prepared->get_result();
		$row = $result->fetch_object();
		if($row->c == '')
			return 0;
		return $row->c;
	}


	public function get_proy_tot_plans($proyidd) {
		$prepared = $this->prepare("SELECT SUM(archivo) as s FROM pf_factura WHERE id_proyect=?", 'get_proy_tot_plans()');
		$this->bind_param($prepared->bind_param('i', $proyidd), 'get_proy_tot_plans()');
		$this->execute($prepared, 'get_proy_tot_plans()');
		
		$result = $prepared->get_result();
		$row = $result->fetch_object();
		
		if($row->s == '')
			return 0;
		return $row->s;
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

$_cats = new Categories($mysqli);