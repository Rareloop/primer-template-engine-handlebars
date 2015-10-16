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
        var_dump(Primer::$PATTERN_PATH);
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
        // Assume that most of the time we'll be including patterns
        $id = Primer::cleanId($name);

        $path = Primer::$PATTERN_PATH . '/' . $id . '/template.' . Template::$extension;

        if (file_exists($path)) {
            return file_get_contents($path);
        } else {
            // We didn't get a pattern match, so we should try the filesystem loader instead
            return $this->filesystemLoader->load($name);
        }
    }
}
