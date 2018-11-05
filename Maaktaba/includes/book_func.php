<?php
require_once("database.php");

class book{
	private $book_title;
	private $book_image;
	private $book_cost;
	private $book_info;
	private $book_category;
	
	public static function insert_book($book_title,$book_image,$book_cost,$book_info,$book_category){
		global $database;
		$insertbook="INSERT INTO books(booktitle,book_image,book_cost,book_info,book_category) VALUES('{$book_title}','{$book_image}','{$book_cost}','{$book_info}','{$book_category}')";
		$insert_Student=$database->run_query($insertbook);
		return $insert_Student; 
		
	}
	public static function select_books(){
		global $database;
		$query="SELECT * FROM books";
		$result=$database->run_query($query);
		return $result;
	}
	
}
	
$Books= new book();
?>