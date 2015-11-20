<?php

class AQ
{
		private $aq_id;
		private $aq_start;	
		private $aq_end	;
		private $aq_points;	
		private $aq_result;
		
		
	public function getAq_id(){
		return $this->aq_id;
	}

	public function setAq_id($aq_id){
		$this->aq_id = $aq_id;
	}

	public function getAq_start(){
		return $this->aq_start;
	}

	public function setAq_start($aq_start){
		$this->aq_start = $aq_start;
	}

	public function getAq_end(){
		return $this->aq_end;
	}

	public function setAq_end($aq_end){
		$this->aq_end = $aq_end;
	}

	public function getAq_points(){
		return $this->aq_points;
	}

	public function setAq_points($aq_points){
		$this->aq_points = $aq_points;
	}

	public function getAq_result(){
		return $this->aq_result;
	}

	public function setAq_result($aq_result){
		$this->aq_result = $aq_result;
	}
}
