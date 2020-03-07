<?php


namespace Jman\Core\Images;

use Exception;
use Grafika\Grafika;

class ImageWorker
{

    private $imageFile, $editor, $image;

    /**
     * ImageWorker constructor.
     * @param ImageFile $imageFile
     * @throws Exception
     */
    public function __construct(ImageFile $imageFile)
    {
        $this->imageFile = $imageFile;
        $this->editor = Grafika::createEditor();
        $this->editor->open($this->image, $imageFile->getFullPath());
    }

    /**
     * Resize the image to fill and return the saved file path.
     *
     * @param array $size
     * @param string $prepend
     * @return string
     */
    public function resize($size = [200, 200], $prepend = "cropped_")
    {
        $this->editor->resizeFill($this->image, $size[0], $size[1]);

        $saveFileName = $prepend . $this->imageFile->getFileName();
        $saveFilePath = $this->imageFile->getPath() . DIRECTORY_SEPARATOR . $saveFileName;

        $this->editor->save($this->image, $saveFilePath);
        return new ImageFile(
            $saveFileName,
            $this->imageFile->getExt(),
            $this->imageFile->getPath()
        );

    }

}