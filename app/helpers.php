<?php
	function getFirstName($name){
		$firstname = explode(' ', $name);
		return $firstname[0];
	}

	function getDay($date){
		if($date != ''){
			$day = explode('/', $date);
			return $day[0];
		}

		return '';
	}

	function getMonth($date){
		if($date != ''){
			$month = explode('/', $date);
			return $month[1];
		}

		return '';
	}

	function getYear($date){
		if($date != ''){
			$year = explode('/', $date);
			return $year[2];
	    }

		return '';
	}

	function getThumbName($name){
			$newThumbExtension = substr($name, -4);
			$newThumbName = substr($name, 0, -4);

			return $newThumbName . '-100x100'.$newThumbExtension;
	}
?>