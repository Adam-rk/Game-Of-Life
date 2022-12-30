<?php

class Game {
    private int $currentGeneration;
    private int $row;
    private int $col;

    public function __construct()
    {
        $this->currentGeneration = 0;
        $this->askDimensions();
    }

    public function askDimensions () {
        system('clear');

        do {
            $row = readline("Veuillez saisir la nombre de lignes: ");
        }while(filter_var($row, FILTER_VALIDATE_INT) === false);

        do {
            $col = readline("Veuillez saisir la nombre de colonnes: ");
        }while(filter_var($col, FILTER_VALIDATE_INT) === false);

        $this->row = $row;
        $this->col = $col;
        system('clear');
    }

    public function newGeneration($board) {
        $newBoard = [];
        for ($i = 0; $i < count($board); $i++) {
            for ($j = 0; $j < count($board[$i]); $j++) {
                $firstIndex = [$i-1, $i, $i+1];
                $secondIndex = [$j-1, $j, $j+1];
                $neighbors = [];


                foreach ($firstIndex as $a) {
                    foreach ($secondIndex as $b) {
                       if (($a < count($board) && $a >= 0) && ($b < count($board[$i]) && $b >= 0)){
                            if (!($a == $i && $b == $j)) {
                                $neighbors[] = $board[$a][$b];
                            }
                       }

                    }
                }

                $aliveNeighbors = 0;

                foreach ($neighbors as $neighbor) {
                    if ($neighbor->getState() == 1) {
                        $aliveNeighbors++;
                    }
                }
                $newBoard[$i][$j] = new Cell;
                if ($board[$i][$j]->getState() == 0 && $aliveNeighbors == 3) {
                    $newBoard[$i][$j]->setState(1);
                } elseif ($board[$i][$j]->getState() == 1 && ($aliveNeighbors == 2 || $aliveNeighbors == 3)) {
                    $newBoard[$i][$j]->setState(1);
                } else {
                    $newBoard[$i][$j]->setState(0);
                }
            }
        }

        $this->currentGeneration++;
        sleep(1);
        //system('clear');
        return $newBoard;
    }


    public function getCurrentGeneration(): int
    {
        return $this->currentGeneration;
    }
    public function getRow (): int {
        return $this->row;
    }
    public function getCol (): int {
        return $this->col;
    }

    public function setCurrentGeneration(int $currentGeneration): void
    {
        $this->currentGeneration = $currentGeneration;
    }


    public function setRow(int $row): void
    {
        $this->row = $row;
    }


    public function setCol(int $col): void
    {
        $this->col = $col;
    }
}