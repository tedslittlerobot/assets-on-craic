<?php

namespace Tlr\Display\Components\Traits;

use Illuminate\View\Expression;

trait FluentComponentTrait
{

    /**
     * The data
     *
     * @var array
     */
    protected $data = [];

    /**
     * Fluently and magically set a value
     *
     * @param  string $key
     * @param  array  $arguments
     * @return mixed
     */
    public function __call($key, $arguments)
    {
        return $this->add($key, $arguments[0], array_get($arguments, 1, false));
    }

    /**
     * Set or append a value.
     *
     * @param string  $key
     * @param mixed   $value
     * @param bool    $shouldAppend
     */
    public function add($key, $value, $shouldAppend = false)
    {
        return $shouldAppend ?
            $this->append($key, $value) :
            $this->set($key, $value);
    }

    /**
     * Set the value
     *
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function set($key, $value)
    {
        $this->data[$key] = $value;

        return $this;
    }

    /**
     * Set the wrapped content for the component
     *
     * @param mixed $content
     */
    public function setWrappedContent($content)
    {
        return $this->set('content', new Expression($content));
    }

    /**
     * Start wrapping some content
     *
     * @return mixed
     */
    public function wrapContent()
    {
        ob_start();

        return $this;
    }

    /**
     * Finish wrapping some content
     *
     * @return mixed
     */
    public function endWrapContent()
    {
        $this->setWrappedContent(ob_get_clean());

        return $this;
    }

    /**
     * Append the value to the given key
     *
     * @param  string $key
     * @param  mixed  $value
     * @return mixed
     */
    public function append($key, $value)
    {
        // @todo - handle collection
        // @todo - handle messagebag

        if (!isset($this->data[$key])) {
            $this->data[$key] = [$value];

            return $this;
        }

        if (!is_array($this->data[$key])) {
            $this->data[$key] = (array)$this->data[$key];
        }

        $this->data[$key][] = $value;

        return $this;
    }

    /**
     * Get a value
     *
     * @param  string $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->data[$key];
    }

}
