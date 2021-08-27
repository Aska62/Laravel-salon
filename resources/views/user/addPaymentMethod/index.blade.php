@extends('layouts.default')
@section('content')

<!-- content -->
<div class="content-wrapper">

    <!-- コンテンツヘッダ -->
    <section class="content-header">
        <h2 class="content-lead">お支払い情報の登録が完了しました。</h2>
        {{-- <h2 class="content-lead">{{ $salon_name }}へようこそ！</h2> --}}
        <p class="user-welcome-msg">月会費は、毎月1日に自動請求となります。</p>
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
