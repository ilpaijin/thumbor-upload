<?php

namespace Favoroute\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 *
 * @package    Favoroute Image Uploader
 * @author     Paolo Pietropoli (ilpaijin) <ilpaijin@gmail.com>
 * @copyright  ilpaijin
 * @license
 * @version    Release: @package_version@
 */
class ApiController
{
    /**
     * sugar response wrapper
     *
     * @param mixed $data
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public function respond($data)
    {
        $data = array(
            'meta' => '',
            'data' => $data
        );

        return new JsonResponse($data);
    }
}
