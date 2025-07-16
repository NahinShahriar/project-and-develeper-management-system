<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskCreateNotification extends Notification  implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $task_name;
    public $task_id;
    public function __construct($task_id,$task_name)
    {
        $this->task_name=$task_name;
        $this->task_id=$task_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
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
                    ->subject('Task Assign')
                    ->line('New Task Assigned To You')
                    ->line('Task Name: '.$this->task_name)
                //    ->action('Task Url', url('/seetasks/'.$this->task_id))
                     ->action('View Task', url('/seetask/'.$this->task_id)) 
                    ->line('Thank you for using our application!');
    }
    public function toDatabase($notifiable)
    {
        return 
        [
            'message'=>"New Task Added",
        ];
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
