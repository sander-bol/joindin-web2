<?php
namespace Talk;

use Application\BaseCommentEntity;
use stdClass;

class TalkCommentEntity extends BaseCommentEntity
{
    public function getTalkTitle(): ?string
    {
        return $this->data->talk_title ?? null;
    }

    public function getTalkUri(): ?string
    {
        return $this->data->talk_uri ?? null;
    }

    public function getCommentUri(): ?string
    {
        return $this->data->uri ?? null;
    }

    public function canRateTalk(string $user_uri): bool
    {
        return !(isset($this->data->user_uri) && $this->data->user_uri === $user_uri);
    }
}
