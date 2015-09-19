<?php

namespace Favoroute\Service\ImageUploader;

use Favoroute\Exception;

/**
 *
 * @package    Favoroute Image Uploader
 * @author     Paolo Pietropoli (ilpaijin) <ilpaijin@gmail.com>
 * @copyright  ilpaijin
 * @license
 * @version    Release: @package_version@
 */
class ThumborUploader implements ProxyUploader
{
    /**
     * @var string
     */
    protected $host;

    /**
     * Of course this shoulf live in a config file, but it's ok for demo purpose.
     */
    public function __construct()
    {
        $this->host = getenv('ENV') === 'development' ? 'http://localhost:8888' : 'http://188.226.195.167:8888';
    }

    /**
     * @var array
     */
    protected $allowedExtensions = array('jpeg', 'jpg');

    /**
     * upload
     *
     * @param  string $image
     * @return string
     */
    public function upload($image)
    {
        //Proxies the call to the Imaging server and pass the binary file
        $fileKey = key($image);

        if (!in_array($image[$fileKey]->guessClientExtension(), $this->allowedExtensions)) {
            throw new Exception\UnsupportedMediaType();
        }

        $stream = fopen($image[$fileKey]->getPathname(), 'r');

        $client = new \GuzzleHttp\Client(array(
            array('base_uri' => $this->host),
            'exceptions' => false,
            'http_errors' => true
        ));

        $response = $client->post(
            $this->host.'/image',
            array(
                'multipart' => array(
                    array(
                        'name' => 'media',
                        'contents' => fopen($image[$fileKey]->getPathname(), 'r'),
                        'filename' => $image[$fileKey]->getClientOriginalName(),
                        'headers'  => array(
                            'Slug' => 'aaaa.jpg'
                        )
                    )
                )
            )
        );

        if($response->getStatusCode() !== 201) {
            throw new Exception\ServerError('Error Thumbor uploader. Check log.');
        }

        return str_replace('/image', '', $response->getHeader('Location')[0]);
    }
}
