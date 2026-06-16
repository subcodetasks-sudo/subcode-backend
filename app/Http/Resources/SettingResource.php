<?php

namespace App\Http\Resources;

use App\Http\Resources\Concerns\WithSeoMeta;
use App\Models\SeoSetting;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    use WithSeoMeta;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'site_name' => $this->site_name,
            'site_logo' => $this->imageWithAlt($this->site_logo, $this->site_logo_alt),
            'site_favicon' => $this->imageWithAlt($this->site_favicon, $this->site_favicon_alt),
            'site_description' => $this->site_description,
            'site_email' => $this->site_email,
            'site_phone_ar' => $this->site_phone,
            'site_phone_tr' => $this->phone_tr,
            'site_phone_sar' => $this->phone_sar,
            'site_address' => $this->site_address,
            'profile_one' => $this->imageWithAlt($this->profile_one, $this->profile_one_alt),
            'profile_two' => $this->imageWithAlt($this->profile_two, $this->profile_two_alt),
            'pages_options' => [
                'web_site' => $this->web_site_toggle ?? false,
                'home_page' => $this->home_page_toggle ?? false,
                'about_page' => $this->about_page_toggle ?? false,
                'our_services' => $this->our_services_toggle ?? false,
                'our_works' => $this->our_projects_toggle ?? false,
                'packages' => $this->packages_toggle ?? false,
                'our_products' => $this->our_products_toggle ?? false,
                'blogs' => $this->blogs_toggle ?? false,
            ],
            'social_media' => [
                'facebook' => $this->facebook,
                'twitter' => $this->twitter,
                'instagram' => $this->instagram,
                'linkedin' => $this->linkedin,
                'youtube' => $this->youtube,
                'tiktok' => $this->tiktok,
                'snapchat' => $this->snapchat,
                'pinterest' => $this->pinterest,
                'whatsapp' => $this->whatsapp,
                'telegram' => $this->telegram,
            ],
            'policies' => [
                'terms_conditions' => $this->terms_conditions,
                'privacy_policy' => $this->privacy_policy,
                'refund_policy' => $this->refund_policy,
                'about_us' => $this->about_us,
                'contact_info' => $this->contact_info,
            ],
            'seo' => [
                'meta_title' => $this->meta_title,
                'meta_keywords' => $this->meta_keywords,
                'meta_description' => $this->meta_description,
                'home_meta_title' => $this->home_meta_title,
                'home_meta_description' => $this->home_meta_description,
                'google_analytics' => $this->google_analytics,
                'facebook_pixel' => $this->facebook_pixel,
                'social_meta' => [
                    'og_default_image' => $this->og_default_image ? url('storage/'.$this->og_default_image) : null,
                    'twitter_site' => $this->twitter_site,
                    'twitter_card_default' => $this->twitter_card_default,
                    'facebook_app_id' => $this->facebook_app_id,
                ],
                'pages' => SeoSettingResource::collection(SeoSetting::all()),
            ],
            'scripts' => [
                'custom_head_scripts' => $this->custom_head_scripts,
                'custom_body_scripts' => $this->custom_body_scripts,
                'robots_txt' => $this->robots_txt,
                'google_analytics' => $this->google_analytics,
                'facebook_pixel' => $this->facebook_pixel,
            ],
            'system' => [
                'currency' => $this->currency,
                'timezone' => $this->timezone,
                'language' => $this->language,
                'maintenance_mode' => $this->maintenance_mode,
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
