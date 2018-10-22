<?php

class Compradors {
	private $self_file = 'compradors_core.php';
	private $mysqli = false;
	private $session = false;
	
	public function __construct($m) { $this->mysqli = $m; }
	
	public function set_session_obj($obj) { $this->session = $obj; }
	
	public function get_compradors($page, $plans_per_page) {
		$page = stripslashes($page);
		$plans_per_page = stripslashes($plans_per_page);
		
		if($page == 0 || $page == 1)
			$x = 0;
		else
			$x = ($plans_per_page * ($page-1));
		$y = $plans_per_page;
		$q = $this->query("SELECT * FROM pf_comprador ORDER BY id DESC LIMIT $x,$y", 'get_compradors()');
		return $q;
	}
	
	public function search($string, $page, $plans_per_page) {
		$s = "%$string%";
		
		if($page == 0 || $page == 1)
			$x = 0;
		else
			$x = ($plans_per_page * ($page-1));
		$y = $plans_per_page;

		$prepared = $this->prepare("SELECT * FROM pf_comprador WHERE id LIKE ? OR nombre LIKE ? OR descripcion LIKE ? OR fecha LIKE ? ORDER BY id DESC LIMIT $x,$y", 'search()');
		$this->bind_param($prepared->bind_param('sssss', $s, $s, $s, $s, $s), 'search()');
		$this->execute($prepared, 'search()');
		
		$result = $prepared->get_result();
		return $result;
	}
	
	public function count_compradors() {
		$res = $this->query("SELECT COUNT(*) as c FROM pf_comprador", 'count_compradors()');
		$obj = $res->fetch_object();
		return $obj->c;
	}
	
	public function count_compradors_search($string) {
		$string = "%$string%";
		$prepared = $this->prepare("SELECT COUNT(*) as c FROM pf_comprador WHERE id LIKE ? OR nombre LIKE ? OR descripcion LIKE ? OR fecha LIKE ?", 'count_compradors_search()');
		$this->bind_param($prepared->bind_param('sssss', $string, $string, $string, $string, $string), 'count_compradors_search()');
		$this->execute($prepared, 'count_compradors_search()');
		
		$result = $prepared->get_result();
		$row = $result->fetch_object();
		
		return $row->c;
	}
	
	public function delete_comprador($comprid) {
		$prepared = $this->prepare("DELETE FROM pf_comprador WHERE id=?", 'delete_comprador()');
		$this->bind_param($prepared->bind_param('i', $comprid), 'delete_comprador()');
		$this->execute($prepared, 'delete_comprador()');
		return true;
	}
	
	public function get_compradors_dropdown() {
		$q = $this->query("SELECT id,nombre FROM pf_comprador", 'get_compradors_dropdown()');
		return $q;
	}
	
	public function new_comprador($nombre, $desc) {
	$date = date_default_timezone_set('America/Bogota'); 
	$date= date('Y-m-d H:i:s');
		$prepared = $this->prepare("INSERT INTO pf_comprador(nombre, descripcion, fecha) VALUES(?,?,?)", 'new_comprador()');
		$this->bind_param($prepared->bind_param('sss', $nombre, $desc, $date), 'new_comprador()');
		$this->execute($prepared, 'new_comprador()');
		return true;
	}
	
	public function edit_comprador($comprid, $nombre, $desc) {
		$prepared = $this->prepare("UPDATE pf_comprador SET nombre=?, descripcion=? WHERE id=?", 'edit_comprador()');
		$this->bind_param($prepared->bind_param('ssi', $nombre, $desc, $comprid), 'edit_comprador()');
		$this->execute($prepared, 'edit_comprador()');
		return true;
	}
	
	public function get_comprador($comprid) {
		$res = $this->query("SELECT * FROM pf_comprador WHERE id=$comprid", 'get_comprador()');
		$obj = $res->fetch_object();
		return $obj;
	}
	
		public function get_comprador_reg_plans($comprid) {
		$comprid = "%$comprid%";
		$prepared = $this->prepare("SELECT COUNT(*) as c FROM pf_factura WHERE comprador like ?", 'get_comprador_reg_plans()');
		$this->bind_param($prepared->bind_param('s', $comprid), 'get_comprador_reg_plans()');
		$this->execute($prepared, 'get_comprador_reg_plans()');
		
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


	
	public function get_comprador_tot_plans($comprid) {
		$prepared = $this->prepare("SELECT SUM(archivo) as s FROM pf_factura WHERE comprador=?", 'get_comprador_tot_plans()');
		$this->bind_param($prepared->bind_param('i', $comprid), 'get_comprador_tot_plans()');
		$this->execute($prepared, 'get_comprador_tot_plans()');
		
		$result = $prepared->get_result();
		$row = $result->fetch_object();
		
		if($row->s == '')
			return 0;
		return $row->s;
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

$_compradors = new Compradors($mysqli);