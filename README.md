Right now if we want to do any manipulation with strings we face same problem like with an array before collections
where we have to read the code inside out.

```php
$title = Str::title(Str::replaceArray('_', [' '], Str::snake('fooBar')));
```

Also Str object in Laravel does not accept the string that is being manipulated as the first argument across all
methods like `replaceArray()`.

It would be great to bring that kind of power and functionality to Laravel and surpass current language limitations.

```php
$title = (new Str('fooBar'))->snake()->replaceArray('_', [' '])->title()->get();
```

Also add helper function to make it even cleaner.

```php
$title = str('fooBar')->snake()->replaceArray('_', [' '])->title()->get();
```

Having `dd()` on that object is a must :D

```php
$title = str('fooBar')->snake()->replaceArray('_', [' '])->dd()->title()->get();
```
