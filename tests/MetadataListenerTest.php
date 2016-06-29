<?php
/**
 * Copyright (c) 2016 Benjamin Kleiner
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated
 * documentation files (the "Software"), to deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of
 * the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
 * WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS
 * OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
 * OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
 
namespace Benkle\DoctrineAdoption;


use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Mapping\ClassMetadata;

class MetadataListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testLoadClassMetadata()
    {
        $collector = $this->createMock(Collector::class);
        $collector
            ->expects($this->atLeast(1))
            ->method('getAdoptees')
            ->willReturn(['childName' => 'child']);
        $metadata = $this->createMock(ClassMetadata::class);
        $metadata->name = 'parent';
        $metadata->discriminatorMap = ['parentName' => 'parent'];
        $LoadClassMetadataEventArgs = $this->createMock(LoadClassMetadataEventArgs::class);
        $LoadClassMetadataEventArgs
            ->expects($this->atLeast(1))
            ->method('getClassMetadata')
            ->willReturn($metadata);

        $listener = new MetadataListener($collector);
        $listener->loadClassMetadata($LoadClassMetadataEventArgs);
        $this->assertEquals(['parentName' => 'parent', 'childName' => 'child'], $metadata->discriminatorMap);
    }
}
