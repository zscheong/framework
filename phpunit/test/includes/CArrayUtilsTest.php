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
    
    public function testIsArrayEmpty()
    {
        $empty_array = array(array(array()), array());
        $non_empty_array = array(array(true, false), array());
        
        $status_empty_array = \includes\php\CArrayUtils::isArrayEmpty($empty_array);
        $status_non_empty_array = \includes\php\CArrayUtils::isArrayEmpty($non_empty_array);
        
        $this->assertEquals(true, $status_empty_array);
        $this->assertEquals(false, $status_non_empty_array);
    }
}

?>
