@extends('layouts.default')
@section('content')

<!-- content -->
<div class="content-wrapper">

    <!-- コンテンツヘッダ -->
    <section class="content-header">
        <div class="user__top-image"
        alt="ようこそみんなのサロンへ"
        >
    </section>
    <!-- メインコンテンツ -->
    <section class="content users__home-content">
        <p class="user-home-lead">あなたにぴったりのオンラインサロンを見つけましょう！</p>
        <div class="user_paginate-top">{{ $salons->links() }}</div>
        <ul class="salon-list_container">
            @foreach($salons as $salon)
                <a href="{{ route('user.detail', ['name' => $salon->name, 'id' => $salon->id]) }}">
                    <li class="salon-list-item">
                        <img src="{{ asset('public/salonImages/thumb-'.$salon->image) }}"
                            class="list_salon-image"
                            alt="{{$salon->name}}"
                        >
                        <div class="salon-list_text-wrapper">
                            <a href="{{ route('user.detail', ['name' => $salon->name, 'id' => $salon->id]) }}">
                                <h3>{{ $salon->name }}</h3>
                            </a>
                            <p>By {{ $salon->owner->owner_name }}</p>
                            <p>会員数 {{ $salon->countUsers() }}名 / {{ $salon->max_members }}名</p>
                            @if($salon->countUsers() >= $salon->max_members)
                                <p class="notice_salon-full">会員数が定員に達しているため、新規入会は受け付けておりません。</p>
                            @endif
                        </div>
                    </li>
                </a>
            @endforeach
        </ul>
        <div class="paginate_bottom paginate_bottom-user">
            {{ $salons->links() }}
        </div>
    </section>
</div>
@endsection

@section('script')
<script>

</script>
@endsection
