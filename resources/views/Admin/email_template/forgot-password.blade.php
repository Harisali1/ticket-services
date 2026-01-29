<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>
<body style="background:#f4f6f8;padding:30px;font-family:Arial">

<table width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center">
            <table width="600" style="background:#ffffff;border-radius:10px;padding:30px;">
                
                <tr>
                    <td align="center">
                        <img src="{{ asset('images/logo.jpg') }}" width="80" style="border-radius:50%">
                        <h2 style="margin:15px 0;color:#0f172a">
                            Password Reset Request
                        </h2>
                    </td>
                </tr>

                <tr>
                    <td style="color:#334155;font-size:14px;">
                        <p>Hello <strong>{{ $user->name }}</strong>,</p>

                        <p>
                            You requested to reset your password. Click the button below
                            to create a new password.
                        </p>

                        <p style="text-align:center;margin:30px 0;">
                            <a href="{{ $resetUrl }}"
                               style="background:#2563eb;color:#fff;
                               padding:12px 25px;text-decoration:none;
                               border-radius:30px;font-weight:600;">
                                Reset Password
                            </a>
                        </p>

                        <p>
                            If you did not request a password reset, please ignore this email.
                        </p>

                        <p style="margin-top:30px;">
                            Regards,<br>
                            <strong>Divine Travel Team</strong>
                        </p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>
