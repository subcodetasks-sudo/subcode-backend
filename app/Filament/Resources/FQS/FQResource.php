<?php

namespace App\Filament\Resources\FQS;

use App\Filament\Resources\FQS\Pages\CreateFQ;
use App\Filament\Resources\FQS\Pages\EditFQ;
use App\Filament\Resources\FQS\Pages\ListFQS;
use App\Filament\Resources\FQS\Pages\ViewFQ;
use App\Filament\Resources\FQS\Schemas\FQForm;
use App\Filament\Resources\FQS\Schemas\FQInfolist;
use App\Filament\Resources\FQS\Tables\FQSTable;
use App\Models\FQ;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FQResource extends Resource
{
    protected static ?string $model = FQ::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQuestionMarkCircle;
    
      public static function getNavigationLabel(): string
    {
        return __('admin.fqs');
    }

    public static function getModelLabel(): string
    {
        return __('admin.fqs');
    }
    
    public static function getPluralModelLabel(): string
    {
        return __('admin.fqs');
    }
    public static function getNavigationGroup(): string
    {
        return __('admin.pages');
    }

    public static function form(Schema $schema): Schema
    {
        return FQForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return FQInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FQSTable::configure($table);
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
            'index' => ListFQS::route('/'),
            //'create' => CreateFQ::route('/create'),
       //     'view' => ViewFQ::route('/{record}'),
         //   'edit' => EditFQ::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
