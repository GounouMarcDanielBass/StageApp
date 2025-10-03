<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nouveau message de contact</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4e73df;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f8f9fc;
            padding: 20px;
            border-radius: 0 0 5px 5px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Nouveau message de contact</h2>
    </div>
    
    <div class="content">
        <p><strong>De :</strong> {{ $name }} ({{ $email }})</p>
        <p><strong>Sujet :</strong> {{ $subject }}</p>
        <p><strong>Message :</strong></p>
        <p>{{ $content }}</p>
    </div>
    
    <div class="footer">
        <p>Ce message a été envoyé via le formulaire de contact de GestionStages.</p>
        <p>&copy; {{ date('Y') }} GestionStages. Tous droits réservés.</p>
    </div>
</body>
</html>