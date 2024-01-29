<?php

class Vista{
    private $contenido;
    private $fecha;
    private $porcentajeVision;

    public function __construct($contenido,$fecha,$porcentajeVision) {
        
        if($contenido instanceof Pelicula || $contenido instanceof Serie || $contenido instanceof Capitulo){
            $this->contenido = $contenido;
        }
        $this->fecha = $fecha;
        $this->porcentajeVision = $porcentajeVision;
    }

    /**
     * Get the value of contenido
     */ 
    public function getContenido()
    {
        return $this->contenido;
    }

    /**
     * Set the value of contenido
     *
     * @return  self
     */ 
    public function setContenido($contenido)
    {
        $this->contenido = $contenido;

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
     * Get the value of porcentajeVision
     */ 
    public function getPorcentajeVision()
    {
        return $this->porcentajeVision;
    }

    /**
     * Set the value of porcentajeVision
     *
     * @return  self
     */ 
    public function setPorcentajeVision($porcentajeVision)
    {
        $this->porcentajeVision = $porcentajeVision;

        return $this;
    }
}