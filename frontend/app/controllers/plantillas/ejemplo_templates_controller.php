<?php

class TemplatesController extends AppController
{
    // allowed templates
    const ALLOW = ['csv', 'xml', 'json'];

    public function index() {
        $this->data = Usuarios::all();
    }

    public function get($template) {
        if (!in_array($template, self::ALLOW)) {
            throw new KumbiaException('');
        }
        View::select(null, $template);
        $this->data = Usuarios::all();
    }
}