<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Agency Approved – Divine Travel</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f6f8;font-family:Arial, Helvetica, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f8;padding:20px 0;">
    <tr>
        <td align="center">

            <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:6px;overflow:hidden;">
                
                <!-- Header -->
                <tr>
                    <td style="background:#198754;color:#ffffff;padding:20px;text-align:center;">
                        <h2 style="margin:0;">Agency Approved ✅</h2>
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td style="padding:25px;color:#333;">
                        <p style="font-size:15px;">
                            Dear <strong>{{ $user->name ?? 'Agency Partner' }}</strong>,
                        </p>

                        <p style="font-size:14px;line-height:1.6;">
                            We are pleased to inform you that your agency has been <strong>successfully approved</strong> by the administrator at <strong>Divine Travel</strong>.
                        </p>

                        <p style="font-size:14px;line-height:1.6;">
                            You can now access your agency dashboard using the credentials below:
                        </p>

                        <p style="font-size:14px;background:#f8f9fa;padding:12px;border-radius:4px;">
                            <strong>Email:</strong> {{ $user->email }}<br>
                            <strong>Password:</strong> {{ $user->show_pass }}
                        </p>

                        <p style="font-size:13px;color:#555;">
                            🔐 For security reasons, please change your password immediately after logging in.
                        </p>

                        <p style="font-size:13px;margin-top:25px;">
                            Best regards,<br>
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
