<?php

class Cliente
{
    private $nombre;
    private $numCuentas;
    private $alquileres = array();
    private $compras = array();
    private $vistas = array();

    public function __construct($nombre, $numCuentas)
    {
        $this->nombre = $nombre;
        $this->numCuentas = $numCuentas;
    }
    public function alquila(Pelicula $pelicula)
    {
            array_push($this->alquileres, $pelicula);
    }
    public function compra(Pelicula $pelicula)
    {
        if (!in_array($pelicula, $this->compras)) {
            array_push($this->compras, $pelicula);
        }
    }

    public function ve(Vista $vista): void
    {
        if ($vista instanceof Serie || $vista instanceof Capitulo){
            array_push($this->vistas, $vista);
        }elseif (in_array($vista->getContenido(), $this->alquileres) || in_array($vista->getContenido(), $this->compras)) {
            array_push($this->vistas, $vista);
        }
    }

    public function gasto(): int
    {
        $total = 0;
        foreach ($this->alquileres as $item) {
            $total += $item->getPrecio_alquiler();
        }
        foreach ($this->compras as $item) {
            $total += $item->getPrecio_compra();
        }
        if ($this->numCuentas === 1) {
            $total += 15;
        } elseif ($this->numCuentas === 2) {
            $total += 20;
        } elseif ($this->numCuentas === 3) {
            $total += 25;
        } elseif ($this->numCuentas === 4) {
            $total += 30;
        }

        return $total ;
    }

    function tiempo(): int
    {
        $tiempoTotal = 0;
        foreach ($this->vistas as $item) {
            $tiempoTotal += ($item->getContenido()->getDuracion() * $item->getPorcentajeVision()) / 100;
        }
        return $tiempoTotal;
    }
    /**
     * Get the value of nombre
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of numCuentas
     */
    public function getNumCuentas()
    {
        return $this->numCuentas;
    }

    /**
     * Set the value of numCuentas
     *
     * @return  self
     */
    public function setNumCuentas($numCuentas)
    {
        $this->numCuentas = $numCuentas;

        return $this;
    }

    /**
     * Get the value of alquileres
     */
    public function getAlquileres()
    {
        return $this->alquileres;
    }

    /**
     * Set the value of alquileres
     *
     * @return  self
     */
    public function setAlquileres($alquiler)
    {
        $this->alquileres += $alquiler;

        return $this;
    }

    /**
     * Get the value of compras
     */
    public function getCompras()
    {
        return $this->compras;
    }

    /**
     * Set the value of compras
     *
     * @return  self
     */
    public function setCompras($compras)
    {
        $this->compras[] = $compras;

        return $this;
    }

    /**
     * Get the value of vistas
     */
    public function getVistas()
    {
        return $this->vistas;
    }

    /**
     * Set the value of vistas
     *
     * @return  self
     */
    public function setVistas($vistas)
    {
        $this->vistas[] = $vistas;

        return $this;
    }
}
