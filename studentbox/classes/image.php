<?php
class Image extends CRUD{
	private $id;
	private $name;
	private $path = "img/services/";
	private $alt;
	private $filetype;
	private $file;
	private $root = "";

	public function __construct($id = false, $table = "images"){
		parent::__construct($table);
		if($id !== false){
			$this->id = $id;
			$this->readImage();
		}
	}
	public function getId(){
		return $this->id;
	}
	public function getName(){
		return $this->name;
	}
	public function getPath(){
		return $this->path;
	}
	public function getAlt(){
		return $this->alt;
	}
	public function setId($int){
		$this->id = $int;
	}
	public function setName($str){
		$this->name = $str;
	}
	public function setPath($str){
		$this->path = $str;
	}
	public function setAlt($str){
		$this->alt = $str;
	}
	public function setFile($file){
		$this->file = $file;
	}
	public function setRoot($str){
		$this->root = $str;
	}
	public function createImage(){
		$valid = true;
		//echo $this->file["name"];
		//print_r($this->file);
		$check = getimagesize($this->file["tmp_name"]);
		//print_r($check);
		$this->filetype = strtolower(pathinfo($this->file["name"],PATHINFO_EXTENSION));
		if($check === false){
			echo "false image";
			$valid = false;
		}
		if($this->file["size"] > 2000000){
			echo "file too large";
			$valid = false;
		}
		if(file_exists($this->path . $this->filename())){
			echo "exists";
			$valid = false;
		}
		if($this->filetype != "jpg" && $this->filetype != "png" && $this->filetype != "jpeg" && $this->filetype != "gif" ){
			echo "wrong filetype";
			$valid = false;
		}
		if($valid){
			if(move_uploaded_file($this->file["tmp_name"], $this->root . $this->path . $this->filename())){
				$this->create(array(
					"name" => $this->name,
					"path" => $this->path,
					"filetype" => $this->filetype,
					"alt" => $this->alt
				));
				$this->id = $this->getCon()->lastInsertId();
			}
		}
	}
	public function readImage(){
		$columns = array(
			"name",
			"path",
			"filetype",
			"alt"
		);
		$obj = $this->read($columns, "id = " . $this->id);
		if($obj){
			$obj = $obj->fetchObject();
			$this->name = $obj->name;
			$this->path = $obj->path;
			$this->filetype = $obj->filetype;
			$this->alt = $obj->alt;
		}
	}
	public function updateImage(){
		
	}
	public function deleteImage(){
		
	}
	private function filename(){
		return str_replace(" ", "_", $this->name) . "." . $this->filetype;
	}
	public function __toString(){
		return $this->root . $this->getPath() . $this->filename();
	}
}
?>