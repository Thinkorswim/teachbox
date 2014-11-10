<?php
	 function getFirstName($name){
		$firstname = explode(' ', $name);
		return $firstname[0];
	}

	function getThumbName($name){
			$newThumbExtension = substr($name, -4);
			$newThumbName = substr($name, 0, -4);

			return $newThumbName . '-100x100'.$newThumbExtension;
	}
?>