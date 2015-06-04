<?php

class CStringUtilsTest extends PHPUnit_Framework_TestCase
{
    public function testGetRandomString() 
    {
        $str = \includes\php\CStringUtils::getRandomString(32);
        
        $this->assertEquals(32, strlen($str));
    }
}