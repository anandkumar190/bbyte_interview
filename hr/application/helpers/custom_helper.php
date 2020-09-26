<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

	function CI(){
		return $CI = get_instance();
	}

	function getUserDetails(){
        return CI()->custom->getUserDetails();
	}

	function getStateList(){
        return CI()->custom->getStateList();
	}

	function getCityByStateId($state_id=false){
		return CI()->custom->getCityByStateId($state_id);
	}

	function getRoles(){
        return CI()->custom->getRoles();
	}
?>
