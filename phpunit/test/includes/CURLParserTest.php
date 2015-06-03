<?php

class CURLParserTest extends PHPUnit_Framework_TestCase
{
    public function testParseURL() 
    {
        global $sys_config;
        $request_uri = '/project/framework/framework/get/User/id/5/status/true';
        
        $url_parser = new \includes\php\CURLParser();
        $url_parser->parseURL($sys_config['base_request_uri'], $request_uri);
        
        $module = $url_parser->GetModule();
        $action = $url_parser->GetAction();
        $value = $url_parser->GetValue();
        
        $this->assertEquals('get', $action);
        $this->assertEquals('User', $module);
        $this->assertEquals(array('id','5', 'status', 'true'), $value);
        
        return $url_parser;
    }
 
    /**
     * @depends testParseURL
     */
    public function testFilterHashValue($parser) 
    {
        $hash = $parser->GetHashValue(array('id'));
        
        $this->assertArrayHasKey('id', $hash);
        $this->assertEquals('5', $hash['id']);
        $this->assertFalse(isset($hash['status']));
    }
}

?>
