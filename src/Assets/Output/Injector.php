<?php

namespace Tlc\Assets\Output;

use Mockery\Matcher\Closure;

class Injector
{
    /**
     * The injectors
     *
     * @var array
     */
    protected $injectors = [];

    /**
     * The enclosing comment tags
     *
     * @var array
     */
    protected $wrapperTags = ['\<\-\-', '\-\-\>'];

    /**
     * The asset tag
     *
     * <-- @@inject-assets:{scripts} method:{tag} domain:{default}@@ -->
     *
     * @var string
     */
    protected $assetTag = '@@inject-assets:\{(scripts|styles)\} method:\{(tag|content)\} domain:\{(.*)\}@@';

    public function __construct(TagInjector $tag, ContentInjector $content)
    {
        $this->injectors['tag'] = $tag;
        $this->injectors['content'] = $content;
    }

    /**
     * Inject the tags or content
     *
     * @param  string   $input
     * @return string
     */
    public function inject($input)
    {
        return preg_replace_callback($this->pattern(), [$this, 'replaceAssetInjectionTag'], $input);
    }

    /**
     * The pattern to match
     *
     * @return string
     */
    public function pattern()
    {
        return sprintf('%s %s %s',
            $this->wrapperTags[0],
            $this->assetTag,
            $this->wrapperTags[1]
        );
    }

    /**
     * The replace callback
     *
     * @param  array  $matches
     * @return string
     */
    public function replaceAssetInjectionTag(array $matches)
    {
        list(,$type, $format, $domain) = $matches;

        return $this->injectors[$format]->{$type}($domain);
    }
}
