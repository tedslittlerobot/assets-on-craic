<?php

namespace Tlc\Assets\Output\Middleware;

use Closure;
use Tlc\Assets\Output\Injector;

class InjectsAssets
{
	/**
	 * The injectors
	 *
	 * @var \Tlc\Assets\Output\Injector
	 */
	protected $injector;

	public function __construct(Injector $injector)
	{
		$this->injector = $injector;
	}

	/**
	 * Handle the response
	 *
	 * @param  mixed   $request
	 * @param  Closure $next
	 * @return string
	 */
	public function handle($request, Closure $next)
	{
		$response = $next($request);

		return $this->injector->inject($response);
	}
}
