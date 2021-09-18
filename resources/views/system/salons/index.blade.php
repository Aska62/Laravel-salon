@extends('layouts.system')
@section('content')

<!-- content -->
<div class="content-wrapper">
    <!-- コンテンツヘッダ -->
    <section class="content-header">
        <h2 class="content-lead">管理画面</h2>
    </section>
    <section class="system__top-content">
        <h3 class="system__page-header">サロン一覧</h3>
        <p class="system__page-lead">総数：{{ count($salons) }}</p>
        <form action="{{route('system.output')}}" method="get" class="system-csv">
            <button type="submit" class="btn system_csv-btn" id="csv-btn">今月のデータをCSV出力</button>
        </form>
    </section>
    <section class="content">
        <div class="user_paginate-top">{{ $salons->links() }}</div>
        <ul class="salon-list_container">
            @foreach($salons as $salon)
                <a href="{{ route('user.detail', ['salon_name' => $salon->name, 'id' => $salon->id]) }}">
                    <li class="salon-list-item">
                        <img src="{{ asset('public/salonImages/thumb-'.$salon->image) }}"
                            class="list_salon-image"
                            alt="{{$salon->name}}"
                        >
                        <div class="salon-list_text-wrapper">
                            <a href="{{ route('user.detail', ['salon_name' => $salon->name, 'id' => $salon->id]) }}">
                                <h3>{{ $salon->name }}</h3>
                            </a>
                            <p>By {{ $salon->owner->owner_name }}</p>
                            <p>会員数 {{ $salon->countUsers() }}名 / {{ $salon->max_members }}名</p>
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
