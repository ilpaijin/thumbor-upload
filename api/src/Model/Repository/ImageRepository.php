<?php

namespace Favoroute\Model\Repository;

use Favoroute\Model\Entity\Image;

/**
 *
 * @package    Favoroute Image Uploader
 * @author     Paolo Pietropoli (ilpaijin) <ilpaijin@gmail.com>
 * @copyright  ilpaijin
 * @license
 * @version    Release: @package_version@
 */
class ImageRepository
{
    /**
     * @var [type]
     */
    private $table = 'images';

    /**
     * @var [type]
     */
    protected $db;

    /**
     * \PDO here should be an interface for every storage connection
     *
     * @param \PDO $db
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * persist an image
     *
     * @return Image
     */
    public function save($image)
    {
        try{
            $stmt = $this->db->prepare(
                "INSERT INTO {$this->table}
                (label, filename, caption, type, width, height, url, user_fk, timestamp) VALUES
                (:label, :filename, :caption, :type, :width, :height, :url, :userId, :createdAt)"
            );

            $now = new \DateTime();

            $stmt->bindValue(':label', $image->getLabel());
            $stmt->bindValue(':filename', $image->getFilename());
            $stmt->bindValue(':caption', $image->getCaption());
            $stmt->bindValue(':type', substr($image->getType(), -4, 4)); // Why mysql is limiting to 5 char? not the mimeType here?
            $stmt->bindValue(':width', $image->getWidth());
            $stmt->bindValue(':height', $image->getHeight());
            $stmt->bindValue(':url', $image->getUrl());
            $stmt->bindValue(':userId', $image->getUser());
            $stmt->bindValue(':userId', $image->getUser());
            $stmt->bindValue(':createdAt', $now->format("Y-m-d H:i:s"));

            $stmt->execute();

        } catch (\Exception $e) {
            throw $e;
        }

        if ($id = $this->db->lastInsertId()) {
            $image->setId($id);
            $image->setTimestamp($now->format("Y-m-d H:i:s"));
        }

        return $image;
    }
}
