<div style="font-family: Arial, sans-serif; padding: 20px; background-color: #f4f4f4; border-radius: 8px; max-width: 600px; margin: 0 auto;">
    <div style="background-color: #ffffff; padding: 20px; border-radius: 8px;">
        <h3 style="color: #333333; font-size: 18px; margin-bottom: 10px;">New Price Update</h3>
        <h2 style="color: #4CAF50; font-size: 32px; margin-top: 0;">{{ $advertisement->price }}</h2>
        <p style="color: #555555; font-size: 16px; line-height: 1.5;">
            The price of <a href="{{ $advertisement->url }}" style="color: #1E90FF; text-decoration: none;">your ad</a> has changed.
        </p>
        <a href="{{ $advertisement->url }}" style="display: inline-block; padding: 10px 20px; background-color: #4CAF50; color: #ffffff; text-decoration: none; border-radius: 5px; margin-top: 20px;">
            View Your Ad
        </a>
    </div>
</div>
