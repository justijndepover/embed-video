<?php

namespace Justijndepover\EmbedVideo\Test;

use Justijndepover\EmbedVideo\Video;
use Justijndepover\EmbedVideo\VideoException;
use PHPUnit\Framework\TestCase;

class EmbedVideoTest extends TestCase
{
    /** @test */
    public function it_throws_an_error_on_wrong_input_url()
    {
        $this->expectException(VideoException::class);

        $video = Video::from('random_string');
    }
}
