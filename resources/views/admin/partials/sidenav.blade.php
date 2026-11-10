@php
    /*
    | Badge counts come from a single cached query (App\Lib\SidebarCounter) shared
    | by the view composer in AppServiceProvider, so nothing here queries the
    | database. $sidebarCounts is keyed by the slugs that class defines.
    */
    $counts = $sidebarCounts ?? [];
    $count = fn($key) => (int) ($counts[$key] ?? 0);
@endphp

<aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div class="d-flex align-items-center">
            <a href="{{ route('admin.dashboard') }}" class="d-inline-flex align-items-center">
                <img src="{{ siteLogo() }}"
                    alt="{{ __(gs('site_name')) }}" style="max-height: 38px; width: auto; max-width: 175px; object-fit: contain;">
            </a>
        </div>
        <div class="toggle-icon ms-auto">
            <i class="bi bi-list"></i>
        </div>
    </div>

    <ul class="metismenu sidebar__menu-main" id="menu">

        {{-- ---------------------------------------------------------------- --}}
        <li class="sidebar--menu {{ menuActive('admin.dashboard') }}">
            <a href="{{ route('admin.dashboard') }}">
                <div class="parent-icon"><i class="bi bi-speedometer2"></i></div>
                <div class="menu-title">@lang('Dashboard')</div>
            </a>
        </li>

        {{-- ----------------------------- REQUESTS ------------------------- --}}
        <li class="menu-label">@lang('Requests')</li>

        <li class="sidebar--menu {{ menuActive('admin.quote_request*') }}">
            <a href="{{ route('admin.quote_request.index') }}">
                <div class="parent-icon"><i class="bi bi-chat-square-quote"></i></div>
                <div class="menu-title">@lang('Quote Requests')</div>
                @if ($count('quote_request'))
                    <span class="badge bg-danger rounded-pill ms-auto">{{ $count('quote_request') }}</span>
                @endif
            </a>
        </li>

        {{-- ----------------------------- CATALOGUE ------------------------ --}}
        <li class="menu-label">@lang('Catalogue')</li>

        <li class="sidebar--menu {{ menuActive('admin.service*') }}">
            <a href="{{ route('admin.service.index') }}">
                <div class="parent-icon"><i class="bi bi-grid-3x3-gap"></i></div>
                <div class="menu-title">@lang('Services Catalog')</div>
            </a>
        </li>

        <li class="sidebar--menu {{ menuActive('admin.project*') }}">
            <a href="{{ route('admin.project.index') }}">
                <div class="parent-icon"><i class="bi bi-briefcase"></i></div>
                <div class="menu-title">@lang('Case Studies / Work')</div>
            </a>
        </li>

        {{-- <li class="sidebar--menu {{ menuActive('admin.country*') }}">
            <a href="{{ route('admin.country.index') }}">
                <div class="parent-icon"><i class="bi bi-globe-americas"></i></div>
                <div class="menu-title">@lang('Countries')</div>
            </a>
        </li> --}}

        {{-- ------------------------------ CONTENT ------------------------- --}}
        <li class="menu-label">@lang('Content')</li>

        <li class="sidebar--menu {{ menuActive(['admin.frontend.manage.pages*', 'admin.frontend.manage.section*']) }}">
            <a href="{{ route('admin.frontend.manage.pages') }}">
                <div class="parent-icon"><i class="bi bi-file-earmark-text"></i></div>
                <div class="menu-title">@lang('Manage Pages')</div>
            </a>
        </li>

        <li class="sidebar--menu sidebar--dropdown {{ menuActive('admin.frontend.sections*') }}">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-layout-text-window-reverse"></i></div>
                <div class="menu-title">@lang('Manage Section')</div>
            </a>
            <ul>
                @php
                    $lastSegment = collect(request()->segments())->last();
                @endphp
                @foreach (getPageSections(true) as $k => $secs)
                    @if ($secs['builder'])
                        <li class="{{ $lastSegment == $k ? 'mm-active' : '' }}">
                            <a href="{{ route('admin.frontend.sections', $k) }}">
                                <i class="bi bi-square"></i>{{ __($secs['name']) }}
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </li>

        {{-- ------------------------------- PEOPLE ------------------------- --}}
        {{-- <li class="menu-label">@lang('People')</li>

        <li class="sidebar--menu sidebar--dropdown {{ menuActive('admin.users*') }}">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-people"></i></div>
                <div class="menu-title">@lang('Manage Users')</div>
                @if ($emailUnverifiedUsersCount || $mobileUnverifiedUsersCount)
                    <span class="red__notify"></span>
                @endif
            </a>
            <ul>
                <li class="{{ menuActive('admin.users.all') }}">
                    <a href="{{ route('admin.users.all') }}">
                        <i class="bi bi-person-lines-fill"></i>@lang('All Users')
                    </a>
                </li>
                <li class="{{ menuActive('admin.users.active') }}">
                    <a href="{{ route('admin.users.active') }}">
                        <i class="bi bi-person-check"></i>@lang('Active Users')
                    </a>
                </li>
                <li class="{{ menuActive('admin.users.banned') }}">
                    <a href="{{ route('admin.users.banned') }}">
                        <i class="bi bi-person-dash"></i>@lang('Banned Users')
                    </a>
                </li>
                <li class="{{ menuActive('admin.users.email.unverified') }}">
                    <a href="{{ route('admin.users.email.unverified') }}">
                        <i class="bi bi-envelope-exclamation"></i>@lang('Email Unverified')
                        @if ($emailUnverifiedUsersCount)
                            <span class="badge bg-danger rounded-pill ms-auto">{{ $emailUnverifiedUsersCount }}</span>
                        @endif
                    </a>
                </li>
                <li class="{{ menuActive('admin.users.mobile.unverified') }}">
                    <a href="{{ route('admin.users.mobile.unverified') }}">
                        <i class="bi bi-phone-vibrate"></i>@lang('Mobile Unverified')
                        @if ($mobileUnverifiedUsersCount)
                            <span class="badge bg-danger rounded-pill ms-auto">{{ $mobileUnverifiedUsersCount }}</span>
                        @endif
                    </a>
                </li>
            </ul>
        </li> --}}

        <li class="sidebar--menu {{ menuActive('admin.subscriber*') }}">
            <a href="{{ route('admin.subscriber.index') }}">
                <div class="parent-icon"><i class="bi bi-envelope-paper"></i></div>
                <div class="menu-title">@lang('Subscribers')</div>
            </a>
        </li>

        <li class="sidebar--menu sidebar--dropdown {{ menuActive('admin.support*') }}">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-headset"></i></div>
                <div class="menu-title">@lang('Customer Support')</div>
                @if ($pendingSupportCount)
                    <span class="red__notify"></span>
                @endif
            </a>
            <ul>
                <li class="{{ menuActive('admin.support.pending') }}">
                    <a href="{{ route('admin.support.pending') }}">
                        <i class="bi bi-hourglass-split"></i>@lang('Pending Support')
                        @if ($pendingSupportCount)
                            <span class="badge bg-danger rounded-pill ms-auto">{{ $pendingSupportCount }}</span>
                        @endif
                    </a>
                </li>
                <li class="{{ menuActive('admin.support.answered') }}">
                    <a href="{{ route('admin.support.answered') }}">
                        <i class="bi bi-reply"></i>@lang('Answered Support')
                    </a>
                </li>
                <li class="{{ menuActive('admin.support.closed') }}">
                    <a href="{{ route('admin.support.closed') }}">
                        <i class="bi bi-archive"></i>@lang('Closed Support')
                    </a>
                </li>
                <li class="{{ menuActive('admin.support.index') }}">
                    <a href="{{ route('admin.support.index') }}">
                        <i class="bi bi-inboxes"></i>@lang('All Support')
                    </a>
                </li>
            </ul>
        </li>


        {{-- --------------------------- AI HELP CENTER ---------------------- --}}
        <li class="menu-label">@lang('AI Help Center')</li>

        <li
            class="sidebar--menu sidebar--dropdown {{ menuActive(['admin.assistant.insights', 'admin.assistant.queries*', 'admin.assistant.conversations*', 'admin.assistant.providers*', 'admin.assistant.knowledge*']) }}">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-chat-dots"></i></div>
                <div class="menu-title">{{ __('Assistant') }}</div>
                @if ($count('assistant_attention'))
                    <span class="red__notify"></span>
                @endif
            </a>
            <ul>
                <li class="{{ menuActive('admin.assistant.insights') }}">
                    <a href="{{ route('admin.assistant.insights') }}">
                        <i class="bi bi-graph-up"></i>@lang('Insights')
                    </a>
                </li>
                <li class="{{ menuActive('admin.assistant.queries.index') }}">
                    <a href="{{ route('admin.assistant.queries.index') }}">
                        <i class="bi bi-question-circle"></i>@lang('Visitor Questions')
                    </a>
                </li>
                <li class="{{ menuActive('admin.assistant.conversations*') }}">
                    <a href="{{ route('admin.assistant.conversations.index') }}">
                        <i class="bi bi-chat-left-text"></i>@lang('Conversations')
                    </a>
                </li>
                <li class="{{ menuActive('admin.assistant.queries.unanswered') }}">
                    <a href="{{ route('admin.assistant.queries.unanswered') }}">
                        <i class="bi bi-patch-exclamation"></i>@lang('Content Gaps')
                        @if ($count('assistant_unanswered'))
                            <span
                                class="badge bg-danger rounded-pill ms-auto">{{ $count('assistant_unanswered') }}</span>
                        @endif
                    </a>
                </li>
                <li class="{{ menuActive('admin.assistant.knowledge') }}">
                    <a href="{{ route('admin.assistant.knowledge') }}">
                        <i class="bi bi-database"></i>@lang('Knowledge Base')
                    </a>
                </li>
                <li class="{{ menuActive('admin.assistant.providers*') }}">
                    <a href="{{ route('admin.assistant.providers.index') }}">
                        <i class="bi bi-cpu"></i>@lang('AI Providers')
                    </a>
                </li>
            </ul>
        </li>

        {{-- ------------------------------- SYSTEM ------------------------- --}}
        <li class="menu-label">@lang('System')</li>

        <li class="sidebar--menu sidebar--dropdown {{ menuActive('admin.report*') }}">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-file-earmark-bar-graph"></i></div>
                <div class="menu-title">@lang('Report')</div>
            </a>
            <ul>
                <li class="{{ menuActive('admin.report.login.history') }}">
                    <a href="{{ route('admin.report.login.history') }}">
                        <i class="bi bi-box-arrow-in-right"></i>@lang('Login History')
                    </a>
                </li>
                <li class="{{ menuActive('admin.report.notification.history') }}">
                    <a href="{{ route('admin.report.notification.history') }}">
                        <i class="bi bi-bell-fill"></i>@lang('Notification History')
                    </a>
                </li>
            </ul>
        </li>

        <li class="sidebar--menu sidebar--dropdown {{ menuActive('admin.setting.notification*') }}">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-bell"></i></div>
                <div class="menu-title">@lang('Notification Setting')</div>
            </a>
            <ul>
                <li class="{{ menuActive('admin.setting.notification.global') }}">
                    <a href="{{ route('admin.setting.notification.global') }}">
                        <i class="bi bi-layout-wtf"></i>@lang('Global Template')
                    </a>
                </li>
                <li class="{{ menuActive('admin.setting.notification.templates') }}">
                    <a href="{{ route('admin.setting.notification.templates') }}">
                        <i class="bi bi-files"></i>@lang('Notification Templates')
                    </a>
                </li>
                <li class="{{ menuActive('admin.setting.notification.email') }}">
                    <a href="{{ route('admin.setting.notification.email') }}">
                        <i class="bi bi-envelope-at"></i>@lang('System Email')
                    </a>
                </li>
                <li class="{{ menuActive('admin.setting.notification.sms') }}">
                    <a href="{{ route('admin.setting.notification.sms') }}">
                        <i class="bi bi-chat-dots"></i>@lang('SMS Setting')
                    </a>
                </li>
            </ul>
        </li>

        <li
            class="sidebar--menu sidebar--dropdown {{ menuActive(['admin.setting.index', 'admin.setting.system*', 'admin.setting.cookie', 'admin.setting.logo.icon', 'admin.setting.custom.css', 'admin.extensions*', 'admin.language*', 'admin.seo', 'admin.setting.sitemap', 'admin.setting.robots', 'admin.maintenance.mode']) }}">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-gear"></i></div>
                <div class="menu-title">@lang('Settings')</div>
            </a>
            <ul>
                <li class="{{ menuActive('admin.setting.index') }}">
                    <a href="{{ route('admin.setting.index') }}">
                        <i class="bi bi-sliders"></i>@lang('General Setting')
                    </a>
                </li>
                <li class="{{ menuActive('admin.setting.system.configuration') }}">
                    <a href="{{ route('admin.setting.system.configuration') }}">
                        <i class="bi bi-toggles"></i>@lang('System Configuration')
                    </a>
                </li>
                <li class="{{ menuActive('admin.setting.logo.icon') }}">
                    <a href="{{ route('admin.setting.logo.icon') }}">
                        <i class="bi bi-image"></i>{{ __('Logo & Favicon') }}
                    </a>
                </li>
                <li class="{{ menuActive('admin.seo') }}">
                    <a href="{{ route('admin.seo') }}">
                        <i class="bi bi-search"></i>{{ __('SEO & Verification') }}
                    </a>
                </li>
                <li class="{{ menuActive('admin.setting.sitemap') }}">
                    <a href="{{ route('admin.setting.sitemap') }}">
                        <i class="bi bi-diagram-3"></i>{{ __('Sitemap Manager') }}
                    </a>
                </li>
                <li class="{{ menuActive('admin.setting.robots') }}">
                    <a href="{{ route('admin.setting.robots') }}">
                        <i class="bi bi-robot"></i>{{ __('Robots.txt') }}
                    </a>
                </li>
                <li class="{{ menuActive('admin.extensions*') }}">
                    <a href="{{ route('admin.extensions.index') }}">
                        <i class="bi bi-puzzle"></i>@lang('Extensions')
                    </a>
                </li>
                <li class="{{ menuActive('admin.language*') }}">
                    <a href="{{ route('admin.language.manage') }}">
                        <i class="bi bi-translate"></i>@lang('Language')
                    </a>
                </li>
                <li class="{{ menuActive('admin.maintenance.mode') }}">
                    <a href="{{ route('admin.maintenance.mode') }}">
                        <i class="bi bi-cone-striped"></i>@lang('Maintenance Mode')
                    </a>
                </li>
                <li class="{{ menuActive('admin.setting.cookie') }}">
                    <a href="{{ route('admin.setting.cookie') }}">
                        <i class="bi bi-shield-check"></i>@lang('GDPR Cookie')
                    </a>
                </li>
                <li class="{{ menuActive('admin.setting.custom.css') }}">
                    <a href="{{ route('admin.setting.custom.css') }}">
                        <i class="bi bi-code-slash"></i>@lang('Custom CSS')
                    </a>
                </li>
            </ul>
        </li>

    </ul>
</aside>
