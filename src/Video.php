<?php

namespace Justijndepover\EmbedVideo;

use Justijndepover\EmbedVideo\VideoException;

class Video
{
    private $url;

    private $isYoutube = false;

    private $youtubeReference;

    private $isVimeo = false;

    private $vimeoReference;

    private $autoplay = false;

    private $class;

    public function __construct(String $url)
    {
        if (preg_match('%^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$%im', $url, $matches)) {
            $this->youtubeReference = $matches[5];
            $this->isYoutube = true;

            return;
        }

        if (preg_match('%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\#?)(?:[?]?.*)$%im', $url, $matches)) {
            $this->vimeoReference = $matches[3];
            $this->isVimeo = true;

            return;
        }

        throw new VideoException("The video is neither a Youtube or Vimeo url", 1);
    }

    public function embed() : String
    {
        if ($this->isYoutube()) {
            return $this->renderYoutubePlayer();
        } else if ($this->isVimeo()) {
            return $this->renderVimeoPlayer();
        }
    }

    public function embedUrl() : String
    {
        if ($this->isYoutube()) {
            return $this->renderYoutubePlayerUrl();
        } else if ($this->isVimeo()) {
            return $this->renderVimeoPlayerUrl();
        }
    }

    public function thumbnail() : String
    {
        if ($this->isYoutube()) {
            return $this->renderYoutubeThumbnailUrl();
        } else if ($this->isVimeo()) {
            return $this->renderVimeoThumbnailUrl();
        }
    }

    public function reference() : String
    {
        if ($this->isYoutube()) {
            return $this->getYoutubeReference();
        } else if ($this->isVimeo()) {
            return $this->getVimeoReference();
        }
    }

    public function autoplay() : self
    {
        $this->autoplay = true;
        return $this;
    }

    public function class(String $class) : self
    {
        $this->class = $class;
        return $this;
    }

    public function isYoutube() : bool
    {
        return $this->isYoutube;
    }

    public function isVimeo() : bool
    {
        return $this->isVimeo;
    }

    private function renderVimeoPlayer() : String
    {
        return "<iframe {$this->renderClass()} src=\"{$this->renderVimeoPlayerUrl()}?autoplay={$this->autoplay}\" frameborder=\"0\" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>";
    }

    private function renderVimeoPlayerUrl() : String
    {
        return "http://player.vimeo.com/video/{$this->getVimeoReference()}";
    }

    private function renderVimeoThumbnailUrl() : String
    {
        $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/{$this->getVimeoReference()}.php"));
        return $hash[0]['thumbnail_medium'];
    }

    private function getVimeoReference() : String
    {
        return $this->vimeoReference;
    }

    private function renderYoutubePlayer() : String
    {
        return "<iframe {$this->renderClass()} type=\"text/html\" src=\"{$this->renderYoutubePlayerUrl()}?autoplay={$this->autoplay}&rel=0\" frameborder=\"0\"></iframe>";
    }

    private function renderYoutubePlayerUrl() : String
    {
        return "http://www.youtube.com/embed/{$this->getYoutubeReference()}";
    }

    private function renderYoutubeThumbnailUrl() : String
    {
        return "http://img.youtube.com/vi/{$this->getYoutubeReference()}/0.jpg";
    }

    private function getYoutubeReference() : String
    {
        return $this->youtubeReference;
    }

    private function renderClass() : String
    {
        return ($this->class) ? "class=\"{$this->class}\"" : "";
    }
}
