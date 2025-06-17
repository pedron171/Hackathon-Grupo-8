<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Inscrição Já Realizada</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #fff2c8, #ffffff);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            background-color: #fff3cd;
            color: #856404;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            text-align: center;
            max-width: 500px;
            width: 100%;
        }

        .card h1 {
            font-size: 2.2rem;
            margin-bottom: 20px;
            color: #856404;
        }

        .icon {
            font-size: 70px;
            color: #ffc107;
            margin-bottom: 20px;
        }

        .btn-dark {
            background-color: #161b22;
            border: none;
            padding: 12px 24px;
            border-radius: 30px;
            font-size: 16px;
            margin-top: 20px;
        }

        .btn-dark:hover {
            background-color: #0f141a;
        }

    </style>
</head>
<body>

    <div class="card">
        <div class="icon">⚠️</div>
        <h1>Você já está inscrito neste evento</h1>
        <p class="mb-4">Parece que você já realizou sua inscrição anteriormente para este evento. Verifique suas inscrições na aba "Minhas Inscrições".</p>
        <a href="index.php" class="btn btn-dark">🏠 Voltar para a Página Inicial</a>
    </div>

</body>
</html>
