<?php

class Serie extends Programa
{
    public $capitulos = array();

    public function __construct($nombre,$nacionalidad,$genero)
    {
        parent::__construct($nombre,$nacionalidad,$genero);
    }

    public function numeroCapitulos(): int
    {
        $total = count($this->capitulos);
        return $total;
    }

    public function duracionMedia(): int
    {
        $duracionTotal = 0;
        $total = count($this->capitulos);

        foreach ($this->capitulos as $capitulo) {
            if ($capitulo instanceof Capitulo) {
                $duracionTotal += $capitulo->getDuracion();
            }
        }

        $duracionMedia = $duracionTotal / $total;
        return round($duracionMedia, 1);
    }

    public function insertaCapitulo(object $capitulo): void
    {
        if ($capitulo instanceof Capitulo) {
            // var_dump($capitulo);
            array_push($this->capitulos, $capitulo);
        }
    }

    public function devuelveCapitulo($numero): string
    {
        foreach ($this->capitulos as $key => $value) {
            if ($numero == $key) {
                return 'Capítulo: ' . $key+1 . ' Duración: ' . $value->getDuracion() . ' Fecha: ' . $value->getFecha();
            }
        }
        return -1;
    }

    /**
     * Get the value of capitulos
     */
    public function getCapitulos(): array
    {
        return $this->capitulos;
    }

    /**
     * Set the value of capitulos
     *
     * @return  self
     */
    public function setCapitulos($capitulos): object
    {
        $this->capitulos = $capitulos;

        return $this;
    }
}
