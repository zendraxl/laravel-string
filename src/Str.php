<?php

namespace Zendraxl\LaravelString;

use Illuminate\Support\Str as LaravelStr;

/**
 * Class Str
 *
 * @package Zendraxl\LaravelString
 * @mixin \Illuminate\Support\Str
 */
class Str
{
    protected $item = '';

    public function __construct(string $item)
    {
        $this->item = $item;
    }

    public function __call($name, $arguments)
    {
        $result = LaravelStr::{$name}(...$this->arrangeParameters($name, $arguments));

        if (is_bool($result)) {
            return $result;
        }

        $this->item = $result;

        return $this;
    }

    public function __toString(): string
    {
        return $this->item;
    }

    public function dd(): void
    {
        dd($this->item);
    }

    public function get()
    {
        return $this->item;
    }

    public static function __callStatic($method, $parameters)
    {
        return LaravelStr::{$method}(...$parameters);
    }

    protected function arrangeParameters($name, $arguments): array
    {
        $parameters = $this->constructorParameterShouldBeOmitted($name)
            ? $arguments
            : array_merge([$this->item], $arguments);

        if ($this->parametersShouldBeReversed($name)) {
            $parameters = array_reverse($parameters);
        }

        if ($this->constructorParameterShouldBePushedToEnd($name)) {
            $parameters[] = $this->item;
        }

        return $parameters;
    }

    protected function constructorParameterShouldBeOmitted(string $name): bool
    {
        return in_array($name, [
            'random',
            'replaceArray',
            'replaceFirst',
            'replaceLast',
        ]);
    }

    protected function constructorParameterShouldBePushedToEnd($name): bool
    {
        return in_array($name, [
            'replaceArray',
            'replaceFirst',
            'replaceLast',
        ]);
    }

    protected function parametersShouldBeReversed(string $name): bool
    {
        return in_array($name, [
            'is',
        ]);
    }
}
