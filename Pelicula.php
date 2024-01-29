<?php
include 'Programa.php';
class Pelicula extends Programa{
    private $duracion;
    private $fecha;
    private $precio_alquiler;
    private $precio_compra;

    public function __construct($titulo,$nacionalidad,$genero,$duracion,$fecha,$precio_alquiler,$precio_compra) {
        parent::__construct($titulo,$nacionalidad,$genero);
        $this->duracion = $duracion;
        $this->fecha = $fecha;
        $this->precio_alquiler = $precio_alquiler;
        $this->precio_compra = $precio_compra;
    }
    /**
     * Get the value of duracion
     */ 
    public function getDuracion()
    {
        return $this->duracion;
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
     * Get the value of fecha
     */ 
    public function getFecha()
    {
        return $this->fecha;
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

    /**
     * Get the value of precio_alquiler
     */ 
    public function getPrecio_alquiler()
    {
        return $this->precio_alquiler;
    }

    /**
     * Set the value of precio_alquiler
     *
     * @return  self
     */ 
    public function setPrecio_alquiler($precio_alquiler)
    {
        $this->precio_alquiler = $precio_alquiler;

        return $this;
    }

    /**
     * Get the value of precio_compra
     */ 
    public function getPrecio_compra()
    {
        return $this->precio_compra;
    }

    /**
     * Set the value of precio_compra
     *
     * @return  self
     */ 
    public function setPrecio_compra($precio_compra)
    {
        $this->precio_compra = $precio_compra;

        return $this;
    }
}


