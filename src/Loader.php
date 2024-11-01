<?php
namespace WP\Plugin\DocumentAutomation;

use Pimple\Container;
use OA_WP_Library\View;
use OA_WP_Library\Plugin;

class Loader extends Container
{
    /**
     *
     * @var mixed
     */
    public static $instance;

    public function __construct()
    {
        parent::__construct();

        $this['bootstrap'] = function ($container) {
            return new WP\Bootstrap($container);
        };

        $this['plugin'] = function ($container) {
            return new \OA_WP_Library\Plugin($container);
        };

        $this['template'] = function ($container) {
            return new Document\Template($container);
        };

        $this['admin'] = function ($container) {
            return new WP\Admin($container);
        };

        $this['view'] = function ($container) {
            return new View($container);
        };

    }

    /**
     * Get container instance
     *
     * @return [type] [description]
     */
    public static function get_instance()
    {
        if (!self::$instance) {
            self::$instance = new Loader();
        }

        return self::$instance;
    }

    public function run()
    {
        register_activation_hook($this['file'], [$this['bootstrap'], 'register_activation_hook']);
        add_action('admin_menu', [$this['admin'], 'admin_menu']);
        $this['template']->process_file_create_request();
    }
}
