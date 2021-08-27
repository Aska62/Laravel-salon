<p>{{ $user->salon->owner->owner_name }}さま</p>

<p>お世話になっております。</p>
<p>みんなのサロン運営事務局です。</p>

<p>{{ $user->salon->name }}の月分会費についてご連絡です。</p>
<p>{{ $user->name }}様（id: {{ $user->id }}）の会費引き落としを試みましたが、失敗しました。</p>

<p>1週間以内に{{ $user->name }}様よりお支払いが確認できない場合は、事務局までお問い合わせください。</p>

<p>サロンURL</p>
<a href="{{ $user->salon->facebook }}">{{ $user->salon->facebook }}</a>
