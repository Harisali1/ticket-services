<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reset Your Password - Divine Travel</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f6f8;font-family:Arial, Helvetica, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f8;padding:20px 0;">
    <tr>
        <td align="center">

            <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:6px;overflow:hidden;">
                
                <!-- Header -->
                <tr>
                    <td style="background:#0d6efd;color:#ffffff;padding:20px;text-align:center;">
                        <h2 style="margin:0;">Password Reset Request 🔐</h2>
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td style="padding:25px;color:#333;">
                        <p style="font-size:15px;">
                            Hello <strong>{{ $user->name ?? 'User' }}</strong>,
                        </p>

                        <p style="font-size:14px;line-height:1.6;">
                            We received a request to reset your password for your <strong>Divine Travel</strong> account.
                        </p>

                        <p style="font-size:14px;line-height:1.6;">
                            Click the button below to reset your password:
                        </p>

                        <!-- Button -->
                        <p style="text-align:center;margin:30px 0;">
                            <a href="{{ $resetUrl }}"
                               style="background:#0d6efd;color:#ffffff;text-decoration:none;
                                      padding:12px 25px;border-radius:4px;
                                      font-size:14px;display:inline-block;">
                                Reset Password
                            </a>
                        </p>

                        <p style="font-size:13px;color:#555;line-height:1.6;">
                            This password reset link will expire in <strong>60 minutes</strong>.
                        </p>

                        <p style="font-size:13px;color:#555;line-height:1.6;">
                            If you did not request a password reset, no further action is required.
                        </p>

                        <p style="font-size:13px;margin-top:25px;">
                            Regards,<br>
                            <strong>Divine Travel Team</strong>
                        </p>
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="background:#f1f1f1;text-align:center;padding:12px;font-size:12px;color:#777;">
                        © {{ date('Y') }} Divine Travel. All rights reserved.
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>
