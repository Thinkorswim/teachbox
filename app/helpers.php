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

	function ageCalculator($dob){
		$day = getDay($dob);
		$month = getMonth($dob);
		$year = getYear($dob);
		$dob = $day.'-'.$month.'-'.$year;
		if(!empty($dob)){
			$birthdate = new DateTime($dob);
			$today   = new DateTime('today');
			$age = $birthdate->diff($today)->y;
			return $age;
		}else{
			return 0;
		}
	}

	function countryFlag($country){
			$country = str_replace(' ', '-', $country);
			return '/img/flags/'. $country . '.png';
	}
	function excerpt($description){
		$excerpt = substr($description, 0, 70);
		return $excerpt . '...';
	}
	function getThumbName($name){
			$newThumbExtension = substr($name, -4);
			$newThumbName = substr($name, 0, -4);

			return $newThumbName . '-100x100'.$newThumbExtension;
	}
?>