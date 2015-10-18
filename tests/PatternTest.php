<?php

namespace Rareloop\Primer\TemplateEngine\Handlebars\Tests;

use Rareloop\Primer\Events\Event;
use Rareloop\Primer\TemplateEngine\Handlebars\Template;

class PatternTest extends \PHPUnit_Framework_TestCase
{
    protected $primer;

    /**
     * Bootstrap the system
     */
    public function setup()
    {
        $this->primer = \Rareloop\Primer\Primer::start(array(
            'basePath' => __DIR__.'/primer-test',
            'templateClass' => Template::class,
        ));
    }

    /**
     * The twig template should render
     */
    public function testBasicRender()
    {
        $output = $this->primer->getPatterns(array('components/test-group/basic-pattern'), false);

        $this->assertEquals($output, 'Basic pattern with no data');
    }

    /**
     * A pattern should load data from data.json
     */
    public function testData()
    {
        $output = $this->primer->getPatterns(array('components/test-group/data-autoload'), false);

        $this->assertEquals($output, '1.2');
    }

    /**
     * An aliased pattern should merge data files
     */
    public function testAliasData()
    {
        $output = $this->primer->getPatterns(array('components/test-group/data-autoload~alias'), false);

        $this->assertEquals($output, '1.3');
    }

    /**
     * Include one pattern in another
     */
    public function testIncludeFunction()
    {
        $output = $this->primer->getPatterns(array('components/test-group/include-basic'), false);

        $this->assertEquals($output, 'Basic pattern with no data');
    }

    /**
     * Test when a pattern is included that itself has default data but the parent pattern overrides the data
     */
    public function testIncludeFunctionWithInlineData()
    {
        $output = $this->primer->getPatterns(array('components/test-group/include-inline-data'), false);

        $this->assertEquals($output, 'Inlined data.');
    }

    /**
     * Test when there are more than one param passed to a partial
     */
    public function testIncludeWithMultipleParams()
    {
        $output = $this->primer->getPatterns(array('components/test-group/include-multi-inline-data'), false);

        $this->assertEquals($output, 'abc123');
    }
    
    /**
     * Test when passing a variable to interpolate into a partial (e.g. title=subTitle instead of title='The subtitle')
     */
    public function testIncludeWithInterpolatedInlineData()
    {
        $output = $this->primer->getPatterns(array('components/test-group/include-interpolated-inline-data'), false);

        $this->assertEquals($output, 'success');
    }

    /**
     * Test when passing a new context into a partial
     */
    public function testIncludeWithInlineContext()
    {
        $output = $this->primer->getPatterns(array('components/test-group/include-with-inline-context'), false);

        $this->assertEquals($output, 'new context');
    }

    /**
     * Test when passing a new context into a partial
     */
    public function testIncludeNonPrimerPartial()
    {
        $output = $this->primer->getPatterns(array('components/test-group/include-non-primer-partial'), false);

        $this->assertEquals($output, 'child');
    }
}
