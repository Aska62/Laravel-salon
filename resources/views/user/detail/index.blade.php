@extends('layouts.default')
@section('content')

<!-- content -->
<div class="content-wrapper">
    <section class="content users__detail-top-content">
        <img
            src="{{ asset('public/salonImages/'.$salon->image) }}"
            alt="{{$salon->name}}"
            class="detail_salon-image"
        >
        @if($salon->countUsers() >= $salon->max_members)
            <p class="notice_salon-full salon-full_detail">会員数が定員に達しているため、新規入会は受け付けておりません。</p>
        @endif
        <h2 class="detail_salon-name">{{ $salon->name }}</h2>
        <p class="detail_owner-name">By {{ $salon->owner->owner_name }}</p>
        @if($salon->countUsers() < $salon->max_members)
            <form
                class="detail_top-button-box"
                action="{{ route('user.entry', ['name' => $salon->name ]) }}"
            >
                <input type="hidden" name="id" value="{{ $salon->id }}">
                <button type="submit" class="btn entry-btn">入会する</button>
            </form>
        @endif
    </section>
    <section class="content users__detail-abstract">
        <p>{{ $salon->abstract }}</p>
        <div class="detail-info-box">
            <p>会費： {{ $salon->fee }}円/1ヶ月</p>
            <p>会員数： {{ $salon->countUsers() }} 名 / {{ $salon->max_members }} 名</p>
        </div>
    </section>
    <section class="content users__detail-description">
        <div class="detail_recommend">
            <h3><i class="fa fa-solid fa-star"></i>こんな人にオススメ！</h3>
            <p>{{ $salon->recommend }}</p>
        </div>
        <div class="detail_benefit">
            <h3><i class="fa fa-solid fa-star"></i>参加特典</h3>
            <p>{{ $salon->benefit }}</p>
        </div>
    </section>
    <section class="content users__detail-owner">
        <h3><i class="fa fa-solid fa-star"></i>主催者について</h3>
        <p class="users__detail_owner-name">{{ $salon->owner->owner_name }}さん</p>
        <p class="users__detail_owner-prof">{{ $salon->owner->profile }}</p>
    </section>
    @if($salon->countUsers() >= $salon->max_members)
        <p class="notice_salon-full salon-full_detail">会員数が定員に達しているため、新規入会は受け付けておりません。</p>
    @endif
    <section class="content users__entry-button-section">
        <a href="{{ route('user.home') }}">
            <button type="button" class="btn to-home-btn">ホームへ戻る</button>
        </a>
        @if($salon->countUsers() < $salon->max_members)
            <form action="{{ route('user.entry', ['name' => $salon->name ]) }}">
                <input type="hidden" name="id" value="{{ $salon->id }}">
                <button type="submit" class="btn entry-btn entry-btn_center">入会する</button>
            </form>
        @endif
    </section>
</div>
@endsection

@section('script')
<script>
</script>
@endsection
