<?php
/**
 * $alert = new BootstrapAlert('Este es un mensaje de alerta', 'success');
 * echo $alert->generateAlert();
 * echo $alert->generateDismissableAlert();
 * @link https://getbootstrap.com/docs/5.0/components/alerts/
 */
class BootstrapAlert {
  
  public function __construct(
    private $message, 
    private $type = 'primary') 
  {
  }
  public function generateAlert($withCloseButton = false) {
    $html = '<div class="alert alert-' . $this->type . '" role="alert">';
    if ($withCloseButton) {
      $html .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    }
    $html .= $this->message;
    $html .= '</div>';
    return $html;
  }

  public function generateDismissableAlert() {
    return $this->generateAlert(true);
  }

}