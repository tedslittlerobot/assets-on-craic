<?php

namespace Tlr\Assets\Assets;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Tlr\Assets\Assets\AssetRenderer;
use Tlr\Assets\Assets\AssetResolver;

class AssetRenderController extends Controller
{
    /**
     * The asset renderer
     *
     * @var \Tlr\Assets\Assets\AssetRenderer
     */
    protected $renderer;

    /**
     * The asset resolver
     *
     * @var \Tlr\Assets\Assets\AssetResolver
     */
    protected $assets;

    public function __construct(AssetResolver $assets, AssetRenderer $renderer)
    {
        $this->renderer = $renderer;
        $this->assets = $assets;
    }

    /**
     * Render the given JS assets
     *
     * @Get("assets/scripts.js", as="assets.js")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function scripts(Request $request)
    {
        return response(
            $this->renderer->scripts($this->resolve($request->input('sources'))),
            200,
            ['Content-Type' => 'application/javascript; charset=UTF-8']
        );
    }


    /**
     * Render the given JS assets
     *
     * @Get("assets/styles.css", as="assets.css")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function styles(Request $request)
    {
        return response(
            $this->renderer->styles($this->resolve($request->input('sources'))),
            200,
            ['Content-Type' => 'text/css; charset=UTF-8']
        );
    }

    /**
     * Resolve the given assets
     *
     * @param  array  $sources
     * @return array
     */
    protected function resolve($sources) {
        return $this->assets
            ->clear()
            ->resolveArray((array)$sources)
            ->assets();
    }
}
