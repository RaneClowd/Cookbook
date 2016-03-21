<?php

namespace Tests\AppBundle\ViewEntity;

use AppBundle\ViewEntity\Measure;

class MeasureTest extends \PHPUnit_Framework_TestCase
{
    public function testConversion()
    {
        $volumeMeasure = Measure::getMeasureType('volume');
        $volumeMeasure->setAmount(8, 'teaspoon');
        
        $largestAmount = $volumeMeasure->getAmountInLargestUnit();
        $this->assertEquals('tablespoon', $largestAmount['unit']);
        $this->assertEquals(2.666, $largestAmount['val']);
    }
}