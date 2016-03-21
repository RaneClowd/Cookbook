<?php

namespace Tests\AppBundle\ViewEntity;

use AppBundle\ViewEntity\Measure;

class MeasureTest extends \PHPUnit_Framework_TestCase
{
    public function testConversion()
    {
        $volumeMeasure = Measure::getMeasureType('volume');
        $volumeMeasure->setAmount(4, "fl ounce");
        $this->assertEquals(118.294, $volumeMeasure->getAmount());
        
        // TODO: replace this test with something more useful
    }
}