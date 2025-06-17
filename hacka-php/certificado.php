<?php
// 🔥 Busca todos os eventos da API
$dadosEventos = file_get_contents("http://localhost:3333/eventos");

if ($dadosEventos === false) {
    die("❌ Erro ao conectar na API de eventos.");
}

$eventos = json_decode($dadosEventos, true);

// 🔥 Recebe dados pela URL
$nome = $_GET['nome'] ?? null;
$eventoId = $_GET['evento'] ?? null;

// 🔥 Validação dos dados recebidos
if (!$nome || !$eventoId) {
    die("❌ Dados insuficientes para gerar o certificado.");
}

// 🔥 Busca o evento com o ID informado
$eventoSelecionado = null;
foreach ($eventos as $evento) {
    if ($evento['id'] == $eventoId) {
        $eventoSelecionado = $evento;
        break;
    }
}

// 🔥 Se não encontrou o evento, exibe erro
if (!$eventoSelecionado) {
    die("❌ Evento não encontrado.");
}

// 🔥 Tratamento correto da data vinda no formato ISO 8601
$dataEvento = date('d/m/Y', strtotime($eventoSelecionado['data']));
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Certificado</title>
    <style>
        body {
            background-color: #e8eef4;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .certificado {
            width: 90%;
            max-width: 1000px;
            margin: 50px auto;
            background: white;
            border: 6px solid #003366;
            padding: 60px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            position: relative;
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo img {
            width: 180px;
            height: auto;
        }

        .titulo {
            text-align: center;
            color: #003366;
            font-size: 42px;
            margin-bottom: 10px;
            font-weight: bold;
            letter-spacing: 2px;
        }

        .linha {
            width: 200px;
            border-top: 4px solid #2f81f7;
            margin: 15px auto 30px auto;
        }

        .texto {
            text-align: center;
            font-size: 20px;
            color: #333;
            margin-bottom: 30px;
        }

        .nome {
            text-align: center;
            color: #2f81f7;
            font-size: 30px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .evento {
            text-align: center;
            color: #003366;
            font-size: 26px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .descricao {
            text-align: center;
            color: #555;
            font-size: 18px;
            margin-bottom: 50px;
        }

        .rodape {
            text-align: center;
            font-size: 16px;
            color: #999;
        }

    </style>
</head>
<body>

<div class="certificado">
    <div class="logo">
        <img src="imagens/logo.png" alt="Logo da UniALFA">
    </div>

    <div class="titulo">CERTIFICADO</div>
    <div class="linha"></div>

    <div class="texto">Certificamos que</div>

    <div class="nome"><?= htmlspecialchars($nome) ?></div>

    <div class="texto">participou do evento</div>

    <div class="evento"><?= htmlspecialchars($eventoSelecionado['nome']) ?></div>

    <div class="descricao">
        realizado no dia <?= $dataEvento ?> no local <?= htmlspecialchars($eventoSelecionado['local']) ?>.
    </div>

    <div class="rodape">
        UniALFA Hackathon - <?= date('Y') ?>
    </div>
</div>

</body>
</html>
