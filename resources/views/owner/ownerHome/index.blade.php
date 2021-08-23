@extends('layouts.default')
@section('content')

<!-- content -->
<div class="content-wrapper">

    <!-- コンテンツヘッダ -->
    <section class="content-header">
        <h2 class="content-lead">サロンオーナー様向けページ</h2>
    </section>
    <!-- メインコンテンツ -->
    <section class="content owner__home-content">
        <a href="{{ route('owner.create')}}">
            <button class="btn" type="button">新しいサロンを登録</button>
        </a>
        <form action="{{ route('owner.home') }}" method="get">
            {{ csrf_field() }}
            <label for="email">ご登録メールアドレスでご自分のサロンを検索</label>
            <input
                type="text"
                name="email"
                id="email"
                class="keyword-input"
                placeholder="アドレスを入力"
                value="{{$email ? $email : ''}}"
            >
            <button type="submit" class="btn search-btn">検索</button>
        </form>
    </section>
    @if($email)
        <section class="content owner_home-search-content">
            @if($salons)
                @foreach($salons as $salon)
                    <h3>{{ $salon->name }}</h3>
                    <p></p>
                @endforeach
            @else
                <p>マッチするアドレスが登録されていません</p>
            @endif
        </section>
    @endif
</div>
@endsection

@section('script')
<script>

</script>
@endsection
