<h1>{{ $user->salon->name }}に新しい会員が参加しました！</h1>

Welcomeメッセージを送りましょう。
<h2>新会員名：{{ $user->name }}さん</h2>
<h3>メールアドレス：{{ $user->email }}</h3>
<p>{{ $user->salon->name }}の会員は全{{ $user->salon->user->count()}}名になりました。</p>

<p>サロンURL</p>
<a href="{{ $user->salon->facebook }}">{{ $user->salon->facebook }}</a>
