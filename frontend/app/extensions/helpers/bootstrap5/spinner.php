<?php
/**
 * $spinner = new BootstrapSpinner(SpinnerColor::PRIMARY, SpinnerSize::SM, 'my-custom-class');
 * echo $spinner->generateSpinner();
 * 
 * $borderSpinner = new BootstrapSpinner(SpinnerColor::DANGER, SpinnerSize::LG);
 * echo $borderSpinner->generateBorderSpinner();
 * 
 * $growSpinner = new BootstrapSpinner(SpinnerColor::SUCCESS, SpinnerSize::MD, 'custom-class');
 * echo $growSpinner->generateGrowSpinner();
 */
enum SpinnerColor: string {
    case PRIMARY = 'primary';
    case SECONDARY = 'secondary';
    // Puedes agregar más colores según tus necesidades
}

enum SpinnerSize: string {
    case SM = 'sm';
    case MD = 'md';
    case LG = 'lg';
    // Puedes agregar más tamaños según tus necesidades
}

class BootstrapSpinner {
    public function __construct(
      private SpinnerColor $color = SpinnerColor::PRIMARY, 
      private SpinnerSize $size = SpinnerSize::MD, 
      private string $additionalClasses = ''
    ) { }

    private function generateClasses(): string 
    {
        $classes = 'spinner-' . $this->color->value;

        if (!empty($this->size)) {
            $classes .= ' spinner-' . $this->size->value;
        }

        if (!empty($this->additionalClasses)) {
            $classes .= ' ' . $this->additionalClasses;
        }

        return $classes;
    }

    public function generateSpinner(): string 
    {
        $classes = $this->generateClasses();

        $html = '<div class="spinner ' . $classes . '" role="status">';
        $html .= '<span class="visually-hidden">Loading...</span>';
        $html .= '</div>';

        return $html;
    }

    public function generateBorderSpinner(): string 
    {
        $classes = $this->generateClasses();

        $html = '<div class="spinner-border ' . $classes . '" role="status">';
        $html .= '<span class="visually-hidden">Loading...</span>';
        $html .= '</div>';

        return $html;
    }

    public function generateGrowSpinner(): string 
    {
        $classes = $this->generateClasses();

        $html = '<div class="spinner-grow ' . $classes . '" role="status">';
        $html .= '<span class="visually-hidden">Loading...</span>';
        $html .= '</div>';

        return $html;
    }


}