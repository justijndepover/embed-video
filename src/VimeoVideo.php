<?php

namespace Justijndepover\EmbedVideo;

use Justijndepover\EmbedVideo\Video;
use Justijndepover\EmbedVideo\VideoContract;

class VimeoVideo extends Video implements VideoContract
{
    public static $regex = '%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\#?)(?:[?]?.*)$%im';

    public function embed(): string
    {
        return "<iframe {$this->renderClass()} src=\"{$this->embedUrl()}?autoplay={$this->getAutoplay()}\" frameborder=\"0\" webkitAllowFullScreen mozallowfullscreen allowFullScreen {$this->getAttributes()}></iframe>";
    }

    public function embedUrl(): string
    {
        return "https://player.vimeo.com/video/{$this->reference()}";
    }

    public function thumbnail(): string
    {
        $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/{$this->reference()}.php"));

        return $hash[0]['thumbnail_medium'];
    }

    public function isVimeo(): bool
    {
        return true;
    }

    public function autoplay(): self
    {
        $this->autoplay = true;
        $this->addAttribute('allow', 'autoplay');

        return $this;
    }

    protected function getAutoplay(): string
    {
        return $this->autoplay == true ? 'true' : 'false';
    }
}
