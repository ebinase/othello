<?php

namespace Tests\Feature\Color;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Packages\Domain\Color\Color;
use Tests\TestCase;

class ColorTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testOpposite()
    {
        $black = new Color(Color::COLOR_BLACK);
        $white = new Color(Color::COLOR_WHITE);

        $this->assertSame($black->opposite()->toCode(), $white->toCode());
        $this->assertSame($white->opposite()->toCode(), $black->toCode());
    }
}
