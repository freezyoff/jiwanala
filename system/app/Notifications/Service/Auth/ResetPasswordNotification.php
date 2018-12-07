<?php

namespace App\Notifications\Service\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification implements ShouldQueue{
    use Queueable;

	protected $reset_url = false;
	
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token){
		//$this->reset_url = route('service.auth.reset', $token);
		
		//force url to remote
        $this->reset_url = 'https://service.jiwa-nala.org/auth/resetpwd/'.$token;
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
			->subject(trans('service/auth/reset.mail.subject'))
			->markdown('service.auth.mail.reset_user_password', ['url' => $this->reset_url]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable){
        return ['reset_url'=>$this->reset_url];
    }
}
