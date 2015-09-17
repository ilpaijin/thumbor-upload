<?php

namespace Favoroute\Exception;

use Exception;

/**
 *
 * @package    Favoroute Image Uploader
 * @author     Paolo Pietropoli (ilpaijin) <ilpaijin@gmail.com>
 * @copyright  ilpaijin
 * @license
 * @version    Release: @package_version@
 */
class ServerError extends \Exception
{
    public function __construct()
    {
        throw new Exception('External Service Error, 503);
    }
}
