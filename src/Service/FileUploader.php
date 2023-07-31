<?php

namespace App\Service;

use Exception;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    public function __construct(
        private readonly SluggerInterface $slugger,
    ) {
    }

    /**
     * @param UploadedFile $file
     * @param string $path
     * @return string
     * @throws Exception
     */
    public function upload(UploadedFile $file, string $path): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        try {
            $file->move($path, $fileName);
        } catch (FileException $e) {
            throw new Exception('Загрузка файла прервана');
        }

        return $fileName;
    }
}