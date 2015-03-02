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
	function dateTimeline($date){
		$dateTimeline = new DateTime($date);
		$now = new DateTime();
		$difference = $dateTimeline->diff($now);
		$days = $difference->d;
		$hours = $difference->h;
		$min = $difference->i;
			if($days != 0 && $days != 1){
				return $dateTimeline->diff($now)->format("%d days ago");
			}
			if($hours == 1 && $days == 0){
				return $dateTimeline->diff($now)->format("%h hour ago");
			}
			if($hours > 1 && $days == 0){
				return $dateTimeline->diff($now)->format("%h hours ago");
			}
			if($days == 1){
				return "Yesterday";
			}
			if($hours == 0 && $days == 0 && $min > 3){
				return $dateTimeline->diff($now)->format("%i minutes ago");
			}
			if($hours == 0 && $days == 0 && $min <= 3){
				return "Just now";
			}

	}

	function generateRandomString($length) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

	function generateRandomInt($length) {
	    $characters = '0123456789';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}
?>