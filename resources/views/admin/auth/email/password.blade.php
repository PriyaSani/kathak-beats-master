Click here to reset your password: <a href="{{ $link =Route('admin.auth.password.reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
