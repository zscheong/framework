<?php

class CArrayUtilsTest extends PHPUnit_Framework_TestCase 
{
    public function testToHash() 
    {
        $array = array('merchant', 'abc', 'invoice', '123', 'status', 'false');
        $hash = \includes\php\CArrayUtils::toHash($array);
        
        $this->assertArrayHasKey('merchant', $hash);
        $this->assertArrayHasKey('invoice', $hash);
        $this->assertArrayHasKey('status', $hash);
        
        $this->assertEquals('abc', $hash['merchant']);
        $this->assertEquals('123', $hash['invoice']);
        $this->assertEquals('false', $hash['status']);
    }
}

?>
