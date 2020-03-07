<?php


namespace Jman\Core\Images;


class ImageFile
{

    private $fileName, $ext, $path, $fullPath, $size;

    public function __construct($fileName, $ext, $path)
    {
        $this->fileName = $fileName;
        $this->ext = $ext;
        $this->path = $path;
        $this->fullPath = sprintf("%s%s%s", $this->path, DIRECTORY_SEPARATOR, $this->fileName);
        $this->size = filesize($this->fullPath);
    }

    /**
     * @return string
     */
    public function getFullPath()
    {
        return $this->fullPath;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @return string
     */
    public function getExt()
    {
        return $this->ext;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

}