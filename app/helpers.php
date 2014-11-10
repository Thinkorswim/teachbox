<?php
	 function getFirstName($name){
		$firstname = explode(' ', $name);
		return $firstname[0];
	}
?>