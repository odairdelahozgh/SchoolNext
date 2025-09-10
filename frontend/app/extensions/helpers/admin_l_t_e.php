<?php

// Incluir todas las clases de componentes
require_once __DIR__ . '/Components/Card.php';
require_once __DIR__ . '/Components/Alert.php';
require_once __DIR__ . '/Components/SmallBox.php';
require_once __DIR__ . '/Components/Callout.php';
require_once __DIR__ . '/Components/Tabs.php';
require_once __DIR__ . '/Components/Accordion.php';
require_once __DIR__ . '/Components/DirectChat.php';
require_once __DIR__ . '/Components/Timeline.php';
require_once __DIR__ . '/Components/Badge.php';
require_once __DIR__ . '/Components/ProgressBar.php';
require_once __DIR__ . '/Components/Pagination.php';
require_once __DIR__ . '/Components/Form.php';
require_once __DIR__ . '/Components/Treeview.php';
require_once __DIR__ . '/Components/Table.php';
require_once __DIR__ . '/Components/Modal.php';
require_once __DIR__ . '/Components/Toast.php';
require_once __DIR__ . '/Widgets/InfoBox.php';
require_once __DIR__ . '/Widgets/UserList.php';
require_once __DIR__ . '/Widgets/Ribbon.php';
require_once __DIR__ . '/Widgets/ProductList.php';
require_once __DIR__ . '/Widgets/DescriptionList.php';

/**
 * Clase AdminLTE (Facade)
 */
class AdminLTE {

    public static function card($title, $body, $options = []) {
        return \AdminLTE\Components\Card::render($title, $body, $options);
    }

    public static function alert($message, $options = []) {
        return \AdminLTE\Components\Alert::render($message, $options);
    }

    public static function smallBox($title, $number, $icon, $options = []) {
        return \AdminLTE\Components\SmallBox::render($title, $number, $icon, $options);
    }

    public static function callout($content, $options = []) {
        return \AdminLTE\Components\Callout::render($content, $options);
    }

    public static function tabs($tabs, $options = []) {
        return \AdminLTE\Components\Tabs::render($tabs, $options);
    }

    public static function accordion($items, $options = []) {
        return \AdminLTE\Components\Accordion::render($items, $options);
    }

    public static function directChat($title, $messages, $options = []) {
        return \AdminLTE\Components\DirectChat::render($title, $messages, $options);
    }

    public static function timeline($items) {
        return \AdminLTE\Components\Timeline::render($items);
    }

    public static function badge($text, $options = []) {
        return \AdminLTE\Components\Badge::render($text, $options);
    }

    public static function progressBar($value, $options = []) {
        return \AdminLTE\Components\ProgressBar::render($value, $options);
    }

    public static function pagination($currentPage, $totalPages, $options = []) {
        return \AdminLTE\Components\Pagination::render($currentPage, $totalPages, $options);
    }

    public static function inputGroup($name, $options = []) {
        return \AdminLTE\Components\Form::inputGroup($name, $options);
    }

    public static function customSwitch($name, $label, $options = []) {
        return \AdminLTE\Components\Form::customSwitch($name, $label, $options);
    }

    public static function input($name, $label, $options = []) {
        return \AdminLTE\Components\Form::input($name, $label, $options);
    }

    public static function textarea($name, $label, $options = []) {
        return \AdminLTE\Components\Form::textarea($name, $label, $options);
    }

    public static function select($name, $label, $selectOptions, $options = []) {
        return \AdminLTE\Components\Form::select($name, $label, $selectOptions, $options);
    }

    public static function customCheckbox($name, $label, $options = []) {
        return \AdminLTE\Components\Form::customCheckbox($name, $label, $options);
    }

    public static function customRadio($name, $label, $options = []) {
        return \AdminLTE\Components\Form::customRadio($name, $label, $options);
    }

    public static function treeview(array $items, array $options = []) {
        return \AdminLTE\Components\Treeview::render($items, $options);
    }

    public static function table(array $headers, array $data, array $options = []) {
        return \AdminLTE\Components\Table::render($headers, $data, $options);
    }

    public static function modal(string $id, string $title, string $body, array $options = []) {
        return \AdminLTE\Components\Modal::render($id, $title, $body, $options);
    }

    public static function modalToggleButton(string $targetId, string $text, array $options = []) {
        return \AdminLTE\Components\Modal::renderToggleButton($targetId, $text, $options);
    }

    public static function toast(string $id, string $title, string $body, array $options = []) {
        return \AdminLTE\Components\Toast::render($id, $title, $body, $options);
    }

    public static function toastContainer(array $toasts) {
        return \AdminLTE\Components\Toast::renderContainer($toasts);
    }

    public static function toastJsTriggerScript() {
        return \AdminLTE\Components\Toast::renderJsTriggerScript();
    }

    public static function widgetInfoBox(string $text, string $number, string $icon, array $options = []) {
        return \AdminLTE\Widgets\InfoBox::render($text, $number, $icon, $options);
    }

    public static function widgetUserList(string $title, array $users, array $options = []) {
        return \AdminLTE\Widgets\UserList::render($title, $users, $options);
    }

    public static function widgetRibbon(string $text, array $options = []) {
        return \AdminLTE\Widgets\Ribbon::render($text, $options);
    }

    public static function widgetProductList(string $title, array $products, array $options = []) {
        return \AdminLTE\Widgets\ProductList::render($title, $products, $options);
    }

    public static function widgetDescriptionList(array $items, array $options = []) {
        return \AdminLTE\Widgets\DescriptionList::render($items, $options);
    }
}