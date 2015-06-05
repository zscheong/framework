<?php

class CStringUtilsTest extends PHPUnit_Framework_TestCase
{
    public function testGetRandomString() 
    {
        $str = \includes\php\CStringUtils::getRandomString(32);
        
        $this->assertEquals(32, strlen($str));
    }
    public function testIsJSON() 
    {
        $str = '{"menu": { "id": "file", "menuitem": [{"value": "New"}, {"value": "Open"}, {"value": "Close"}]}}';
        
        $status = \includes\php\CStringUtils::isJSON($str);
        $this->assertTrue($status);
    }
}