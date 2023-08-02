<?php
 namespace Gtech\Media\Api;
 interface AllmediaRepositoryInterface 
 {
    public function save(\Gtech\Media\Api\Data\AllmediaInterface $media);

    public function getById($mediaId);

    public function delete(\Gtech\Media\Api\Data\AllmediaInterface $media);

    public function deleteById($mediaId);
 }
?>

