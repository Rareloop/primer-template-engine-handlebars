<?php namespace Rareloop\Primer\TemplateEngine\Handlebars;

use Rareloop\Primer\Templating\Template as PrimerTemplate;
use Rareloop\Primer\TemplateEngine\Handlebars\Handlebars;
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

        $path = $directory . '/' . $filename;

        $template = Handlebars::instance()->getPartialsLoader()->load($path);

        if ($template === false) {
            throw new \Exception('Template can not be found: ' . $directory . '/' . $filename);
        }

        $this->template = $template;
    }

    public function render($data)
    {
        $engine = Handlebars::instance();

        return $engine->render((string)$this->template, $data->toArray());
    }

    public function raw()
    {
        return $this->template;
    }
}
