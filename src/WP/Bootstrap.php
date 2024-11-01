<?php
namespace WP\Plugin\DocumentAutomation\WP;

/**
 * Bootstrap
 */
class Bootstrap
{
    protected $container;

    /**
     * Constructor
     *
     * @param [type] $container [description]
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Register Activation Hook
     *
     * @return [type] [description]
     */
    public function register_activation_hook()
    {
    }
}
