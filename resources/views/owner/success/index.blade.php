@extends('layouts.default')
@section('content')

<!-- content -->
<div class="content-wrapper">

    <!-- コンテンツヘッダ -->
    <section class="content-header">
        <h2 class="content-lead">サロン登録が完了しました！</h2>
        <div class="owners__success_btn-container">
            <a href="{{ route('owner.home')}}">
                <button type="button" class="btn to-owner-top-btn">トップへ</button>
            </a>
            <a href="{{ route('owner.create')}}">
                <button type="button" class="btn to-create-salon-btn">もうひとつ登録する</button>
            </a>
        </div>
    </section>
</div>
@endsection

@section('script')
<script>

</script>
@endsection
