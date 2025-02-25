<?php

namespace App\Filament\Widgets;

use App\Models\News;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LatestNewsWidget extends BaseWidget
{
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';
    
    public function table(Table $table): Table
    {
        $user = Auth::user();
    
        // Inisialisasi query
        $query = News::query()->latest();
        
        if ($user) {
            if ($user->roles->contains('name', 'Penulis')) {
                // Penulis hanya melihat berita yang mereka buat
                $query->where('user_id', $user->id);
            } elseif ($user->roles->contains('name', 'Pembaca')) {
                // Pembaca hanya melihat berita yang statusnya 'published'
                $query->where('status', 'published');
            }
        }
        
        $query->limit(3);
        
        return $table
            ->query($query)
            ->columns([
                Tables\Columns\ImageColumn::make('image_url')
                    ->label('Image')
                    ->width(50)
                    ->height(50),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Dibuat Oleh'),
                Tables\Columns\TextColumn::make('likes_count')
                    ->label('Disukai')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('d-m-Y')
                    ->sortable(),
            ])
            ->paginated(false)
            ->filters([
                // Tambahkan filter jika diperlukan
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->url('/admin/news')
                    ->label('See All'),
            ]);
    }

}
