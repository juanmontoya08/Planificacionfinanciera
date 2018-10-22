<?php

class Plans {
	private $self_file = 'plan_core.php';
	private $mysqli = false;
	private $session = false;
	
	public function __construct($m) { $this->mysqli = $m; }
	
	public function set_session_obj($obj) { $this->session = $obj; }
	
	public function get_plans($page, $plans_per_page) {
		$page = stripslashes($page);
		$plans_per_page = stripslashes($plans_per_page);
		
		if($page == 0 || $page == 1)
			$x = 0;
		else
			$x = ($plans_per_page * ($page-1));
		$y = $plans_per_page;
		
		$res = $this->query("SELECT * FROM pf_factura ORDER BY id ASC", 'get_plans()');
		return $res;
	}



	public function get_plans_checkin($page, $plans_per_page) {
		$page = stripslashes($page);
		$plans_per_page = stripslashes($plans_per_page);
		
		if($page == 0 || $page == 1)
			$x = 0;
		else
			$x = ($plans_per_page * ($page-1));
		$y = $plans_per_page;
		
		$res = $this->query("SELECT * FROM pf_factura where `estado`= 0 ORDER BY date_added ASC", 'get_plans_checkin()');
		return $res;
	}
	
	public function get_cat_proy_plans($catid) {
		$prepared = $this->prepare("SELECT COUNT(*) as c FROM pf_factura WHERE id_proyect=?", 'get_cat_proy_plans()');
		$this->bind_param($prepared->bind_param('i', $catid), 'get_cat_proy_plans()');
		$this->execute($prepared, 'get_cat_proy_plans()');
		
		$result = $prepared->get_result();
		$row = $result->fetch_object();
		return $row->c;
	}

	public function get_plans_checkout($page, $plans_per_page) {
		$page = stripslashes($page);
		$plans_per_page = stripslashes($plans_per_page);
		
		if($page == 0 || $page == 1)
			$x = 0;
		else
			$x = ($plans_per_page * ($page-1));
		$y = $plans_per_page;
		
		$res = $this->query("SELECT * FROM pf_factura where `estado`= 1 ORDER BY date_added ASC", 'get_plans_checkin()');
		return $res;
	}


	
	public function count_plans() {
		$res = $this->query("SELECT COUNT(*) as c FROM pf_factura", 'count_plans()');
		$obj = $res->fetch_object();
		return $obj->c;
	}
	
	public function count_plans_search($string) {
		$s = "%$string%";
		$prepared = $this->prepare("SELECT COUNT(*) as c FROM pf_factura WHERE id LIKE ? OR archivo LIKE ? OR caras LIKE ? OR tamaño LIKE ? OR desde LIKE ? OR hasta LIKE ? OR descripcion LIKE ? OR date_added LIKE ? OR id_proyect LIKE ?", 'count_plans_search()');
		$this->bind_param($prepared->bind_param('sssssssss', $s, $s, $s, $s, $s, $s, $s, $s, $s), 'count_plans_search()');
		$this->execute($prepared, 'count_plans_search()');
		
		$result = $prepared->get_result();
		$row = $result->fetch_object();
		return $row->c;
	}
	
	public function search($string, $page, $plans_per_page) {
		$s = "%$string%";
		if($page == 0 || $page == 1)
			$x = 0;
		else
			$x = ($plans_per_page * ($page-1));
		$y = $plans_per_page;
		
		$prepared = $this->prepare("SELECT * FROM pf_factura WHERE id LIKE ? OR archivo LIKE ? OR caras LIKE ? OR tipo LIKE ? OR desde LIKE ? OR hasta LIKE ? OR descripcion LIKE ? OR date_added LIKE ? OR id_proyect LIKE ? ORDER BY id ASC LIMIT $x,$y", 'search()');
		$this->bind_param($prepared->bind_param('ssssssssss', $s, $s, $s, $s, $s, $s, $s, $s, $s), 'search()');
		$this->execute($prepared, 'search()');
		
		$result = $prepared->get_result();
		return $result;
	}
	
	public function get_category_name($id) {
		$prepared = $this->prepare("SELECT name FROM pf_categories WHERE id=?", 'get_category_name()');
		$this->bind_param($prepared->bind_param('i', $id), 'get_category_name()');
		$this->execute($prepared, 'get_category_name()');
		
		$result = $prepared->get_result();
		$row = $result->fetch_object();
		
		return $row->name;
	}

		public function get_users_name($id) {
		$prepared = $this->prepare("SELECT name FROM pf_users WHERE id=?", 'get_users_name()');
		$this->bind_param($prepared->bind_param('i', $id), 'get_users_name()');
		$this->execute($prepared, 'get_users_name()');
		
		$result = $prepared->get_result();
		$row = $result->fetch_object();
		
		return $row->name;
	}
	
	
	public function get_proyect_name($id) {
		$prepared = $this->prepare("SELECT nombre FROM pf_proyect WHERE id=?", 'get_proyect_name()');
		$this->bind_param($prepared->bind_param('i', $id), 'get_proyect_name()');
		$this->execute($prepared, 'get_proyect_name()');
		
		$result = $prepared->get_result();

		$row = $result->fetch_object();
		return $row->nombre;
	}


	public function get_plan_name($id) {
		$prepared = $this->prepare("SELECT archivo FROM pf_factura WHERE id=?", 'get_plan_name()');
		$this->bind_param($prepared->bind_param('i', $id), 'get_plan_name()');
		$this->execute($prepared, 'get_plan_name()');
		
		$result = $prepared->get_result();
		$row = $result->fetch_object();
		
		return $row->name;
	}
	
	public function delete_plan($id, $archivo) {
		$prepared = $this->prepare("DELETE FROM pf_factura WHERE id=?", 'delete_plan()');
		$this->bind_param($prepared->bind_param('i', $id), 'delete_plan()');
		$this->execute($prepared, 'delete_plan()');

		unlink($archivo);
		return false;
	}
	
	
public function new_plan($descripcion, $categoria, $cant_planificada, $cant_comprada, $valor_planificado, $valor_comprado, $comprador, $archivo1, $date) {		
		$prepared = $this->prepare("INSERT INTO `pf_factura`(descripcion, categoria, cant_planificada, cant_comprada, valor_planificado, valor_comprado, comprador, archivo, date_added)  VALUES (?,?,?,?,?,?,?,?,?)", 'new_plan()');
		$this->bind_param($prepared->bind_param('siiiiisss', $descripcion, $categoria, $cant_planificada, $cant_comprada, $valor_planificado, $valor_comprado, $comprador, $archivo1, $date), 'new_plan()');
		$this->execute($prepared, 'new_plan()');
		
		return true;
	}
	
	public function get_plan($planid) {
		$prepared = $this->prepare("SELECT * FROM pf_factura WHERE id=?", 'get_plan()');
		$this->bind_param($prepared->bind_param('i', $planid), 'get_plan()');
		$this->execute($prepared, 'get_plan()');
		
		$result = $prepared->get_result();
		$row = $result->fetch_object();
		
		return $row;
	}

	public function get_planu($planid) {
		$res= $this->query("SELECT * FROM pf_factura WHERE usuario=$planid", 'get_planu()');

		return $res;

	}

public function get_planp($planid) {
		$res= $this->query("SELECT * FROM pf_factura WHERE id_proyect=$planid", 'get_planp()');

		return $res;

	}
	
	public function update_plan($planid, $descripcion, $categoria, $cant_planificada, $cant_comprada, $valor_planificado, $valor_comprado, $comprador) {
		// Create log
		//$update = $this->new_log(3, $planid, false, $price);

		$prepared = $this->prepare("UPDATE pf_factura SET descripcion=?, categoria=?, cant_planificada=?, cant_comprada=?, valor_planificado=?, valor_comprado=?, comprador=? WHERE id=?", 'update_plan()');
		$this->bind_param($prepared->bind_param('siiiiisi', $descripcion, $categoria, $cant_planificada, $cant_comprada, $valor_planificado, $valor_comprado,  $comprador, $planid), 'update_plan()');
		$this->execute($prepared, 'update_plan()');
		return true;
	}
	
	public function parse_price($p) {
		return $p;
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

$_plans = new Plans($mysqli);