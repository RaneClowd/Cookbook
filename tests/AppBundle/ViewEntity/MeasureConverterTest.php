<?php

namespace Tests\AppBundle\ViewEntity;

use AppBundle\ViewEntity\MeasureConverter;
use AppBundle\ViewEntity\VolumeMeasureConverter;
use AppBundle\ViewEntity\WeightMeasureConverter;

class MeasureConverterTest extends \PHPUnit_Framework_TestCase
{
    public function testVolumeConversion()
    {
        $volumeMeasure = MeasureConverter::newMeasure(8, 'teaspoon');
        
        $converted = $volumeMeasure->convertTo('tablespoon');
        $this->assertEquals(2.666, $converted, '', 0.01);
    }
    
    public function testWeightConversion()
    {
        $volumeMeasure = MeasureConverter::newMeasure(8, 'ounce');
        
        $converted = $volumeMeasure->convertTo('pound');
        $this->assertEquals(0.5, $converted, '', 0.01);
    }
    
    public function testVolumeComparison()
    {
        $this->assertEquals(-1, MeasureConverter::compareUnits('tablespoon', 'cup'));
    }
    
    public function testWeightComparison()
    {
        $this->assertEquals(1, MeasureConverter::compareUnits('pound', 'ounce'));
    }
}