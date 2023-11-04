<?php declare(strict_types=1);

namespace NylonCoffee\Form\Utils;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(ArrayData::class)]
class ArrayDataTest extends TestCase
{
    public function testCount(): void
    {
        self::assertEquals(0, count(new ArrayData()));
        self::assertEquals(3, count(new ArrayData([1,2,3])));
        self::assertEquals(5, count(new ArrayData([9,8,7,6,5])));
    }
    
    public function testGettersSetters(): void
    {
        $data = new ArrayData(['foo' => 'bar']);
        
        self::assertEquals('bar', $data->get('foo'));
        self::assertTrue($data->has('foo'));
        $data->remove('foo');
        self::assertFalse($data->has('foo'));
        self::assertNull($data->get('foo'));
        self::assertEquals('fallback', $data->get('foo', 'fallback'));
        
        self::assertFalse($data->has('baz'));
        self::assertNull($data->get('baz'));
        $data->set('baz', 'quz');
        self::assertTrue($data->has('baz'));
        self::assertEquals('quz', $data->get('baz'));
    }
    
    public function testArrayAccess(): void
    {
        $data = new ArrayData(['foo' => 'bar']);
        
        self::assertEquals('bar', $data['foo']);
        self::assertTrue(isset($data['foo']));
        unset($data['foo']);
        self::assertFalse(isset($data['foo']));
        self::assertNull($data['foo']);
        
        self::assertFalse(isset($data['baz']));
        self::assertNull($data['baz']);
        $data['baz'] = 'quz';
        self::assertTrue(isset($data['baz']));
        self::assertEquals('quz', $data['baz']);
    }
    
    public function testIterator(): void
    {
        $expected = ['foo' => 'bar', 'bar' => 'quz'];
        
        $data = new ArrayData($expected);
        
        self::assertEquals(2, iterator_count($data));
        self::assertEquals($expected, iterator_to_array($data, true));
    }
    
    public function testExchangeData(): void
    {
        $expected = ['foo' => 'bar', 'bar' => 'quz'];
        
        $data = new ArrayData($expected);
        
        self::assertEquals($expected, $data->getArrayCopy());
    }
}
