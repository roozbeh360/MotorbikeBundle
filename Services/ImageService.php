<?php

namespace Rth\MotorbikeBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class ImageService
{

    private $container;
    private $config;

    public function __construct(Container $container, $config)
    {
        $this->container = $container;
        $this->config = $config;
    }

    public function uploadImage($file, $name = null)
    {
        if ($name) {
            $fileName = $name . '.' . $file->guessExtension();
        } else {
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
        }

        $fileName = md5(uniqid()) . '.' . $file->guessExtension();
        $config = $this->config;
        $generatedDirectory = md5(time('now') . uniqid());
        $motorbikeDir = $config['general']['upload_path'] . '/' . $generatedDirectory;
        $file->move($motorbikeDir, $fileName);
        $thumbnail = $this->thumbnailCreator($motorbikeDir . '/' . $fileName, $motorbikeDir, $fileName);

        return [
            'image' => $config['general']['upload_directory'] . '/' . $generatedDirectory . '/' . $fileName,
            'thumbnail' => $config['general']['upload_directory'] . '/' . $generatedDirectory . '/' . $thumbnail,
            'dir' => $motorbikeDir
        ];
    }

    public function removeImage($imagePath)
    {
        $config = $this->config;
        $path = rtrim($config['general']['upload_path'], $config['general']['upload_directory']);
        if (file_exists($path . '/' . $imagePath)) {
            unlink($path . '/' . $imagePath);
            return true;
        }
        return false;
    }

    public function removeDirectory($directory)
    {
        foreach (glob("{$directory}/*") as $file) {
            if (is_dir($file)) {
                $this->removeDirectory($file);
            } else {
                unlink($file);
            }
        }
        rmdir($directory);
    }

    private function thumbnailCreator($imageAddress, $targetDirectory, $targetName)
    {
        $config = $this->config;
        $image = new \Imagick($imageAddress);
        $image->cropThumbnailImage($config['general']['image_tumbnail_width'], $config['general']['image_tumbnail_height']);
        $image->writeImage($targetDirectory . "/thumb_" . $targetName);
        return "thumb_" . $targetName;
    }

}
