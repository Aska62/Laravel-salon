<p>{{ $user->name }}さま</p>

<p>お世話になっております。</p>
<p>みんなのサロン運営事務局です。</p>
<p><a href="{{ $user->salon->facebook }}">{{ $user->salon->name }}</a>の月会費のお支払いに失敗しました。</p>
<p>ご登録のお支払い情報をご確認ください。</p>

<p>サロンURL</p>
<a href="{{ $user->salon->facebook }}">{{ $user->salon->facebook }}</a>
