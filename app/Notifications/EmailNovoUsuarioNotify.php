<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailNovoUsuarioNotify extends Notification
{
    use Queueable;
    protected $dados;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($dados)
    {
        $this->dados = $dados;
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
     * Novo ADM da empresa
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = config('constants.SISTEMA_URL');

        $email  = $this->dados['email'];
        $senha = $this->dados['senha'];

        return (new MailMessage)
            ->subject('Notificação de Novo Usuário')
            ->greeting('Olá!')
            ->line('Seja bem-vindo(a) ao Make Events !')
            ->line('A partir de agora você terá acesso a edição do seu perfil em Make Events') 
            ->line('Sua senha foi gerada automaticamente pelo sistema:')
            ->line('E-mail: '. $email)
            ->line('Senha: '. $senha)
            ->action('Entrar', $url);
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
