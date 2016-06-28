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

/**
 * Class MetadataListener
 * This class is used to inject adoptees into the discriminator map.
 * @package Benkle\DoctrineAdoption
 */
class MetadataListener
{
    /** @var Collector */
    private $adoptionManager = null;

    /**
     * MetadataListener constructor.
     * @param Collector $adoptionManager
     */
    public function __construct(Collector $adoptionManager)
    {
        $this->adoptionManager = $adoptionManager;
    }

    /**
     * Handle LoadClassMetadataEvents to inject adoptees.
     * @param LoadClassMetadataEventArgs $class
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $class)
    {
        $metaData = $class->getClassMetadata();
        $adoptees = $this->adoptionManager->getAdoptees($metaData->name);
        foreach ($adoptees as $discriminator => $adoptee) {
            $metaData->discriminatorMap[$discriminator] = $adoptee;
        }
    }
}
