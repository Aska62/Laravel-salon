@extends('layouts.default')
@section('content')

<!-- content -->
<div class="content-wrapper">

    <!-- コンテンツヘッダ -->
    <section class="content-header">
        <h2 class="content-lead">{{ $user }}さん、{{ $salon_name }}へようこそ！</h2>
        <p class="user-welcome-msg">ご登録いただいたメールアドレスに確認メールを送信しました。</p>
        <p class="user-welcome-msg">月会費は、毎月1日に自動請求となります。</p>
        <a href="{{ route('user.home')}}">
            <button type="button" class="btn user_welcome-btn to-home-btn">みんなのサロン トップへ</button>
        </a>
        {{-- <h3>支払い方法の登録</h3>
        カード名義人 <input id="card-holder-name" type="text">

        <!-- Stripe要素のプレースホルダ -->
        <div id="card-element"></div>

        <button id="card-button" data-secret="{{ $intent->client_secret }}">
            支払い方法を登録する
        </button>

        <form method="post"
            action="{{ route('user.addPayment', ['salon_name' => $salon_name, 'user_id' => $user_id] ) }}"
            id="updateForm"
        >
            @csrf
            <input type="hidden" name="payment_method">
            <input type="hidden" name="user_id" value="{{$user_id}}">
        </form>
        <script src="https://js.stripe.com/v3/"></script>
        <script>
            const stripe = Stripe('{{ env('STRIPE_KEY') }}');

            const elements = stripe.elements();
            const cardElement = elements.create('card');

            cardElement.mount('#card-element');

            const cardHolderName = document.getElementById('card-holder-name');
            const cardButton = document.getElementById('card-button');
            const clientSecret = cardButton.dataset.secret;

            cardButton.addEventListener('click', async (e) => {
                const { setupIntent, error } = await stripe.confirmCardSetup(
                    clientSecret, {
                        payment_method: {
                            card: cardElement,
                            billing_details: { name: cardHolderName.value }
                        }
                    }
                );

                if (error) {
                    alert(error.message);
                } else {
                    // クレジットカードの登録に成功したので、Laravel側にトークンをPostする
                    const updateForm = document.getElementById('updateForm');
                    updateForm.payment_method.value = setupIntent.payment_method;
                    updateForm.submit();
                }
            });

        </script>
        {{-- <a href="{{ route('user.home')}}">
            <button type="button" class="btn user_welcome-btn to-home-btn">みんなのサロン トップへ</button>
        </a> --}}
    </section>
</div>
@endsection

@section('script')
<script>

</script>
@endsection
