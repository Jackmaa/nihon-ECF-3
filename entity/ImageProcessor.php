<?php

class ImageProcessor {
    public static function processImage($sourcePath, $destinationPath, $newWidth, $newHeight) {
        if (! file_exists($sourcePath)) {
            return false;
        }

        // Obtenir les dimensions et le type d'image
        list($width, $height, $imageType) = getimagesize($sourcePath);

        // Création d'une image en fonction du type
        switch ($imageType) {
        case IMAGETYPE_JPEG:
            $imageTmp = imagecreatefromjpeg($sourcePath);
            break;
        case IMAGETYPE_PNG:
            $imageTmp = imagecreatefrompng($sourcePath);
            break;
        case IMAGETYPE_GIF:
            $imageTmp = imagecreatefromgif($sourcePath);
            break;
        case IMAGETYPE_WEBP:
            $imageTmp = function_exists('imagecreatefromwebp') ? imagecreatefromwebp($sourcePath) : null;
            break;
        default:
            return false;
        }

        if (! $imageTmp) {
            return false;
        }

        // Création d'une nouvelle image redimensionnée
        $imageResized = imagecreatetruecolor($newWidth, $newHeight);

        // Gestion de la transparence pour PNG
        if ($imageType == IMAGETYPE_PNG) {
            imagealphablending($imageResized, false);
            imagesavealpha($imageResized, true);
        }

        // Redimensionnement
        imagecopyresampled($imageResized, $imageTmp, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        // Sauvegarde en WebP
        imagewebp($imageResized, $destinationPath, 80);

        // Nettoyage
        imagedestroy($imageTmp);
        imagedestroy($imageResized);

        return true;
    }
}
