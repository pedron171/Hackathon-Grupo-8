<?php
date_default_timezone_set('America/Sao_Paulo'); // Define o fuso horário para evitar problemas na data/hora

// Pega o ID do evento pela URL
$evento_id = $_GET['id'] ?? null;

// Validação: Se não tiver ID, exibe erro
if (!$evento_id) {
    echo "❌ Evento não encontrado.";
    exit;
}

// Busca dados do evento pela API
$dados = file_get_contents("http://localhost:3333/eventos/$evento_id");
$evento = json_decode($dados, true);

// Se o evento não for encontrado, mostra erro
if (!$evento) {
    echo "❌ Evento inválido.";
    exit;
}

// Busca lista de palestrantes
$dados_palestrantes = file_get_contents("http://localhost:3333/palestrantes");
$palestrantes = json_decode($dados_palestrantes, true);

// Função para buscar nome e especialidade do palestrante
function buscarDadosPalestrante($id, $palestrantes) {
    foreach ($palestrantes as $p) {
        if ($p['id'] == $id) {
            return [
                'nome' => $p['nome'],
                'especialidade' => $p['especialidade'] ?? 'Especialidade não informada'
            ];
        }
    }
    return [
        'nome' => 'A definir',
        'especialidade' => 'Especialidade não informada'
    ];
}

// Executa a função para obter dados do palestrante deste evento
$palestrante = buscarDadosPalestrante($evento['palestrante'], $palestrantes);
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($evento['nome']) ?> - Inscrição</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    body {
      background-color: rgb(202, 221, 240);
      color: #1c1c1c;
    }

    .navbar {
      background-color: #161b22 !important;
      transition: all 0.3s ease;
    }

    .navbar.sticky {
      position: fixed;
      top: 0;
      width: 100%;
      z-index: 999;
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
      background-color: #161b22 !important;
    }

    .navbar .navbar-brand,
    .navbar a {
      color: #ffffff !important;
    }

    .card {
      background-color: #161b22;
      border: 1px solid #30363d;
      color: #c9d1d9;
      border-radius: 20px;
    }

    label {
      font-weight: bold;
      color: #f8f9fa;
    }

    .form-control {
      border-radius: 0.5rem;
    }

    .logo-img {
      width: 150px;
      height: auto;
      margin-right: 10px;
    }

    .evento-img {
      width: 100%;
      height: 300px;
      object-fit: cover;
      border-radius: 15px;
    }
  </style>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark px-3">
    <a class="navbar-brand d-flex align-items-center" href="index.php">
      <img src="imagens/logo.png" alt="Logo" class="logo-img me-2">
      <span class="fw-bold">Eventos Acadêmicos</span>
    </a>
    <div class="ms-auto">
      <a href="index.php" class="btn btn-outline-light btn-sm">🏠 Início</a>
    </div>
  </nav>

  <div class="container py-5">

    <div class="card p-4 shadow-lg mx-auto mb-5" style="max-width: 800px;">
      <img src="<?= htmlspecialchars($evento['imagem']) ?>" class="evento-img mb-4" alt="Imagem do Evento">

      <h1 class="mb-3"><?= htmlspecialchars($evento['nome']) ?></h1>
      <p class="mb-2"><?= htmlspecialchars($evento['descricao']) ?></p>

      <p><strong>Palestrante:</strong> <?= htmlspecialchars($palestrante['nome']) ?></p>
      <p><strong>Especialidade:</strong> <?= htmlspecialchars($palestrante['especialidade']) ?></p>

      <p><strong>Data e Hora:</strong> 
        <?= date('d/m/Y', strtotime($evento['data'])) ?> às <?= date('H:i', strtotime($evento['data'])) ?>
      </p>

      <p><strong>Local:</strong> <?= htmlspecialchars($evento['local']) ?></p>
      <p><strong>Curso:</strong> <?= htmlspecialchars($evento['curso']) ?></p>
    </div>

    <div class="card p-4 shadow-lg mx-auto" style="max-width: 600px;">
      <h2 class="text-center mb-4">Formulário de Inscrição</h2>

      <form action="sucesso.php" method="post">
        <input type="hidden" name="evento_id" value="<?= $evento['id'] ?>">

        <div class="mb-3">
          <label for="nome">Nome do Aluno:</label>
          <input type="text" class="form-control" id="nome" name="nome" required>
        </div>

        <div class="mb-3">
          <label for="email">E-mail do Aluno:</label>
          <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="mb-3">
          <label for="telefone">Telefone:</label>
          <input type="text" class="form-control" id="telefone" name="telefone" required>
        </div>

        <div class="mb-3">
          <label for="cep">CEP:</label>
          <input type="text" class="form-control" id="cep" name="cep" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Confirmar Inscrição</button>
      </form>
    </div>

  </div>

  <script>
    window.addEventListener('scroll', function() {
      const navbar = document.querySelector('.navbar');
      if (window.scrollY > 50) {
        navbar.classList.add('sticky');
      } else {
        navbar.classList.remove('sticky');
      }
    });
  </script>

</body>
</html>
