<table>
    <thead>
    <tr>
        <th>@lang('Id')</th>
        <th>@lang('Name')</th>
        <th>@lang('Username ')</th>
        <th>@lang('Email')</th>
        <th>@lang('Country code')</th>
        <th>@lang('Mobile')</th>
        <th>@lang('Position Title')</th>
        <th>@lang('Address')</th>
        <th>@lang('Created At')</th>
        <th>@lang('Status')</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->username }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->country_code }}</td>
            <td>{{ $user->mobile }}</td>
            <td>{{ $user->position_title }}</td>
            <td>
                @if($user->address)
                    @php
                        $addresses = json_decode($user->address, true);
                    @endphp

                    @if(is_array($addresses))
                        @foreach ($addresses as $u_address)
                            {{ $u_address }},
                        @endforeach
                    @endif
                @endif
            </td>
            <td>{{ $user->created_at->format('d-m-Y') }}</td>
            <td>@if($user->status == 1) Active @endif </td>
        </tr>
    @endforeach
    </tbody>
</table>
