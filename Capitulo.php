<?php
class Capitulo{

private $duracion;
private $fecha;

public function __construct($duracion,$fecha) {
    $this->duracion = $duracion;
    $this->fecha = $fecha;
}

/**
 * Get the value of duracion
 */ 
public function getDuracion()
{
    return $this->duracion;
}

/**
 * Get the value of fecha
 */ 
public function getFecha()
{
    return $this->fecha;
}

/**
 * Set the value of duracion
 *
 * @return  self
 */ 
public function setDuracion($duracion)
{
    $this->duracion = $duracion;

    return $this;
}

/**
 * Set the value of fecha
 *
 * @return  self
 */ 
public function setFecha($fecha)
{
    $this->fecha = $fecha;

    return $this;
}
}

