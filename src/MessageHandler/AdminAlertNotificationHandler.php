<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\AdminAlertNotification;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Mailer\MailerInterface;

#[AsMessageHandler]
class AdminAlertNotificationHandler
{
    public function __construct(private readonly MailerInterface $mailer)
    {
    }

    /**
     * @param AdminAlertNotification $notification
     * @return void
     * @throws TransportExceptionInterface
     */
    public function __invoke(AdminAlertNotification $notification): void
    {
        $email = (new Email())
            ->from($notification->getFromEmail())
            ->to($notification->getRecipient())
            ->subject($notification->getSubject())
            ->text($notification->getBody());

        $this->mailer->send($email);
    }
}
