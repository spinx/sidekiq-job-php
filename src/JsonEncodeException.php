<?php

namespace SidekiqJob;

/**
 * @package SidekiqJob
 */
class JsonEncodeException extends \Exception
{
    /** @var mixed */
    private $nonJsonEncodableData;
    /** @var int */
    private $jsonErrorCode;
    /** @var string */
    private $jsonErrorMessage;

    /**
     * @param string          $nonJsonEncodableData
     * @param int             $jsonErrorCode
     * @param string          $jsonErrorMessage
     * @param \Exception|null $previous
     */
    public function __construct($nonJsonEncodableData, $jsonErrorCode, $jsonErrorMessage, \Exception $previous = null)
    {
        $this->nonJsonEncodableData = $nonJsonEncodableData;
        $this->jsonErrorCode = $jsonErrorCode;
        $this->jsonErrorMessage = $jsonErrorMessage;

        parent::__construct(sprintf('Json encode error [%d]: %s', $jsonErrorCode, $jsonErrorMessage), 0, $previous);
    }

    /**
     * @return mixed
     */
    public function getNonJsonEncodableData()
    {
        return $this->nonJsonEncodableData;
    }
}