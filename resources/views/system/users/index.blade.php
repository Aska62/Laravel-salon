@extends('layouts.system')
@section('content')

<!-- content -->
<div class="content-wrapper">
    <!-- コンテンツヘッダ -->
    <section class="content-header">
        <h2 class="content-lead">管理画面</h2>
    </section>
    <section class="system__top-content">
        <h3>ユーザー一覧</h3>
        <p>総数：{{ $totalUserCount }}名</p>
        <p>アクティブユーザー: {{ count($activeUsers) }}名</p>
        <table>
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
        {{ $users->links() }}
    </section>
</div>
@endsection

@section('script')
<script>

</script>
@endsection
