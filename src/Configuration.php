<?php

namespace Cerwyn\Laraser;

class Configuration
{
    public $allModels = false;
    public $exceptModels;
    public $models;

    public $removesIn;

    public function __construct()
    {
        $this->models();
    }

    public function models()
    {
        if (config('laraser.only') == ['*']) {
            $this->allModels = true;
        }
        $this->models = config('laraser.only');
        $this->exceptModels = config('laraser.except');
    }

    public function remove()
    {
        $this->removesIn = config('laraser.remove_in');
    }

}