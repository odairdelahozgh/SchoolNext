<?php

// Incluir el archivo de la clase
require_once 'php/AdminLTE.php';

// Incluir el encabezado HTML de la página de AdminLTE para una correcta visualización
// NOTA: Este es un ejemplo simplificado. En una aplicación real, tendrías un sistema de plantillas.
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ejemplo de Componente PHP AdminLTE</title>
    <!-- Estilos de AdminLTE -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Iconos de Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <!-- Contenido principal -->
        <main class="app-main">
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Componentes Generados con PHP</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="app-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <?php
                            // --- EJEMPLOS DE USO DE LA CLASE AdminLTE ---

                            // 1. Tarjeta Básica
                            echo AdminLTE::card(
                                'Tarjeta Básica',
                                'Este es el cuerpo de la tarjeta básica. ¡Hola, mundo!'
                            );

                            // 2. Tarjeta de Éxito con contorno y pie de página
                            echo AdminLTE::card(
                                'Tarjeta de Éxito (con Pie y Herramientas)',
                                'El cuerpo de la tarjeta con estilo <code>card-outline-success</code>.',
                                [
                                    'color' => 'success',
                                    'outline' => true,
                                    'footer' => '<i>Este es el pie de página</i>',
                                    'collapsable' => true,
                                    'removable' => true
                                ]
                            );
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?php
                            // 3. Tarjeta de Peligro, minimizada por defecto
                            echo AdminLTE::card(
                                'Tarjeta de Peligro (Minimizada)',
                                'Este contenido no se verá inicialmente porque la tarjeta está minimizada.',
                                [
                                    'color' => 'danger',
                                    'collapsed' => true,
                                    'collapsable' => true
                                ]
                            );

                            // 4. Tarjeta con clases personalizadas
                            echo AdminLTE::card(
                                'Tarjeta con Clases CSS Personalizadas',
                                'Se ha añadido la clase <code>my-custom-shadow</code> a esta tarjeta.',
                                [
                                    'color' => 'primary',
                                    'customClass' => 'mt-5 my-custom-shadow'
                                ]
                            );
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <!-- Scripts de AdminLTE (jQuery y Bootstrap son dependencias) -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>

    <style>
        .my-custom-shadow {
            box-shadow: 0 1rem 3rem rgba(0,0,0,.175) !important;
        }
    </style>
</body>
</html>
