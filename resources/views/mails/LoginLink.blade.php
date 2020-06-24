<p>Hallo, {{ $user->name }}</p>
<p>This your login link : <a href="{{ route('auth.login.token') }}?rememberMe={{ $user->remember_token }}">click here</a></p>
<p>Thank you</p>