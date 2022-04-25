<?php

namespace BolCom;

class Request
{
    private string $token;
    private bool $legacyApiToken;
    private string $sessionId;
    private int $httpResponseCode;
    private string $httpFullHeader;

    public function __construct(string $token, bool $legacyApiToken)
    {
        $this->token = $token;
        $this->legacyApiToken = $legacyApiToken;
    }

    public function fetch($httpMethod, $url, $parameters = '', $content = '')
    {
        $parameters .= ($parameters == '' ? '?' : '&');
        $parameters .= 'format=json';
        if ($this->legacyApiToken) {
            $parameters .= '&apikey=' . $this->token;
        }

        switch ($httpMethod) {
            default:
            case 'GET':
                $contentType = 'application/json';
                break;
            case 'POST':
            case 'PUT':
            case 'DELETE':
                $contentType = 'application/x-www-form-urlencoded';
                break;
        }

        $headers = $httpMethod . " " . $url . $parameters . " HTTP/1.0\r\n";
        if(! $this->legacyApiToken) {
            $headers .= "Authorization: Bearer {$this->token}'\r\n";
        }
        $headers .= "Content-type: " . $contentType . "\r\n";
        $headers .= "Host: api.bol.com\r\n";
        $headers .= "Content-length: " . strlen($content) . "\r\n";
        $headers .= "Connection: close\r\n";

        if (! empty($this->sessionId)) {
            $headers .= "X-OpenAPI-Session-ID: " . $this->sessionId . "\r\n";
        }
        $headers .= "\r\n";

        $socket = @fsockopen('ssl://api.bol.com', '443', $errno, $errstr, 30);
        if (!$socket) {
            throw new BolOpenApiException("{$errstr} ({$errno})");
        }

        $opts = [
            'ssl' => [
                'verify_peer' => true,
                'verify_peer_name' => true,
                'allow_self_signed' => false,
                'SNI_enabled' => true,
            ],
        ];

        stream_context_set_option($socket, $opts);

        fputs($socket, $headers);
        fputs($socket, $content);

        $result = '';

        while (!feof($socket)) {
            $result .= fgets($socket);
        }
        fclose($socket);

        $this->httpResponseCode = intval(substr($result, 9, 3));

        list($header, $body) = explode("\r\n\r\n", $result, 2);

        $this->httpFullHeader = $header;

        return json_decode($body);
    }

    public function getHttpResponseCode()
    {
        return $this->httpResponseCode;
    }

    public function getFullHeader()
    {
        return $this->httpFullHeader;
    }

    public function getSessionId()
    {
        return $this->sessionId;
    }

    public function setSessionId($sessionId)
    {
        $this->sessionId = '' . $sessionId;
    }

}
