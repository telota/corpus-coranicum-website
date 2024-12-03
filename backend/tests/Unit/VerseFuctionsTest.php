<?php

namespace Tests\Unit;

use App\Exceptions\VerseDoesNotExist;
use App\Helpers\Verse;
use App\Helpers\VerseFunctions;
use PHPUnit\Framework\TestCase;

class VerseFunctionsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExists()
    {
        $verse_counts = array();
        $verse_counts[1] = 7;
        $this->assertTrue(VerseFunctions::VerseExists(new Verse(1, 4), $verse_counts));
        $this->assertFalse(VerseFunctions::VerseExists(new Verse(1, 8), $verse_counts));
        $this->assertFalse(VerseFunctions::VerseExists(new Verse(2, 1), $verse_counts));
    }

    public function testNextVerse()
    {
        $verse_counts = array();
        $verse_counts[1] = 7;
        $verse_counts[2] = 286;
        $verse_counts[3] = 200;


        $inputs = [[1, 1], [1, 7], [2, 212], [2, 286], [3, 200]];
        $outputs = [[1, 2], [2, 1], [2, 213], [3, 1], null];

        foreach ($inputs as $key => $v) {
            $input = new Verse($v[0], $v[1]);
            
            if ($outputs[$key] != null) {
                $output = new Verse($outputs[$key][0], $outputs[$key][1]);
            } else {
                $output = $outputs[$key];
            }

            $this->assertEquals(
                $output,
                VerseFunctions::NextVerse($input, $verse_counts)
            );
        }

        // Warnining: no code is executed after the exception is thrown.
        $this->expectException(VerseDoesNotExist::class);
        VerseFunctions::NextVerse(new Verse(1, 8), $verse_counts);
    }
}
