<?php

namespace App\Filament\Resources\LikeResource\Pages;

use App\Filament\Resources\LikeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditLike extends EditRecord
{
    protected static string $resource = LikeResource::class;

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
            ->title('Like Telah Diedit')
            ->body('Berhasil Mengedit Like anda.');
    }
}
