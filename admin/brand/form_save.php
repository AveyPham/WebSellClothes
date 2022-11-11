<?php
if(!empty($_POST)) {
	$id = getPost("id");
	$name = getPost("name");

	if($id > 0) {
		//update
		$sql = "update brand set name = '$name' where id = $id";
		execute($sql);
	} else {
		//insert
		$sql = "insert into brand(name) values ('$name')";
		execute($sql);
	}
}