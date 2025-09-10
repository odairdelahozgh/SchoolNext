<?php

require_once 'php/Layout.php';
require_once 'php/AdminLTE.php';

// --- Configuración del Layout ---
$pageTitle = 'Página con Layout Dinámico';
$layoutOptions = [
    'fixed_header' => true,
    'fixed_sidebar' => true, // En v4, esto se activa con layout-fixed que ya está en fixed_header
    'collapsed_sidebar' => false,
    'dist_path' => 'dist'
];

// 1. Instanciar la clase Layout
$layout = new Layout($pageTitle, $layoutOptions);

// 2. Renderizar el inicio de la página
$layout->renderHead();
$layout->renderBodyStart();

// 3. Renderizar las partes principales de la UI

// Definición del menú dinámico
$menuItems = [
    ['type' => 'header', 'text' => 'MAIN NAVIGATION'],
    [
        'text' => 'Dashboard',
        'icon' => 'bi bi-speedometer',
        'active' => true,
        'children' => [
            ['text' => 'Dashboard v1', 'link' => '#', 'icon' => 'bi bi-circle'],
            ['text' => 'Dashboard v2', 'link' => '#', 'icon' => 'bi bi-circle', 'active' => true],
        ]
    ],
    [
        'text' => 'Widgets',
        'link' => '#', 
        'icon' => 'bi bi-box-seam-fill',
        'badge' => ['text' => 'New', 'color' => 'success']
    ],
    ['type' => 'header', 'text' => 'ACCOUNT SETTINGS'],
    ['text' => 'Profile', 'link' => '#', 'icon' => 'bi bi-person-circle'],
    ['text' => 'Logout', 'link' => '#', 'icon' => 'bi bi-box-arrow-right'],
];

$layout->renderHeader();
$layout->renderSidebar('AdminLTE 4', 'Gemini User', $menuItems);

// 4. Renderizar el contenedor de contenido y los breadcrumbs
$breadcrumbs = [
    ['name' => 'Home', 'link' => '#'],
    ['name' => 'Layouts', 'link' => '#'],
    ['name' => 'Mi Página']
];
$layout->renderContentWrapperStart('Mi Página Dinámica', $breadcrumbs);

// --- INICIO DEL CONTENIDO PERSONALIZADO DE LA PÁGINA ---
// Aquí es donde pones el contenido específico de tu página.
// Puedes usar la clase AdminLTE que creamos antes.
?>

<div class="row">
    <div class="col-md-6">
        <?php
        echo AdminLTE::card(
            '¡Contenido Dinámico!',
            'Esta tarjeta se ha insertado dentro de un layout generado por PHP.',
            [
                'color' => 'info',
                'outline' => true,
                'collapsable' => true
            ]
        );
        ?>
    </div>
    <div class="col-md-6">
        <?php
        echo AdminLTE::card(
            'Otra Tarjeta',
            'Puedes añadir tantos componentes como necesites.',
            [
                'color' => 'warning',
                'collapsable' => true,
                'removable' => true
            ]
        );
        ?>
    </div>
</div>

<hr>

<div class="row">
    <div class="col-lg-3 col-6">
        <?php
        echo AdminLTE::smallBox('New Orders', '150', 'bi-bag-check-fill', ['color' => 'primary']);
        ?>
    </div>
    <div class="col-lg-3 col-6">
        <?php
        echo AdminLTE::smallBox('Bounce Rate', '53%', 'bi-bar-chart-line-fill', ['color' => 'success']);
        ?>
    </div>
    <div class="col-lg-3 col-6">
        <?php
        echo AdminLTE::smallBox('User Registrations', '44', 'bi-person-plus-fill', ['color' => 'warning']);
        ?>
    </div>
    <div class="col-lg-3 col-6">
        <?php
        echo AdminLTE::smallBox('Unique Visitors', '65', 'bi-pie-chart-fill', ['color' => 'danger']);
        ?>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <?php
        echo AdminLTE::alert('Esta es una alerta que se puede cerrar.', [
            'color' => 'success',
            'icon' => 'bi bi-check-circle-fill',
            'dismissible' => true
        ]);
        ?>
    </div>
    <div class="col-md-6">
        <?php
        echo AdminLTE::alert('Esta es una alerta de peligro con un icono.', [
            'color' => 'danger',
            'icon' => 'bi bi-exclamation-triangle-fill'
        ]);
        ?>
    </div>
</div>

<hr>

<?php
// --- DATOS DE EJEMPLO PARA COMPONENTES COMPLEJOS ---

$chatMessages = [
    [
        'name' => 'Alexander Pierce',
        'image' => 'dist/assets/img/user1-128x128.jpg',
        'timestamp' => '23 Jan 2:00 pm',
        'text' => 'Is this template really for free? That\'s unbelievable!',
        'align' => 'left'
    ],
    [
        'name' => 'Sarah Bullock',
        'image' => 'dist/assets/img/user3-128x128.jpg',
        'timestamp' => '23 Jan 2:05 pm',
        'text' => 'You better believe it!',
        'align' => 'right'
    ]
];

$timelineItems = [
    ['type' => 'label', 'color' => 'danger', 'text' => '10 Feb. 2023'],
    [
        'type' => 'item',
        'icon' => 'bi bi-envelope',
        'icon_color' => 'primary',
        'time' => '12:05',
        'header' => '<a href="#">Support Team</a> sent you an email',
        'body' => 'Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.',
        'footer' => '<a class="btn btn-primary btn-sm">Read more</a>'
    ],
];

?>

<div class="row mt-4">
    <div class="col-lg-6">
        <?php echo AdminLTE::directChat('Direct Chat', $chatMessages); ?>
    </div>
    <div class="col-lg-6">
        <?php echo AdminLTE::timeline($timelineItems); ?>
    </div>
</div>

<hr>

<?php
// --- DATOS DE EJEMPLO PARA TABS ---
$tabsData = [
    [
        'title' => 'Pestaña 1',
        'content' => 'Contenido de la primera pestaña. <strong>Puedes usar HTML aquí.</strong>',
        'active' => true
    ],
    [
        'title' => 'Pestaña 2',
        'content' => 'Contenido de la segunda pestaña. Mucho más interesante.'
    ],
];
?>

<div class="row mt-4">
    <div class="col-12">
        <?php echo AdminLTE::tabs($tabsData, ['card' => 'Ejemplo de Pestañas']); ?>
    </div>
</div>

<hr>

<?php
// --- DATOS DE EJEMPLO PARA ACCORDION Y CALLOUT ---
$accordionItems = [
    [
        'title' => 'Elemento #1',
        'content' => 'Contenido del primer elemento.',
        'open' => true
    ],
    [
        'title' => 'Elemento #2',
        'content' => 'Contenido del segundo elemento.'
    ],
];
?>

<div class="row mt-4">
    <div class="col-md-6">
        <?php echo AdminLTE::accordion($accordionItems, ['card' => 'Ejemplo de Acordeón']); ?>
    </div>
    <div class="col-md-6">
        <?php 
        echo AdminLTE::callout('Este es un callout de información importante.', ['title' => 'Información', 'color' => 'info']);
        echo AdminLTE::callout('¡Operación completada con éxito!', ['title' => 'Éxito', 'color' => 'success']);
        ?>
    </div>
</div>

<hr>

<div class="row mt-4">
    <div class="col-md-6">
        <?php 
        $indicatorsContent = '';
        $indicatorsContent .= '<h5>Badges</h5>';
        $indicatorsContent .= AdminLTE::badge('Primary', ['color' => 'primary']) . ' ';
        $indicatorsContent .= AdminLTE::badge('Pill', ['color' => 'success', 'pill' => true]) . ' ';
        $indicatorsContent .= '<h5>Progress Bars</h5>';
        $indicatorsContent .= AdminLTE::progressBar(40, ['color' => 'info', 'striped' => true]);

        echo AdminLTE::card('Indicadores', $indicatorsContent);
        ?>
    </div>
    <div class="col-md-6">
        <?php 
        $paginationContent = '';
        $paginationContent .= '<h6>Paginación Normal</h6>';
        $paginationContent .= AdminLTE::pagination(3, 10);

        echo AdminLTE::card('Paginación', $paginationContent, ['collapsable' => true]);
        ?>
    </div>
</div>

<hr>

<?php
// --- DATOS DE EJEMPLO PARA FORMULARIO COMPLETO ---
$formContent = '';
$formContent .= AdminLTE::input('name', 'Nombre Completo', ['placeholder' => 'Ingrese su nombre']);
$formContent .= AdminLTE::input('email', 'Correo Electrónico', ['type' => 'email', 'placeholder' => 'sucorreo@ejemplo.com', 'help_text' => 'Nunca compartiremos su correo.']);

$selectOptions = ['1' => 'Opción 1', '2' => 'Opción 2', '3' => 'Opción 3'];
$formContent .= AdminLTE::select('user_option', 'Seleccione una opción', $selectOptions, ['selected_value' => '2']);

$formContent .= AdminLTE::textarea('comments', 'Comentarios', ['rows' => 4]);

$formContent .= '<hr>';
$formContent .= AdminLTE::customCheckbox('terms', 'Acepto los términos y condiciones', ['checked' => true]);

$formContent .= '<hr><h5>Tipo de Cuenta</h5>';
$formContent .= AdminLTE::customRadio('account_type', 'Gratuita', ['value' => 'free', 'checked' => true]);
$formContent .= AdminLTE::customRadio('account_type', 'Premium', ['value' => 'premium']);

$cardFooter = '<button type="submit" class="btn btn-primary">Registrar</button>';
$form = '<form>' . $formContent . '</form>';

?>

<div class="row mt-4">
    <div class="col-12">
        <?php echo AdminLTE::card('Formulario de Registro Completo', $form, ['footer' => $cardFooter]); ?>
    </div>
</div>

<hr>

<div class="row mt-4">
    <div class="col-12">
        <?php
        $toastButton = '<button type="button" class="btn btn-success" onclick="showToast(\'toastSuccessExample\')">Mostrar Notificación Toast</button>';
        echo AdminLTE::card('Notificaciones Toast', $toastButton);
        ?>
    </div>
</div>

<hr>

<div class="row mt-4">
    <div class="col-12"><h4>Widgets</h4></div>
</div>

<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
        <?php echo AdminLTE::widgetInfoBox('CPU Traffic', '90%', 'bi bi-cpu-fill', ['color' => 'primary']); ?>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <?php echo AdminLTE::widgetInfoBox('Likes', '41,410', 'bi bi-hand-thumbs-up-fill', ['color' => 'danger']); ?>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <?php echo AdminLTE::widgetInfoBox('Sales', '760', 'bi bi-cart-fill', ['color' => 'success']); ?>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <?php echo AdminLTE::widgetInfoBox('New Members', '2,000', 'bi bi-people-fill', ['color' => 'warning']); ?>
    </div>
</div>

<?php
// --- DATOS DE EJEMPLO PARA WIDGETS ---
$users = [
    ['name' => 'Alexander Pierce', 'image' => 'dist/assets/img/user1-128x128.jpg', 'meta' => 'Today'],
    ['name' => 'Norman', 'image' => 'dist/assets/img/user2-160x160.jpg', 'meta' => 'Yesterday'],
    ['name' => 'Jane', 'image' => 'dist/assets/img/user7-128x128.jpg', 'meta' => '12 Jan'],
    ['name' => 'John', 'image' => 'dist/assets/img/user6-128x128.jpg', 'meta' => '12 Jan'],
    ['name' => 'Alexander', 'image' => 'dist/assets/img/user2-160x160.jpg', 'meta' => '13 Jan'],
    ['name' => 'Sarah', 'image' => 'dist/assets/img/user5-128x128.jpg', 'meta' => '14 Jan'],
    ['name' => 'Nora', 'image' => 'dist/assets/img/user4-128x128.jpg', 'meta' => '15 Jan'],
    ['name' => 'Nadia', 'image' => 'dist/assets/img/user3-128x128.jpg', 'meta' => '15 Jan'],
];
?>

<div class="row mt-4">
    <div class="col-md-6">
        <?php echo AdminLTE::widgetUserList('Latest Members', $users, [
            'badge_text' => '8 New Members',
            'footer_link' => '#'
        ]); ?>
    </div>
</div>

<hr>

<div class="row mt-4">
    <div class="col-md-6">
        <?php
        $ribbonCardContent = AdminLTE::widgetRibbon('New', ['color' => 'primary', 'position' => 'right']);
        $ribbonCardContent .= '<p>Esta es una tarjeta con una cinta decorativa. La cinta es un elemento puramente visual.</p>';
        echo AdminLTE::card('Tarjeta con Cinta', $ribbonCardContent);
        ?>
    </div>
    <div class="col-md-6">
        <?php
        $descriptionListItems = [
            ['term' => 'CPU Traffic', 'description' => '10% (' . AdminLTE::progressBar(10, ['color' => 'info']) . ')'],
            ['term' => 'RAM Usage', 'description' => '80% (' . AdminLTE::progressBar(80, ['color' => 'danger']) . ')'],
            ['term' => 'Disk Space', 'description' => '40% (' . AdminLTE::progressBar(40, ['color' => 'success']) . ')'],
        ];
        echo AdminLTE::widgetDescriptionList($descriptionListItems, ['card' => 'Lista de Descripción']);
        ?>
    </div>
</div>

<?php
// --- DATOS DE EJEMPLO PARA WIDGETS ---
$products = [
    [
        'image' => 'dist/assets/img/prod-1.jpg',
        'name' => 'Samsung TV',
        'price' => '$1800',
        'price_color' => 'warning',
        'description' => 'Samsung 32" 1080p 60Hz LED Smart HDTV.',
        'link' => '#'
    ],
    [
        'image' => 'dist/assets/img/prod-2.jpg',
        'name' => 'Bicycle',
        'price' => '$700',
        'price_color' => 'info',
        'description' => '26" Mongoose Dolomite Men\'s 7-speed, Navy Blue.',
        'link' => '#'
    ],
    [
        'image' => 'dist/assets/img/prod-3.jpg',
        'name' => 'Xbox One',
        'price' => '$350',
        'price_color' => 'danger',
        'description' => 'Xbox One Console Bundle with Halo Master Chief Collection.',
        'link' => '#'
    ],
];
?>

<div class="row mt-4">
    <div class="col-12">
        <?php echo AdminLTE::widgetProductList('Recently Added Products', $products, ['footer_link' => '#']); ?>
    </div>
</div>

<?php
// --- FIN DEL CONTENIDO PERSONALIZADO DE LA PÁGINA ---



// 5. Renderizar el final del contenedor de contenido
$layout->renderContentWrapperEnd();

// 6. Renderizar el pie de página y el final del body
$layout->renderFooter();

// --- DEFINICIÓN DE TOASTS Y SCRIPT TRIGGER ---
$toasts = [
    [
        'id' => 'toastSuccessExample',
        'title' => 'Éxito',
        'body' => 'La operación se ha completado satisfactoriamente.',
        'options' => ['color' => 'success', 'icon' => 'bi bi-check-circle-fill']
    ]
];
echo AdminLTE::toastContainer($toasts);
echo AdminLTE::toastJsTriggerScript();
// --- FIN TOASTS ---

$layout->renderBodyEnd();

?>