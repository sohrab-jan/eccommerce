<x-mail::message>
# Order Placed Successfully!
Thank you for your order. your order id is:{{$order->id}}

The body of your message.

<x-mail::button :url="$url">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
