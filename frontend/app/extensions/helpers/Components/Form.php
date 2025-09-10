<?php

namespace AdminLTE\Components;

class Form {
    /**
     * Genera un campo de input completo (label, input, help text).
     */
    public static function input($name, $label, $options = []) {
        $defaultOptions = ['type' => 'text', 'value' => '', 'placeholder' => '', 'help_text' => '', 'id' => null];
        $options = array_merge($defaultOptions, $options);
        $id = $options['id'] ?? 'form-' . $name;

        $html = '<div class="mb-3">';
        $html .= '  <label for="' . $id . '" class="form-label">' . htmlspecialchars($label) . '</label>';
        $html .= '  <input type="' . $options['type'] . '" class="form-control" id="' . $id . '" name="' . $name . '" value="' . htmlspecialchars($options['value']) . '" placeholder="' . htmlspecialchars($options['placeholder']) . '">';
        if ($options['help_text']) {
            $html .= '<div class="form-text">' . htmlspecialchars($options['help_text']) . '</div>';
        }
        $html .= '</div>';
        return $html;
    }

    /**
     * Genera un campo de textarea completo.
     */
    public static function textarea($name, $label, $options = []) {
        $defaultOptions = ['value' => '', 'rows' => 3, 'placeholder' => '', 'id' => null];
        $options = array_merge($defaultOptions, $options);
        $id = $options['id'] ?? 'form-' . $name;

        $html = '<div class="mb-3">';
        $html .= '  <label for="' . $id . '" class="form-label">' . htmlspecialchars($label) . '</label>';
        $html .= '  <textarea class="form-control" id="' . $id . '" name="' . $name . '" rows="' . $options['rows'] . '" placeholder="' . htmlspecialchars($options['placeholder']) . '">' . htmlspecialchars($options['value']) . '</textarea>';
        $html .= '</div>';
        return $html;
    }

    /**
     * Genera un campo de select completo.
     */
    public static function select($name, $label, $selectOptions, $options = []) {
        $defaultOptions = ['selected_value' => null, 'id' => null];
        $options = array_merge($defaultOptions, $options);
        $id = $options['id'] ?? 'form-' . $name;

        $html = '<div class="mb-3">';
        $html .= '  <label for="' . $id . '" class="form-label">' . htmlspecialchars($label) . '</label>';
        $html .= '  <select class="form-select" id="' . $id . '" name="' . $name . '">';
        foreach ($selectOptions as $value => $text) {
            $selectedAttr = ($value == $options['selected_value']) ? ' selected' : '';
            $html .= '<option value="' . htmlspecialchars($value) . '"' . $selectedAttr . '>' . htmlspecialchars($text) . '</option>';
        }
        $html .= '  </select>';
        $html .= '</div>';
        return $html;
    }

    /**
     * Genera un Custom Checkbox.
     */
    public static function customCheckbox($name, $label, $options = []) {
        $defaultOptions = ['value' => '1', 'checked' => false, 'id' => null];
        $options = array_merge($defaultOptions, $options);
        $id = $options['id'] ?? 'check-' . uniqid();
        $checkedAttr = $options['checked'] ? 'checked' : '';

        $html = '<div class="form-check">';
        $html .= '  <input class="form-check-input" type="checkbox" name="' . $name . '" value="' . htmlspecialchars($options['value']) . '" id="' . $id . '" ' . $checkedAttr . '>';
        $html .= '  <label class="form-check-label" for="' . $id . '">' . htmlspecialchars($label) . '</label>';
        $html .= '</div>';
        return $html;
    }

    /**
     * Genera un Custom Radio button.
     */
    public static function customRadio($name, $label, $options = []) {
        $defaultOptions = ['value' => '1', 'checked' => false, 'id' => null];
        $options = array_merge($defaultOptions, $options);
        $id = $options['id'] ?? 'radio-' . uniqid();
        $checkedAttr = $options['checked'] ? 'checked' : '';

        $html = '<div class="form-check">';
        $html .= '  <input class="form-check-input" type="radio" name="' . $name . '" value="' . htmlspecialchars($options['value']) . '" id="' . $id . '" ' . $checkedAttr . '>';
        $html .= '  <label class="form-check-label" for="' . $id . '">' . htmlspecialchars($label) . '</label>';
        $html .= '</div>';
        return $html;
    }


    /**
     * Genera un Input Group.
     */
    public static function inputGroup($name, $options = []) {
        $defaultOptions = ['type' => 'text', 'placeholder' => '', 'prepend' => null, 'append' => null, 'value' => ''];
        $options = array_merge($defaultOptions, $options);

        $html = '<div class="input-group mb-3">';
        if ($options['prepend']) {
            $html .= '<span class="input-group-text">' . $options['prepend'] . '</span>';
        }
        $html .= '<input type="' . $options['type'] . '" name="' . $name . '" class="form-control" placeholder="' . htmlspecialchars($options['placeholder']) . '" value="' . htmlspecialchars($options['value']) . '">';
        if ($options['append']) {
            $html .= '<span class="input-group-text">' . $options['append'] . '</span>';
        }
        $html .= '</div>';
        return $html;
    }

    /**
     * Genera un Custom Switch.
     */
    public static function customSwitch($name, $label, $options = []) {
        $defaultOptions = ['checked' => false, 'id' => null];
        $options = array_merge($defaultOptions, $options);

        $id = $options['id'] ?? 'switch-' . uniqid();
        $checkedAttr = $options['checked'] ? 'checked' : '';

        $html = '<div class="form-check form-switch">';
        $html .= '  <input class="form-check-input" type="checkbox" name="' . $name . '" role="switch" id="' . $id . '" ' . $checkedAttr . '>';
        $html .= '  <label class="form-check-label" for="' . $id . '">' . htmlspecialchars($label) . '</label>';
        $html .= '</div>';
        return $html;
    }
}
