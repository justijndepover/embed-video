<?php

namespace Justijndepover\EmbedVideo\Test;

use Justijndepover\EmbedVideo\Video;
use Justijndepover\EmbedVideo\VideoException;
use PHPUnit\Framework\TestCase;

class EmbedVideoTest extends TestCase
{
    /** @test */
    public function it_can_validate()
    {
        $validated = Video::validate('random_string');
        $this->assertFalse($validated);

        $validated = Video::validate('https://www.youtube.com/watch?v=dQw4w9WgXcQ');
        $this->assertTrue($validated);

        $validated = Video::validate('https://www.youtube.com/embed/dQw4w9WgXcQ');
        $this->assertTrue($validated);

        $validated = Video::validate('https://youtu.be/dQw4w9WgXcQ');
        $this->assertTrue($validated);

        $validated = Video::validate('https://vimeo.com/452638847');
        $this->assertTrue($validated);

        $validated = Video::validate('https://player.vimeo.com/video/452638847');
        $this->assertTrue($validated);
    }

    /** @test */
    public function it_can_validate_a_youtube_link()
    {
        $validated = Video::validateYoutube('random_string');
        $this->assertFalse($validated);

        $validated = Video::validateYoutube('https://www.youtube.com/watch?v=dQw4w9WgXcQ');
        $this->assertTrue($validated);

        $validated = Video::validateYoutube('https://www.youtube.com/embed/dQw4w9WgXcQ');
        $this->assertTrue($validated);

        $validated = Video::validateYoutube('https://youtu.be/dQw4w9WgXcQ');
        $this->assertTrue($validated);

        $validated = Video::validateYoutube('https://vimeo.com/452638847');
        $this->assertFalse($validated);

        $validated = Video::validateYoutube('https://player.vimeo.com/video/452638847');
        $this->assertFalse($validated);
    }

    /** @test */
    public function it_can_validate_a_vimeo_link()
    {
        $validated = Video::validateVimeo('random_string');
        $this->assertFalse($validated);

        $validated = Video::validateVimeo('https://www.youtube.com/watch?v=dQw4w9WgXcQ');
        $this->assertFalse($validated);

        $validated = Video::validateVimeo('https://www.youtube.com/embed/dQw4w9WgXcQ');
        $this->assertFalse($validated);

        $validated = Video::validateVimeo('https://youtu.be/dQw4w9WgXcQ');
        $this->assertFalse($validated);

        $validated = Video::validateVimeo('https://vimeo.com/452638847');
        $this->assertTrue($validated);

        $validated = Video::validateVimeo('https://player.vimeo.com/video/452638847');
        $this->assertTrue($validated);
    }

    /** @test */
    public function it_throws_an_error_on_wrong_input_url()
    {
        $this->expectException(VideoException::class);

        $video = Video::from('random_string');
    }

    /** @test */
    public function it_is_a_youtube_url()
    {
        $video = Video::from('https://www.youtube.com/watch?v=dQw4w9WgXcQ');

        $this->assertTrue($video->isYoutube());
    }

    /** @test */
    public function it_returns_the_youtube_reference()
    {
        $reference = Video::from('https://www.youtube.com/watch?v=dQw4w9WgXcQ')->reference();

        $this->assertEquals($reference, 'dQw4w9WgXcQ');
    }

    /** @test */
    public function it_returns_a_youtube_embed_url()
    {
        $embedUrl = Video::from('https://www.youtube.com/watch?v=dQw4w9WgXcQ')->embedUrl();

        $this->assertEquals('https://www.youtube.com/embed/dQw4w9WgXcQ', $embedUrl);
    }

    /** @test */
    public function it_is_a_vimeo_url()
    {
        $video = Video::from('https://vimeo.com/452638847');

        $this->assertTrue($video->isVimeo());
    }

    /** @test */
    public function it_returns_the_vimeo_reference()
    {
        $reference = Video::from('https://vimeo.com/452638847')->reference();

        $this->assertEquals($reference, '452638847');
    }

    /** @test */
    public function it_returns_a_vimeo_embed_url()
    {
        $embedUrl = Video::from('https://vimeo.com/452638847')->embedUrl();

        $this->assertEquals('https://player.vimeo.com/video/452638847', $embedUrl);
    }

    /** @test */
    public function it_adds_class_to_iframe()
    {
        $iframe = Video::from('https://vimeo.com/452638847')->class('testclass')->embed();

        $this->assertStringContainsString('testclass', $iframe);

        $iframe = Video::from('https://www.youtube.com/watch?v=dQw4w9WgXcQ')->class('testclass')->embed();

        $this->assertStringContainsString('testclass', $iframe);
    }

    /** @test */
    public function it_returns_an_iframe()
    {
        $iframe = Video::from('https://vimeo.com/452638847')->embed();

        $this->assertStringContainsString('<iframe', $iframe);

        $iframe = Video::from('https://www.youtube.com/watch?v=dQw4w9WgXcQ')->embed();

        $this->assertStringContainsString('<iframe', $iframe);
    }

    /** @test */
    public function it_sets_the_correct_autoplay()
    {
        $iframe = Video::from('https://vimeo.com/452638847')->autoplay()->embed();

        $this->assertStringContainsString('autoplay=true', $iframe);

        $iframe = Video::from('https://vimeo.com/452638847')->embed();

        $this->assertStringContainsString('autoplay=false', $iframe);

        $iframe = Video::from('https://www.youtube.com/watch?v=dQw4w9WgXcQ')->autoplay()->embed();

        $this->assertStringContainsString('autoplay=1', $iframe);

        $iframe = Video::from('https://www.youtube.com/watch?v=dQw4w9WgXcQ')->embed();

        $this->assertStringContainsString('autoplay=0', $iframe);
    }

    /** @test */
    public function it_does_not_mute_by_default()
    {
        $iframe = Video::from('https://vimeo.com/452638847')->embed();
        $this->assertStringContainsString('muted=false', $iframe);

        $iframe = Video::from('https://www.youtube.com/watch?v=dQw4w9WgXcQ')->embed();
        $this->assertStringContainsString('mute=0', $iframe);
    }

    /** @test */
    public function it_can_mute_a_video()
    {
        $iframe = Video::from('https://vimeo.com/452638847')->muted()->embed();
        $this->assertStringContainsString('muted=true', $iframe);

        $iframe = Video::from('https://www.youtube.com/watch?v=dQw4w9WgXcQ')->muted()->embed();
        $this->assertStringContainsString('mute=1', $iframe);
    }

    /** @test */
    public function it_sets_the_correct_mute_on_autoplay()
    {
        $iframe = Video::from('https://vimeo.com/452638847')->autoplay()->embed();

        $this->assertStringContainsString('muted=true', $iframe);

        $iframe = Video::from('https://vimeo.com/452638847')->embed();

        $this->assertStringContainsString('muted=false', $iframe);

        $iframe = Video::from('https://www.youtube.com/watch?v=dQw4w9WgXcQ')->autoplay()->embed();

        $this->assertStringContainsString('mute=1', $iframe);

        $iframe = Video::from('https://www.youtube.com/watch?v=dQw4w9WgXcQ')->embed();

        $this->assertStringContainsString('mute=0', $iframe);
    }
}
