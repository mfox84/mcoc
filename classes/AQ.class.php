<?php

class AQ
{
		private $aq_id;
		private $aq_start;	// Startdatum
		private $aq_end	;	// Enddatum
		private $aq_points;	// Gesamtpunkt
		private $aq_rank; // Rang
		private $aq_missions; // Array mit den Missionen pro Tag
		private $aq_percent; // Array mit den Prozent pro Tag
		private $aq_prestige; // Array mit Prestige pro Tag
		private $aq_sumsPerDay; // Array mit Tagessummen der Punkte
		private $aq_totalSum; // Gesamtsumme der Quest
		
		
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

	public function getAq_rank(){
		return $this->aq_rank;
	}

	public function setAq_rank($aq_rank){
		$this->aq_rank = $aq_rank;
	}
	
		public function getAq_missions(){
		return $this->aq_missions;
	}

	public function setAq_missions($aq_missions){
		$this->aq_missions = $aq_missions;
	}

	public function getAq_percent(){
		return $this->aq_percent;
	}

	public function setAq_percent($aq_percent){
		$this->aq_percent = $aq_percent;
	}

	public function getAq_prestige(){
		return $this->aq_prestige;
	}

	public function setAq_prestige($aq_prestige){
		$this->aq_prestige = $aq_prestige;
	}
	
		public function getAq_sumsPerDay(){
		return $this->aq_sumsPerDay;
	}

	public function setAq_sumsPerDay($aq_sumsPerDay){
		$this->aq_sumsPerDay = $aq_sumsPerDay;
	}

	public function getAq_totalSum(){
		return $this->aq_totalSum;
	}

	public function setAq_totalSum($aq_totalSum){
		$this->aq_totalSum = $aq_totalSum;
	}
}
