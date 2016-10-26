<?php

namespace Shop\CoreBundle\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileService
{
    private $targetDir;

    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }

    public function upload(UploadedFile $file): string 
    {
        $fileName = md5(time()).'.'.$file->guessExtension();
        $file->move($this->targetDir, $fileName);

        return $fileName;
    }

    public function delete($fileName): bool 
    {
        return unlink($this->targetDir.'/'.$fileName);
    }
}
