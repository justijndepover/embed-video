<?php

namespace Justijndepover\EmbedVideo;

use Justijndepover\EmbedVideo\VideoException;
use Justijndepover\EmbedVideo\VimeoVideo;
use Justijndepover\EmbedVideo\YoutubeVideo;

abstract class Video
{
    private $class;
    private $autoplay;
    private $reference;

    public static function validate(String $url)
    {
        if (preg_match('%^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$%im', $url, $matches)) {
            return true;
        }

        if (preg_match('%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\#?)(?:[?]?.*)$%im', $url, $matches)) {
            return true;
        }

        return false;
    }

    public static function from(String $url)
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

    public function class(String $class): self
    {
        $this->class = $class;

        return $this;
    }

    public function reference(): String
    {
        return $this->reference;
    }

    protected function renderClass(): String
    {
        return ($this->class) ? "class=\"{$this->class}\"" : "";
    }

    protected function getAutoplay(): String
    {
        return $this->autoplay == true ? '1' : '0';
    }
}
