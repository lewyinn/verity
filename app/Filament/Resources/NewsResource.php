<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Filament\Resources\NewsResource\Pages\ListNews;
use App\Filament\Resources\NewsResource\RelationManagers;
use App\Models\Categorie;
use App\Models\Like;
use App\Models\News;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Storage;
use Filament\Tables\Enums\FiltersLayout;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationGroup = 'Utama'; 

    
    public static function getNavigationBadge(): ?string
    {
    $user = Auth::user();
    
    // Cek apakah user memiliki role 'Penulis'
    if ($user->roles->contains('name', 'Penulis')) {
        // Hitung jumlah news yang berstatus 'draft' dan dibuat oleh user tersebut
        $draftCount = News::where('user_id', $user->id)
                        ->where('status', 'draft')
                        ->count();
        return $draftCount > 0 ? (string) $draftCount : null;
    }

    // Cek apakah user memiliki role 'Super Admin'
    if ($user->roles->contains('name', 'super_admin')) {
        // Hitung semua news yang berstatus 'draft'
        $draftCount = News::where('status', 'draft')
                        ->count();
        return $draftCount > 0 ? (string) $draftCount : null;
    }
    
    return null;
    }

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->columnSpan(2)
                    ->required()
                    ->maxLength(255),
                Forms\Components\RichEditor::make('content')
                    ->columnSpan(2)
                    ->required(),
                Forms\Components\FileUpload::make('image_url')
                    ->columnSpan(2)
                    ->nullable(),
                Forms\Components\Select::make('category_id')
                    ->columnSpan(2)    
                    ->label('Category')
                    ->options(Categorie::all()->pluck('name', 'id'))
                    ->required(),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                    ])
                    ->default('draft'),
                Forms\Components\TextInput::make('likes_count')
                    ->numeric()
                    ->default(0)
                    ->disabled(),
                    ]);
    }

    public static function table(Table $table): Table
    {   
        // Get the authenticated user
        $user = Auth::user();
        
        // Define the query
        $query = News::query(); // Replace `News` with your actual model
        
        // Conditionally modify the query based on the user's role
        if ($user) {
            if ($user->roles->contains('name', 'Penulis')) {
                // Penulis hanya melihat berita yang mereka buat
                $query->where('user_id', $user->id);
            } elseif ($user->roles->contains('name', 'Pembaca')) {
                // Pembaca hanya melihat berita yang statusnya 'published'
                $query->where('status', 'published');
            }
        }

        return $table
            ->query($query)
            ->columns([
                Tables\Columns\ImageColumn::make('image_url')
                    ->label('Image')
                    ->width(50)
                    ->height(50),
                Tables\Columns\TextColumn::make('title')
                    ->limit(48)
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')->label('Dibuat Oleh'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'published' => 'success',
                    }),
                Tables\Columns\TextColumn::make('likes_count')
                    ->label('Disukai')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                ImageEntry::make('image_url')
                    ->height(300)
                    ->columnSpan(3)
                    ->label("Image"),
                ImageEntry::make('user.avatar_url')
                    ->label('Profile')
                    ->height(70)
                    ->circular()
                    ->url(fn ($record) => $record->avatar_url ? Storage::url($record->avatar_url) : asset('default-avatar.png'))
                    ->defaultImageUrl(asset('default-avatar.png')),
                TextEntry::make('user.name')
                    ->label('Penulis'),
                TextEntry::make('title')
                    ->label('Judul Berita')
                    ->columnSpan(2),
                TextEntry::make('content')
                    ->label('Isi Berita')
                    ->columnSpan(3),
                TextEntry::make('likes_count')
                    ->label('Disukai')
                    ->columnSpan(1),
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
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
