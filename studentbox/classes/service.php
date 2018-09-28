<?php
class Service extends CRUD{
	private $id;
	private $name;
	private $price;
	private $category;
	private $images = array();
	private $people = 1;
	private $duration = 5;

	public function __construct($id = false, $table = "services"){
		parent::__construct($table);
		if($id !== false){
			$this->id = $id;
			$this->readService();
		}
	}
	public function getName(){
		return $this->name;
	}
	public function getId(){
		return $this->id;
	}
	public function getPrice(){
		return $this->price;
	}
	public function getTotal(){
		$price = $this->price / 5 * $this->duration * $this->people;
		return $price;
	}
	public function getCategory(){
		return $this->category;
	}
	public function getImages(){
		return $this->images;
	}
	public function getImage($int){
		return $this->images[$int];
	}
	public function getPeople(){
		return $this->people;
	}
	public function getDuration(){
		return $this->duration;
	}
	public function setName($str){
		$this->name = $str;
	}
	public function setId($int){
		$this->id = $int;
	}
	public function setPrice($decimal){
		$this->price = $decimal;
	}
	public function setCategory($str){
		$this->category = $str;
	}
	public function setImages($arr){
		$images = array();
		foreach($arr as $image){
			$images[] = $image; 
		}
		$this->images = $images;
	}
	public function setPeople($int){
		$this->people = $int;
	}
	public function setDuration($int){
		$this->duration = $int;
	}
	public function addImage($id){
		$tmp = new Image($id);
		$this->images[] = $tmp;
	}
	public function createService(){
		$this->setTable("categories");
		$cat = $this->read("id", "name = '" . $this->category . "'");
		if($cat){
			$cat = $cat->fetchObject();
		}
		if(!$this->numRows() > 0){
			$this->create(array("name" => $this->category));
			$catId = $this->getCon()->lastInsertId();
		}
		else{
			$catId = $cat->id;
		}
		$this->setTable("services");
		$columns = array(
			"name" => $this->name,
			"price" => $this->price,
			"categories_id" => $catId
		);
		$this->create($columns);
		$this->id = $this->getCon()->lastInsertId();
		$this->setTable("services_has_images");
		foreach($this->images as $image){
			$data = array(
				"services_id" => $this->id,
				"images_id" => $image->getId()
			);
			$this->create($data);
		}
		$this->setTable("services");
	}
	public function readService(){
		$columns = array(
			"name",
			"price",
			"categories_id"
		);
		$obj = $this->read($columns, "id = '" . $this->id . "'")->fetchObject();
		$this->name = $obj->name;
		$this->price = $obj->price;
		$this->setTable("categories");
		$cat = $this->read("name", "id = '" . $obj->categories_id . "'")->fetchObject();
		$this->category = $cat->name;
		$this->setTable("services_has_images");
		$res = $this->read("images_id", "services_id = " . $this->id);
		if($res){
			while($obj = $res->fetchObject()){
				$this->images[] = new Image($obj->images_id);
			}
		}
		$this->setTable("services");
	}
	public function updateService(){
		$this->setTable("categories");
		$cat = $this->read("id", "name = '" . $this->category . "'")->fetchObject();
		$this->setTable("services");
		$columns = array(
			"name" => $this->name,
			"price" => $this->price,
			"categories_id" => $cat->id
		);
		$this->update($columns, "id = " . $this->id);
	}
	public function deleteService(){
		$this->delete("id = " . $this->id);
	}
}
?>