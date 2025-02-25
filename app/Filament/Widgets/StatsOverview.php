<?php

namespace App\Filament\Widgets;

use App\Models\Categorie;
use App\Models\News;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', $this->getTotalUsers())
                ->description('Total Users yang sudah registrasi.')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),
            Stat::make('Total Kategori', $this->getTotalCategories())
                ->description('Total Kategori yang tersedia')
                ->descriptionIcon('heroicon-m-tag')
                ->color('warning'),
            Stat::make('Total Berita', $this->getTotalPublishedNews())
                ->description('Total Berita Dengan Status Published')
                ->descriptionIcon('heroicon-m-newspaper')
                ->color('info'),
        ];
    }

    /**
     * Get the total number of users.
     *
     * @return int
     */
    protected function getTotalUsers(): int
    {
        return User::count(); // Adjust as needed to fit your user model
    }

    /**
     * Get the total number of published news articles.
     *
     * @return int
     */
    protected function getTotalPublishedNews(): int
    {
        return News::where('status', 'published')->count(); // Adjust as needed to fit your news model
    }

    /**
     * Get the total number of categories.
     *
     * @return int
     */
    protected function getTotalCategories(): int
    {
        return Categorie::count(); // Adjust as needed to fit your categories model
    }

}
