<?php

namespace Justijndepover\EmbedVideo;

use Justijndepover\EmbedVideo\VideoException;
use Justijndepover\EmbedVideo\VimeoVideo;
use Justijndepover\EmbedVideo\YoutubeVideo;

abstract class Video
{
    protected $class;
    protected $autoplay;
    protected $muted;
    protected $reference;
    protected $attributes = [];

    public static function validate(string $url)
    {
        if (preg_match(YoutubeVideo::$regex, $url, $matches)) {
            return true;
        }

        if (preg_match(VimeoVideo::$regex, $url, $matches)) {
            return true;
        }

        return false;
    }

    public static function validateYoutube(string $url)
    {
        if (preg_match(YoutubeVideo::$regex, $url, $matches)) {
            return true;
        }

        return false;
    }

    public static function validateVimeo(string $url)
    {
        if (preg_match(VimeoVideo::$regex, $url, $matches)) {
            return true;
        }

        return false;
    }

    public static function from(string $url)
    {
        if (preg_match(YoutubeVideo::$regex, $url, $matches)) {
            return new YoutubeVideo($matches[5]);
        }

        if (preg_match(VimeoVideo::$regex, $url, $matches)) {
            return new VimeoVideo($matches[3]);
        }

        throw new VideoException("The video is neither a Youtube or Vimeo url", 1);
    }

    public function __construct($reference)
    {
        $this->reference = $reference;
    }

    public function isYoutube(): bool
    {
        return false;
    }

    public function isVimeo(): bool
    {
        return false;
    }

    // return type is gone here, because of weird php 7.1 - 7.3 bug
    public function autoplay()
    {
        $this->autoplay = true;
        $this->muted = true;

        return $this;
    }

    public function muted()
    {
        $this->muted = true;

        return $this;
    }

    public function class(string $class): self
    {
        $this->class = $class;

        return $this;
    }

    public function addAttribute(string $key, string $value): self
    {
        if (isset($this->attributes[$key])) {
            $this->attributes[$key] = $this->attributes[$key] . ' ' . $value;
        } else {
            $this->attributes[$key] = $value;
        }

        return $this;
    }

    public function reference(): string
    {
        return $this->reference;
    }

    protected function renderClass(): string
    {
        return ($this->class) ? "class=\"{$this->class}\"" : "";
    }

    protected function getAutoplay(): string
    {
        return $this->autoplay == true ? '1' : '0';
    }

    protected function getMuted(): string
    {
        return $this->muted == true ? '1' : '0';
    }

    protected function getAttributes(): string
    {
        $return = '';

        foreach ($this->attributes as $key => $value) {
            $return .= $key . '="' . $value . '" ';
        }

        return rtrim($return);
    }

    public function embed(): string
    {
        return "";
    }
}
