<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AvisoRequisitos extends Notification
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
            ->subject('Requisitos de contratación')
            ->line('Buen día, según la información proporcionada, le adjuntamos por esta vía la documentación relacionada para la conformación de su expediente:')
            ->line('1. Enlace para adjuntar los requisitos correspondientes.')
            ->line('2. Formato de Declaración Jurada. (No se aceptará otro formato)')
            ->attach(public_path('templates/RRHH-CONRED - Declaración Jurada 2023.docx'))
            ->line('3. Formato de Hoja de Vida, el cual debe ser llenado de conformidad con los datos allí incluidos; deberá imprimirlo, firmarlo y agregarlo dentro de los requisitos de su expediente en formato PDF.')
            ->attach(public_path('templates/CURRICULUM CONRED - FORMATO 2023.docx'))
            ->line('Además, solicitamos poner atención a la descripción de cada requisito, ya que son aspectos relevantes para la conformación y correcta presentación de su expediente.')
            ->line('¡IMPORTANTE!')
            ->line('1. Todo documento debe ser impreso en TAMAÑO OFICIO.')
            ->line('2. El título debe ser presentado en el día de entrega de sus respectivos documentos, para su confrontación.')
            ->line('Para cualquier información adicional, quedamos a su disposición.')
            ->action('Requisitos', route('buscar_aplicacion'))
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
