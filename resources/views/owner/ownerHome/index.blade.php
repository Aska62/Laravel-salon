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
        <a href="{{ route('owner.create')}}" class="create-btn-link">
            <button class="btn salon-create-btn" type="button">新しいサロンを登録</button>
        </a>
        <form
            action="{{ route('owner.home') }}"
            method="get"
            class="owner__search-form"
        >
            {{ csrf_field() }}
            <label for="email" class="search-label">オーナー様のメールアドレスでサロンを検索</label>
            <div class="search-container">
                <input
                    type="text"
                    name="email"
                    id="email"
                    class="keyword-input"
                    placeholder="アドレスを入力"
                    value="{{$email ? $email : ''}}"
                >
                <button type="submit" class="btn search-btn">検索</button>
            </div>
            <p class="error-msg error-msg_search">{{ session('message') }}</p>
        </form>
    </section>
    @if($email)
        <section class="content owner_home-search-content">
            @if($salons)
                @foreach($salons as $salon)
                    <div class="search-result-elem">
                        <div class="search_salon-image-box">
                            <img src="{{ asset('public/salonImages/thumb-'.$salon->image) }}"
                                class="search_salon-image"
                                alt="{{$salon->name}}"
                            >
                        </div>
                        <div class="search_salon-info-box">
                            <h3>{{ $salon->name }}</h3>
                            <p>会員数 {{ $salon->countUsers() }} / {{$salon->max_members }}名</p>
                            <p>{{ $salon->abstract }}</p>
                        </div>
                    </div>
                @endforeach
            @endif
        </section>
    @endif
</div>
@endsection

@section('script')
<script>

</script>
@endsection
