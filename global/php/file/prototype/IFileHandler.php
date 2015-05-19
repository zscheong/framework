<?php

namespace Library\File\Prototype;

interface IFileHandler {
    public function Load($url);
    public function Write($filePath, $data);
}

?>
