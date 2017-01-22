<?php

namespace PH7\PHYZSYLE\Tests;

use Phake;

class TemplateTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        Phake::mock(Template::class, Phake::u)
    }

    public function test()
    {
        $template = new Template;

    }
}
