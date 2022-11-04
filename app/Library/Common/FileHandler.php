<?php

namespace App\Library\Common;

class FileHandler
{
    private string $folder_name;
    private string $file_name;
    private string $file_path;

    public function saveToStore($path = '')
    {

    }

    public function deleteFromStore($path = '')
    {

    }

    public function setFolderName()
    {

    }

    public function getFolderName()
    {

    }

    public function setFileName()
    {

    }

    public function getFileName()
    {

    }

    public function getFilePath(): string
    {
        return $this->file_path;
    }

    public function setFilePath(string $file_path): self
    {
        $this->file_path = $file_path;

        return $this;
    }
}