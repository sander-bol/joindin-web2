<?php

namespace User;

use Application\BaseEntity;

class UserEntity extends BaseEntity
{
    public function getUsername(): string
    {
        return $this->data->username;
    }

    public function getFullName(): string
    {
        return $this->data->full_name;
    }

    public function getTwitterUsername(): ?string
    {
        return str_replace('@', '', $this->data->twitter_username);
    }


    public function getBiography(): ?string
    {
        return $this->data->biography ?? null;
    }

    public function getEmail(): ?string
    {
        return $this->data->email ?? null;
    }

    public function getUri(): string
    {
        return $this->data->uri;
    }

    public function getVerboseUri(): string
    {
        return $this->data->verbose_uri;
    }

    public function getWebsiteUri(): string
    {
        return $this->data->website_uri;
    }

    public function getTalksUri(): string
    {
        return $this->data->talks_uri;
    }

    public function getAttendedEventsUri(): string
    {
        return $this->data->attended_events_uri;
    }

    public function getHostedEventsUri(): string
    {
        return $this->data->hosted_events_uri;
    }

    public function getTalkCommentsUri(): string
    {
        return $this->data->talk_comments_uri;
    }

    public function getGravatarHash(): ?string
    {
        return $this->data->gravatar_hash;
    }

    public function getCanEdit(): bool
    {
        return $this->data->can_edit ?? false;
    }

    public function getAdmin(): bool
    {
        return $this->data->admin ?? false;
    }

    public function getId(): string
    {
        $uri   = $this->data->uri;
        $parts = explode('/', $uri);

        return $parts[5];
    }
}
