@extends('layouts.system')
@section('content')

<!-- content -->
<div class="content-wrapper">
    <!-- コンテンツヘッダ -->
    <section class="content-header">
        <h2 class="content-lead">管理画面</h2>
    </section>
    <section class="system__top-content">
        <h3 class="system__page-header">オーナー一覧</h3>
        <p class="system__page-lead">総数：{{ count($owners) }}名</p>
        <form action="{{route('system.output')}}" method="get" class="system-csv">
            <button type="submit" class="btn system_csv-btn" id="csv-btn">今月のデータをCSV出力</button>
        </form>
        <table class="system__owners-table">
            <tr class="table-head">
                <th>アカウント名</th>
                <th>総ユーザー数</th>
                <th>停止・退会</th>
            </tr>
            @foreach($owners as $owner)
            <tr>
                <td class="table-owner">{{ $owner->owner_name }}</td>
                <td class="table-users">{{ $owner->countFollwers() }}名</td>
                <td class="table-deleted">{{ $owner->deleted_at?? '-' }}</td>
            </tr>
            @endforeach
        </table>
        <ul class="system__owners-table-mb">
            @foreach($owners as $owner)
                <li class="owners-table-elem-mb">
                    <h4 class="mb-table_owner-name">{{ $owner->id }}. {{ $owner->owner_name }}</h4>
                    <div>
                        <p class="mb-table_info"><span>総ユーザー数 </span>{{ $owner->countFollwers() }}名</p>
                        <p class="mb-table_info"><span>停止・退会 </span>{{ $owner->deleted_at?? '-' }}</p>
                    </div>
                </li>
            @endforeach
        </ul>
    </section>
</div>
@endsection

@section('script')
<script>

</script>
@endsection
