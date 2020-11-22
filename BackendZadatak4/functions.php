<?php 
	function pickerDateTimeToMysql($pickerDate){
		$date = DateTime::createFromFormat('Y-m-d H:i:s', $pickerDate);
		return $date->format('d. m. Y H:i:s');
	}  

	function pickerDateToMysql($pickerDate){
		$date = DateTime::createFromFormat('Y-m-d', $pickerDate);
		return $date->format('d. m. Y');
	}  
?>