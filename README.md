# Embed Video

[![Latest Version on Packagist](https://img.shields.io/packagist/v/justijndepover/embed-video.svg?style=flat-square)](https://packagist.org/packages/justijndepover/embed-video)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/github/workflow/status/justijndepover/embed-video/Tests?style=flat-square)](https://github.com/justijndepover/embed-video/actions)
[![Total Downloads](https://img.shields.io/packagist/dt/justijndepover/embed-video.svg?style=flat-square)](https://packagist.org/packages/justijndepover/embed-video)

This package makes it easier to work with both Youtube and Vimeo video url's.
It automatically detects the reference from the url.

For example:
```
https://www.youtube.com/watch?v=dQw4w9WgXcQ
https://youtu.be/dQw4w9WgXcQ
https://www.youtube.com/embed/dQw4w9WgXcQ
```
are all valid youtube links, but to embed an iFrame, you need the third option.

This package allows all the options as input, and is able to generate the correct output urls to embed the iframe.

## Installation

You can install the package with composer

```sh
composer require justijndepover/embed-video
```

## Usage

```php
use Justijndepover\EmbedVideo\Video;

$video = Video::from('https://www.youtube.com/watch?v=dQw4w9WgXcQ');
```

If you provide the class with a faulty link, a `Justijndepover\EmbedVideo\VideoException` will be thrown.

### Validate

```php
$validated = Video::validate('https://www.youtube.com/watch?v=dQw4w9WgXcQ');
```

This will validate the given url and return either `true` or `false`

### Embed

```php
$html = $video->embed();
```

This will generate the embedded iframe for either Youtube or Vimeo.

```html
<iframe type="text/html" src="https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=0&rel=0" frameborder="0"></iframe>
```

### Embed url

```php
$url = $video->embedUrl();
```

This will generate the embedded url used in the iframe for either Youtube or Vimeo.

```
https://www.youtube.com/embed/dQw4w9WgXcQ
```

### Thumbnail

```php
$thumbnail = $video->thumbnail();
```

This will generate a thumbnail url for the cover image;

```
http://img.youtube.com/vi/dQw4w9WgXcQ/0.jpg
```

### Reference

```php
$reference = $video->reference();
```

This will return the video reference;

```
dQw4w9WgXcQ
```

### Mute

To add mute to the embed iframe, you can make use of the fluent syntax:

```php
$html = $video->muted()->embed();
```

```html
<iframe type="text/html" src="https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=0&mute=1&rel=0" frameborder="0"></iframe>
```

### Autoplay

To add autoplay to the embed iframe, you can make use of the fluent syntax:

```php
$html = $video->autoplay()->embed();
```

```html
<iframe type="text/html" src="https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1&mute=1&rel=0" frameborder="0"></iframe>
```

note: adding autoplay will automatically mute the video.

### Class

To add a class to the embed iframe, you can make use of the fluent syntax:

```php
$html = $video->class('video-container')->embed();
```

```html
<iframe class="video-container" type="text/html" src="https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=0&mute=0&rel=0" frameborder="0"></iframe>
```

### Additional attributes

To add additional attributes to the embed iframe, you can make use of the fluent syntax:

```php
$html = $video->addAttribute('width', 'auto')->embed();
```

```html
<iframe type="text/html" src="https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=0&mute=0&rel=0" frameborder="0" width="auto"></iframe>
```

## Security

If you find any security related issues, please open an issue or contact me directly at [justijndepover@gmail.com](justijndepover@gmail.com).

## Contribution

If you wish to make any changes or improvements to the package, feel free to make a pull request.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
