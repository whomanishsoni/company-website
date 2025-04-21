<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reply to Your Inquiry</title>
    <style>
        body {
            margin: 0;
            padding: 20px;
            background-color: #f4f6f8;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }

        .email-wrapper {
            max-width: 640px;
            margin: auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.06);
            border: 1px solid #e0e0e0;
        }

        .email-header {
            background-color: #1d4ed8;
            padding: 20px;
            text-align: center;
        }

        .email-header a {
            color: #ffffff;
            font-size: 22px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
        }

        .email-body {
            padding: 30px;
        }

        .email-body h1 {
            font-size: 20px;
            margin-bottom: 20px;
            color: #1f2937;
        }

        .email-body p {
            line-height: 1.6;
            margin-bottom: 16px;
            font-size: 15px;
        }

        .email-panel {
            background-color: #f9fafb;
            border-left: 4px solid #2563eb;
            padding: 15px 20px;
            font-size: 15px;
            margin: 20px 0;
            white-space: pre-line;
            color: #374151;
        }

        .email-footer {
            background-color: #f1f5f9;
            text-align: center;
            font-size: 13px;
            padding: 20px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
        }

        .signature {
            margin-top: 30px;
        }

        .signature strong {
            font-size: 16px;
            color: #1f2937;
        }
    </style>
</head>

<body>
    <div class="email-wrapper">
        <!-- Header -->
        <div class="email-header">
            <a href="{{ config('app.url') }}">{{ config('app.name') }}</a>
        </div>

        <!-- Body -->
        <div class="email-body">
            <h1>Reply to Your Inquiry</h1>

            <p>Dear <strong>{{ $inquiry->name }}</strong>,</p>

            <p>Thank you for reaching out to us. Please find our response below:</p>

            <div class="email-panel">
                {!! nl2br(e($reply)) !!}
            </div>

            <p>If you have any further questions, feel free to reply to this message or contact our support team.</p>

            <div class="signature">
                <p>Warm regards,</p>
                <p><strong>{{ config('app.name') }}</strong></p>
            </div>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</body>

</html>
