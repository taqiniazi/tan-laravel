<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | TAN Network</title>
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #08121f;
            font-family: Arial, sans-serif;
            color: #e5eefc;
        }
        .card {
            width: min(100%, 420px);
            background: rgba(16, 24, 40, 0.95);
            border: 1px solid rgba(91, 140, 255, 0.25);
            border-radius: 18px;
            padding: 32px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.35);
        }
        h1 {
            margin-top: 0;
            font-size: 28px;
            margin-bottom: 8px;
        }
        p {
            color: #9fb2d8;
            line-height: 1.5;
        }
        .status {
            background: rgba(34, 197, 94, 0.12);
            border: 1px solid rgba(34, 197, 94, 0.25);
            color: #86efac;
            padding: 12px 14px;
            border-radius: 10px;
            margin-bottom: 18px;
        }
        .error {
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.25);
            color: #fca5a5;
            padding: 12px 14px;
            border-radius: 10px;
            margin-bottom: 18px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            margin-top: 16px;
            font-weight: 600;
        }
        input {
            width: 100%;
            box-sizing: border-box;
            padding: 14px 16px;
            border-radius: 12px;
            border: 1px solid #2d3d5b;
            background: #0b1526;
            color: #fff;
            outline: none;
        }
        input:focus {
            border-color: #5b8cff;
            box-shadow: 0 0 0 3px rgba(91, 140, 255, 0.15);
        }
        button {
            width: 100%;
            margin-top: 24px;
            padding: 14px 16px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #5b8cff, #7c4dff);
            color: white;
            font-weight: 700;
            font-size: 15px;
            cursor: pointer;
        }
        .hint {
            margin-top: 16px;
            font-size: 13px;
            color: #7e93b9;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>Reset your password</h1>
        <p>Enter a new password for your TAN Network account.</p>

        @if (session('status'))
            <div class="status">{{ session('status') }}</div>
            <div class="success-actions" style="margin-top: 24px; text-align: center;">
                <p style="color: #86efac; font-weight: bold; font-size: 18px; margin-bottom: 8px;">✓ Password Updated</p>
                <p style="color: #9fb2d8; font-size: 14px; margin-bottom: 24px;">Your password has been successfully reset. You can now close this tab and return to the App to sign in.</p>
            </div>
        @else
            @if ($errors->any())
                <div class="error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email', $email) }}" required>

                <label for="password">New Password</label>
                <input id="password" type="password" name="password" required minlength="6">

                <label for="password_confirmation">Confirm New Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required minlength="6">

                <button type="submit">Update Password</button>
            </form>
        @endif

        <div class="hint">After updating, return to the app and sign in again.</div>
    </div>
</body>
</html>