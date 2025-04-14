@component('mail::layout')
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            {{ config('app.name') }}
        @endcomponent
    @endslot

    # Reply to Your Inquiry

    Hello {{ $inquiry->name }},

    Here's our response to your inquiry:

    @component('mail::panel')
        {!! nl2br(e($reply)) !!}
    @endcomponent

    If you have any further questions, please don't hesitate to contact us.

    Thanks,<br>
    {{ config('app.name') }}

    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        @endcomponent
    @endslot
@endcomponent
