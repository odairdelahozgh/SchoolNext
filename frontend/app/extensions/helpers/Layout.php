<?php

class Layout {
    private $title;
    private $options;
    private $distPath;

    /**
     * Constructor de la clase Layout.
     *
     * @param string $title El título de la página.
     * @param array $options Opciones para configurar el layout.
     *   - 'fixed_header' (bool): Fija la cabecera.
     *   - 'fixed_sidebar' (bool): Fija la barra lateral (requiere fixed_header).
     *   - 'fixed_footer' (bool): Fija el pie de página.
     *   - 'collapsed_sidebar' (bool): Colapsa la barra lateral al inicio.
     *   - 'sidebar_mini' (bool): Usa el modo 'mini' para la barra lateral.
     *   - 'dist_path' (string): Ruta a la carpeta 'dist' para los assets.
     */
    public function __construct($title = 'AdminLTE 4', $options = []) {
        $this->title = $title;
        $defaultOptions = [
            'fixed_header' => false,
            'fixed_sidebar' => false,
            'fixed_footer' => false,
            'collapsed_sidebar' => false,
            'sidebar_mini' => false,
            'dist_path' => 'dist' // Ruta por defecto a la carpeta dist
        ];
        $this->options = array_merge($defaultOptions, $options);
        $this->distPath = $this->options['dist_path'];
    }

    private function getBodyClasses() {
        $classes = ['sidebar-expand-lg', 'bg-body-tertiary'];
        if ($this->options['fixed_header']) {
            $classes[] = 'layout-fixed'; // En v4, layout-fixed maneja el sidebar y el header.
        }
        if ($this->options['fixed_footer']) {
            $classes[] = 'layout-footer-fixed';
        }
        if ($this->options['collapsed_sidebar']) {
            $classes[] = 'sidebar-collapse';
        }
        if ($this->options['sidebar_mini']) {
            $classes[] = 'sidebar-mini';
        }
        return implode(' ', $classes);
    }

    public function renderHead() {
        echo <<<HTML
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{$this->title}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{$this->distPath}/css/adminlte.min.css">
</head>
HTML;
    }

    public function renderBodyStart() {
        $bodyClasses = $this->getBodyClasses();
        echo <<<HTML
<body class="{$bodyClasses}">
<div class="app-wrapper">
HTML;
    }

    public function renderHeader($brandName = 'AdminLTE', $menuItems = '') {
        // Placeholder para un header más dinámico en el futuro
        echo <<<HTML
    <nav class="app-header navbar navbar-expand bg-body">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                        <i class="bi bi-list"></i>
                    </a>
                </li>
                <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Home</a></li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" data-lte-toggle="fullscreen" href="#" role="button">
                        <i class="bi bi-arrows-fullscreen"></i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
HTML;
    }

    public function renderSidebar($brandName = 'AdminLTE 4', $userName = 'User Name', $menuItems = []) {
        echo <<<HTML
    <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <div class="sidebar-brand">
            <a href="#" class="brand-link">
                <img src="{$this->distPath}/assets/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image opacity-75 shadow">
                <span class="brand-text fw-light">{$brandName}</span>
            </a>
        </div>
        <div class="sidebar-wrapper">
            <nav class="mt-2">
                <?php echo AdminLTE::treeview(
                    // The original_old_string had the default menu defined as a string with escaped newlines and tabs.
                    // The corrected_old_string has the default menu defined as a string with actual newlines and tabs.
                    // The original_new_string replaces the entire menu definition with a call to AdminLTE::treeview and expects an array.
                    // To align with the corrected_old_string, we should ensure that the $menuItems parameter is correctly handled.
                    // Since the original_new_string intends to use $menuItems as an array, we will pass it directly.
                    // If $menuItems is empty, AdminLTE::treeview should handle it gracefully or we might need to provide a default.
                    // For now, we pass it directly as intended by the original_new_string.
                    $menuItems
                ); ?>
            </nav>
        </div>
    </aside>
HTML;
    }

    public function renderContentWrapperStart($pageTitle = '', $breadcrumbs = []) {
        echo <<<HTML
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">{$pageTitle}</h3>
                    </div>
HTML;
        if (!empty($breadcrumbs)) {
            echo '<div class="col-sm-6"><ol class="breadcrumb float-sm-end">';
            foreach ($breadcrumbs as $i => $crumb) {
                if ($i < count($breadcrumbs) - 1) {
                    echo '<li class="breadcrumb-item"><a href="' . ($crumb['link'] ?? '#') . '">' . $crumb['name'] . '</a></li>';
                } else {
                    echo '<li class="breadcrumb-item active" aria-current="page">' . $crumb['name'] . '</li>';
                }
            }
            echo '</ol></div>';
        }
        echo <<<HTML
                </div>
            </div>
        </div>
        <div class="app-content">
            <div class="container-fluid">
HTML;
    }

    public function renderContentWrapperEnd() {
        echo <<<HTML
            </div>
        </div>
    </main>
HTML;
    }

    public function renderFooter($content = '<b>Version</b> 4.0.0') {
        echo <<<HTML
    <footer class="app-footer">
        <div class="float-end d-none d-sm-inline">{$content}</div>
        <strong>Copyright &copy; 2014-2025 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
    </footer>
HTML;
    }

    public function renderBodyEnd() {
        echo <<<HTML
</div>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{$this->distPath}/js/adminlte.min.js"></script>
</body>
</html>
HTML;
    }
}
