<?php

namespace Justijndepover\EmbedVideo;

use Justijndepover\EmbedVideo\Video;
use Justijndepover\EmbedVideo\VideoContract;

class YoutubeVideo extends Video implements VideoContract
{
    public function embed(): String
    {
        return "<iframe {$this->renderClass()} type=\"text/html\" src=\"{$this->embedUrl()}?autoplay={$this->getAutoplay()}&rel=0\" frameborder=\"0\" {$this->getAttributes()}></iframe>";
    }

    public function embedUrl(): String
    {
        return "https://www.youtube.com/embed/{$this->reference()}";
    }

    public function thumbnail(): String
    {
        return "http://img.youtube.com/vi/{$this->reference()}/0.jpg";
    }

    public function isYoutube(): bool
    {
        return true;
    }
}
