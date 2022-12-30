<?php
require_once ('World.php');
class Cell {
    private bool $state;


    public function __construct()
    {
        $this->state = 0;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        $this->state = $state;
    }

}