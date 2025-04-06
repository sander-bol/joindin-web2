<?php

namespace Event;

use Application\BaseEntity;
use DateTime;

class EventEntity extends BaseEntity
{
    public function getName()
    {
        return $this->data->name ?? null;
    }

    public function setName($name): self
    {
        $this->data->name = $name;

        return $this;
    }

    public function getFullTimezone(): ?string
    {
        if ( ! isset($this->data->tz_continent) || ! isset($this->data->tz_place)) {
            return null;
        }

        return $this->data->tz_continent . "/" . $this->data->tz_place;
    }

    public function getIcon(): ?string
    {
        return $this->data->icon ?? null;
    }

    public function setIcon($icon): void
    {
        $this->data->icon = $icon;
    }

    public function getStartDate()
    {
        return $this->data->start_date ?? null;
    }

    public function setStartDate($date): self
    {
        $this->data->start_date = $date;

        return $this;
    }

    public function getEndDate(): ?string
    {
        return $this->data->end_date ?? null;
    }

    public function getEndDateObject(): ?\DateTimeImmutable
    {
        $string = $this->getEndDate();
        if ($string === null) {
            return null;
        }

        return \DateTimeImmutable::createFromFormat(DateTime::ISO8601, $string);
    }

    public function setEndDate($date): self
    {
        $this->data->end_date = $date;

        return $this;
    }

    public function getLocation()
    {
        return $this->data->location ?? null;
    }

    public function setLocation($location): void
    {
        $this->data->location = $location;
    }

    public function getDescription(): ?string
    {
        return $this->data->description ?? null;
    }

    public function setDescription($description): self
    {
        $this->data->description = $description;

        return $this;
    }

    /**
     * @return array
     */
    public function getTags(): array
    {
        return $this->data->tags ?? [];
    }

    /**
     * @param array<string> $tags
     *
     * @return $this
     */
    public function setTags(array $tags): self
    {
        $this->data->tags = $tags;

        return $this;
    }

    public function getLatitude()
    {
        return $this->data->latitude ?? null;
    }

    public function setLatitude($latitude): self
    {
        $this->data->latitude = $latitude;

        return $this;
    }

    public function getLongitude()
    {
        return $this->data->longitude ?? null;
    }

    public function setLongitude($longitude): self
    {
        $this->data->longitude = $longitude;

        return $this;
    }

    public function getWebsiteAddress()
    {
        return $this->data->href ?? null;
    }

    public function getAttendeeCount()
    {
        return $this->data->attendee_count ?? null;
    }

    public function getCommentsCount()
    {
        return $this->data->event_comments_count ?? null;
    }

    public function getCommentsUri()
    {
        return $this->data->comments_uri ?? null;
    }

    public function getApiUriToMarkAsAttending()
    {
        return $this->data->attending_uri ?? null;
    }

    public function getTalksUri()
    {
        return $this->data->talks_uri ?? null;
    }

    public function getUri()
    {
        return $this->data->uri ?? null;
    }

    public function getVerboseUri()
    {
        return $this->data->verbose_uri ?? null;
    }

    public function isAttending()
    {
        return $this->data->attending ?? null;
    }

    public function areCommentsEnabled(): bool
    {
        return (bool)($this->data->comments_enabled ?? false);
    }

    public function isPastEvent(): bool
    {
        $endDate = $this->getEndDateObject();
        if ( ! $endDate) {
            return false;
        }

        $now = new \DateTimeImmutable(null, $endDate->getTimezone());
        $now->setTime(0, 0, 0);

        return ($endDate < $now);
    }

    public function getUrlFriendlyName(): ?string
    {
        return $this->data->url_friendly_name ?? null;
    }

    public function getStub(): ?string
    {
        return $this->data->stub ?? null;
    }

    public function setStub($stub): void
    {
        $this->data->stub = $stub;
    }

    /**
     * Returns the timezone in Continent/Place format or null if the timezone is not provided.
     *
     * @see \DateTimeZone::listIdentifiers() for a list of supported timezones.
     */
    public function getTimezone(): ?string
    {
        if (empty($this->data->tz_continent) || empty($this->data->tz_place)) {
            return null;
        }

        return $this->data->tz_continent . '/' . $this->data->tz_place;
    }

    public function getAllTalkCommentsUri(): ?string
    {
        return $this->data->all_talk_comments_uri ?? null;
    }

    /**
     * Returns the continent for the set timezone
     */
    public function getTzContinent(): string
    {
        $tz = explode('/', $this->getTimezone());

        return $tz[0];
    }

    /**
     * Set the Timezone continent
     *
     * @param string $tzContinent
     */
    public function setTzContinent(string $tzContinent): void
    {
        $this->data->tz_continent = $tzContinent;
    }

    /**
     * Returns the city for the set timezone
     */
    public function getTzPlace(): string
    {
        $tz = explode('/', $this->getTimezone());

        return $tz[1] ?? '';
    }

    /**
     * Set the Timezone place
     *
     * @param string $tzPlace
     */
    public function setTzPlace(string $tzPlace): void
    {
        $this->data->tz_place = $tzPlace;
    }

    /**
     * Returns the URL
     *
     * This is required by Symfonys PropertyAccessor
     *
     * @return string
     */
    public function getHref(): string
    {
        return $this->data->href;
    }

    /**
     * Set the HREF value
     *
     * @param string $href
     */
    public function setHref(string $href): void
    {
        $this->data->href = $href;
    }

    public function getCfPStartDate(): ?string
    {
        return ! empty($this->data->cfp_start_date) ? $this->data->cfp_start_date : null;
    }

    public function setCfpStartDate(string $date): self
    {
        $this->data->cfp_start_date = $date;

        return $this;
    }

    public function getCfPEndDate()
    {
        return ! empty($this->data->cfp_end_date) ? $this->data->cfp_end_date : null;
    }

    public function setCfpEndDate(string $date): self
    {
        $this->data->cfp_end_date = $date;

        return $this;
    }

    /**
     * Wrapper to getCallForPapersWebsiteAddress
     *
     * @return string
     */
    public function getCfpUrl(): ?string
    {
        return ! empty($this->data->cfp_url) ? $this->data->cfp_url : null;
    }

    public function setCfpUrl(string $cfpUrl): self
    {
        $this->data->cfp_url = $cfpUrl;

        return $this;
    }

    /**
     * Returns the status of the CFP
     * Based on start and end dates
     */
    public function getCfpStatus(): string
    {
        if (empty($this->getCfpStartDate()) || empty($this->getCfpEndDate())) {
            return '';
        }

        $startDate = DateTime::createFromFormat(DateTime::ISO8601, $this->getCfpStartDate());
        $endDate   = DateTime::createFromFormat(DateTime::ISO8601, $this->getCfpEndDate());
        $now       = new DateTime(null, $endDate->getTimezone());
        $now->setTime(0, 0, 0);

        if ($now < $startDate) {
            return 'Pending';
        }
        if ($now <= $endDate) {
            return 'Open';
        }

        return 'Closed';
    }

    public function getId()
    {
        return $this->data->ID;
    }

    public function toArray(): array
    {
        return (array)$this->data;
    }

    public function getEventSlug(): ?string
    {
        return $this->getUrlFriendlyName();
    }

    public function getCanEdit(): bool
    {
        return $this->data->can_edit;
    }

    public function getHosts(): array
    {
        return $this->data->hosts ?? [];
    }

    public function getAverageRating()
    {
        return $this->data->event_average_rating;
    }

    public function getApprovalUri(): string
    {
        return $this->data->approval_uri;
    }

    public function getReportedEventCommentsUri(): string
    {
        return $this->data->reported_comments_uri ?? false;
    }

    public function getReportedTalkCommentsUri(): string
    {
        return $this->data->reported_talk_comments_uri ?? false;
    }

    public function getPendingClaimsUri(): string
    {
        return $this->data->pending_claims_uri ?? false;
    }

    public function getAttendeesUri(): string
    {
        return $this->data->attendees_uri;
    }

    public function getImagesUri(): string
    {
        return $this->data->images_uri;
    }

    public function getTracksUri(): string
    {
        return $this->data->tracks_uri;
    }

    public function getHostsUri(): string
    {
        return $this->data->hosts_uri;
    }

    /**
     * Used by the edit form
     */
    public function getNewIcon()
    {
        return null;
    }

    public function getSmallImage(): string
    {
        return $this->data->images->small ?? "/img/event_icons/none.png";
    }

    public function getPending()
    {
        return $this->data->pending;
    }
}
