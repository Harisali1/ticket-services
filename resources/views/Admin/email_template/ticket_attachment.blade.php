<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $subject ?? 'Document' }}</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f6f8; font-family: Arial, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center" style="padding:30px 0;">
            <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:6px; overflow:hidden;">

                <!-- Header -->
                <tr>
                    <td style="background:#0d6efd; padding:20px; text-align:center;">
                        <h2 style="color:#ffffff; margin:0;">
                            {{ config('app.name') }}
                        </h2>
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td style="padding:30px;">
                        <h3 style="margin-top:0;">Hello {{ $name ?? 'User' }},</h3>

                        <p style="color:#555; font-size:14px; line-height:1.6;">
                            Please find the attached PDF document as requested.
                        </p>

                        <p style="color:#555; font-size:14px; line-height:1.6;">
                            If you have any questions, feel free to contact us.
                        </p>

                        <p style="margin-top:30px; color:#555;">
                            Regards,<br>
                            <strong>{{ config('app.name') }}</strong>
                        </p>
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="background:#f1f3f5; padding:15px; text-align:center; font-size:12px; color:#888;">
                        © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>
