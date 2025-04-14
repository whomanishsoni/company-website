<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Contact Email</title>
</head>

<body
    style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f9f9f9;">
    <table cellpadding="0" cellspacing="0" width="100%" style="background-color: #f9f9f9; padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0"
                    style="background-color: #ffffff; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); overflow: hidden;">
                    <tr style="background-color: #4a90e2; color: white;">
                        <td style="padding: 30px; text-align: center;">
                            <h1 style="margin: 0; font-size: 24px;">📩 New Contact Inquiry</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 30px;">
                            <p style="font-size: 16px;"><strong>Name:</strong> {{ $name }}</p>
                            <p style="font-size: 16px;"><strong>Email:</strong> {{ $email }}</p>
                            <p style="font-size: 16px;"><strong>Subject:</strong> {{ $subject }}</p>
                            <hr style="margin: 20px 0; border: none; border-top: 1px solid #eee;">
                            <p style="font-size: 16px;"><strong>Message:</strong></p>
                            <p style="font-size: 16px; color: #333; line-height: 1.6;">
                                {{ $messageText }}
                            </p>
                        </td>
                    </tr>
                    <tr style="background-color: #f1f1f1;">
                        <td style="padding: 20px; text-align: center; font-size: 14px; color: #999;">
                            This message was sent from your website contact form.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
