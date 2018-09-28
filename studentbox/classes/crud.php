<?php
class CRUD{
	private $db;
	private $table;
	private $numRows = 0;
	private $operators = array("=", "<>", ">", "<", ">=", "<=", "BETWEEN", "LIKE", "IN");

	public function __construct($table){
		$this->setTable($table);
	}
	public function getTable(){
		return $this->table;
	}
	public function setTable($table){
		if($this->validateTable($table)){
			$this->table = $table;
		}
	}
	public function getCon(){
		return DbObj::getInstance()->getCon();
	}
	public function numRows(){
		return $this->numRows;
	}
	public function create($data){
		$validation = true;
		$count = count($data);
		foreach($data as $key => $value){
			if(!$this->validateColumn($key)){
				$validation = false;
			}
			$columns[] = $key;
			$params[] = $value;
			$template[] = "?";
		}
		if($validation){
			$columns = implode(", ", $columns);
			$template = implode(", ", $template);
			$sql = "INSERT INTO $this->table (" . $columns . ") VALUES (" . $template . ")";
			$query = DbObj::getInstance()->getCon()->prepare($sql);
			$query->execute($params);
		}
	}
	public function read($column = "*", $search = false, $order = false){
		if($this->validateColumn($column)){
			$sql = "SELECT COUNT(*) FROM " . $this->table;
			if($search){
				$sql .= " WHERE " . $search;
			}
			if($res = DbObj::getInstance()->getCon()->query($sql)){
				if($this->numRows = $res->fetchColumn() > 0){
					if(is_array($column)){
						$column = implode(", ", $column);
					}
					$sql = "SELECT " . $column . " FROM " . $this->table;
					// Support for secure advanced WHERE clause - work in progress

					/*if(strpos($search, "AND") !== true || strpos($search, "OR") !== true || strpos($search, "AND NOT") !== true || strpos($search, "OR NOT") !== true){
						$searchArr = explode($search, " ");
						foreach($this->operators as $value){
							if($value == $searchArr[1]){
								$operators[] = $value;
							}
						}
					if($search){
						$sql .= " WHERE :search";
						$params[":search"] = $search;
					}
					}*/

					// Current WHERE clause is insecure
					if($search){
						$sql .= " WHERE " . $search;
					}
					if($order){
						if(!is_array($order)){
							$valCheck = true;
							$order = explode(" ", $order);
							if(count($order) == 2){
								$col = $order[0];
								$seq = $order[1];
							}
							else{
								$col = $order[0];
								$seq = "ASC";
							}
							if($this->validateTable($col)){
								$ascor = ($seq == "DESC" ? "DESC" : "ASC");
								$sql .= " ORDER BY " . $col . " " . $ascor;
							}
						}
					}
					//echo $sql;
					$query = DbObj::getInstance()->getCon()->prepare($sql);
					if(isset($params)){
						$query->execute($params);
					}
					else{
						$query->execute();
					}

					return $query;


				}
			}
			else{
				return false;
				$numRows = 0;
			}
		}
	}
	public function update($data, $search){
		$validation = true;
		if(!$this->validateTable($this->table)){
			$validation = false;
		}
		$count = count($data);
		foreach($data as $key => $value){
			if(!$this->validateColumn($key)){
				$validation = false;
			}
			$columns[] = $key . " = ?";
			$values[] = $value;
		}
		if($validation){
			$columns = implode(", ", $columns);
			// Current WHERE clause is insecure
			$sql = "UPDATE $this->table SET " . $columns . " WHERE " . $search;
			$query = DbObj::getInstance()->getCon()->prepare($sql);
			$query->execute($values);
		}
	}
	public function delete($search){
		if($this->validateTable($this->table)){
			// Current WHERE clause is insecure
			$sql = "DELETE FROM " . $this->table . " WHERE " . $search;
			$query = DbObj::getInstance()->getCon()->prepare($sql);
			$query->execute();
		}
	}
	private function validateColumn($data){
		if(is_array($data)){
			$bool = true;
			foreach($data as $value){
				if(!preg_match("/^[a-zA-Z0-9_]*$/", $value)){
					$bool = false;
				}
			}
			return $bool;
		}
		else{
			if(preg_match("/^[a-zA-Z0-9_]*$/", $data) || $data === "*"){
				return true;
			}
			else{
				return false;
			}
		}
	}
	private function validateTable($data){
		return preg_match("/^[a-zA-Z0-9_]*$/", $data);
	}
}
?>