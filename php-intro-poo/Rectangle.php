<?php

class Rectangle{

    private int $longueur;
    private int $largeur;
    private string $couleur;

    public function __construct(int $longueur, int $largeur, string $couleur){

        $this->longueur = $longueur;
        $this->largeur = $largeur;
        $this->couleur = $couleur;
    }

    public function calculAire():int{
        return $this->longueur*$this->largeur;
    }

    public function calculPerimetre():int{
        return $this->longueur*2+$this->largeur*2;
    }

    public function getInfosString():string{
        return "Le rectangle a une longueur de ".$this->longueur.", une largeur de ".$this->largeur." et est ".$this->couleur;
    }
//ACCESSEURS

    public function getLongueur():int{
        return $this->longueur;
    }

    public function getLargeur():int{
        return $this->largeur;
    }

    public function getCouleur(): string
    {
        return $this->couleur;
    }

//MUTATEURS

    public function setLargeur(int $largeur):void
    {
        if ($largeur>=0) {
            $this->largeur = $largeur;
        }else{
            echo PHP_EOL."La largeur doit être positive pour être modifiée.".PHP_EOL;
        }
    }

    public function setLongueur(int $longueur):void
    {
        if ($longueur) {
            $this->longueur = $longueur;
        }else{
            echo PHP_EOL."La longueur doit être positive pour être modifiée.".PHP_EOL;
        }
    }

    public function setCouleur(string $couleur):void
    {
        $this->couleur = $couleur;
    }

}

