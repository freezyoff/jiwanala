<?php

namespace App\Notifications\Service\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification implements ShouldQueue{
    use Queueable;

	protected $token = '';
	
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token){
		$this->token = route('service.auth.reset',[$token]);
		$this->token = str_replace(["https://",'http://'],"",$this->token);
    }

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
    public function toMail($notifiable){
		return (new MailMessage)
			->subject(trans('service/auth/reset.mail.reset'))
			->markdown('service.auth.mail.reset_user_password', [
				'token'=>$this->token
			]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable){
        return ['reset_url'=>$this->token];
    }
}
