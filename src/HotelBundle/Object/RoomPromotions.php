<?php

namespace HotelBundle\Object;


class RoomPromotions
{

    /**
    * @var string
    */
    protected $monday;

    /**
    * @var string
    */
    protected $tuesday;

    /**
    * @var string
    */
    protected $wednesday;

    /**
    * @var string
    */
    protected $thursday;

    /**
    * @var string
    */
    protected $friday;

    /**
    * @var string
    */
    protected $saturday;

    /**
    * @var string
    */
    protected $sunday;

    /**
    * @return string
    */
    public function getMonday(){
  		return $this->monday;
  	}
    
    /**
    * @param string $monday
    */
  	public function setMonday($monday){
  		$this->monday = $monday;
  	}

    /**
    * @return string
    */
  	public function getTuesday(){
  		return $this->tuesday;
  	}

    /**
    * @param string $tuesday
    */
  	public function setTuesday($tuesday){
  		$this->tuesday = $tuesday;
  	}

    /**
    * @return string
    */
  	public function getWednesday(){
  		return $this->wednesday;
  	}

    /**
    * @param string $wednesday
    */
  	public function setWednesday($wednesday){
  		$this->wednesday = $wednesday;
  	}

    /**
    * @return string
    */
  	public function getThursday(){
  		return $this->thursday;
  	}

    /**
    * @param string $thursday
    */
  	public function setThursday($thursday){
  		$this->thursday = $thursday;
  	}

    /**
    * @return string
    */
  	public function getFriday(){
  		return $this->friday;
  	}

    /**
    * @param string $friday
    */
  	public function setFriday($friday){
  		$this->friday = $friday;
  	}

    /**
    * @return string
    */
  	public function getSaturday(){
  		return $this->saturday;
  	}

    /**
    * @param string $saturday
    */
  	public function setSaturday($saturday){
  		$this->saturday = $saturday;
  	}

    /**
    * @return string
    */
  	public function getSunday(){
  		return $this->sunday;
  	}

    /**
    * @param string $sunday
    */
  	public function setSunday($sunday){
  		$this->sunday = $sunday;
  	}


}
