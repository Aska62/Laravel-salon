<h1>{{ $user->name }}さん、{{ $user->salon->name }}へようこそ！</h1>

<p>サロンにアクセスし、お楽しみください。</p>
<a href="{{ $user->salon->facebook }}">{{ $user->salon->facebook }}</a>
