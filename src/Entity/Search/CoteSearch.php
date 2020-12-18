<?php
namespace App\Entity\Search;



/**
 * 
 */
class CoteSearch 
{
	
	private  $cote;

	private  $numberCotes;




    /**
     * @return mixed
     */
    public function getNumberCotes():?int
    {
        return $this->numberCotes;
    }

    /**
     * @param mixed $numberCotes
     *
     * @return self
     */
    public function setNumberCotes(int $numberCotes):?self
    {
        $this->numberCotes = $numberCotes;

        return $this;
    }

    

    /**
     * @return mixed
     */
    public function getCote()
    {
        return $this->cote;
    }

    /**
     * @param mixed $cote
     *
     * @return self
     */
    public function setCote($cote)
    {
        $this->cote = $cote;

        return $this;
    }
}