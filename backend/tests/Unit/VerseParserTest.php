<?php

namespace Tests\Unit;

use App\Exceptions\VerseDoesNotExist;
use App\Helpers\Verse;
use App\Helpers\Range;
use App\Helpers\VerseFunctions;
use App\Helpers\VerseParser;
use PHPUnit\Framework\TestCase;

class VerseParserTest extends TestCase
{
    public function testParseVerses()
    {
        $inputs = ["037:001-037:001", "078:038-078:038", "089:022-089:022"];
        $outputs = [
            new Range(new Verse(37, 1), new Verse(37, 1)),
            new Range(new Verse(78, 38), new Verse(78, 38)),
            new Range(new Verse(89, 22), new Verse(89, 22)),

        ];

        foreach ($inputs as $index => $input) {
            $this->assertEquals($outputs[$index], VerseParser::parseVerseRange($input));
        }
    }
}
