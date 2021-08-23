@extends('layouts.default')
@section('content')

<!-- content -->
<div class="content-wrapper">

    <!-- コンテンツヘッダ -->
    <section class="content-header">
        <h2 class="content-lead">新しいサロンを登録</h2>
    </section>
    <!-- メインコンテンツ -->
    <form
        action="{{ route('owner.submit') }}"
        method="post"
        enctype="multipart/form-data"
        class="content owner__create-content"
    >
        {{ csrf_field() }}
        <div class="salon-form_owner-wrapper">
            <h3>オーナー情報</h3>
            <div class="salon-form-elem">
                <label for="owner_name" class="salon-form-label">名前：</label>
                <div class="owner_input-field-box">
                    <input
                    type="text"
                        id="owner_name"
                        class="input-lg"
                        name="owner_name"
                        placeholder="入力してください"
                        value="{{ old('owner_name')?? '' }}"
                    >
                    @if($errors->has('owner_name'))
                        <span class="error-msg">{{ $errors->first('owner_name')}}</span>
                    @endif
                </div>
            </div>
            <div class="salon-form-elem">
                <label for="email" class="salon-form-label">メールアドレス：</label>
                <div class="owner_input-field-box">
                    <input
                        type="email"
                        id="email"
                        class="input-lg"
                        name="email"
                        placeholder="入力してください"
                        value="{{ old('email')?? '' }}"
                    >
                    @if($errors->has('email'))
                        <span class="error-msg">{{ $errors->first('email')}}</span>
                    @endif
                </div>
            </div>
            <div class="salon-form-elem">
                <label for="profile" class="salon-form-label">プロフィール：</label>
                <div class="owner_input-field-box">
                    <textarea
                        id="profile"
                        name="profile"
                        placeholder="入力してください"
                    >{{ old('profile')?? '' }}</textarea>
                    @if($errors->has('profile'))
                        <span class="error-msg">{{ $errors->first('profile')}}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="salon-form_salon-wrapper">
            <h3>サロン情報</h3>
            <div class="salon-form-elem">
                <label for="name" class="salon-form-label">サロン名：</label>
                <div class="owner_input-field-box">
                    <input
                        type="text"
                        id="name"
                        class="input-lg"
                        name="name"
                        placeholder="入力してください"
                        value="{{ old('name')?? '' }}"
                    >
                    @if($errors->has('name'))
                        <span class="error-msg">{{ $errors->first('name')}}</span>
                    @endif
                </div>
            </div>
            <div class="salon-form-elem">
                <label for="fee" class="salon-form-label">月会費：</label>
                <div class="owner_input-field-box">
                    <input
                        type="int"
                        id="fee"
                        class="input-sm"
                        name="fee"
                        placeholder="0"
                        value="{{ old('fee')?? '' }}"
                    >
                    <label for="fee" class="label-counter">円</label>
                    @if($errors->has('fee'))
                        <span class="error-msg">{{ $errors->first('fee')}}</span>
                    @endif
                </div>
            </div>
            <div class="salon-form-elem">
                <label for="abstract" class="salon-form-label">概要：</label>
                <div class="owner_input-field-box">
                    <textarea
                        id="abstract"
                        name="abstract"
                        placeholder="入力してください"
                    >{{ old('abstract')?? '' }}</textarea>
                    @if($errors->has('abstract'))
                        <span class="error-msg">{{ $errors->first('abstract')}}</span>
                    @endif
                </div>
            </div>
            <div class="salon-form-elem">
                <label for="recommend" class="salon-form-label">こんな人におすすめ：</label>
                <div class="owner_input-field-box">
                    <textarea
                        id="recommend"
                        name="recommend"
                        placeholder="入力してください"
                    >{{ old('recommend')?? '' }}</textarea>
                    @if($errors->has('recommend'))
                        <span class="error-msg">{{ $errors->first('recommend')}}</span>
                    @endif
                </div>
            </div>
            <div class="salon-form-elem">
                <label for="benefit" class="salon-form-label">特典：</label>
                <div class="owner_input-field-box">
                    <textarea
                        id="benefit"
                        name="benefit"
                        placeholder="入力してください"
                    >{{ old('benefit')?? '' }}</textarea>
                    @if($errors->has('benefit'))
                        <span class="error-msg">{{ $errors->first('benefit')}}</span>
                    @endif
                </div>
            </div>
            <div class="salon-form-elem">
                <label for="facebook" class="salon-form-label">facebook URL：</label>
                <div class="owner_input-field-box">
                    <input
                        type="text"
                        id="facebook"
                        class="input-lg"
                        name="facebook"
                        placeholder="入力してください"
                        value="{{ old('facebook')?? '' }}"
                    >
                    @if($errors->has('facebook'))
                        <span class="error-msg">{{ $errors->first('facebook')}}</span>
                    @endif
                </div>
            </div>
            <div class="salon-form-elem">
                <label for="max_members" class="salon-form-label">最大会員数：</label>
                <div class="owner_input-field-box">
                    <input
                        type="int"
                        id="max_members"
                        class="input-sm"
                        name="max_members"
                        placeholder="0"
                        value="{{ old('max_members')?? '' }}"
                    >
                    <label for="max_members" class="label-counter">人</label>
                    @if($errors->has('max_members'))
                        <span class="error-msg">{{ $errors->first('max_members')}}</span>
                    @endif
                </div>
            </div>
            <div class="salon-form-elem">
                <label for="image" class="salon-form-label">画像：</label>
                <div class="owner_input-field-box">
                    <input
                        type="file"
                        id="image"
                        class="image-input"
                        name="image"
                        accept="image/png, image/jpeg, image/jpg"
                        value="{{ old('image')?? '' }}"
                    >
                    <p class="image-input-notice">※横長の画像をおすすめします</p>
                    <div id="preview"></div>
                    @if($errors->has('image'))
                        <span class="error-msg">{{ $errors->first('image')}}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="owner__btn-wrapper">
            {{-- <button type="button" class="btn back-btn" onclick="history.back()">戻る</button> --}}
            <button type="submit" class="btn salon-register-btn">登録</button>
        </div>
    </form>
</div>
@endsection

@section('script')
<script>
    const iamgeInput = document.getElementById("image");
    const preview = document.getElementById("preview");

    iamgeInput.addEventListener('change', (e) => {
        showPreview(e);
    });

    const showPreview = (e) => {
        const previewImg = document.getElementById("previewImg");
        const file = e.target.files[0];
        const reader = new FileReader();

        if(previewImg != null) {
            console.log("I am going to remove old image");
            preview.removeChild(previewImg);
        }
        reader.onload = () => {
            const img = document.createElement("img");
            img.setAttribute("src", reader.result);
            img.setAttribute("id", "previewImg");
            preview.appendChild(img);
        };
        reader.readAsDataURL(file);
    }

</script>
@endsection
