<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payment Approved – Divine Travel</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f6f8;font-family:Arial, Helvetica, sans-serif;">

<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <title>Payment Approved – Divine Travel</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f6f8;font-family:Arial, Helvetica, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f8;padding:20px 0;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:6px;overflow:hidden;">

                <!-- Header -->
                <tr>
                    <td style="background:#0d6efd;color:#ffffff;padding:20px;text-align:center;">
                        <h2 style="margin:0;">Payment Approved ✅</h2>
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td style="padding:25px;color:#333;">
                        <p style="font-size:15px;">
                            Dear <strong>{{ $user->name ?? 'Agency Partner' }}</strong>,
                        </p>

                        <p style="font-size:14px;line-height:1.6;">
                            We are pleased to inform you that your payment has been <strong>successfully approved</strong> by the administrator at <strong>Divine Travel</strong>.
                        </p>

                        <!-- Payment Summary -->
                        <table width="100%" cellpadding="0" cellspacing="0" style="margin-top:15px;border-collapse:collapse;">
                            <tr>
                                <td style="padding:10px;border:1px solid #dee2e6;font-size:14px;">
                                    Approved Amount
                                </td>
                                <td style="padding:10px;border:1px solid #dee2e6;font-size:14px;font-weight:bold;text-align:right;">
                                    {{ number_format($approvedAmount) }}
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:10px;border:1px solid #dee2e6;font-size:14px;">
                                    Paid Amount
                                </td>
                                <td style="padding:10px;border:1px solid #dee2e6;font-size:14px;font-weight:bold;text-align:right;color:#198754;">
                                    {{ number_format($paidAmount) }}
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:10px;border:1px solid #dee2e6;font-size:14px;">
                                    Remaining Balance
                                </td>
                                <td style="padding:10px;border:1px solid #dee2e6;font-size:14px;font-weight:bold;text-align:right;color:#dc3545;">
                                    {{ number_format($remainingAmount) }}
                                </td>
                            </tr>
                        </table>

                        <p style="font-size:13px;color:#555;margin-top:15px;">
                            📌 Please ensure that the remaining balance is cleared on time to avoid any service disruption.
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


</body>
</html>
