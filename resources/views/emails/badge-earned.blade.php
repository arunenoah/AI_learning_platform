<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Badge Earned</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 10px 10px; }
        .badge-box { background: white; padding: 30px; border-radius: 10px; text-align: center; margin: 20px 0; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .badge-icon { font-size: 80px; margin-bottom: 10px; }
        .badge-name { font-size: 24px; font-weight: bold; color: #333; margin: 10px 0; }
        .badge-desc { color: #666; }
        .cta-button { display: inline-block; background: #667eea; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 Congratulations!</h1>
        </div>
        <div class="content">
            <p>Hi {{ $user->name }},</p>
            
            <p>You've earned a new badge!</p>

            <div class="badge-box">
                <div class="badge-icon">{{ $badge->icon }}</div>
                <div class="badge-name">{{ $badge->name }}</div>
                <div class="badge-desc">{{ $badge->description }}</div>
            </div>

            <p style="text-align: center; margin: 30px 0;">
                <a href="{{ url('/badges') }}" class="cta-button">View Your Badges →</a>
            </p>

            <p>Keep up the great work! You're making excellent progress on your learning journey.</p>
        </div>
        <div class="footer">
            <p>Keep learning and earn more badges!</p>
        </div>
    </div>
</body>
</html>
