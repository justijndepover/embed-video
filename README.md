# Embed Video

[![Latest Version on Packagist](https://img.shields.io/packagist/v/justijndepover/embed-video.svg?style=flat-square)](https://packagist.org/packages/justijndepover/embed-video)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/github/workflow/status/justijndepover/embed-video/Tests?style=flat-square)](https://github.com/justijndepover/embed-video/actions)
[![Total Downloads](https://img.shields.io/packagist/dt/justijndepover/embed-video.svg?style=flat-square)](https://packagist.org/packages/justijndepover/embed-video)

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

### Embed
```php
$html = $video->embed();
```

This will generate the embedded iframe for either Youtube or Vimeo.

### Embed url
```php
$url = $video->embedUrl();
```

This will generate the embedded url used in the iframe for either Youtube or Vimeo.

### Thumbnail
```php
$thumbnail = $video->thumbnail();
```

This will generate a thumbnail url for the cover image;

### Reference
```php
$reference = $video->reference();
```

This will return the video reference;

### Autoplay
To add autoplay to the embed iframe, you can make use of the fluent syntax:
```php
$html = $video->autoplay()->embed();
```

### Class
To add a class to the embed iframe, you can make use of the fluent syntax:
```php
$html = $video->class('video-container')->embed();
```

## Security
If you find any security related issues, please open an issue or contact me directly at [justijndepover@gmail.com](justijndepover@gmail.com).

## Contribution
If you wish to make any changes or improvements to the package, feel free to make a pull request.

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.