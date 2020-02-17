<?php

namespace App\Service;

abstract class AbstractManager {

    protected $container;
    protected $configuration;

    public function __construct() {
        global $container;
        global $configuration;
        $this->container = $container;
        $this->configuration = $configuration;
    }
}