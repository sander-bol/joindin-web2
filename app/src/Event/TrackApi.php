<?php
namespace Event;

use Application\BaseApi;

class TrackApi extends BaseApi
{
    /**
     * Retrieve a list of tracks from the API
     *
     *
     */
    public function getTracks(string $url): array
    {
        $queryParams['resultsperpage'] = 0;

        $result = $this->apiGet($url, $queryParams);

        return json_decode($result, true);
    }

    /**
     * Return the list of tracks in a format suitable for a choice list
     */
    public function getTracksChoiceList(string $url): array
    {
        $tracks = [];

        $list = $this->getTracks($url);
        foreach ($list['tracks'] as $track) {
            $tracks[$track['uri']] = $track['track_name'];
        }

        return $tracks;
    }

    /**
     * Update a track
     */
    public function updateTrack(string $trackUri, array $data): bool
    {
        $params = [
            'track_name'        => $data['track_name'],
            'track_description' => $data['track_description'] ?? '',
        ];

        [$status, $result, $headers] = $this->apiPut($trackUri, $params);
        if ($status === 204) {
            return true;
        }

        $result  = json_decode($result);
        $message = $result[0];

        throw new \Exception("Failed: " . $message);
    }

    /**
     * Add a track to an event's tracks collection
     */
    public function addTrack(string $eventTracksUri, array $data): bool
    {
        $params = [
            'track_name'        => $data['track_name'],
            'track_description' => $data['track_description'] ?? '',
        ];

        [$status, $result, $headers] = $this->apiPost($eventTracksUri, $params);
        if ($status === 201) {
            return true;
        }

        $result  = json_decode($result);
        $message = $result[0];

        throw new \Exception("Failed: " . $message);
    }

    /**
     * Delete a track
     */
    public function deleteTrack(string $trackUri): bool
    {
        [$status, $result, $headers] = $this->apiDelete($trackUri);
        if ($status === 204) {
            return true;
        }

        $result  = json_decode($result);
        $message = $result[0];

        throw new \Exception("Failed to delete track: " . $message);
    }
}
