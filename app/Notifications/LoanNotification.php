<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoanNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $loan;
    protected $type; 

    public function __construct($loan, $type)
    {
        $this->loan = $loan;
        $this->type = $type;
    }

    public function via($notifiable)
    {
        return ['database', 'mail']; 
    }

    public function toMail($notifiable)
{
    $message = match ($this->type) {
        'borrowed' => 'Buku "' . $this->loan->book->title . '" berhasil dipinjam. Jatuh tempo: ' . $this->loan->due_date->format('d/m/Y'),
        'returned' => 'Buku "' . $this->loan->book->title . '" telah dikembalikan.',
        'due_soon' => 'Pengingat: Buku "' . $this->loan->book->title . '" jatuh tempo dalam 2 hari.',
        'fine' => 'Denda baru: Rp' . number_format($this->loan->fine_amount) . ' untuk buku "' . $this->loan->book->title . '".',
        default => 'Notifikasi peminjaman buku.', 
    };

    return (new MailMessage)
        ->subject('Notifikasi Peminjaman Buku')
        ->line($message)
        ->action('Lihat Detail', url('/loans'));
}

    public function toArray($notifiable)
    {
        return [
            'loan_id' => $this->loan->id,
            'book_title' => $this->loan->book->title,
            'type' => $this->type,
            'message' => $this->toMail($notifiable)->introLines[0] ?? 'Notifikasi peminjaman.',
        ];
    }
}