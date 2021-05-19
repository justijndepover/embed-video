<?php

namespace Justijndepover\EmbedVideo;

use Justijndepover\EmbedVideo\VideoException;
use Justijndepover\EmbedVideo\VimeoVideo;
use Justijndepover\EmbedVideo\YoutubeVideo;

abstract class Video
{
    protected $class;
    protected $autoplay;
    protected $reference;
    protected $attributes = [];

    public static function validate(string $url)
    {
        if (preg_match('%^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$%im', $url, $matches)) {
            return true;
        }

        if (preg_match('%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\#?)(?:[?]?.*)$%im', $url, $matches)) {
            return true;
        }

        return false;
    }

    public static function from(string $url)
    {
        if (preg_match('%^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$%im', $url, $matches)) {
            return new YoutubeVideo($matches[5]);
        }

        if (preg_match('%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\#?)(?:[?]?.*)$%im', $url, $matches)) {
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

    public function autoplay(): self
    {
        $this->autoplay = true;

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

    protected function getAttributes(): string
    {
        $return = '';

        foreach ($this->attributes as $key => $value) {
            $return .= $key . '="' . $value . '" ';
        }

        return rtrim($return);
    }
}
