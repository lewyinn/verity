<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KomentarResource\Pages;
use App\Filament\Resources\KomentarResource\RelationManagers;
use App\Models\Komentar;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class KomentarResource extends Resource
{
    protected static ?string $model = Komentar::class;

    protected static ?string $navigationGroup = 'Addition'; 

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('news_id')
                    ->relationship('news', 'title')
                    ->label('Related News')
                    ->columnSpan(2)
                    ->required(),
                Textarea::make('content')
                    ->label('Comment Content')
                    ->columnSpan(2)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        $user = Auth::user();
        $query = Komentar::query();

        if ($user) {
            if ($user->roles->contains('name', 'Pembaca')) {
                $query->where('user_id', $user->id);
            }
            elseif ($user->roles->contains('name', 'Penulis')) {
                $query->where(function ($query) use ($user) {
                    // Condition to include likes made by the user
                    $query->where('user_id', $user->id)
                        ->orWhereHas('news', function ($query) use ($user) {
                            // Condition to include likes on news created by the user
                            $query->where('user_id', $user->id);
                        });
                });
            }
        }
        return $table
            ->query($query)
            ->columns([
                TextColumn::make('news.title')->label('Berita'),
                TextColumn::make('content')->label('Kometar')->limit(50),
                TextColumn::make('user.name')->label('Username'),
                TextColumn::make('created_at')->label('Commented At')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->visible(fn ($record) => $record->user_id === Auth::id()), 
                Tables\Actions\DeleteAction::make()
                    ->visible(fn ($record) => $record->user_id === Auth::id()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKomentars::route('/'),
            'create' => Pages\CreateKomentar::route('/create'),
            'edit' => Pages\EditKomentar::route('/{record}/edit'),
        ];
    }
}
