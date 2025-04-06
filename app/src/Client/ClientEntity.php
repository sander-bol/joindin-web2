<?php
namespace Client;

use Application\BaseEntity;
use DateTime;
use DateInterval;

class ClientEntity extends BaseEntity
{
    public function getId(): string
    {
        return substr($this->data->client_uri, strrpos($this->data->client_uri, '/') + 1);
    }

    public function getName(): string
    {
        return $this->data->application;
    }

    public function getDescription(): string
    {
        return $this->data->description;
    }

    public function getConsumerKey(): string
    {
        return $this->data->consumer_key;
    }

    public function getCreationDateTime(): \DateTimeImmutable
    {
        return new \DateTimeImmutable($this->data->created_date);
    }

    public function getCallbackUrl(): string
    {
        return $this->data->callback_url;
    }

    public function hasConsumerSecret(): bool
    {
        return isset($this->data->consumer_secret);
    }

    public function getConsumerSecret(): string
    {
        return $this->hasConsumerSecret() ? $this->data->consumer_secret : '';
    }

    public function getApiUri(): string
    {
        return $this->data->client_uri;
    }
}
