<?php

namespace App\Filament\Resources\KomentarResource\Pages;

use App\Filament\Resources\KomentarResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditKomentar extends EditRecord
{
    protected static string $resource = KomentarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Komentar Telah Diedit')
            ->body('Berhasil Mengedit Komentar Anda.');
    }
}
