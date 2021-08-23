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
        <form action="{{route('system.output')}}" method="get">
            {{-- <input type="hidden" name="owners[]" value="{{$owners}}"> --}}
            <button type="submit" class="btn system_csv-btn">今月のデータをCSV出力</button>
        </form>
        <table class="system__owners-table">
            <tr class="table-head">
                <th>アカウント名</th>
                <th>ユーザー数</th>
                <th>停止・退会</th>
            </tr>
            @foreach($owners as $owner)
            <tr>
                <td class="table-owner">{{ $owner->owner_name }}</td>
                <td class="table-users">{{ $owner->countFollwers() }}名</td>
                <td class="table-deleted">{{ $owner->deleted_at?? '-' }}</td>
            </tr>
            @endforeach
            @if(count($owners) >= 20)
            <tr>
                <th>アカウント名</th>
                <th>参加者数</th>
                <th>停止・退会</th>
            </tr>
            @endif
        </table>
    </section>
</div>
@endsection

@section('script')
<script>

</script>
@endsection
