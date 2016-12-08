<?php

class databaseConnect {
	
	function saveEmail() {

		$userEmail = $_POST['email'];

		$link = mysqli_connect("localhost", "cl53-appshot", "9Ut3bm-UU", "cl53-appshot");

		$query = "INSERT INTO `users` (`email`) VALUES ('$userEmail')";

		mysqli_query($link, $query);

	}

}

?>