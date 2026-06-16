<?php
namespace App\Filament\Resources\Admins\Schemas;

use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\IconEntry;
 use Filament\Schemas\Schema;

class AdminInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                   
                        ImageEntry::make('avatar')
                            ->label(__('admin.avatar'))
                            ->disk('public')
                            ->height(100),
                        TextEntry::make('name')
                            ->label(__('admin.name')),
                        TextEntry::make('email')
                            ->label(__('admin.email')),
                        TextEntry::make('phone')
                            ->label(__('admin.phone')),
 
                
                    
                        IconEntry::make('is_active')
                            ->label(__('admin.is_active'))
                            ->boolean(),
                        TextEntry::make('created_at')
                            ->label(__('admin.created_at'))
                            ->dateTime(),
                        TextEntry::make('updated_at')
                            ->label(__('admin.updated_at'))
                            ->dateTime(),
                     
            ]);
    }
}