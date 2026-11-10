{{-- Rendered inside the "CRM & Campaigns" dropdown in admin.partials.sidenav. --}}

<li class="{{ menuActive('admin.category*') }}">
    <a href="javascript:;" class="has-arrow">
        <i class="bi bi-folder2-open"></i>@lang('Category')
    </a>
    <ul>
        <li>
            <a href="{{ route('admin.category.index') }}?type=EMAIL">
                <i class="bi bi-envelope-open"></i>@lang('Mail Category')
            </a>
        </li>
    </ul>
</li>

<li class="{{ menuActive('admin.contacts*') }}">
    <a href="javascript:;" class="has-arrow">
        <i class="bi bi-person-rolodex"></i>@lang('Contacts')
    </a>
    <ul>
        <li class="{{ menuActive('admin.contacts.email.index') }}">
            <a href="{{ route('admin.contacts.email.index') }}">
                <i class="bi bi-person-vcard"></i>@lang('Email Contacts')
            </a>
        </li>
        <li class="{{ menuActive('admin.contacts.sms.index') }}">
            <a href="{{ route('admin.contacts.sms.index') }}">
                <i class="bi bi-phone"></i>@lang('SMS Contacts')
            </a>
        </li>
    </ul>
</li>

<li class="{{ menuActive('admin.send-mail*') }}">
    <a href="javascript:;" class="has-arrow">
        <i class="bi bi-envelope"></i>@lang('Mailing')
    </a>
    <ul>
        <li class="{{ menuActive('admin.send-mail.index') }}">
            <a href="{{ route('admin.send-mail.index') }}">
                <i class="bi bi-send"></i>@lang('Send Mail')
            </a>
        </li>
        <li class="{{ menuActive('admin.send-mail.group') }}">
            <a href="{{ route('admin.send-mail.group') }}">
                <i class="bi bi-broadcast"></i>@lang('Group Send Mail')
            </a>
        </li>
        <li class="{{ menuActive('admin.send-mail.mail.history') }}">
            <a href="{{ route('admin.send-mail.mail.history') }}">
                <i class="bi bi-clock-history"></i>@lang('Mail History')
            </a>
        </li>
    </ul>
</li>

{{--
    The SMS half of this module was fully built - controllers, routes and views
    all present and working - but nothing in the panel ever linked to it, so no
    one could reach any of it without typing a URL. These mirror the Mailing and
    Campaign Config entries above one for one.
--}}
<li class="{{ menuActive(['admin.messaging*', 'admin.general-messaging*', 'admin.group.messaging*', 'admin.sms.history']) }}">
    <a href="javascript:;" class="has-arrow">
        <i class="bi bi-chat-dots"></i>@lang('Messaging')
    </a>
    <ul>
        <li class="{{ menuActive('admin.messaging.sendmessage') }}">
            <a href="{{ route('admin.messaging.sendmessage') }}">
                <i class="bi bi-send"></i>@lang('Send SMS')
            </a>
        </li>
        <li class="{{ menuActive('admin.general-messaging.sendmessage') }}">
            <a href="{{ route('admin.general-messaging.sendmessage') }}">
                <i class="bi bi-megaphone"></i>@lang('Send General SMS')
            </a>
        </li>
        <li class="{{ menuActive('admin.group.messaging.sendmessage') }}">
            <a href="{{ route('admin.group.messaging.sendmessage') }}">
                <i class="bi bi-broadcast"></i>@lang('Group Send SMS')
            </a>
        </li>
        <li class="{{ menuActive('admin.sms.history') }}">
            <a href="{{ route('admin.sms.history') }}">
                <i class="bi bi-clock-history"></i>@lang('SMS History')
            </a>
        </li>
    </ul>
</li>

<li class="{{ menuActive(['admin.setting.email', 'admin.setting.createEmail', 'admin.setting.edit.email', 'admin.setting.sms', 'admin.setting.edit.sms', 'admin.template*']) }}">
    <a href="javascript:;" class="has-arrow">
        <i class="bi bi-sliders2"></i>@lang('Campaign Config')
    </a>
    <ul>
        <li class="{{ menuActive(['admin.setting.email', 'admin.setting.createEmail', 'admin.setting.edit.email']) }}">
            <a href="{{ route('admin.setting.email') }}">
                <i class="bi bi-envelope-gear"></i>@lang('Sending Domains')
            </a>
        </li>
        <li class="{{ menuActive(['admin.setting.sms', 'admin.setting.edit.sms']) }}">
            <a href="{{ route('admin.setting.sms') }}">
                <i class="bi bi-phone-vibrate"></i>@lang('SMS Gateways')
            </a>
        </li>
        <li class="{{ menuActive('admin.template*') }}">
            <a href="{{ route('admin.template.index') }}">
                <i class="bi bi-file-earmark-code"></i>@lang('Mail Templates')
            </a>
        </li>
    </ul>
</li>
