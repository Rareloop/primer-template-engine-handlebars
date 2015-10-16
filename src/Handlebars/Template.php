<?php namespace Rareloop\Primer\TemplateEngine\Handlebars;

use Rareloop\Primer\Templating\Template as PrimerTemplate;
use Rareloop\Primer\TemplateEngine\Handlebars\Handlebars;
// use \Handlebars\Handlebars;
use Rareloop\Primer\Primer;

class Template extends PrimerTemplate
{
    /**
     * Array of file extensions
     *
     * @var array
     */
    public static $extension = 'hbs';

    public function load($directory, $filename)
    {
        parent::load($directory, $filename);

        $template = false;

        $path = $directory . '/' . $filename . '.' . self::$extension;

        if (is_file($path)) {
            $template = file_get_contents($path);
        }

        if (!$template) {
            throw new \Exception('Template can not be found: ' . $directory . '/' . $filename);
        }

        $this->template = $template;
    }

    public function render($data)
    {
        $engine = Handlebars::instance();

        return $engine->render($this->template, $data->toArray());
    }

    public function raw()
    {
        return $this->template;
    }
}
