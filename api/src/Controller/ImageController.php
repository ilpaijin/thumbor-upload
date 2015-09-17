<?php

namespace Favoroute\Controller;

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
     * @param  Symfony\Component\HttpFoundation\Request $request
     * @return mixed
     */
    public function post($request)
    {

        var_dump($request->files->all());
        exit;
        sleep(1);

        $data = array('image' => true);

        return $this->respond($data);
    }
}
