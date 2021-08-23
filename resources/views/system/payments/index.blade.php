@extends('layouts.system')
@section('content')

<!-- content -->
<div class="content-wrapper">
    <!-- コンテンツヘッダ -->
    <section class="content-header">
        <h2 class="content-lead">管理画面</h2>
    </section>
    <section class="system__top-content">
        <h3>支払い履歴</h3>
        <ul>
            @foreach($payments as $payment)
                <li>{{ substr($payment->payment_for, 0, 4) }}年{{ substr($payment->payment_for, 4, 2) }}月分</li>
                <li>総額{{ number_format($payment->total_amount) }}円</li>
                <li>支払者数{{ $payment->total_users }}人</li>
            @endforeach
        </ul>
    </section>
</div>
@endsection

@section('script')
<script>

</script>
@endsection
