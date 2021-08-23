@extends('layouts.default')
@section('content')

<!-- content -->
<div class="content-wrapper">

    <!-- コンテンツヘッダ -->
    <section class="content-header">
        <h2 class="content-lead">{{ $salon_name }}へようこそ！</h2>
        <p class="user-welcome-msg">ご登録いただいたメールアドレスに確認メールを送信しました。</p>
        <p>メールボックスをご確認ください。</p>
        <a href="{{ route('user.home')}}">
            <button type="button" class="btn user_welcome-btn to-home-btn">みんなのサロン トップへ</button>
        </a>
    </section>
</div>
@endsection

@section('script')
<script>

</script>
@endsection
