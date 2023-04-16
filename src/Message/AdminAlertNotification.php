<?php

declare(strict_types=1);

namespace App\Message;

class AdminAlertNotification
{
    public function __construct(
        private readonly string $adminEmail,
        private ?string $body = null,
    )
    {
    }

    /**
     * @return string
     */
    public function getFromEmail(): string
    {
        return $this->adminEmail;
    }

    /**
     * @return string
     */
    public function getRecipient(): string
    {
        return $this->adminEmail;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return 'Admin Alert';
    }

    /**
     * @param string $body
     * @return $this
     */
    public function setBody(string $body): static
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }
}
