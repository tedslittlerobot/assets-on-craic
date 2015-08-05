<?php

namespace Tlr\Assets;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AssetRenderController extends Controller
{

    /**
     * The asset renderer
     *
     * @var \Tlr\Assets\Components\AssetRenderer
     */
    protected $renderer;

    public function __construct(AssetRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * Render the given JS assets
     *
     * @Get("assets/scripts.js", as="assets.js")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getJs(Request $request)
    {
        return response(
            $this->renderer->scripts( (array)$request->input('sources', []) ),
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
    public function getCss(Request $request)
    {
        return response(
            $this->renderer->styles( (array)$request->input('sources', []) ),
            200,
            ['Content-Type' => 'text/css; charset=UTF-8']
        );
    }
}
