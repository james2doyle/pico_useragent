pico_useragent
==============

A plugin for [Pico CMS](http://pico.dev7studios.com/) that allows you to parse the user agent of the current visitor and then expose that information in an easy to use variable in your twig templates.

Hopefully that makese sense.

### Output

When using the plugin, you get a new variable called `browser`. The browser variable has the following properties in it when dumped from my computer:

```php
$browser = array (
  'useragent'   => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.44 Safari/537.36' // full ua string
  'name'        => 'Google Chrome' // name of the browser
  'browser'     => 'google-chrome' // CSS safe browser name
  'version'     => '30.0.1599.37' // bowser version
  'type'        => 'desktop' // device form factor
  'platform'    => 'mac' // OS platform
  'pattern'     => '#(?Version|Chrome|other)[/ ]+(?[0-9.|a-zA-Z.]*)#' // match pattern
);
```

### Example

I use this example when I want to make small modifications to my CSS. Not unlike how Modernizr is supposed to work. Except modernizr doesn't give you browser information.

```html
<html lang="en" class="{{ browser.browser }} {{ browser.platform }} {{ browser.type }}">
```

Here is the output for that html tag:

```html
<html lang="en" class="google-chrome mac desktop">
```

I usually use it to normalize issues across different browsers. Like something looking weird in Firefox, so I know I can modify some CSS by using a `.firefox` parent.

```css
.button {
  padding: 0.25em 1em;
}
/* fix padding in FF */
.firefox .button {
  padding: 0.28em 1em;
}
```

### Use Cases

* conditional content
* conditional styles/scripts
* layout modifications
* serving specific images
* Modernizr-esque CSS classes

### License

**The MIT License**

Copyright (c) 2013 [James Doyle](http://twitter.com/james2doyle) james2doyle@gmail.com

Permission is hereby granted, free of charge, to any person obtaining
a copy of this software and associated documentation files (the
'Software'), to deal in the Software without restriction, including
without limitation the rights to use, copy, modify, merge, publish,
distribute, sublicense, and/or sell copies of the Software, and to
permit persons to whom the Software is furnished to do so, subject to
the following conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED 'AS IS', WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY
CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.