<?php

namespace CustomForm;

class Form {

    public function submit() {
       //code 
    }

    public static function render() {
        require_once __DIR__ . "/../../public/form.html"; 
    }

    public static function loadStyle() {
        require_once __DIR__ . "/../../public/assets/css/style.css";
    }

    public static function loadJs() {
        require_once __DIR__ . "/../../public/assets/js/index.js";
    }
}
