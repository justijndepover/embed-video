<?php

namespace Justijndepover\EmbedVideo;

use Justijndepover\EmbedVideo\Video;
use Justijndepover\EmbedVideo\VideoContract;

class YoutubeVideo extends Video implements VideoContract
{
    public static $regex = '%^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$%im';

    public function embed(): string
    {
        return "<iframe {$this->renderClass()} type=\"text/html\" src=\"{$this->embedUrl()}?autoplay={$this->getAutoplay()}&mute={$this->getMuted()}&rel=0\" frameborder=\"0\" {$this->getAttributes()}></iframe>";
    }

    public function embedUrl(): string
    {
        return "https://www.youtube.com/embed/{$this->reference()}";
    }

    public function thumbnail(): string
    {
        return "http://img.youtube.com/vi/{$this->reference()}/0.jpg";
    }

    public function isYoutube(): bool
    {
        return true;
    }
}
