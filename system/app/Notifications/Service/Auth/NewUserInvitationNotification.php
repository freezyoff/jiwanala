<?php

namespace App\Notifications\Service\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewUserInvitationNotification extends Notification
{
    use Queueable;

	protected $token = '';
	
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token){ $this->token = 'service.jiwa-nala.org/auth/resetpwd/'.$token; }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
			->subject(trans('service/auth/reset.mail.invitation'))
			->markdown('service.auth.mail.new_user_invitation', [
				'token'=>$this->token
			]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
