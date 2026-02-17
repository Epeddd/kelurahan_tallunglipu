<?php
// Usage: php scripts/compress_image.php
// Compress and resize public/images/BG2.jpg to a web-friendly size

// Increase memory limit temporarily for big images
@ini_set('memory_limit', '1024M'); // 1GB to avoid OOM on very large images

$root = __DIR__ . '/../public/images';
$source = $root . '/BG2.jpg';
$backup = $root . '/BG2.original.backup.jpg';
$temp   = $root . '/BG2.tmp.jpg';

if (!file_exists($source)) {
    fwrite(STDERR, "Source not found: $source\n");
    exit(1);
}

// Prefer original backup (if exists) as input to avoid upscaling from a previously-compressed image
$input = file_exists($backup) ? $backup : $source;

[$w, $h, $type] = getimagesize($input);
if (!$w || !$h) {
    fwrite(STDERR, "Invalid image: $input\n");
    exit(1);
}

// Try using Imagick first (more memory efficient), fallback to GD
if (class_exists('Imagick')) {
    try {
        $image = new Imagick($input);
        $image->setImageOrientation(Imagick::ORIENTATION_TOPLEFT);

        // Cover-crop to 1600x900 without upscaling if smaller
        $targetW = 1600; $targetH = 900;
        if ($w >= $targetW && $h >= $targetH) {
            // downscale and crop center to cover
            $image->cropThumbnailImage($targetW, $targetH);
        } else {
            // Don't upscale small images; just keep as-is
            $targetW = $w; $targetH = $h;
        }

        // Convert to JPEG with quality
        $image->setImageFormat('jpeg');
        $image->setImageCompression(Imagick::COMPRESSION_JPEG);
        $image->setImageCompressionQuality(78);
        // Progressive JPEG
        $image->setInterlaceScheme(Imagick::INTERLACE_JPEG);

        if (!file_exists($backup)) {
            copy($source, $backup);
        }

        $image->writeImage($temp);
        $outW = $image->getImageWidth();
        $outH = $image->getImageHeight();
        $image->clear();
        $image->destroy();

        if (!rename($temp, $source)) {
            fwrite(STDERR, "Failed to replace original file.\n");
            exit(1);
        }

        clearstatcache(true, $source);
        $sizeKB = round(filesize($source) / 1024);
        $origKB = file_exists($backup) ? round(filesize($backup) / 1024) : 0;
        echo "Done (Imagick). Size: {$origKB}KB -> {$sizeKB}KB, Dimensions: {$w}x{$h} -> {$outW}x{$outH}\n";
        exit(0);
    } catch (Throwable $e) {
        fwrite(STDERR, "Imagick failed, fallback to GD: " . $e->getMessage() . "\n");
    }
}

// --- GD fallback ---
switch ($type) {
    case IMAGETYPE_JPEG:
        $img = @imagecreatefromjpeg($input);
        break;
    case IMAGETYPE_PNG:
        $img = @imagecreatefrompng($input);
        break;
    default:
        fwrite(STDERR, "Unsupported type. Only JPEG/PNG supported.\n");
        exit(1);
}

if (!$img) {
    fwrite(STDERR, "Failed to load image with GD (possibly out of memory).\n");
    exit(1);
}

// Target final canvas and quality for fullscreen without pixelation
$targetW = 1600; // width for modern screens
$targetH = 900;  // 16:9 height
$quality = 78;   // balance quality/size

// Compute cover crop: scale so that image covers target, then center-crop
$scale = max($targetW / $w, $targetH / $h); // cover (not contain)
$scaledW = (int) ceil($w * $scale);
$scaledH = (int) ceil($h * $scale);

// First: scale source onto a temp canvas
$scaled = imagecreatetruecolor($scaledW, $scaledH);
imageinterlace($scaled, true);
imagecopyresampled($scaled, $img, 0, 0, 0, 0, $scaledW, $scaledH, $w, $h);

// Then: crop center to target size
$cropX = (int) max(0, ($scaledW - $targetW) / 2);
$cropY = (int) max(0, ($scaledH - $targetH) / 2);
$dst = imagecreatetruecolor($targetW, $targetH);
imagecopy($dst, $scaled, 0, 0, $cropX, $cropY, $targetW, $targetH);
imagedestroy($scaled);

// Backup original once
if (!file_exists($backup)) {
    copy($source, $backup);
}

// Save as optimized JPEG (progressive-like via interlace)
imageinterlace($dst, true);
imagejpeg($dst, $temp, $quality);
imagedestroy($dst);
imagedestroy($img);

// Replace original
if (!rename($temp, $source)) {
    fwrite(STDERR, "Failed to replace original file.\n");
    exit(1);
}

clearstatcache(true, $source);
$sizeKB = round(filesize($source) / 1024);
$origKB = file_exists($backup) ? round(filesize($backup) / 1024) : 0;

echo "Done (GD). Size: {$origKB}KB -> {$sizeKB}KB, Dimensions: {$w}x{$h} -> {$targetW}x{$targetH}\n";