<?php namespace Arcanesoft\Auth\Notifications\Users;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

/**
 * Class     ResetPassword
 *
 * @package  Arcanesoft\Auth\Notifications\Users
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class ResetPassword extends Notification
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /* ------------------------------------------------------------------------------------------------
     |  Constructors
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Create a notification instance.
     *
     * @param  string  $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     *
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail()
    {
        return (new MailMessage)
            ->subject(trans('auth::password.mail.subject'))
            ->line(trans('auth::password.mail.line-1'))
            ->action(trans('auth::password.mail.action'), route('auth::password.token', [$this->token]))
            ->line(trans('auth::password.mail.line-2'));
    }
}
