<?php
/**
 * Created by PhpStorm.
 * User: benjamin
 * Date: 28.06.16
 * Time: 15:03
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
