<?php

namespace Shashin\Shared\Exception;

use Exception;
use Throwable;

abstract class DomainException extends Exception
{
    /**
     * @param string              $message
     * @param int                 $code
     * @param array<string,mixed> $options
     * @param Throwable|null      $previous
     */
    public function __construct(
        string $message,
        int $code = 0,
        protected array $options = [],
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);

        $this->addOptions(
            [
                'exception' => get_class($this),
                'file' => $this->getFile(),
                'line' => $this->getLine()
            ]
        );

        if (!empty($this->getTrace())) {
            if (isset($this->getTrace()[0]['class'])) {
                $this->addOption('class', $this->getTrace()[0]['class']);
            }
            if (isset($this->getTrace()[0]['function'])) {
                $this->addOption('method', $this->getTrace()[0]['function']);
            }
        }

        $this->addOptions($this->options);
    }

    /**
     * @return array<string, mixed>
     */
    public
    function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array<string, mixed> $options
     */
    public
    function setOptions(
        array $options
    ): void {
        $this->options = $options;
    }

    /**
     * @param string $key
     * @param mixed  $value
     * @return void
     */
    public
    function addOption(
        string $key,
        mixed $value
    ): void {
        $this->options[$key] = $value;
    }

    /**
     * @param array<string,mixed> $options
     * @return void
     */
    public
    function addOptions(
        array $options
    ): void {
        $this->options = array_merge($this->options, $options);
    }
}