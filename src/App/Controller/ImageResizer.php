<?php
namespace App\Controller;

class ImageResizer
{
    private array $options;

    public function __construct(array $options = [])
    {
        $this->options = array_replace([
            'width'             => null,
            'height'            => null,
            'mode'              => 'fit',        // fit|cover|width|height
            'output'            => 'png',        // format par défaut
            'quality'           => 82,           // pour jpeg/webp
            'png_compression'   => 9,            // 0 (rapide) → 9 (max compression)
            'strip'             => true,
            'background'        => 'white',
            'progressive'       => true,
        ], $options);
    }

    public function process(string $srcPath, string $destPath = ''): string
    {
        if (!extension_loaded('imagick')) {
            throw new \RuntimeException('L’extension Imagick n’est pas chargée.');
        }
        if (!is_file($srcPath)) {
            throw new \InvalidArgumentException("Fichier introuvable: $srcPath");
        }

        $im = new \Imagick($srcPath);
        @$im->autoOrient();

        $srcW = $im->getImageWidth();
        $srcH = $im->getImageHeight();
        [$targetW, $targetH] = $this->computeTargetSize($srcW, $srcH);

        
        if ($this->options['mode'] === 'cover' && $targetW && $targetH) {
            $ratio = max($targetW / $srcW, $targetH / $srcH);
            $resizeW = (int)ceil($srcW * $ratio);
            $resizeH = (int)ceil($srcH * $ratio);
            $im->resizeImage($resizeW, $resizeH, \Imagick::FILTER_LANCZOS, 1);
            $x = (int)max(0, ($resizeW - $targetW) / 2);
            $y = (int)max(0, ($resizeH - $targetH) / 2);
            $im->cropImage($targetW, $targetH, $x, $y);
            $im->setImagePage(0, 0, 0, 0);
        } else {
            $im->resizeImage($targetW ?? 0, $targetH ?? 0, \Imagick::FILTER_LANCZOS, 1, true);
        }

        // Format de sortie
        $format = strtolower($this->options['output']);
        if ($destPath === null) {
            $destPath = preg_replace('/\.[^.]+$/', '', $srcPath) . '.' . $format;
        }

        $im->setImageFormat($format);

        if ($this->options['strip']) {
            @$im->stripImage();
        }

        // Options spécifiques
        if ($format === 'png') {
            echo $format;
            $im->setOption('png:compression-level', (string)$this->options['png_compression']);
            $im->setOption('png:compression-filter', '5');
            $im->setOption('png:compression-strategy', '1');
        } elseif ($format === 'jpeg') {
            $im->setImageCompressionQuality($this->options['quality']);
            if ($this->options['progressive']) {
                $im->setInterlaceScheme(\Imagick::INTERLACE_JPEG);
            }
        } elseif ($format === 'webp') {
            $im->setImageCompressionQuality($this->options['quality']);
        }

        $im->writeImage($destPath);
        $im->clear();
        $im->destroy();
        
        return $destPath;
    }

    private function computeTargetSize(int $srcW, int $srcH): array
    {
        $w = $this->options['width'];
        $h = $this->options['height'];
        $mode = $this->options['mode'];

        if ($mode === 'width' && $w) {
            $ratio = $w / $srcW;
            return [$w, (int)round($srcH * $ratio)];
        }
        if ($mode === 'height' && $h) {
            $ratio = $h / $srcH;
            return [(int)round($srcW * $ratio), $h];
        }
        if ($mode === 'cover' && $w && $h) {
            return [$w, $h];
        }
        if ($w && $h) {
            $ratio = min($w / $srcW, $h / $srcH);
            return [(int)floor($srcW * $ratio), (int)floor($srcH * $ratio)];
        }
        if ($w) {
            $ratio = $w / $srcW;
            return [$w, (int)round($srcH * $ratio)];
        }
        if ($h) {
            $ratio = $h / $srcH;
            return [(int)round($srcW * $ratio), $h];
        }
        return [$srcW, $srcH];
    }
}