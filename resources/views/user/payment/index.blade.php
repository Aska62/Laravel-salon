@extends('layouts.default')
@section('content')

<!-- content -->
<div class="content-wrapper">

    <!-- コンテンツヘッダ -->
    <section class="content-header">
        <h2 class="content-lead payment-lead">{{ $salon->name }} 初月会費のお支払い</h2>
        <p>{{ $user_name }}様</p>
        {{-- <p>{{ $user_email }}</p> --}}
        <p>{{date("Y")}}年{{date("m")}}月分：{{ $salon->fee }}円</p>
        <div class="payment_button-wrapper">
            <button class="btn back-btn" onclick="history.back()">戻る</button>
            <script src="https://js.stripe.com/v3/"></script>
            <form action="{{ route('user.submit', ['salon_name' => $salon->name]) }}"
                method="POST"
                class="pay-btn-wrapper"
                id="payment-form"
            >
                {{ csrf_field() }}
                <script
                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                    data-key="{{ env('STRIPE_KEY') }}"
                    data-amount="{{ $salon->fee }}"
                    data-name="{{ $salon->name }} 初月会費"
                    data-label="初月会費を払う"
                    data-description="{{date("Y")}}年{{date("m")}}月分"
                    data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                    data-locale="auto"
                    data-currency="JPY"
                    >
                </script>
                <input type="hidden" name="payment_method">
                <input type="hidden" name="salon_id" value="{{ $salon->id }}">
                <input type="hidden" name="user_name" value="{{ $user_name }}">
                <input type="hidden" name="user_email" value="{{ $user_email }}">
            </form>
        </div>
    </section>
</div>
@endsection

@section('script')
<script>
</script>
@endsection
