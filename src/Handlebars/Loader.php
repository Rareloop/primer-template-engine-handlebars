<?php

namespace Rareloop\Primer\TemplateEngine\Handlebars;

use Rareloop\Primer\Primer;
use Rareloop\Primer\TemplateEngine\Handlebars\Template;
use Handlebars\Loader\FilesystemLoader;
use InvalidArgumentException;

class Loader implements \Handlebars\Loader
{
    protected $filesystemLoader;

    public function __construct()
    {
        $this->filesystemLoader = new FilesystemLoader(Primer::$PATTERN_PATH, [
            "extension" => Template::$extension,
        ]);
    }

    /**
     * Load a Template by name.
     *
     * @param string $name template name to load
     *
     * @return String
     */
    public function load($name)
    {
        $primerTemplate = $name . '.' . Template::$extension;
        $primerTemplateFromInclude = Primer::$PATTERN_PATH . '/' . $name . '/template.' . Template::$extension;

        if (is_file($primerTemplate)) {
            return file_get_contents($primerTemplate);
        } elseif (is_file($primerTemplateFromInclude)) {
            return file_get_contents($primerTemplateFromInclude);
        } else {
            // We didn't get a pattern match, so we should try the filesystem loader instead
            return $this->filesystemLoader->load($name);
        }
    }
}
