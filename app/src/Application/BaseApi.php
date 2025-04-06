<?php
namespace Application;

abstract class BaseApi
{
    protected string $baseApiUrl;

    protected ?string $accessToken;

    protected ?string $proxy;

    public function __construct($config, ?string $accessToken = null)
    {
        if (!is_string($config['apiUrl'] ?? null)) {
            throw new \InvalidArgumentException('Configuration array is required');
        }

        $this->baseApiUrl = $config['apiUrl'];
        $this->proxy      = $config['proxy'] ?? null;
        $this->accessToken = $accessToken;
    }

    /**
     * @return resource
     */
    private function getStreamContext(string $httpMethod, string $content = null)
    {
        $contextOpts = [
            'http' => [
                'timeout'       => 10,
                'ignore_errors' => true,
            ]
        ];

        $headers = [
            'Accept' => 'application/json',
        ];

        if ($httpMethod === 'POST' || $httpMethod === 'PUT') {
            $headers['Content-type'] = 'application/json';
            $contextOpts['content'] = $content;
        }

        // Forwarded header - see RFC 7239 (http://tools.ietf.org/html/rfc7239)
        $ip                   = $_SERVER['REMOTE_ADDR'];
        $agent                = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
        $headers['Forwarded'] = sprintf('for=%s;user-agent="%s"', $ip, $agent);

        if ($this->accessToken) {
            $headers['Authorization'] = 'OAuth ' . $this->accessToken;
        }

        if ($this->proxy) {
            $contextOpts['http']['proxy']           = $this->proxy;
            $contextOpts['http']['request_fulluri'] = true;
        }

        $contextOpts['http']['headers'] = $headers;

        return stream_context_create($contextOpts);
    }

    protected function apiGet(string $url, array $params = []): string
    {
        $paramsString = count($params) > 0 ? '?' . http_build_query($params, '', '&') : '';

        $streamContext = $this->getStreamContext('GET');
        $result        = file_get_contents($url . $paramsString, false, $streamContext);

        if (false === $result) {
            throw new \RuntimeException('Unable to connect to API');
        }
        if ($result === '') {
            throw new \RuntimeException('API returned an empty result');
        }

        return $result;
    }

    protected function apiDelete(string $url, array $params = []): array
    {
        $paramsString = count($params) > 0 ? '?' . http_build_query($params, '', '&') : '';

        $streamContext = $this->getStreamContext('DELETE');
        $result        = file_get_contents($url . $paramsString, false, $streamContext);

        if (false === $result) {
            throw new \RuntimeException('Unable to connect to API');
        }

        $status = 0;
        if (preg_match('@HTTP\/1\.[0|1] (\d+) @', $http_response_header[0], $matches)) {
            $status = $matches[1];
        }

        $headers = $this->extractListOfHeaders($http_response_header);

        return [$status, $result, $headers];
    }

    protected function apiPost(string $url, array $params = []): array
    {
        $streamContext = $this->getStreamContext('POST', json_encode($params, JSON_THROW_ON_ERROR));
        $result        = file_get_contents($url, false, $streamContext);
        if (false === $result) {
            throw new \RuntimeException('Unable to connect to API');
        }

        $status = 0;
        if (preg_match('@HTTP\/1\.[0|1] (\d+) @', $http_response_header[0], $matches)) {
            $status = $matches[1];
        }

        $headers = $this->extractListOfHeaders($http_response_header);

        return [(int)$status, $result, $headers];
    }

    protected function apiPut(string $url, array $params = []): array
    {
        $streamContext = $this->getStreamContext('PUT', json_encode($params, JSON_THROW_ON_ERROR));
        $result        = file_get_contents($url, false, $streamContext);
        if (false === $result) {
            throw new \RuntimeException('Unable to connect to API');
        }

        $status = 0;
        if (preg_match('@HTTP\/1\.[0|1] (\d+) @', $http_response_header[0], $matches)) {
            $status = $matches[1];
        }

        $headers = $this->extractListOfHeaders($http_response_header);

        return [$status, $result, $headers];
    }

    /**
     * Converts an array of headers, including tag, to an associative array.
     *
     * By default many header-providing methods return an array with the complete line of a header. Because we want
     * to be able to locate and return the contents of a specific header we convert the aforementioned array into an
     * associative array where the key represents the header tag, in lowercase, and the value the contents.
     *
     * @param string[] $rawHeaders
     *
     * @return string[]
     */
    private function extractListOfHeaders(array $rawHeaders): array
    {
        $headers = [];
        foreach ($rawHeaders as $header) {
            $header = explode(':', $header, 2);
            if (count($header) < 2) {
                continue;
            }

            $headers[strtolower($header[0])] = trim($header[1]);
        }

        return $headers;
    }

    public function setAccessToken(string $accessToken): void
    {
        $this->accessToken = $accessToken;
    }
}
