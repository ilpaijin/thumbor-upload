<?php

namespace Favoroute\Service\Builder;

use Favoroute\Model\Entity\Image;

/**
 *
 * @package    Favoroute Image Uploader
 * @author     Paolo Pietropoli (ilpaijin) <ilpaijin@gmail.com>
 * @copyright  ilpaijin
 * @license
 * @version    Release: @package_version@
 */
class ImageBuilder
{
    public function build($images, $url)
    {
        $label = key($images);

        $file = getimagesize($images[$label]->getPathname());

        $image = new Image();
        $image->setLabel($label);
        $image->setFilename($images[$label]->getClientOriginalName());
        $image->setCaption('');
        $image->setType($images[$label]->getClientMimeType());
        $image->setWidth($file[0]);
        $image->setHeight($file[1]);
        $image->setUrl($url);
        $image->setUser(1);

        return $image;
    }
}
