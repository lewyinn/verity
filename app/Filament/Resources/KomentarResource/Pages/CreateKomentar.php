<?php

namespace App\Filament\Resources\KomentarResource\Pages;

use App\Filament\Resources\KomentarResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateKomentar extends CreateRecord
{
    protected static string $resource = KomentarResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Komentar Telah Dibuat')
            ->body('Berhasil membuat Berita terbaru');
    }
}
