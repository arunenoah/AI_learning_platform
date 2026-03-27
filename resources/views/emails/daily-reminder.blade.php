<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daily Reminder</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 10px 10px; }
        .streak-box { background: white; padding: 20px; border-radius: 10px; text-align: center; margin: 20px 0; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .streak-number { font-size: 48px; font-weight: bold; color: #ff6b35; }
        .cta-button { display: inline-block; background: #667eea; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔥 Don't Break Your Streak!</h1>
        </div>
        <div class="content">
            <p>Hi {{ $user->name }},</p>
            
            <div class="streak-box">
                <p style="margin: 0; color: #666;">Your current streak</p>
                <p class="streak-number">{{ $streakDays }} days</p>
                <p style="color: #888; font-size: 14px;">Keep it going!</p>
            </div>

            <p>You haven't visited today. Just a few minutes of learning can keep your streak alive and help you reach your goals!</p>

            <p style="text-align: center; margin: 30px 0;">
                <a href="{{ url('/dashboard') }}" class="cta-button">Continue Learning →</a>
            </p>

            <p style="color: #888; font-size: 14px;">
                Tip: Completing a resource gives you 25 points, and starting a learning path gives you 10 points!
            </p>
        </div>
        <div class="footer">
            <p>You're receiving this email because you have an active learning streak.</p>
            <p><a href="{{ url('/settings') }}">Update email preferences</a></p>
        </div>
    </div>
</body>
</html>
