<!DOCTYPE html>
<html>
<head>
    <title>Stage Progress Updated</title>
</head>
<body>
    <h2>Stage Progress Update</h2>
    <p>Dear {{ $stage->user->name ?? 'Student' }},</p>
    <p>Your stage progress for "{{ $stage->offer->title ?? 'Offer' }}" has been updated.</p>
    <p>Update: <strong>{{ $progress }}</strong></p>
    <p>Keep up the great work!</p>
    <p>Best regards,<br>Stage Management Team</p>
</body>
</html>