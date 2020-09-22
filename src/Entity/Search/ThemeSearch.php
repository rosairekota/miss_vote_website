<?php
namespace App\Entity\Search;

use App\Entity\Competition;

class ThemeSearch {
    
    private $title;

    /**
     *
     * @var [Competition]
     */
    private $competition;

    public function getTitle():?string
    {
        return $this->title;
    }
    public function setTitle(?string $title):self
    {
        $this->title=$title;
        return $this;
    }
    

    /**
     * Get the value of competition
     *
     * @return  Competition
     */ 
    public function getCompetition()
    {
        return $this->competition;
    }

    /**
     * Set the value of competition
     *
     * @param  Competition $competition
     *
     * @return  self
     */ 
    public function setCompetition(Competition $competition):self
    {
        $this->competition = $competition;

        return $this;
    }
}