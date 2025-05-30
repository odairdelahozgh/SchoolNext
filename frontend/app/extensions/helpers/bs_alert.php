<?php
declare(strict_types=1);
namespace App\Components\Bootstrap5;
use Exception;

class BsAlert extends BtComponent
{
    public function __construct(
      private string $type, 
      private string $message, 
      private string $id = '', 
      private bool $dismissible = false)
    {
      parent::__construct('alert', $this->id);
    }

    protected function getTemplate(): string
    {
        $alertClasses = "alert alert-$this->type";
        if ($this->dismissible) {
            $alertClasses .= ' alert-dismissible fade show';
        }

        return "
        <div id=\"$this->id\" {$this->getClasses()}$alertClasses{$this->getDataAttributes()}>
            {$this->message}
            ({$this->dismissible} ? '<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>' : '')
        </div>
        ";
    }
}

