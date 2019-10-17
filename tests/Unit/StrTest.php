<?php

namespace Zendraxl\LaravelString\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Zendraxl\LaravelString\Str;

class StrTest extends TestCase
{
    /** @test */
    public function it_can_be_converted_to_string(): void
    {
        $string = new Str('foobar');
        $this->assertSame('foobar', (string) $string);
    }

    /** @test */
    public function str_after(): void
    {
        $this->assertSame(' my name', Str::after('This is my name', 'This is'));
        // Str
        $string = new Str('This is my name');
        $this->assertSame(' my name', $string->after('This is')->get());
    }

    /** @test */
    public function str_ascii(): void
    {
        $this->assertSame('@', Str::ascii('@'));
        $this->assertSame('u', Str::ascii('ü'));
        $this->assertSame('h H sht SHT a A y Y', Str::ascii('х Х щ Щ ъ Ъ ь Ь', 'bg'));
        $this->assertSame('ae oe ue AE OE UE', Str::ascii('ä ö ü Ä Ö Ü', 'de'));
        // Str
        $string = new Str('@');
        $this->assertSame('@', $string->ascii()->get());
        $string = new Str('ü');
        $this->assertSame('u', $string->ascii()->get());
        $string = new Str('х Х щ Щ ъ Ъ ь Ь');
        $this->assertSame('h H sht SHT a A y Y', $string->ascii('bg')->get());
        $string = new Str('ä ö ü Ä Ö Ü');
        $this->assertSame('ae oe ue AE OE UE', $string->ascii('de')->get());
    }

    /** @test */
    public function str_before(): void
    {
        $this->assertSame('This is ', Str::before('This is my name', 'my name'));
        // Str
        $string = new Str('This is my name');
        $this->assertSame('This is ', $string->before('my name')->get());
    }

    /** @test */
    public function str_camel(): void
    {
        $this->assertSame('fooBar', Str::camel('foo_bar'));
        // Str
        $string = new Str('foo_bar');
        $this->assertSame('fooBar', $string->camel()->get());
    }

    /** @test */
    public function str_contains(): void
    {
        $this->assertTrue(Str::contains('This is my name', 'my'));
        $this->assertTrue(Str::contains('This is my name', ['my', 'foo']));
        // Str
        $string = new Str('This is my name');
        $this->assertTrue($string->contains('my'));
        $string = new Str('This is my name');
        $this->assertTrue($string->contains(['my', 'foo']));
    }

    /** @test */
    public function str_contains_all(): void
    {
        $this->assertTrue(Str::containsAll('This is my name', ['my', 'name']));
        // Str
        $string = new Str('This is my name');
        $this->assertTrue($string->containsAll(['my', 'name']));
    }

    /** @test */
    public function str_ends_with(): void
    {
        $this->assertTrue(Str::endsWith('This is my name', 'name'));
        // Str
        $string = new Str('This is my name');
        $this->assertTrue($string->endsWith('name'));
    }

    /** @test */
    public function str_finish(): void
    {
        $this->assertSame('this/string/', Str::finish('this/string', '/'));
        $this->assertSame('this/string/', Str::finish('this/string/', '/'));
        // Str
        $string = new Str('this/string');
        $this->assertSame('this/string/', $string->finish('/')->get());
        $string = new Str('this/string/');
        $this->assertSame('this/string/', $string->finish('/')->get());
    }

    /** @test */
    public function str_is(): void
    {
        $this->assertTrue(Str::is('foo*', 'foobar'));
        $this->assertFalse(Str::is('baz*', 'foobar'));
        // Str
        $string = new Str('foobar');
        $this->assertTrue($string->is('foo*'));
        $string = new Str('foobar');
        $this->assertFalse($string->is('baz*'));
    }

    /** @test */
    public function str_kebab(): void
    {
        $this->assertSame('foo-bar', Str::kebab('fooBar'));
        // Str
        $string = new Str('fooBar');
        $this->assertSame('foo-bar', $string->kebab()->get());
    }

    /** @test */
    public function str_length(): void
    {
        $this->assertSame(11, Str::length('foo bar baz'));
        $this->assertSame(11, Str::length('foo bar baz', 'UTF-8'));
        // Str
        $string = new Str('foo bar baz');
        $this->assertSame(11, $string->length()->get());
        $string = new Str('foo bar baz');
        $this->assertSame(11, $string->length('UTF-8')->get());
    }

    /** @test */
    public function str_limit(): void
    {
        $this->assertSame('The quick brown fox...', Str::limit('The quick brown fox jumps over the lazy dog', 20));
        $this->assertSame(
            'The quick brown fox (...)',
            Str::limit('The quick brown fox jumps over the lazy dog', 20, ' (...)')
        );
        // Str
        $string = new Str('The quick brown fox jumps over the lazy dog');
        $this->assertSame('The quick brown fox...', $string->limit(20)->get());
        $string = new Str('The quick brown fox jumps over the lazy dog');
        $this->assertSame('The quick brown fox (...)', $string->limit(20, ' (...)')->get());
    }

    /** @test */
    public function str_lower(): void
    {
        $this->assertSame('foo bar baz', Str::lower('FOO BAR BAZ'));
        $this->assertSame('foo bar baz', Str::lower('fOo Bar bAz'));
        // Str
        $string = new Str('FOO BAR BAZ');
        $this->assertSame('foo bar baz', $string->lower()->get());
        $string = new Str('fOo Bar bAz');
        $this->assertSame('foo bar baz', $string->lower()->get());
    }

    /** @test */
    public function str_ordered_uuid(): void
    {
        $this->assertRegExp('/\w{8}-\w{4}-\w{4}-\w{4}-\w{12}/', (string) Str::orderedUuid());
        // Str
        $string = new Str('');
        $this->assertRegExp('/\w{8}-\w{4}-\w{4}-\w{4}-\w{12}/', (string) $string->orderedUuid()->get());
    }

    /** @test */
    public function str_parse_callback(): void
    {
        $this->assertSame(['Class', 'method'], Str::parseCallback('Class@method', 'foo'));
        $this->assertsame(['Class', 'foo'], Str::parseCallback('Class', 'foo'));
        // Str
        $string = new Str('Class@method');
        $this->assertSame(['Class', 'method'], $string->parseCallback('foo')->get());
        $string = new Str('Class');
        $this->assertSame(['Class', 'foo'], $string->parseCallback('foo')->get());
    }

    /** @test */
    public function str_plural(): void
    {
        $this->assertSame('cars', Str::plural('car'));
        $this->assertSame('children', Str::plural('child'));
        $this->assertSame('children', Str::plural('child', 2));
        $this->assertSame('child', Str::plural('child', 1));
        // Str
        $string = new Str('car');
        $this->assertSame('cars', $string->plural()->get());
        $string = new Str('child');
        $this->assertSame('children', $string->plural()->get());
        $string = new Str('child');
        $this->assertSame('children', $string->plural(2)->get());
        $string = new Str('child');
        $this->assertSame('child', $string->plural(1)->get());
    }

    /** @test */
    public function str_random(): void
    {
        $this->assertRegExp('/\w{40}/', Str::random(40));
        // Str
        $string = new Str('');
        $this->assertRegExp('/\w{40}/', $string->random(40)->get());
    }

    /** @test */
    public function str_replace_array(): void
    {
        $this->assertSame(
            'The event will take place between 8:30 and 9:00',
            Str::replaceArray('?', ['8:30', '9:00'], 'The event will take place between ? and ?')
        );
        // Str
        $string = new Str('The event will take place between ? and ?');
        $this->assertSame(
            'The event will take place between 8:30 and 9:00',
            $string->replaceArray('?', ['8:30', '9:00'])->get()
        );
    }

    /** @test */
    public function str_replace_first(): void
    {
        $this->assertSame(
            'a quick brown fox jumps over the lazy dog',
            Str::replaceFirst('the', 'a', 'the quick brown fox jumps over the lazy dog')
        );
        // Str
        $string = new Str('the quick brown fox jumps over the lazy dog');
        $this->assertSame(
            'a quick brown fox jumps over the lazy dog',
            $string->replaceFirst('the', 'a')->get()
        );
    }

    /** @test */
    public function str_replace_last(): void
    {
        $this->assertSame(
            'the quick brown fox jumps over a lazy dog',
            Str::replaceLast('the', 'a', 'the quick brown fox jumps over the lazy dog')
        );
        // Str
        $string = new Str('the quick brown fox jumps over the lazy dog');
        $this->assertSame(
            'the quick brown fox jumps over a lazy dog',
            $string->replaceLast('the', 'a')->get()
        );
    }

    /** @test */
    public function str_singular(): void
    {
        $this->assertSame('car', Str::singular('cars'));
        $this->assertSame('child', Str::singular('children'));
        // Str
        $string = new Str('cars');
        $this->assertSame('car', $string->singular()->get());
    }

    /** @test */
    public function str_slug(): void
    {
        $this->assertSame('laravel-5-framework', Str::slug('Laravel 5 Framework', '-'));
        // Str
        $string = new Str('Laravel 5 Framework');
        $this->assertSame('laravel-5-framework', $string->slug('-')->get());
    }

    /** @test */
    public function str_snake(): void
    {
        $this->assertSame('foo_bar', Str::snake('fooBar'));
        // Str
        $string = new Str('fooBar');
        $this->assertSame('foo_bar', $string->snake()->get());
    }

    /** @test */
    public function str_start(): void
    {
        $this->assertSame('/this/string', Str::start('this/string', '/'));
        $this->assertSame('/this/string', Str::start('/this/string', '/'));
        // Str
        $string = new Str('this/string');
        $this->assertSame('/this/string', $string->start('/')->get());
        $string = new Str('/this/string');
        $this->assertSame('/this/string', $string->start('/')->get());
    }

    /** @test */
    public function str_starts_with(): void
    {
        $this->assertTrue(Str::startsWith('This is my name', 'This'));
        // Str
        $string = new Str('This is my name');
        $this->assertTrue($string->startsWith('This'));
    }

    /** @test */
    public function str_studly(): void
    {
        $this->assertSame('FooBar', Str::studly('foo_bar'));
        // Str
        $string = new Str('foo_bar');
        $this->assertSame('FooBar', $string->studly()->get());
    }

    /** @test */
    public function str_substr(): void
    {
        $this->assertSame('r', Str::substr('foobar', -1));
        // Str
        $string = new Str('foobar');
        $this->assertSame('r', $string->substr(-1)->get());
    }

    /** @test */
    public function str_title(): void
    {
        $this->assertSame('A Nice Title Uses The Correct Case', Str::title('a nice title uses the correct case'));
        // Str
        $string = new Str('a nice title uses the correct case');
        $this->assertSame('A Nice Title Uses The Correct Case', $string->title()->get());
    }

    /** @test */
    public function str_uc_first(): void
    {
        $this->assertSame('Laravel', Str::ucfirst('laravel'));
        $this->assertSame('Laravel framework', Str::ucfirst('laravel framework'));
        // Str
        $string = new Str('laravel');
        $this->assertSame('Laravel', $string->ucfirst()->get());
        $string = new Str('laravel framework');
        $this->assertSame('Laravel framework', $string->ucfirst()->get());
    }

    /** @test */
    public function str_upper(): void
    {
        $this->assertSame('FOO BAR BAZ', Str::upper('foo bar baz'));
        $this->assertSame('FOO BAR BAZ', Str::upper('foO bAr BaZ'));
        // Str
        $string = new Str('foo bar baz');
        $this->assertSame('FOO BAR BAZ', $string->upper()->get());
        $string = new Str('foO bAr BaZ');
        $this->assertSame('FOO BAR BAZ', $string->upper()->get());
    }

    /** @test */
    public function str_uuid(): void
    {
        $this->assertRegExp('/\w{8}-\w{4}-\w{4}-\w{4}-\w{12}/', (string) Str::uuid());
        // Str
        $string = new Str('');
        $this->assertRegExp('/\w{8}-\w{4}-\w{4}-\w{4}-\w{12}/', (string) $string->uuid()->get());
    }

    /** @test */
    public function str_words(): void
    {
        $this->assertSame(
            'Perfectly balanced, as >>>',
            Str::words('Perfectly balanced, as all things should be.', 3, ' >>>')
        );
        // Str
        $string = new Str('Perfectly balanced, as all things should be.');
        $this->assertSame(
            'Perfectly balanced, as >>>',
            $string->words(3, ' >>>')->get()
        );
    }

    /** @test */
    public function utterly_not_so_complex_example(): void
    {
        $string = new Str('fooBar');
        $this->assertSame('Foo Bar', $string->snake()->replaceArray('_', [' '])->title()->get());
    }
}
