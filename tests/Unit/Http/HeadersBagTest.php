<?php
/**
 * Portions of This file are part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the SYMFONY_COPY_LICENSE
 * file that was distributed with this source code.
 * 
 */

namespace Scandiweb\Test\Unit\Http;

use PHPUnit\Framework\TestCase;
use Scandiweb\App\Http\Headers\HeadersBag;

final class HeadersBagTest extends TestCase
{

    public function testConstructor()
    {
        $bag = new HeadersBag(['foo' => 'bar']);
        $this->assertTrue($bag->has('foo'));
    }

    public function testKeys()
    {
        $bag = new HeadersBag(['foo' => 'bar']);
        $keys = $bag->keys();
        $this->assertEquals('foo', $keys[0]);
    }

    public function testGetDate()
    {
        $bag = new HeadersBag(['foo' => 'Tue, 4 Sep 2012 20:00:00 +0200']);
        $headerDate = $bag->getDate('foo');
        $this->assertInstanceOf('DateTime', $headerDate);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGetDateException()
    {
        $bag = new HeadersBag(['foo' => 'Tue']);

        $this->expectException(\RuntimeException::class);

        $headerDate = $bag->getDate('foo');
    }


    public function testAll()
    {
        $now = \DateTime::createFromFormat('U', time());
        $now->setTimezone(new \DateTimeZone('UTC'));

        $headersArg = ['foo' => 'bar', 'date' => $now->format('D, d M Y H:i:s').' GMT'];

        $bag = new HeadersBag($headersArg);
        $this->assertEquals(
            ['foo' => ['bar'], 'date' => [$now->format('D, d M Y H:i:s').' GMT']],
            $bag->all()
        );
    }

    public function testReplace()
    {
        $bag = new HeadersBag(['foo' => 'bar']);

        $bag->replace(['NOPE' => 'BAR']);
        $this->assertEquals(['nope' => ['BAR']], $bag->all(), '->replace() replaces the input with the argument');
        $this->assertFalse($bag->has('foo'), '->replace() overrides previously set the input');
    }

    public function testGet()
    {
        $bag = new HeadersBag(['foo' => 'bar', 'fuzz' => 'bizz']);
        $this->assertEquals('bar', $bag->get('foo'));

        // defaults
        $this->assertNull($bag->get('none'), '->get unknown values returns null');

        $bag->set('foo', 'baz', false);
        $this->assertEquals('bar', $bag->get('foo'), '->get return first value');
        $this->assertEquals(['bar', 'baz'], $bag->get('foo', 'nope', false), '->get return all values as array');
    }

    public function testContains()
    {
        $bag = new HeadersBag(['foo' => 'bar', 'fuzz' => 'bizz']);
        $this->assertTrue($bag->contains('foo', 'bar'), '->contains first value');
        $this->assertTrue($bag->contains('fuzz', 'bizz'), '->contains second value');
        $this->assertFalse($bag->contains('nope', 'nope'), '->contains unknown value');
        $this->assertFalse($bag->contains('foo', 'nope'), '->contains unknown value');

        // Multiple values
        $bag->set('foo', 'bor', false);
        $this->assertTrue($bag->contains('foo', 'bar'), '->contains first value');
        $this->assertTrue($bag->contains('foo', 'bor'), '->contains second value');
        $this->assertFalse($bag->contains('foo', 'nope'), '->contains unknown value');
    }


    public function testCount()
    {
        $headers = ['foo' => 'bar', 'HELLO' => 'WORLD'];
        $headerBag = new HeadersBag($headers);

        // because the contructor appends date header if not exist
        // thus we have to add +1 while counting
        $this->assertCount(\count($headers) + 1, $headerBag->all());
    }
}
