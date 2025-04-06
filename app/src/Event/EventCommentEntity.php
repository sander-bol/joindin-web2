<?php
namespace Event;

use Application\BaseCommentEntity;

class EventCommentEntity extends BaseCommentEntity
{
    public function getCommentUri(): ?string
    {
        return $this->data->comment_uri ?? null;
    }
}
