<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotificacionCargaRequisitos extends Notification
{
    protected $requisitos_cargados, $nombre_candidato, $id_candidato;
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct($requisitos_cargados, $nombre_candidato, $id_candidato)
    {
        $this->requisitos_cargados = $requisitos_cargados;
        $this->nombre_candidato = $nombre_candidato;
        $this->id_candidato = $id_candidato;
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
        $message = (new MailMessage)
            ->greeting('¡Hola!')
            ->subject('Requisitos de contratación')
            ->line('El candidato ' . $this->nombre_candidato . ' ha cargado los siguientes requisitos: ');
        foreach ($this->requisitos_cargados as $requisito) {
            $message->line($requisito['requisito']);
        }
        $message->line('Para verificar los requisitos que han sido agregados o actualizados, puedes verificar el expediente en el siguiente enlace.')
            ->action('Requisitos', route('expedientes', ['candidato_id' => $this->id_candidato]));


        return $message;
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
