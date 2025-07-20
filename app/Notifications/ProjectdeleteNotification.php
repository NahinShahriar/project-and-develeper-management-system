<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Project;
use Illuminate\Queue\SerializesModels;

class ProjectdeleteNotification extends Notification implements ShouldQueue
{
    use Queueable,SerializesModels;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $project;
  
    
    public function __construct(Project $project)
    {
        $this->project=$project;
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
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject("Project {$this->project->name}")
                    ->line(" project has been Deleted.")
                    // ->action('View Project', route('projects.show', $this->project->id))
                    ->line('Thank you.');
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
