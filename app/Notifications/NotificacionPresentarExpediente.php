<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotificacionPresentarExpediente extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
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
            ->subject('Presentar expediente')
            ->line('Buen día, para continuar con el proceso de solicitud de contratación, es necesario que 
                    presente su expediente en la Dirección de Recursos Humanos de la Secretaría Ejecutiva de CONRED.')
            ->line('La fecha límite para la entrega del expediente es de dos días hábiles posteriores a la recepción de este correo.')
            ->line('¡IMPORTANTE!')
            ->line('1. Todo documento debe ser impreso en TAMAÑO OFICIO.')
            ->line('2. El título debe ser presentado en el día de entrega de sus respectivos documentos, para su confrontación.')
            ->line('Para cualquier información adicional, quedamos a su disposición.')
            ->action('SE-CONRED', url('https://maps.app.goo.gl/eN4a3bohgAwDEAH76'))
            ->line('Si no has realizado ninguna aplicación laboral, puedes ignorar o eliminar este e-mail.');
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
