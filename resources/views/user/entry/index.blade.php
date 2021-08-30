@extends('layouts.default')
@section('content')

<!-- content -->
<div class="content-wrapper">

    <!-- コンテンツヘッダ -->
    <section class="content-header">
        <h2 class="content-lead">{{ $salon->name }}に入会する</h2>
        <ol class="entry-step-box" type="1">
            <p class="entry_step-lead">入会の流れ</p>
            <li class="entry-step">お名前とメールアドレスを入力し、「初月会費のお支払いへ」ボタンを押してください。</li>
            <li class="entry-step">次のページで、今月分の会費をカードにてお支払いいただきます。</li>
            <li class="entry-step">お支払い完了後、ご入力いただいたメールアドレスにサロン詳細をお送りします。</li>
        </ol>
    </section>
    <!-- メインコンテンツ -->
    <form action="{{ route('user.payment', ['salon_name' => $salon->name])}}"
        method="post"
        class="content users__entry-content"
    >
        {{ csrf_field() }}
        <div class="entry-input-wrapper">
            <div class="entry-input-box">
                <label for="name" class="entry-input-label">Facebook Name</label>
                <input
                    type="text"
                    name="name"
                    placeholder="入力してください"
                    value="{{ old('name')?? '' }}"
                    class="entry-input"
                >
            </div>
            @if($errors->has('name'))
                <span class="error-msg error-msg_entry">{{ $errors->first('name')}}</span>
            @endif
        </div>
        <div class="entry-input-wrapper">
            <div class="entry-input-box">
                <label for="email" class="entry-input-label">メールアドレス</label>
                <input
                    type="email"
                    name="email"
                    placeholder="入力してください"
                    value="{{ old('email')?? '' }}"
                    class="entry-input"
                >
            </div>
            <span class="error-msg error-msg_entry">{{ session('message') }}</span>
            @if($errors->has('email'))
                <span class="error-msg error-msg_entry">{{ $errors->first('email')}}</span>
            @endif
        </div>
        <input type="hidden" name="salon_id" value="{{ $salon->id }}">
        <input type="hidden" name="owner_id" value="{{ $salon->owner_id }}">
        <button type="submit" class="btn entry-submit-btn">初月会費のお支払いへ</button>
    </form>
</div>
@endsection

@section('script')
<script>
</script>
@endsection
