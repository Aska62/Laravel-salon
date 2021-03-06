@extends('layouts.system')
@section('content')

<!-- content -->
<div class="content-wrapper">
    <!-- コンテンツヘッダ -->
    <section class="content-header">
        <h2 class="content-lead">管理画面</h2>
    </section>
    <section class="system__top-content">
        <h3 class="system__page-header">ユーザー一覧</h3>
        <form action="{{route('system.output')}}" method="get">
            <button type="submit" class="btn system_csv-btn csv-btn_users">今月のデータをCSV出力</button>
        </form>
        <div class="system__users-list-lead">
            <div class="users-list-total">
                <p class="users-list_num">総数：{{ $totalUserCount }}名</p>
                <p class="users-list_num">アクティブユーザー: {{ count($activeUsers) }}名</p>
            </div>
            {{ $users->links() }}
        </div>
        <table class="user-table">
            <tr>
                <th>アカウント名</th>
                <th>参加サロン</th>
                <th>停止・退会</th>
            </tr>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->salon->name }}</td>
                    <td>{{ $user->deleted_at?? ''}}</td>
                </tr>
            @endforeach
        </table>
        <ul class="system__owners-table-mb">
            @foreach($users as $user)
                <li class="owners-table-elem-mb">
                    <h4 class="mb-table_owner-name">{{ $user->id }}. {{ $user->name }}</h4>
                    <div>
                        <p class="mb-table_info"><span>サロン： </span>{{ $user->salon->name }}</p>
                        <p class="mb-table_info"><span>停止・退会 </span>{{ $user->deleted_at?? '-' }}</p>
                    </div>
                </li>
            @endforeach
        </ul>
        <div class="paginate_bottom">
            {{ $users->links() }}
        </div>
    </section>
</div>
@endsection

@section('script')
<script>

</script>
@endsection
