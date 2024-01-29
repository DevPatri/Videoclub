<?php
/* incluimos todas las clases lo primero de todo */
require_once 'Pelicula.php';
require_once 'Serie.php';
require_once 'Cliente.php';
require_once 'Programa.php';
require_once 'Capitulo.php';
require_once 'Vista.php';

session_start();


if (isset($_POST['reset'])) {
    unset($_SESSION['usuario1']);
    unset($usuario);
}

/* script para crear un usuario nuevo o recuperarlo de la sesion*/
if (isset($_SESSION["usuario1"])) {
    $usuario = $_SESSION['usuario1'];
    // echo '<br>Usuario recuperado<br>';
} else {
    $usuario = new Cliente('Marina', 1);
    $_SESSION['usuario1'] = $usuario;
    echo '<br>usuario creado<br>';
}

echo '<pre>'; // This is for correct handling of newlines
ob_start();
var_dump($usuario);
$a = ob_get_contents();
ob_end_clean();
echo htmlspecialchars($a, ENT_QUOTES); // Escape every HTML special chars (especially > and < )
echo '</pre>';
/* script para verificar si existe en sesion el array con las peliculas o no. */
// if (!isset($_SESSION["arrayPelis"])) {
    $peli1 = new Pelicula('Matrix', 'EEUU', 'Sci-fi', 110, '2001-06-20', 0, 0);
    $peli2 = new Pelicula('Amanece que no es poco', 'Española', 'Humor absurdo', 95, '2001-12-17', 0, 0);
    $peli3 = new Pelicula('Harry Potter', 'EEUU', 'Fantasía', 90, '2007-05-15', 3, 15);
    $peli4 = new Pelicula('Malditos bastardos', 'EEUU', 'Bélico', 120, '2020-04-01', 5, 25);
    $arrayPelis = array($peli1, $peli2, $peli3, $peli4);
    $_SESSION['arrayPelis'] = $arrayPelis;

    $serie = new Serie('Breaking Bad', 'EEUU', 'Thriller');

    $cap1 = new Capitulo(25, '2022-10-01');
    $cap2 = new Capitulo(30, '2022-10-08');
    $cap3 = new Capitulo(40, '2022-10-15');
    $cap4 = new Capitulo(35, '2022-10-22');
    $cap5 = new Capitulo(45, '2022-10-29');

    $arrayCapitulos = array($cap1, $cap2, $cap3, $cap4, $cap5);
    $_SESSION['arrayCapitulos'] = $arrayCapitulos;

    $serie->insertaCapitulo($cap1);
    $serie->insertaCapitulo($cap2);
    $serie->insertaCapitulo($cap3);
    $serie->insertaCapitulo($cap4);
    $serie->insertaCapitulo($cap5);

    $_SESSION['serie'] = $serie;
// }
// $serie = $_SESSION['serie'];
// $arrayPelis = $_SESSION['arrayPelis'];
// $arrayCapitulos = $_SESSION['arrayCapitulos'];

/* script para comprar una pelicula */
if (isset($_POST["comprar"])) {
    $opcionElegida = $_POST["pelis"];
    if ($opcionElegida !== null) {

        foreach ($arrayPelis as $item) {
            if ($item->getTitulo() === $opcionElegida) {
                $usuario->compra($item);
            }
        }
    } else {
        echo 'No se eligió una opción valida';
    }
}
/* script para alquilar una pelicula */
if (isset($_POST["alquilar"])) {
    $opcionElegida = $_POST["pelis"];
    if ($opcionElegida !== null) {
        foreach ($arrayPelis as $item) {
            if ($item->getTitulo() === $opcionElegida) {
                $usuario->alquila($item);
            }
        }
    }
}
/* script para poner una película o un capitulo en visto */
if (isset($_POST["vista"])) {

    $visto = $_POST['visto'];
    foreach ($arrayPelis as $item) {
        if ($item->getTitulo() === $visto) {
            $contenido = $item;
        }
    }
    foreach ($serie->getCapitulos() as $key => $cap) {
        if ($serie->devuelveCapitulo($key) === $visto) {
            $contenido = $cap;
        }
    }
}
// var_dump($contenido);
$repetido = false; /* verificamos que no está el objeto Pelicula en el array de vistas */
foreach ($usuario->getVistas() as $item) {
    if ($item->getContenido() === $contenido) {
        $repetido = true;
    }
}
if (!$repetido) { /* si no está creamos una vista nueva con los parámetros dados y la incluimos en el array */
    $vista = new Vista($contenido, date("Y-m-d"), 100);
    $usuario->ve($vista);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VideoClub</title>
</head>

<body style="font-size: 14px; color: #3B3B3B; background-color: #9fc2cc; font-family:system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;">
    <div>
        <form action="" method="POST">
            <input type="submit" name="reset" id="reset" value="Reiniciar">
        </form>
    </div>
    <div style="display:flex; flex-direction:column; align-items:center; justify-content:center; ">
        <h1 style="font-size:3em; text-align: center; color: #F05365; padding:  0em 0.5em 0em 0.5em; border-radius: .3em; box-shadow: 4px 3px 0px rgba(255,255,255,1); background-color:aquamarine;">VIDEOCLUB</h1>
    </div>
    <!-- tabla con todas las peliculas disponibles -->
    <div style="display:flex; flex-direction:column; align-items:center; justify-content:center; ">
        <h3 style=" text-align:center; color: #F05365; text-shadow: 2px 1px 0px rgba(255,255,255,0.6);">PEL&Iacute;CULAS</h3>
        <table style=" text-align:center; width:fit-content; border-collapse: collapse;">
            <tr style="border-bottom: 1px solid #331832;">
                <th>T&itulo</th>
                <th>Nacionalidad</th>
                <th>G&eacute;nero</th>
                <th>Duraci&oacute;n</th>
                <th>Fecha</th>
                <th>Precio Compra</th>
                <th>Precio Alquiler</th>
            </tr>
            <?php
            if (isset($usuario)) {
                foreach ($arrayPelis as $item) : ?>
                    <tr style="border-bottom: 1px solid #331832;">
                        <td><?= $item->getTitulo() ?></td>
                        <td><?= $item->getNacionalidad() ?></td>
                        <td><?= $item->getGenero() ?></td>
                        <td><?= $item->getDuracion() ?></td>
                        <td><?= $item->getFecha() ?></td>
                        <td><?= $item->getPrecio_compra() ?></td>
                        <td><?= $item->getPrecio_alquiler() ?></td>
                    </tr>
            <?php endforeach;
            } ?>
        </table>
    </div>
    <!-- tabla con todas las series disponibles -->
    <div style="display:flex; flex-direction:column; align-items:center; justify-content:center; ">
        <h3 style=" text-align:center; color: #F05365; text-shadow: 2px 1px 0px rgba(255,255,255,0.6);">SERIES</h3>
        <details>
            <summary>
                <table style=" text-align:center; width:fit-content; border-collapse: collapse;">
                    <tr>
                        <th>T&itulo</th>
                        <th>Nacionalidad</th>
                        <th>G&eacute;nero</th>
                        <th>N&uacute;mero cap&iacute;tulos</th>
                        <th>Duraci&oacute;n media</th>
                    </tr>
                    <tr>
                        <td><?= $serie->getTitulo() ?></td>
                        <td><?= $serie->getNacionalidad() ?></td>
                        <td><?= $serie->getGenero() ?></td>
                        <td><?= $serie->numeroCapitulos() ?></td>
                        <td><?= $serie->duracionMedia() ?></td>
                    </tr>
                </table>
            </summary>
            <table style="display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; ">
                <?php
                    foreach ($serie->getCapitulos() as $key => $cap) : ?>
                        <tr style="border-bottom: 1px solid #331832;">
                        <td><?= $serie->devuelveCapitulo($key) ?></td>
                        <td>
                            <form method="POST">
                                <select name="porcentaje" id="porcentaje">
                                    <?php
                                    for ($i = 5; $i <= 100; $i += 5) {
                                        echo '<option value="' . $i . '">' . $i . '</option>';
                                    }
                                    ?>
                                </select>
                                <input type="text" name="visto" id="visto" value="<?= $serie->devuelveCapitulo($key) ?>" hidden>
                                <input type="submit" name="vista" id="vista" value="Vista">
                            </form>
                        </td>
                    <?php endforeach;

                    ?>
                </tr>


            </table>
        </details>

    </div>
    <br>
    <!-- formulario para elegir pelicula a comprar o a alquilar -->
    <div style="display:flex; gap: 3em; align-items:flex-start; justify-content:center">
        <div>
            <h3 style="color: #F05365; text-shadow: 2px 1px 0px rgba(255,255,255,0.6);">Seleccione la película que desee alquilar o comprar:</h3>
            <form method="POST" style="display:flex; flex-direction: row; gap: 1em; justify-content: center;">
                <select name="pelis" id="pelis">
                    <?php
                    foreach ($arrayPelis as $item) {
                        echo '<option value="' . $item->getTitulo() . '">' . $item->getTitulo() . '</option>';
                    }
                    ?>
                </select>
                <input type="submit" name="comprar" id="comprar" value="Comprar">
                <input type="submit" name="alquilar" id="alquilar" value="Alquilar">
            </form>
        </div>
    </div>
    <!-- tabla con todas las peliculas compradas -->
    <div style="display:flex; flex-direction:column; align-items:center; justify-content:center;">
        <h3 style="text-align: center; color: #F05365; text-shadow: 2px 1px 0px rgba(255,255,255,0.6);">PEL&Iacute;CULAS COMPRADAS</h3>
        <table style="text-align:center; border-collapse: collapse;">
            <tr style="border-bottom: 1px solid #331832;">
                <th>T&itulo</th>
                <th>Nacionalidad</th>
                <th>G&eacute;nero</th>
                <th>Duraci&oacute;n</th>
                <th>Fecha</th>
                <th>Precio Compra</th>
                <th>Precio Alquiler</th>
            </tr>
            <?php
            if (isset($usuario)) {
                foreach ($usuario->getCompras() as $item) : ?>
                    <tr style="border-bottom: 1px solid #331832;">
                        <td><?= $item->getTitulo() ?></td>
                        <td><?= $item->getNacionalidad() ?></td>
                        <td><?= $item->getGenero() ?></td>
                        <td><?= $item->getDuracion() ?></td>
                        <td><?= $item->getFecha() ?></td>
                        <td><?= $item->getPrecio_compra() ?></td>
                        <td><?= $item->getPrecio_alquiler() ?></td>
                        <td>
                            <form method="POST">
                                <input type="text" name="visto" id="visto" value="<?= $item->getTitulo() ?>" hidden>
                                <select name="porcentaje" id="porcentaje">
                                    <?php
                                    for ($i = 5; $i <= 100; $i += 5) {
                                        echo '<option value="' . $i . '">' . $i . '</option>';
                                    }
                                    ?>
                                </select>
                                <input type="submit" name="vista" id="vista" value="Vista">
                            </form>
                        </td>
                    </tr>
            <?php endforeach;
            } ?>
        </table>
    </div>
    <!-- tabla con todas las peliculas alquiladas -->
    <div style="display:flex; flex-direction:column; align-items:center; justify-content:center;">
        <h3 style="text-align: center; color: #F05365; text-shadow: 2px 1px 0px rgba(255,255,255,0.6);">PEL&Iacute;CULAS ALQUILADAS</h3>
        <table style="text-align:center; border-collapse: collapse;">
            <tr style="border-bottom: 1px solid #331832;">
                <th>T&iacute;tulo</th>
                <th>Nacionalidad</th>
                <th>G&eacute;nero</th>
                <th>Duraci&oacute;n</th>
                <th>Fecha</th>
                <th>Precio Compra</th>
                <th>Precio Alquiler</th>
            </tr>
            <?php
            if (isset($usuario)) {
                foreach ($usuario->getAlquileres() as $item) : ?>
                    <tr style="border-bottom: 1px solid #331832;">
                        <td><?= $item->getTitulo() ?></td>
                        <td><?= $item->getNacionalidad() ?></td>
                        <td><?= $item->getGenero() ?></td>
                        <td><?= $item->getDuracion() ?></td>
                        <td><?= $item->getFecha() ?></td>
                        <td><?= $item->getPrecio_compra() ?></td>
                        <td><?= $item->getPrecio_alquiler() ?></td>
                        <td>
                            <form method="POST">
                                <input type="text" name="visto" id="visto" value="<?= $item->getTitulo() ?>" hidden>
                                <input type="submit" name="vista" id="vista" value="Vista">
                            </form>
                        </td>
                    </tr>
            <?php endforeach;
            } ?>
        </table>
    </div>
    <!-- tabla con todas las peliculas y series vistas -->
    <div style="display:flex; flex-direction:column; align-items:center; justify-content:center;">
        <h3 style="text-align: center; color: #F05365; text-shadow: 2px 1px 0px rgba(255,255,255,0.6);">CONTENIDO VISTO</h3>
        <table style="text-align:center; border-collapse: collapse;">
            <tr style="border-bottom: 1px solid #331832;">
                <th>T&iacute;tulo</th>
                <th>Fecha</th>
                <th>Porcentaje visi&oacute;n</th>

            </tr>
            <?php
            if (isset($usuario)) {
                foreach ($usuario->getVistas() as $item) : ?>
                    <tr style="border-bottom: 1px solid #331832;">
                        <td><?= $item->getContenido()->getTitulo() ?></td>
                        <td><?= $item->getFecha() ?></td>
                        <td><?= $item->getPorcentajeVision() ?></td>
                    </tr>
            <?php endforeach;
            } ?>
        </table>
    </div>
    <div style="display:flex; flex-direction:column; align-items:center; justify-content:center;">
        <h3 style="margin-bottom: 0; text-align: center; color: #F05365; text-shadow: 2px 1px 0px rgba(255,255,255,0.6);">DATOS VISI&Oacute;N Y GASTOS</h3>
        <p>El gasto que llevas este mes, es de: <strong><?php echo $usuario->gasto(); ?> &euro;</strong>
            y este mes llevas <strong><?php echo $usuario->tiempo(); ?> min.</strong> visualizados.</p>
    </div>

    <?php
    $_SESSION['usuario1'] = $usuario;
    ?>
</body>

</html>