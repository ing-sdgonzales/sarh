<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotificacionActualizacionPIR extends Notification
{
    use Queueable;
    protected $direccion;
    protected $usuario;

    /**
     * Create a new notification instance.
     */
    public function __construct($direccion, $usuario)
    {
        $this->direccion = $direccion;
        $this->usuario = $usuario;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting('¡Hola!')
            ->subject('Solicitud de actualización de formulario PIR')
            ->line('El usuario ' . $this->usuario . ' de la ' . $this->direccion . ' ha solicitado actualización para el formulario PIR.')
            ->line('Puede ver todas las solicitudes en el siguiente enlace.')
            ->action('solicitudes', route('control_pir'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
