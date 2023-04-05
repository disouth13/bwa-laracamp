@component('mail::message')
# Register Camp: {{ $checkout->Camp->title }}

Hi, {{ $checkout->User->name }}
<br>
<table class="table table-sm">
    <thead>
        <tr>
            <td>Name Camp</td>
            <td>Date</td>
            <td>Price</td>
            <td>Status Payment</td>
        </tr>
        <tbody>
            <tr>
                <td>{{ $checkout->Camp->title }}</td>
                <td>{{ $checkout->date()->format('d M, y') }}</td>
                <td>{{ $checkout->Camp->price }}</td>
                <td>{{ $checkout->status_paid }}</td>
            </tr>
        </tbody>
    </thead>
</table>
Thank you for register on <b>{{ $checkout->Camp->title }}</b>, please see you payment instruction by click the button below.


@component('mail::button', ['url' => route('user-checkout-invoice', $checkout->id)])
Get Invoice
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
