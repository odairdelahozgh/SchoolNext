<?php
/**
 * OdaTabs: Helper ThemeSteeper.
 * 
 * @author  ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category Helper.
 * @source  frontend\app\extensions\helpers\th_steeper.php
 */
class BsTabSteeper {
  private $_cnt = 0;
  private $_cnt_tab = 0;
  private $_cnt_contenido = 0;
  private $_arrTabs = [];
  private $_arrContenido = [];

  // public function __construct() {
  // }

  public function __toString() {
    return "
      <div id=\"stepper\" class=\"bs-stepper\">
       <div class=\"card\">

        <div class=\"card-header\">
          <div class=\"steps steps-\" role=\"tablist\">
           <ul>
            {$this->getTabs()}
           </ul>
          </div>
        </div>

        <div class=\"card-body\">
          <form id=\"stepper-form\" name=\"stepperForm\" class=\"p-lg-4 p-sm-3 p-0\">
            {$this->getContenidos()}
          </form>
        </div>

       </div>
      </div>
    ";
  }
  
  public function addTabStep(
    array $tab = [], 
    array $contenido = [],
  ) :void 
  {
    $this->_cnt +=1;
    $this->_arrTabs[$this->_cnt] = 
    "<li class=\"step\" data-target=\"#$tab[0]\" data-validate=\"$tab[1]\">
      <a href=\"#\" class=\"step-trigger\" tabindex=\"-1\">
       <span class=\"step-indicator step-indicator-icon\"><i class=\"oi oi-$tab[2]\"></i></span>
       <span class=\"d-none d-sm-inline\">$tab[3]</span>
      </a>
    </li>";
    
    $this->_arrContenido[$this->_cnt] = 
    "<div id=\"$tab[0]\" class=\"content dstepper-none fade\">
       <fieldset>
         <legend>$contenido[0]</legend>
         $contenido[1]
       </fieldset>
    </div>";

  } //END-addTabStep

  public function getTabs(): string {
    $tabs = '';
    foreach ($this->_arrTabs as $tab_key => $tab) {
      $tabs .= $tab;
    }
    return $tabs;
  }

  public function getContenidos(): string {
    $contenidos = '';
    foreach ($this->_arrContenido as $cont_key => $conten) {
      $contenidos .= $conten;
    }
    return $contenidos;
  }
} // END-OdaTabs