<?php namespace Rareloop\Primer\TemplateEngine\Handlebars;

use Rareloop\Primer\FileSystem;
use Rareloop\Primer\Events\Event;

class Handlebars extends \Handlebars\Handlebars
{

    private static $_instance;

    /**
     * Handlebars engine constructor
     * $options array can contain :
     * helpers        => Helpers object
     * escape         => a callable function to escape values
     * escapeArgs     => array to pass as extra parameter to escape function
     * loader         => Loader object
     * partials_loader => Loader object
     * cache          => Cache object
     *
     * @param array $options array of options to set
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(array $options = array())
    {
        $options['partials_loader'] = new Loader();
        parent::__construct($options);
    }

    public static function instance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new Handlebars();

            Event::fire('handlebars.init', self::$_instance);
        }

        return self::$_instance;
    }
}
