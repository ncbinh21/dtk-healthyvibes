<?php

namespace Healthyvibes\IntegrationBase\Model\Service\Http;

interface TransferInterface
{
    /**
     * Returns service client configuration
     *
     * @return array
     */
    public function getClientConfig();

    /**
     * Returns method used to request
     *
     * @return string|int
     */
    public function getMethod();

    /**
     * Returns headers
     *
     * @return array
     */
    public function getHeaders();

    /**
     * Whether body should be encoded before making request
     *
     * @return bool
     */
    public function shouldEncode();

    /**
     * Returns request body
     *
     * @return array|string
     */
    public function getBody();

    /**
     * Returns URI
     *
     * @return string
     */
    public function getUri();

    /**
     * Returns Auth username
     *
     * @return string
     */
    public function getAuthUsername();

    /**
     * Returns Auth password
     *
     * @return string
     */
    public function getAuthPassword();
}
