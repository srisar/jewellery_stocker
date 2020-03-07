<?php


namespace Jman\Core\Images;

use Grafika\Grafika;


class UploadedImageFile
{

    private $uploadedFileName, $uploadedFilePath, $size, $type, $tempPath, $name, $error;
    private $imageFile;

    const FILE_TYPES = ['png', 'jpg', 'jpeg'];

    public function __construct($file)
    {
        $this->name = $file['name'];
        $this->size = $file['size'];
        $this->tempPath = $file['tmp_name'];
        $this->error = $file['error'];
        $this->type = $file['type'];


    }

    /**
     * Returns the filename
     * e.g., filename.jpg
     * @return mixed
     */
    public function getUploadedFileName()
    {
        return $this->uploadedFileName;
    }

    /**
     * Returns the uploaded local file path.
     * Useful for manipulating files.
     * e.g., X:/folder/filename.jpg
     * @return mixed
     */
    public function getUploadedFilePath()
    {
        return $this->uploadedFilePath;
    }

    /**
     * Get the image extension
     * @return array
     */
    public function getExt()
    {
        return explode("/", $this->type)[1];
    }

    /**
     * @return mixed
     */
    public function getFileSize()
    {
        return $this->size;
    }

    /**
     * To check if the image has valid ext and not 0 byte.
     * @return bool
     */
    public function isValidImage()
    {
        $ext = $this->getExt();
        $valid = in_array($ext, self::FILE_TYPES);
        return ($this->size > 0 && $valid && $this->error == 0);

    }

    public function uploadImage($extra = "")
    {
        if ($this->isValidImage()) {

            $filePath = sprintf("%s", PROFILE_UPLOAD_PATH);
            $filename = sprintf("%s_%s.%s", time(), $extra, $this->getExt());

            $fullPath = sprintf("%s%s%s", $filePath, DIRECTORY_SEPARATOR, $filename);

            $result = move_uploaded_file($this->tempPath, $fullPath);

            if ($result) {
                $this->uploadedFileName = $filename;
                $this->uploadedFilePath = $filePath;
                return true;
            }

        }

        return false;
    }


    /**
     * @return ImageFile
     */
    public function getImageFileInstance()
    {
        return new ImageFile(
            $this->getUploadedFileName(), $this->getExt(), $this->getUploadedFilePath()
        );
    }

}