<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>New Contact Inquiry</title>
</head>

<body
    style="margin: 0; padding: 0; background-color: #f4f6f8; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

    <table cellpadding="0" cellspacing="0" width="100%" style="padding: 40px 0; background-color: #f4f6f8;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0"
                    style="background-color: #ffffff; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.06); overflow: hidden; border: 1px solid #e0e0e0;">

                    <!-- Header -->
                    <tr style="background-color: #1d4ed8; color: white;">
                        <td style="padding: 30px; text-align: center;">
                            <h1 style="margin: 0; font-size: 22px;">📩 New Contact Inquiry</h1>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 30px;">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="padding-bottom: 12px; font-size: 15px;"><strong>Name:</strong></td>
                                    <td style="padding-bottom: 12px; font-size: 15px; color: #374151;">
                                        {{ $name }}</td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom: 12px; font-size: 15px;"><strong>Email:</strong></td>
                                    <td style="padding-bottom: 12px; font-size: 15px; color: #374151;">
                                        {{ $email }}</td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom: 12px; font-size: 15px;"><strong>Subject:</strong></td>
                                    <td style="padding-bottom: 12px; font-size: 15px; color: #374151;">
                                        {{ $subject }}</td>
                                </tr>
                            </table>

                            <hr style="margin: 25px 0; border: none; border-top: 1px solid #e5e7eb;">

                            <p style="margin-bottom: 8px; font-size: 15px;"><strong>Message:</strong></p>
                            <div style="font-size: 15px; color: #374151; line-height: 1.6; white-space: pre-line;">
                                {{ $messageText }}
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr style="background-color: #f3f4f6;">
                        <td style="padding: 20px; text-align: center; font-size: 13px; color: #6b7280;">
                            This message was sent from your website contact form.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>

</html>
