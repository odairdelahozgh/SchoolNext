<?php

class Bootstrap5Helper {
  private array $menuItems = [];
  public function __construct(
    private $defaultClasses = 
    [
      'button' => 'btn btn-primary',
      'alert' => 'alert alert-primary',
      'card' => 'card',
      'form' => 'needs-validation',
      'modal' => 'modal fade',
      'navbar' => 'navbar navbar-expand-lg navbar-light bg-light',
      'listGroup' => 'list-group',
      'table' => 'table',
      'dashboard' => 'd-flex',
      'sidebar' => 'bg-light border-right',
      'content' => 'flex-grow-1 p-3',
    ],
    private $defaultParams = [],
    )
  {
    $defaultParams = [
      'title' => APP_NAME,
      'modulo' => Session::get('modulo'),
      'periodo' => Session::get('periodo'),
      'annio' => Session::get('annio'),
      'f_ini_periodo' => date('M-d',strtotime(Session::get('fecha_inicio'))),
      'f_fin_periodo' => date('M-d',strtotime(Session::get('fecha_fin'))),
      'f_open_day' => date('M-d',strtotime(Session::get('f_open_day'))),
      'user_id' => Session::get('id'),
      'username' => Session::get('username'),
    ];
  }
  
  public function addMenuItem(string $label, string $link, array $subMenu = []): void
  {
    $this->menuItems[] = 
    [
      'label' => $label,
      'link' => $link,
      'subMenu' => $subMenu
    ];
  }

  private function renderSubMenu(array $subMenu): string
  {
    if (empty($subMenu))
    {
      return '';
    }
    $html = '<ul class="dropdown-menu" aria-labelledby="navbarDropdown">';
    foreach ($subMenu as $item)
    {
      $html .= '<li><a class="dropdown-item" href="' . htmlspecialchars($item['link']) . '">' . htmlspecialchars($item['label']) . '</a></li>';
    }
    $html .= '</ul>';
    return $html;
  }


  public function renderHeader(): string
  {
    $html = '<header class="p-3 bg-dark text-white">';
    $html .= '<div class="container">';
    $html .= '<div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">';
    $html .= '<a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">';
    $html .= $this->defaultParams['title'];
    $html .= '</a>';

    $html .= '<ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">';
    foreach ($this->menuItems as $item)
    {
      if (empty($item['subMenu'])) 
      {
        $html .= '<li><a href="' . htmlspecialchars($item['link']) . '" class="nav-link px-2 text-white">' . htmlspecialchars($item['name']) . '</a></li>';
      } 
      else 
      {
        $html .= '<li class="nav-item dropdown">';
        $html .= '<a class="nav-link dropdown-toggle text-white" href="' . htmlspecialchars($item['link']) . '" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">';
        $html .= htmlspecialchars($item['label']);
        $html .= '</a>';
        $html .= $this->renderSubMenu($item['subMenu']);
        $html .= '</li>';
      }
    }
    $html .= '</ul>';

    //$html .= '<form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">';
    //$html .= '<input type="search" class="form-control form-control-dark" placeholder="Search..." aria-label="Search">';
    //$html .= '</form>';

    $html .= $this->defaultParams['annio'].'-'.$this->defaultParams['periodo'];
    $html .= '';
    $html .= '';
    $html .= '';
    $html .= '<div class="text-end">';
    //$html .= '<button type="button" class="btn btn-outline-light me-2">Login</button>';
    //$html .= '<button type="button" class="btn btn-warning">Sign-up</button>';

    $html .= '<div class="dropdown">
        <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
        </a>
        <ul class="dropdown-menu text-small" style="">
          <li><a class="dropdown-item" href="#">New project...</a></li>
          <li><a class="dropdown-item" href="#">Settings</a></li>
          <li><a class="dropdown-item" href="#">Profile</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="#">Sign out</a></li>
        </ul>
      </div>';
    $html .= '</div>';

    $html .= '</div>';
    $html .= '</div>';
    $html .= '</header>';

    return $html;
  }


  public function renderNavbar(array $navbarItems): string 
  {
      $itemsHtml = '';
      foreach ($navbarItems as $item) {
          $itemsHtml .= "<li class='nav-item'><a class='nav-link' href='{$item['href']}'>{$item['label']}</a></li>";
      }

      return "<nav class=\"navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow\">
        <a class=\"navbar-brand col-md-3 col-lg-2 me-0 px-3\" href=\"#\">Company Name</a>
  <button class=\"navbar-toggler position-absolute d-md-none collapsed\" type=\"button\" data-bs-toggle=\"collapse\" data-bs-target=\"#sidebarMenu\" aria-controls=\"sidebarMenu\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">
      <span class=\"navbar-toggler-icon\"></span
  </button>
  <input class=\"form-control form-control-dark w-100\" type=\"text\" placeholder=\"Search\" aria-label=\"Search\">
  <div class=\"navbar-nav\">
      <div class=\"nav-item text-nowrap\">
          <a class=\"nav-link px-3\" href=\"logout\">Sign out</a>
          $itemsHtml
      </div>
  </div>
  </nav>";
  }

  // Método para generar un botón
  public function createButton(string $text, string $type = 'button', string $class = '', array $attributes = []): string {
    $class = empty($class) ? $this->defaultClasses['button'] : $class;
    $attrString = $this->arrayToAttributes($attributes);
    return "<button type=\"$type\" class=\"$class\" $attrString>$text</button>";
  }

  // Método para generar una alerta
  public function createAlert(string $message, string $type = 'primary', string $class = '', array $attributes = []): string {
    $class = empty($class) ? "alert alert-$type" : $class;
    $attrString = $this->arrayToAttributes($attributes);
    return "<div class=\"$class\" role=\"alert\" $attrString>$message</div>";
  }

  // Método para generar una tarjeta
  public function createCard(string $title, string $body, string $footer = '', string $class = '', array $attributes = []): string {
    $class = empty($class) ? $this->defaultClasses['card'] : $class;
    $attrString = $this->arrayToAttributes($attributes);
    $footerHtml = $footer ? "<div class=\"card-footer\">$footer</div>" : '';
    return "
      <div class=\"$class\" $attrString>
        <div class=\"card-header\">$title</div>
        <div class=\"card-body\">$body</div>
        $footerHtml
      </div>
    ";
  }

  // Método para generar un formulario
  public function createForm(string $action, string $method = 'post', array $elements = [], string $class = '', array $attributes = []): string {
    $class = empty($class) ? $this->defaultClasses['form'] : $class;
    $attrString = $this->arrayToAttributes($attributes);
    $elementsHtml = implode('', $elements);
    return "<form action=\"$action\" method=\"$method\" class=\"$class\" $attrString>$elementsHtml</form>";
  }

  // Método para generar un campo de formulario
  public function createFormField(string $label, string $type, string $name, string $value = '', string $class = '', array $attributes = []): string {
    $class = empty($class) ? 'form-control' : $class;
    $attrString = $this->arrayToAttributes($attributes);
    return "
      <div class=\"mb-3\">
        <label for=\"$name\" class=\"form-label\">$label</label>
        <input type=\"$type\" name=\"$name\" value=\"$value\" class=\"$class\" id=\"$name\" $attrString>
      </div>
    ";
  }

  // Método para generar un modal
  public function createModal(string $id, string $title, string $body, string $footer = '', string $class = '', array $attributes = []): string {
    $class = empty($class) ? $this->defaultClasses['modal'] : $class;
    $attrString = $this->arrayToAttributes($attributes);
    $footerHtml = $footer ? "<div class=\"modal-footer\">$footer</div>" : '';
    return "
      <div class=\"$class\" id=\"$id\" tabindex=\"-1\" aria-labelledby=\"${id}Label\" aria-hidden=\"true\" $attrString>
        <div class=\"modal-dialog\">
          <div class=\"modal-content\">
            <div class=\"modal-header\">
              <h5 class=\"modal-title\" id=\"${id}Label\">$title</h5>
              <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>
            </div>
            <div class=\"modal-body\">$body</div>
            $footerHtml
          </div>
        </div>
      </div>
    ";
  }

  // Método para generar una barra de navegación
  public function createNavbar(array $items, string $class = '', array $attributes = []): string {
    $class = empty($class) ? $this->defaultClasses['navbar'] : $class;
    $attrString = $this->arrayToAttributes($attributes);
    $itemsHtml = implode('', $items);
    return "
      <nav class=\"$class\" $attrString>
        <div class=\"container-fluid\">
          <a class=\"navbar-brand\" href=\"#\">Menú</a>
          <button class=\"navbar-toggler\" type=\"button\" data-bs-toggle=\"collapse\" data-bs-target=\"#navbarNav\" aria-controls=\"navbarNav\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">
            <span class=\"navbar-toggler-icon\"></span>
          </button>
          <div class=\"collapse navbar-collapse\" id=\"navbarNav\">
            <ul class=\"navbar-nav\">$itemsHtml</ul>
          </div>
        </div>
      </nav>
    ";
  }

  // Método para generar un elemento de lista de navegación
  public function createNavItem(string $text, string $href = '#', string $class = '', array $attributes = []): string {
    $class = empty($class) ? 'nav-item' : $class;
    $attrString = $this->arrayToAttributes($attributes);
    return "
      <li class=\"$class\">
        <a class=\"nav-link\" href=\"$href\" $attrString>$text</a>
      </li>
    ";
  }

  // Método para generar una lista de grupo
  public function createListGroup(array $items, string $class = '', array $attributes = []): string {
    $class = empty($class) ? $this->defaultClasses['listGroup'] : $class;
    $attrString = $this->arrayToAttributes($attributes);
    $itemsHtml = implode('', $items);
    return "<ul class=\"$class\" $attrString>$itemsHtml</ul>";
  }

  // Método para generar un elemento de lista de grupo
  public function createListGroupItem(string $text, string $class = '', array $attributes = []): string {
    $class = empty($class) ? 'list-group-item' : $class;
    $attrString = $this->arrayToAttributes($attributes);
    return "<li class=\"$class\" $attrString>$text</li>";
  }

  // Método para generar una tabla
  public function createTable(array $headers, array $rows, string $class = '', array $attributes = []): string {
    $class = empty($class) ? $this->defaultClasses['table'] : $class;
    $attrString = $this->arrayToAttributes($attributes);
    $headerHtml = implode('', array_map(fn($header) => "<th>$header</th>", $headers));
    $rowsHtml = implode('', array_map(fn($row) => '<tr>' . implode('', array_map(fn($cell) => "<td>$cell</td>", $row)) . '</tr>', $rows));
    return "
      <table class=\"$class\" $attrString>
        <thead>
          <tr>$headerHtml</tr>
        </thead>
        <tbody>$rowsHtml</tbody>
      </table>
    ";
  }

  // Método para convertir un array de atributos en una cadena de atributos HTML
  private function arrayToAttributes(array $attributes): string {
    return implode(' ', array_map(fn($key, $value) => htmlspecialchars($key) . '="' . htmlspecialchars($value) . '"', array_keys($attributes), $attributes));
  }
}
