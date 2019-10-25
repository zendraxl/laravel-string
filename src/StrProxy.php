<?php

namespace Zendraxl\LaravelString;

use Illuminate\Support\Str as LaravelStr;

/**
 * Class StrProxy
 *
 * @mixin \Illuminate\Support\Str
 *
 * @method self after(string $search)
 * @method self ascii(string $language = 'en')
 * @method self before(string $search)
 * @method self camel()
 * @method self finish(string $cap)
 * @method self kebab()
 * @method self limit(int $limit = 100, string $end = '...')
 * @method self lower()
 * @method self plural(int $count = 2)
 * @method self random(int $length = 16)
 * @method self replaceArray(string $search, array $replace)
 * @method self replaceFirst(string $search, string $replace)
 * @method self replaceLast(string $search, string $replace)
 * @method self singular()
 * @method self slug(string $separator = '-', string $language = 'en')
 * @method self snake(string $delimiter = '_')
 * @method self start(string $prefix)
 * @method self studly()
 * @method self substr(int $start, int $length = null)
 * @method self title()
 * @method self ucfirst()
 * @method self upper()
 * @method self words(int $words = 100, string $end = '...')
 * @method \Ramsey\Uuid\UuidInterface orderedUuid()
 * @method \Ramsey\Uuid\UuidInterface uuid()
 * @method array parseCallback(string $default = null)
 * @method bool contains(array|string $needles)
 * @method bool containsAll(array $needles)
 * @method bool endsWith(array|string $needles)
 * @method bool is(array|string $pattern)
 * @method bool startsWith(array|string $needles)
 * @method int length(string $encoding = null)
 */
class StrProxy
{
    protected const METHOD_IS = 'is';
    protected const METHOD_RANDOM = 'random';
    protected const METHOD_REPLACE_ARRAY = 'replaceArray';
    protected const METHOD_REPLACE_FIRST = 'replaceFirst';
    protected const METHOD_REPLACE_LAST = 'replaceLast';

    protected $text = '';

    public function __construct(string $text = '')
    {
        $this->text = $text;
    }

    public static function __callStatic($method, $parameters)
    {
        return LaravelStr::{$method}(...$parameters);
    }

    public function __call($name, $arguments)
    {
        $this->text = LaravelStr::{$name}(...$this->rearrangeParameters($name, $arguments));

        if ($this->shouldReturnDifferentValue()) {
            return $this->text;
        }

        if (! is_string($this->text)) {
            throw new \Exception('Invalid change made to the text.');
        }

        return $this;
    }

    public function __toString(): string
    {
        if (! is_string($this->text)) {
            return '';
        }
        return $this->text;
    }

    public function dd(): void
    {
        dd($this->text);
    }

    public function get()
    {
        return $this->text;
    }

    protected function constructorParameterShouldBeOmitted($name): bool
    {
        return in_array($name, [
            static::METHOD_RANDOM,
            static::METHOD_REPLACE_ARRAY,
            static::METHOD_REPLACE_FIRST,
            static::METHOD_REPLACE_LAST,
        ]);
    }

    protected function constructorParameterShouldBePushedToEnd($name): bool
    {
        return in_array($name, [
            static::METHOD_REPLACE_ARRAY,
            static::METHOD_REPLACE_FIRST,
            static::METHOD_REPLACE_LAST,
        ]);
    }

    protected function parametersShouldBeReversed($name): bool
    {
        return in_array($name, [
            static::METHOD_IS,
        ]);
    }

    protected function rearrangeParameters($name, $arguments): array
    {
        $parameters = $this->constructorParameterShouldBeOmitted($name)
            ? $arguments
            : array_merge([$this->text], $arguments);

        if ($this->parametersShouldBeReversed($name)) {
            $parameters = array_reverse($parameters);
        }

        if ($this->constructorParameterShouldBePushedToEnd($name)) {
            $parameters[] = $this->text;
        }

        return $parameters;
    }

    protected function shouldReturnDifferentValue(): bool
    {
        if (is_array($this->text)) {
            return true;
        }

        if (is_bool($this->text)) {
            return true;
        }

        if (is_int($this->text)) {
            return true;
        }

        if (is_object($this->text)) {
            return true;
        }

        return false;
    }
}
