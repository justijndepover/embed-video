<?php

namespace Justijndepover\EmbedVideo;

interface VideoContract
{
    public function embed(): String;

    public function embedUrl(): String;

    public function thumbnail(): String;
}
