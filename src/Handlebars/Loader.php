<?php 

namespace Rareloop\Primer\TemplateEngine\Handlebars;

use Rareloop\Primer\Primer;
use Rareloop\Primer\TemplateEngine\Handlebars\Template;

class Loader implements \Handlebars\Loader
{
    /**
     * Load a Template by name.
     *
     * @param string $name template name to load
     *
     * @return String
     */
    public function load($name)
    {
        $id = Primer::cleanId($name);

        $path = Primer::$PATTERN_PATH . '/' . $id . '/template.' . Template::$extension;

        if (file_exists($path)) {
            return file_get_contents($path);
        } else {
            throw new \InvalidArgumentException('Template ' . $name . ' not found.');
        }
    }
}
