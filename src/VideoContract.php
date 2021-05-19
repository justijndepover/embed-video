<?php

namespace Justijndepover\EmbedVideo;

interface VideoContract
{
    public function embed(): string;

    public function embedUrl(): string;

    public function thumbnail(): string;
}
