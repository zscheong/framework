<?php

namespace Library\File;

require_once('resource/php/my/file/prototype/IFileHandler.php');
require_once('resource/php/my/file/ext/csv/CSVHandler.php');
require_once('resource/php/my/file/ext/excel/ExcelHandler.php');
require_once('resource/php/my/file/ext/json/JSONHandler.php');
require_once('resource/php/my/file/ext/pdf/PDFHandler.php');
require_once('resource/php/my/file/ext/xml/XmlHandler.php');

use \Library\File\Prototype\IFileHandler;

class FileHandler {
    private $mHandler = '';
    
    public function __construct(IFileHandler $handler) {
        $this->mHandler = $handler;
    }
    public function __destruct() {
        $this->mHandler = '';
    }
    
    public function Load($url) {
        return $this->mHandler->Load($url);
    }
    public function Write($filePath, $data){
        $this->mHandler->Write($filePath, $data);
    }
    
    public function Invoke($method, $args) {
        if(method_exists($this->mHandler, $method)) {
           return $this->mHandler->$method($args);
        }
        return false;
    }
}

?>
