<?php

use App\Constants\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Search engine verification tags and marketing pixels, managed from
     * Admin > Extensions and rendered by resources/views/partials/head_scripts.blade.php.
     * They are seeded disabled with placeholder keys.
     */
    public function up(): void
    {
        foreach ($this->extensions() as $extension) {
            DB::table('extensions')->updateOrInsert(
                ['act' => $extension['act']],
                array_merge($extension, [
                    'shortcode' => json_encode($extension['shortcode']),
                    'status' => Status::DISABLE,
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }

    public function down(): void
    {
        DB::table('extensions')
            ->whereIn('act', array_column($this->extensions(), 'act'))
            ->delete();
    }

    private function extensions(): array
    {
        return [
            [
                'act' => 'google-site-verification',
                'name' => 'Google Search Console',
                'description' => 'Paste the content value of the HTML tag Google Search Console gives you when you verify site ownership.',
                'image' => 'google_analytics.png',
                'support' => 'na',
                'script' => '<meta name="google-site-verification" content="{{verification_code}}">',
                'shortcode' => [
                    'verification_code' => ['title' => 'Verification Code', 'value' => '------'],
                ],
            ],
            [
                'act' => 'bing-site-verification',
                'name' => 'Bing Webmaster Tools',
                'description' => 'Paste the content value of the msvalidate.01 meta tag from Bing Webmaster Tools.',
                'image' => null,
                'support' => 'na',
                'script' => '<meta name="msvalidate.01" content="{{verification_code}}">',
                'shortcode' => [
                    'verification_code' => ['title' => 'Verification Code', 'value' => '------'],
                ],
            ],
            [
                'act' => 'yandex-site-verification',
                'name' => 'Yandex Webmaster',
                'description' => 'Paste the content value of the yandex-verification meta tag from Yandex Webmaster.',
                'image' => null,
                'support' => 'na',
                'script' => '<meta name="yandex-verification" content="{{verification_code}}">',
                'shortcode' => [
                    'verification_code' => ['title' => 'Verification Code', 'value' => '------'],
                ],
            ],
            [
                'act' => 'google-tag-manager',
                'name' => 'Google Tag Manager',
                'description' => 'Container ID from Google Tag Manager, in the format GTM-XXXXXXX. The noscript fallback is added automatically.',
                'image' => 'google_analytics.png',
                'support' => 'na',
                'script' => '<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({"gtm.start":new Date().getTime(),event:"gtm.js"});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!="dataLayer"?"&l="+l:"";j.async=true;j.src="https://www.googletagmanager.com/gtm.js?id="+i+dl;f.parentNode.insertBefore(j,f);})(window,document,"script","dataLayer","{{container_id}}");</script>',
                'shortcode' => [
                    'container_id' => ['title' => 'Container ID (GTM-XXXXXXX)', 'value' => 'GTM-XXXXXXX'],
                ],
            ],
            [
                'act' => 'facebook-pixel',
                'name' => 'Facebook Pixel',
                'description' => 'Meta (Facebook) Pixel ID from Events Manager.',
                'image' => 'Facebook.png',
                'support' => 'na',
                'script' => '<script>!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version="2.0";n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,"script","https://connect.facebook.net/en_US/fbevents.js");fbq("init","{{pixel_id}}");fbq("track","PageView");</script>',
                'shortcode' => [
                    'pixel_id' => ['title' => 'Pixel ID', 'value' => '------'],
                ],
            ],
            [
                'act' => 'linkedin-insight',
                'name' => 'LinkedIn Insight Tag',
                'description' => 'Partner ID from your LinkedIn Campaign Manager Insight Tag.',
                'image' => null,
                'support' => 'na',
                'script' => '<script>_linkedin_partner_id="{{partner_id}}";window._linkedin_data_partner_ids=window._linkedin_data_partner_ids||[];window._linkedin_data_partner_ids.push(_linkedin_partner_id);(function(l){if(!l){window.lintrk=function(a,b){window.lintrk.q.push([a,b])};window.lintrk.q=[]}var s=document.getElementsByTagName("script")[0];var b=document.createElement("script");b.type="text/javascript";b.async=true;b.src="https://snap.licdn.com/li.lms-analytics/insight.min.js";s.parentNode.insertBefore(b,s);})(window.lintrk);</script>',
                'shortcode' => [
                    'partner_id' => ['title' => 'Partner ID', 'value' => '------'],
                ],
            ],
            [
                'act' => 'tiktok-pixel',
                'name' => 'TikTok Pixel',
                'description' => 'Pixel ID from TikTok Ads Manager.',
                'image' => null,
                'support' => 'na',
                'script' => '<script>!function(w,d,t){w.TiktokAnalyticsObject=t;var ttq=w[t]=w[t]||[];ttq.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie"];ttq.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);ttq.instance=function(t){for(var e=ttq._i[t]||[],n=0;n<ttq.methods.length;n++)ttq.setAndDefer(e,ttq.methods[n]);return e};ttq.load=function(e,n){var i="https://analytics.tiktok.com/i18n/pixel/events.js";ttq._i=ttq._i||{};ttq._i[e]=[];ttq._i[e]._u=i;ttq._t=ttq._t||{};ttq._t[e]=+new Date;ttq._o=ttq._o||{};ttq._o[e]=n||{};var o=document.createElement("script");o.type="text/javascript";o.async=!0;o.src=i+"?sdkid="+e+"&lib="+t;var a=document.getElementsByTagName("script")[0];a.parentNode.insertBefore(o,a)};ttq.load("{{pixel_id}}");ttq.page();}(window,document,"ttq");</script>',
                'shortcode' => [
                    'pixel_id' => ['title' => 'Pixel ID', 'value' => '------'],
                ],
            ],
        ];
    }
};
