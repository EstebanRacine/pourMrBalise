<?php
class Rect
{
    private int $longeur;
    private int $largeur;


    public function __construct()
    {
        $this->longeur = 0;
        $this->largeur = 0;
    }


    public function getLongeur(): int
    {
        return $this->longeur;
    }


    public function setLongeur(int $longeur): void
    {
        $this->longeur = $longeur;
    }


    public function getLargeur(): int
    {
        return $this->largeur;
    }


    public function setLargeur(int $largeur): void
    {
        $this->largeur = $largeur;
    }

}