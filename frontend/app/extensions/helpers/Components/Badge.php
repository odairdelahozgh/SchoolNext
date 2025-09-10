<?php

namespace AdminLTE\Components;

class Badge {
    /**
     * Genera un componente Badge.
     */
    public static function render($text, $options = []) {
        $defaultOptions = ['color' => 'secondary', 'pill' => false, 'class' => ''];
        $options = array_merge($defaultOptions, $options);

        $classes = 'badge text-bg-' . $options['color'];
        if ($options['pill']) {
            $classes .= ' rounded-pill';
        }
        if ($options['class']) {
            $classes .= ' ' . $options['class'];
        }

        return '<span class="' . $classes . '">' . htmlspecialchars($text) . '</span>';
    }
}
