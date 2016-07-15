<?php
/*
CRUD CLASS
zato93s
zato93one@gmail.com
v 1.0
*/
class CRUD{
	function __construct($income) {
		$defaultOptions = array("fns" => "crud", "idfield" => "owner", "crlimit" => 0);
		$options = array_merge($defaultOptions, $income);

		if(isset($income["fns"])){
			$this->fns=$income["fns"];
		} else {
			$this->fns='crud';
		}
		$this->table=$options["table"];
		$this->idfield=$options["idfield"];
		$this->crlimit=$options["crlimit"];
		$this->structure=$options["structure"];
		$this->fields=join(',',$options["structure"]);

	}
	public function sqlquery($data){
		$set_update = [];
		foreach($data as $key=>$value){
			if(in_array($key,$this->structure)&&$key!='id'&&gettype($value)=='string'){
				$set_update[$key] = $value;
			}
		}
		return $set_update;
	}
	public function filter_string($income){
		$filters=[''];
		foreach ($income as $filter) {
			if(isset($filter["name"])&&isset($filter["value"])){
				$filters[]=db()->parse("?n = ?s",$filter["name"],$filter["value"]);
			}
		}
		return  implode(" AND ",$filters);
	}
	public function read($income=false){
		if(strpos($this->fns,'r')===false)return array(status=>-1);
		global $userid;
		if(isset($income["id"])){
			$item=db()->getRow("SELECT ?p FROM ?n WHERE id=?i AND ?n=?i",$this->fields,$this->table,$income["id"],$this->idfield,$userid);
			return array("item"=>$item);
		} else {
			$adds=array();
			if(isset($income["sort"])){
				$adds[]=db()->parse(' ORDER BY ?p',$income["sort"]);
			}
			if(isset($income["limit"])){
				if(isset($income["start"])){
					$adds[]=db()->parse(' LIMIT ?i,?i',$income["start"],$income["limit"]);
				}
				else {
					$adds[]=db()->parse(' LIMIT ?i',$income["limit"]);
				}
			}
			$adds=implode(" ",$adds);
			if(isset($income["filters"])){
				$filterstr=$this->filter_string($income["filters"]);
			} else {
				$filterstr='';
			}
			$items=db()->getAll("SELECT ?p FROM ?n WHERE ?n=?i ?p ?p",$this->fields,$this->table,$this->idfield,$userid,$filterstr,$adds);
			$qty=db()->getRow("SELECT COUNT(*) as qty FROM ?n WHERE ?n=?i ?p",$this->table,$this->idfield,$userid,$filterstr);
			return array("items"=>$items,"qty"=>$qty["qty"]);
		}
	}
	public function save($income){
		if(strpos($this->fns,'u')===false)return array("status"=>-1);
		global $userid;
		$set_update=$this->sqlquery($income);
		if(!count($set_update)){
			die('{}');
		}
		if(isset($income["id"])) {
			$status=db()->query("UPDATE ?n SET ?u WHERE id=?i AND ?n=?i",$this->table,$set_update,$income["id"],$this->idfield,$userid);
			$income["status"]=$status?'success':'error';
			return $income;
		}
	}
	public function create($income){
		if(strpos($this->fns,'c')===false)return array("status"=>-1);
		global $userid;
		$set_update=$this->sqlquery($income);
		if(!count($set_update)){
			die('{}');
		}
		$set_update[$this->idfield]=$userid;
		if($this->crlimit){
			$found=db()->getRow("SELECT count(*) as qty FROM ?n WHERE ?n=?i",$this->table,$this->idfield,$userid);
			if($found["qty"]>=$this->crlimit){
				return array("error"=>true,"code"=>'LIMIT_REACHED');
			}
		}
		$result=db()->query("INSERT INTO ?n SET ?u",$this->table,$set_update);

		if($result){
			return array("status"=>1,"id"=>db()->insertId());
		} else {
			return array("error"=>true,"code"=>"UNDEFINED_ERROR");
		}
	}
	public function delete($income){
		if(!isset($income["id"])){
			return array("error"=>true,"code"=>"ID_IS_NOT_DEFINED");
		}
		if(strpos($this->fns,'d')===false)return array("status"=>-1);
		global $userid;
		$result=db()->query("DELETE FROM ?n WHERE id=?i AND ?n=?i",$this->table,$income["id"],$this->idfield,$userid);
		//print_r($result);
		if($result){
			return array("status"=>1);
		} else {
			return array("error"=>true,"code"=>"UNDEFINED_ERROR");
		}
	}
}



?>