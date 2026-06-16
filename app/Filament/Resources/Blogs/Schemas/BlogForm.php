<?php

namespace App\Filament\Resources\Blogs\Schemas;

use App\Models\Admin;
use App\Filament\Schemas\Components\SeoSection;
use App\Filament\Schemas\Components\SlugField;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Radio;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\DateTimePicker;

class BlogForm
{
     public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
              Section::make(__('admin.post_details'))
                ->schema([
                     TextInput::make('title')
                        ->required()
                        ->label(__('admin.title'))
                        ->columnSpanFull()
                        ->live(onBlur: true)
                        ->translatableTabs()
                        ->modifyFieldsUsing(SlugField::sourceCustomizer('title')),

                     SlugField::make('title'),

                     RichEditor::make('description')
                        ->required()
                        ->label(__('admin.description'))
                        ->columnSpanFull()
                        ->translatableTabs(),
                        
                     FileUpload::make('image')
                        ->required()
                        ->label(__('admin.image'))
                        ->disk('public')
                        ->columnSpanFull(),

                     SeoSection::imageAltField()
                        ->columnSpanFull(),
                        
                     Select::make('category_id')
                        ->required()
                        ->relationship(name: 'category', titleAttribute: 'name')
                        ->label(__('admin.category')),

                    Radio::make('status')
                        ->label(__('admin.status'))
                        ->options([
                            'publish' => __('admin.publish'),
                            'draft' => __('admin.draft'),
                            'schedule' => __('admin.schedule'),
                        ])
                        ->default('publish')
                        ->inline()
                        ->reactive()
                        ->afterStateUpdated(
                            fn (callable $set, $state) =>
                            $set('time_publish', $state === 'schedule' ? now() : null)
                        ),

                     DateTimePicker::make('time_publish')
                        ->label(__('admin.time_publish'))
                        ->nullable()
                        ->hidden(fn ($get) => $get('status') !== 'schedule'),
                ])
                ->columns(2)->columnSpanFull(),

                SeoSection::section(),

                Hidden::make('auther_id')
                    ->required()
                    ->default(Auth::user()->id),
            ]);
    }
}
