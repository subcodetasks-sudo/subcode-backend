<?php

namespace App\Filament\Pages;
use App\Models\Setting;
use App\Models\SeoSetting;
use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use App\Filament\Schemas\Components\SeoSection;
use App\Filament\Schemas\Components\SocialSection;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Support\Exceptions\Halt;

class Settings extends Page implements HasSchemas
{
    use InteractsWithActions, InteractsWithForms;

    protected  string $view = 'filament.pages.settings';

    public ?array $data = [];

    public Setting $record;

    public function getHeading(): string
    {
        return __('admin.all_settings');
    }

    public static function getNavigationGroup(): string
    {
        return __('admin.all_settings');
    }

    public static function getNavigationLabel(): string
    {
        return __('admin.all_settings');
    }

    public function mount(): void
    {
        $this->record = Setting::firstOrCreate([]);
        $this->fillForms();
    }

    protected function getForms(): array
    {
        return [
            'form'
        ];
    }

public function form(Schema $form): Schema
{
    return $form
        ->schema([
            Tabs::make('Settings')
                ->tabs([
                    // General Settings Tab
                    Tab::make(__('admin.settings.tabs.general'))
                        ->icon('heroicon-o-cog-6-tooth')
                        ->schema([
                            Section::make(__('admin.settings.sections.site_information'))
                                ->schema([
                                    TextInput::make('site_name')
                                        ->label(__('admin.site_name'))
                                        ->maxLength(255),
                                    
                                    FileUpload::make('site_logo')
                                        ->label(__('admin.site_logo'))
                                        ->image()
                                        ->disk('public')
                                        ->directory('settings'),
                                    
                                    FileUpload::make('site_favicon')
                                        ->label(__('admin.site_favicon'))
                                        ->image()
                                         ->disk('public')
                                        ->directory('settings'),
                                    
                                    Textarea::make('site_description')
                                        ->label(__('admin.site_description'))
                                        ->rows(3)
                                        ->maxLength(500),
                                ])
                                ->columns(2),

                            Section::make(__('admin.settings.sections.contact_information'))
                                ->schema([
                                    TextInput::make('site_email')
                                        ->label(__('admin.site_email'))
                                        ->email()
                                        ->maxLength(255),
                                    
                                    TextInput::make('site_phone')
                                        ->label(__('admin.phone_egy'))
                                        ->tel()
                                        ->maxLength(255),

                                    TextInput::make('phone_tr')
                                        ->label(__('admin.phone_tr'))
                                        ->tel()
                                        ->maxLength(255),

                                    TextInput::make('phone_sar')
                                        ->label(__('admin.phone_sar'))
                                        ->tel()
                                        ->maxLength(255),


                                        FileUpload::make('profile_one')
                                        ->label(__('admin.profile_one'))
                                        ->directory('settings')
                                        ->nullable()
                                        ->disk('public'),

                                        FileUpload::make('profile_two')
                                        ->label(__('admin.profile_two'))
                                        ->directory('settings')
                                        ->nullable()
                                        ->disk('public'),
                                    
                                    Textarea::make('site_address')
                                        ->label(__('admin.site_address'))
                                        ->rows(2)
                                        ->maxLength(500)
                                        ->columnSpanFull(),
                                    
                                    Textarea::make('contact_info')
                                        ->label(__('admin.contact_info'))
                                        ->rows(4)
                                        ->columnSpanFull(),
                                ])
                                ->columns(2),

                            Section::make(__('admin.settings.sections.system_settings'))
                                ->schema([
                                    TextInput::make('currency')
                                        ->label(__('admin.currency'))
                                        ->maxLength(10)
                                        ->placeholder('USD'),
                                    
                                    TextInput::make('timezone')
                                        ->label(__('admin.timezone'))
                                        ->maxLength(50)
                                        ->placeholder('UTC'),
                                    
                                    TextInput::make('language')
                                        ->label(__('admin.language'))
                                        ->maxLength(10)
                                        ->placeholder('en'),
                                    
                                    Toggle::make('maintenance_mode')
                                        ->label(__('admin.maintenance_mode'))
                                        ->inline(false),
                                ])
                                ->columns(2),
                        ]),

                    // Social Media Tab
                    Tab::make(__('admin.settings.tabs.social_media'))
                        ->icon('heroicon-o-share')
                        ->schema([
                            Section::make(__('admin.settings.sections.social_networks'))
                                ->schema([
                                    TextInput::make('facebook')
                                        ->label(__('admin.facebook'))
                                        ->url()
                                        ->maxLength(255)
                                        ->prefixIcon('heroicon-o-globe-alt'),
                                    
                                    TextInput::make('twitter')
                                        ->label(__('admin.twitter'))
                                        ->url()
                                        ->maxLength(255)
                                        ->prefixIcon('heroicon-o-globe-alt'),
                                    
                                    TextInput::make('instagram')
                                        ->label(__('admin.instagram'))
                                        ->url()
                                        ->maxLength(255)
                                        ->prefixIcon('heroicon-o-globe-alt'),
                                    
                                    TextInput::make('linkedin')
                                        ->label(__('admin.linkedin'))
                                        ->url()
                                        ->maxLength(255)
                                        ->prefixIcon('heroicon-o-globe-alt'),
                                    
                                    TextInput::make('youtube')
                                        ->label(__('admin.youtube'))
                                        ->url()
                                        ->maxLength(255)
                                        ->prefixIcon('heroicon-o-globe-alt'),
                                    
                                    TextInput::make('tiktok')
                                        ->label(__('admin.tiktok'))
                                        ->url()
                                        ->maxLength(255)
                                        ->prefixIcon('heroicon-o-globe-alt'),
                                    
                                    TextInput::make('snapchat')
                                        ->label(__('admin.snapchat'))
                                        ->url()
                                        ->maxLength(255)
                                        ->prefixIcon('heroicon-o-globe-alt'),
                                    
                                    TextInput::make('pinterest')
                                        ->label(__('admin.pinterest'))
                                        ->url()
                                        ->maxLength(255)
                                        ->prefixIcon('heroicon-o-globe-alt'),
                                ])
                                ->columns(2),

                            Section::make(__('admin.settings.sections.messaging_apps'))
                                ->schema([
                                    TextInput::make('whatsapp')
                                        ->label(__('admin.whatsapp'))
                                        ->tel()
                                        ->maxLength(255)
                                        ->prefixIcon('heroicon-o-phone'),
                                    
                                    TextInput::make('telegram')
                                        ->label(__('admin.telegram'))
                                        ->maxLength(255)
                                        ->prefixIcon('heroicon-o-chat-bubble-left-right'),
                                ])
                                ->columns(2),
                        ]),

                    // Legal Pages Tab
                    Tab::make(__('admin.settings.tabs.legal_pages'))
                        ->icon('heroicon-o-document-text')
                        ->schema([
                            Section::make(__('admin.settings.sections.policies'))
                                ->schema([
                                    RichEditor::make('terms_conditions')
                                        ->label(__('admin.terms_conditions'))
                                        ->columnSpanFull(),
                                    
                                    RichEditor::make('privacy_policy')
                                        ->label(__('admin.privacy_policy'))
                                        ->columnSpanFull(),
                                    
                                    RichEditor::make('refund_policy')
                                        ->label(__('admin.refund_policy'))
                                        ->columnSpanFull(),
                                ]),
                        ]),

                    // About Tab
                    Tab::make(__('admin.settings.tabs.about'))
                        ->icon('heroicon-o-information-circle')
                        ->schema([
                            Section::make(__('admin.settings.sections.about_content'))
                                ->schema([
                                    RichEditor::make('about_us')
                                        ->label(__('admin.about_us'))
                                        ->columnSpanFull(),
                                ]),
                        ]),

                    // SEO Tab
                    Tab::make(__('admin.settings.tabs.seo'))
                        ->icon('heroicon-o-magnifying-glass')
                        ->schema([
                            Section::make(__('admin.settings.sections.meta_tags'))
                                ->schema([
                                    SeoSection::translatableMetaFields(__('admin.settings.sections.meta_tags')),
                                    Textarea::make('meta_keywords')
                                        ->label(__('admin.meta_keywords'))
                                        ->rows(3)
                                        ->helperText(__('admin.comma_separated'))
                                        ->columnSpanFull(),
                                ]),
                            Section::make(__('strings.home_seo'))
                                ->schema([
                                    TranslatableTabs::make(__('strings.home_seo'))
                                        ->schema([
                                            RichEditor::make('home_meta_title')
                                                ->label(__('strings.home_meta_title'))
                                                ->columnSpanFull(),
                                            RichEditor::make('home_meta_description')
                                                ->label(__('strings.home_meta_description'))
                                                ->columnSpanFull(),
                                        ])
                                        ->columnSpanFull(),
                                ]),
                            Section::make(__('strings.image_alt'))
                                ->schema([
                                    TextInput::make('site_logo_alt')
                                        ->label(__('strings.site_logo_alt'))
                                        ->maxLength(255)
                                        ->translatableTabs(),
                                    TextInput::make('site_favicon_alt')
                                        ->label(__('strings.site_favicon_alt'))
                                        ->maxLength(255)
                                        ->translatableTabs(),
                                    TextInput::make('profile_one_alt')
                                        ->label(__('strings.profile_one_alt'))
                                        ->maxLength(255)
                                        ->translatableTabs(),
                                    TextInput::make('profile_two_alt')
                                        ->label(__('strings.profile_two_alt'))
                                        ->maxLength(255)
                                        ->translatableTabs(),
                                ])->columns(2),
                            Section::make(__('admin.social_meta_defaults'))
                                ->icon('heroicon-o-share')
                                ->schema(SocialSection::globalDefaultsFields())
                                ->columns(2)
                                ->columnSpanFull(),
                        ]),
                    Tab::make(__('admin.settings.tabs.analytics'))
                        ->icon('heroicon-o-chart-bar')
                        ->schema([
                            Section::make(__('admin.settings.sections.tracking_codes'))
                                ->schema([
                                    Textarea::make('google_analytics')
                                        ->label(__('admin.google_analytics'))
                                        ->rows(5)
                                        ->helperText(__('admin.paste_tracking_code'))
                                        ->columnSpanFull(),

                                    Textarea::make('facebook_pixel')
                                        ->label(__('admin.facebook_pixel'))
                                        ->rows(5)
                                        ->helperText(__('admin.paste_pixel_code'))
                                        ->columnSpanFull(),
                                ]),
                            Section::make(__('admin.settings.sections.custom_scripts'))
                                ->schema([
                                    Textarea::make('custom_head_scripts')
                                        ->label(__('admin.custom_head_scripts'))
                                        ->rows(6)
                                        ->helperText(__('admin.custom_head_scripts_help'))
                                        ->columnSpanFull(),
                                    Textarea::make('custom_body_scripts')
                                        ->label(__('admin.custom_body_scripts'))
                                        ->rows(6)
                                        ->helperText(__('admin.custom_body_scripts_help'))
                                        ->columnSpanFull(),
                                    Textarea::make('robots_txt')
                                        ->label(__('admin.robots_txt'))
                                        ->rows(8)
                                        ->helperText(__('admin.robots_txt_help'))
                                        ->columnSpanFull(),
                                ]),
                        ]),


                         // About Tab
                            Tab::make(__('admin.pages_control'))
                        ->icon('heroicon-o-home')
                        ->schema([
                            Section::make(__('admin.pages_control'))
                                ->schema([
                                    Toggle::make('web_site_toggle')
                                        ->label(__('admin.web_site')),
                                         Toggle::make('home_page_toggle')
                                        ->label(__('admin.home_page')),
                                    Toggle::make('about_page_toggle')
                                        ->label(__('admin.about_page')),
                                    Toggle::make('our_services_toggle')
                                        ->label(__('admin.our_services')),
                                    Toggle::make('our_projects_toggle')
                                        ->label(__('admin.our_projects')),
                                    Toggle::make('packages_toggle')
                                        ->label(__('admin.packages')),
                                    Toggle::make('our_products_toggle')
                                        ->label(__('admin.our_products')),
                                    Toggle::make('blogs_toggle')
                                        ->label(__('admin.blogs')),
                                ])->columns(3),
                        ]),
                ])
                ->columnSpanFull(),
        ])
        ->model($this->record)
        ->statePath('data');
}

    protected function fillForms(): void
    {
        $data = $this->record->attributesToArray();
        $this->form->fill($data);
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('admin.save_settings'))
                ->submit('submit'),
        ];
    }

    public function submit(): void
    {
        try {
            $data = $this->form->getState();
            $this->record->update($data);

            if (isset($data['home_meta_title']) || isset($data['home_meta_description'])) {
                SeoSetting::query()->updateOrCreate(
                    ['page_key' => 'home'],
                    [
                        'meta_title' => $data['home_meta_title'] ?? null,
                        'meta_description' => $data['home_meta_description'] ?? null,
                    ]
                );
            }
        } catch (Halt $exception) {
            return;
        }

        Notification::make()
            ->success()
            ->title(__('admin.updated_successfully'))
            ->send();
    }
}