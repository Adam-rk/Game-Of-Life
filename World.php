<?php
require_once ('Game.php');
require_once ('Cell.php');
class World extends Game {
    private array $board;

    public function __construct()
    {
        parent::__construct();
        $this->setCurrentGeneration(0);

    }


    public function main() {
        $mode = $this->menu();

        if ($mode == 0){
            $this->generateBoard(0);
            do {
                $this->displayBoard(0);
                $this->board = $this->newGeneration($this->board);
                $this->updateBoard($this->board);
            }while(true);
        } else {
            $this->generateBoard(1);
            $this->chooseCell();
            do {
                $this->displayBoard(1, true);
                $this->newGeneration($this->board);
                //$this->generateBoard(1);
            }while(true);
        }
    }

    public function menu() {
        echo "Choisissez votre mode: \n";
        do {
            $mode = readline("0 - Mode aléatoire (l'état des cellules est généré de façon aléatoire \n1 - Mode manuel (vous choissisez l'état des cellules \n");
        }while(filter_var($mode, FILTER_VALIDATE_INT) === false && ($mode != 1 || $mode != 0));
        system('clear');
        return $mode;
    }
    public function generateBoard($state)
    {
        $board = [];

        for ($i = 0; $i < $this->getRow(); $i++) {
            for ($j = 0; $j < $this->getCol(); $j++) {
                    $board[$i][] = new Cell();
                    if ($state == 0) {
                        $board[$i][$j]->setState(rand(0, 1));
                    }

            }
        }
        $this->board =  $board;
    }

    public function updateBoard($board) {

        $this->setRow($this->getRow()+1);
        $this->setCol($this->getCol()+1);
        for ($i = 0; $i < $this->getRow(); $i++) {
            if ($i >= count($board)) {
                $board[] = [];
            }
            for ($j = 0; $j < $this->getCol(); $j++) {
                if ($j >= count($board[$i])) {
                    $board[$i][] = new Cell();
                    $board[$i][$j]->setState(0);
                }
            }
        }
        $this->board =  $board;
    }


    public function displayBoard ($state, $addDimensions = false) {

        if ($state == 1){
            // Affiche les numéros au dessus de chaque colonnes
            echo "  ";
            for ($a = 0; $a < $this->getCol(); $a++) {
                echo $a . "  ";
            }
            echo "\n";
        }


        for ($i = 0; $i < count($this->board); $i++) {
             echo ($state == 1) ? $i . " " : "";
            for ($j = 0; $j < count($this->board[$i]); $j++) {
                    switch ($this->board[$i][$j]->getState()) {
                    case 0:
                        echo ".  ";
                        break;
                    case 1:
                        echo "O  ";
                        break;
                }
            }
            echo("\n");
        }
    }

    public function chooseCell() {
        $continue = 1;
        $array = [];
        do {
            do {
                system('clear');
                $this->displayBoard(1);
                echo "Choisissez les cellules à rendre vivantes.";
                echo "\n";
                $arg1 = readline("Numéro de ligne: ");
            } while (filter_var($arg1, FILTER_VALIDATE_INT) === false || $arg1 > $this->getRow()-1);

            do {
                system('clear');
                $this->displayBoard(1);
                echo "Choisissez les cellules à rendre vivantes.";
                echo "\n";
                $arg2 = readline("Numéro de colonne: ");
            } while (filter_var($arg2, FILTER_VALIDATE_INT) === false || $arg2 > $this->getCol()-1);

            $arguments = [$arg1, $arg2];

            if (in_array($arguments, $array)) {
                system('clear');
                echo "\e[31mVous avez déjà choisis cette cellule \e[39m \n ";

            }
            else {
                $array[] = $arguments;
                $this->board[$arg1][$arg2]->setState(1);
            }

            do {
                system('clear');
                $continue = readline("Voulez-vous modifier une autre cellule ? \n 0 - Oui \n 1 - Non \n");
            } while (filter_var($continue, FILTER_VALIDATE_INT) === false);
        } while($continue == 0);
    }
}

