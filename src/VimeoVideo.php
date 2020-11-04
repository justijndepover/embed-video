<?php

namespace Justijndepover\EmbedVideo;

use Justijndepover\EmbedVideo\Video;
use Justijndepover\EmbedVideo\VideoContract;

class VimeoVideo extends Video implements VideoContract
{
    public function embed() : String
    {
        return "<iframe {$this->renderClass()} src=\"{$this->embedUrl()}?autoplay={$this->autoplay}\" frameborder=\"0\" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>";
    }

    public function embedUrl() : String
    {
        return "https://player.vimeo.com/video/{$this->reference()}";
    }

    public function thumbnail() : String
    {
        $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/{$this->reference()}.php"));
        return $hash[0]['thumbnail_medium'];
    }

    public function isVimeo() : bool
    {
        return true;
    }
}
