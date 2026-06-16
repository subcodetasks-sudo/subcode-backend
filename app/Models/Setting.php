<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Setting extends Model
{
  use HasTranslations;
  use SoftDeletes;

  protected $fillable = [
    'site_name',
    'site_logo',
    'site_favicon',
    'site_logo_alt',
    'site_favicon_alt',
    'site_description',
    'site_email',
    'site_phone',
    'phone_tr',
    'phone_sar',
    'site_address',

    'facebook',
    'twitter',
    'instagram',
    'linkedin',
    'youtube',
    'tiktok',
    'snapchat',
    'pinterest',
    'whatsapp',
    'telegram',

    'terms_conditions',
    'privacy_policy',
    'refund_policy',
    'about_us',
    'contact_info',

    'meta_title',
    'meta_keywords',
    'meta_description',
    'home_meta_title',
    'home_meta_description',
    'og_default_image',
    'twitter_site',
    'twitter_card_default',
    'facebook_app_id',
    'custom_head_scripts',
    'custom_body_scripts',
    'robots_txt',
    'google_analytics',
    'facebook_pixel',

    'currency',
    'timezone',
    'language',
    'maintenance_mode',

    'profile_one',
    'profile_two',
    'profile_one_alt',
    'profile_two_alt',

    'web_site_toggle',
    'home_page_toggle',
    'about_page_toggle',
    'our_services_toggle',
    'our_projects_toggle',
    'packages_toggle',
    'our_products_toggle',
    'blogs_toggle',

  ];

  public array $translatable = [
    'meta_title',
    'meta_description',
    'home_meta_title',
    'home_meta_description',
    'site_logo_alt',
    'site_favicon_alt',
    'profile_one_alt',
    'profile_two_alt',
  ];
}
