<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LikeResource\Pages;
use App\Filament\Resources\LikeResource\RelationManagers;
use App\Models\Like;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class LikeResource extends Resource
{
    protected static ?string $model = Like::class;

    protected static ?string $navigationGroup = 'Addition'; 

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('news_id')
                    ->relationship('news', 'title')
                    ->required()
                    ->columnSpan(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        $user = Auth::user();
        $query = Like::query();

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
                TextColumn::make('news.title')->label('News Title'),
                TextColumn::make('user.name')->label('Dilike Oleh'),
                TextColumn::make('created_at')->label('Liked At')->dateTime(),
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
            'index' => Pages\ListLikes::route('/'),
            'create' => Pages\CreateLike::route('/create'),
            'edit' => Pages\EditLike::route('/{record}/edit'),
        ];
    }
}
