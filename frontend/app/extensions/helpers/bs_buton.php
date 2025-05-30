<?php
declare(strict_types=1);
namespace App\Components\Bootstrap5;
use Exception;

class BsButton extends BtComponent
{
    private string $text;
    private string $type;
    private string $color;
    private string $size;

    public function __construct(string $text, string $type = 'button', string $color = 'primary', string $size = 'md', string $id = '')
    {
        parent::__construct('button', $id);
        $this->text = $text;
        $this->type = $type;
        $this->color = $color;
        $this->size = $size;
    }

    protected function getTemplate(): string
    {
        $buttonClasses = "btn btn-$this->color";
        if ($this->size !== 'md') {
            $buttonClasses .= " btn-$this->size";
        }

        return <<<EOD
        <button 
            type="$this->type" 
            id="$this->id" 
            {$this->getClasses()}$buttonClasses{$this->getDataAttributes()}
        >
            {$this->text}
        </button>
EOD;
    }
}
