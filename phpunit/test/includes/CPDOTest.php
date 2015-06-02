<?php

class CPDOTest extends PHPUnit_Framework_TestCase
{
    public function testConnect() 
    {
        $host = "mysql:host=localhost;dbname=cdcol";
        $user = "root";
        $pass = "root";
        
        $pdo = new \includes\php\CPDO();
        $status = $pdo->connect($host, $user, $pass); 
        
        $this->assertTrue($status);
        
        return $pdo;
    }
    
    /**
     * @depends testConnect
     */
    public function testQuery($pdo) 
    {
       $query = "select 1 as col";
       
       $result = $pdo->query($query);
       $this->assertTrue($result['status']);
       $this->assertEquals('1', $result['result'][0]['col']);
    }
    
    /**
     * @depends testConnect
     */
    public function testNonQuery($pdo) {
        $query = "use cdcol";
        
        $result = $pdo->nonQuery($query);
        $this->assertTrue($result['status']);
        $this->assertEmpty($result['result']);
    }
}

?>
