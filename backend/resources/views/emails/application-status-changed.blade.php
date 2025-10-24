<!DOCTYPE html>
<html>
<head>
    <title>Application Status Updated</title>
</head>
<body>
    <h2>Your Application Status Has Changed</h2>
    <p>Dear {{ $application->student->name ?? 'Student' }},</p>
    <p>Your application for the offer "{{ $application->offer->title ?? 'Offer' }}" has been updated.</p>
    <p>New Status: <strong>{{ $newStatus }}</strong></p>
    <p>Thank you for your interest!</p>
    <p>Best regards,<br>Stage Management Team</p>
</body>
</html>