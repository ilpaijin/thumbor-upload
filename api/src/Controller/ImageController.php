<?php

namespace Favoroute\Controller;

use Favoroute\Exception;
use Favoroute\Model\Repository\ImageRepository;
use Favoroute\Service\Builder\ImageBuilder;

/**
 *
 * @package    Favoroute Image Uploader
 * @author     Paolo Pietropoli (ilpaijin) <ilpaijin@gmail.com>
 * @copyright  ilpaijin
 * @license
 * @version    Release: @package_version@
 */
class ImageController extends ApiController
{
    /**
     * POST a resource
     *
     * TODO Image coming from the $_FILES should be unified to a DTO.
     *
     * @param  Symfony\Component\HttpFoundation\Request $request
     * @return mixed
     */
    public function post($request)
    {
        $image = $request->files->all();

        if (empty($image)) {
            throw new Exception\UnprocessableEntity();
        }

        $uploaderImageUrl = $this->container['imageUploader']->upload($image);

        //Coupled but easily repleceable with a manager
        $imageRepository = new ImageRepository($this->container['db']);

        // cathcing exception/error needed here
        $image = $this->container['imageBuilder']->build($image, $uploaderImageUrl);

        // cathcing exception/error needed here
        $image = $imageRepository->save($image);

        return $this->respond($image, 201);
    }
}
