<?php
date_default_timezone_set('America/Sao_Paulo'); // Fuso horário correto

// Busca eventos e palestrantes das APIs
$dados = file_get_contents("http://localhost:3333/eventos");
$eventos = json_decode($dados, true);

$dados_palestrantes = file_get_contents("http://localhost:3333/palestrantes");
$palestrantes = json_decode($dados_palestrantes, true);

// Gera a lista de cursos únicos para filtro
$cursos = array_unique(array_column($eventos, 'curso'));
sort($cursos); // Organiza os cursos em ordem alfabética

// Verifica se o usuário escolheu algum curso no filtro
$cursoSelecionado = isset($_GET['curso']) ? $_GET['curso'] : null;

// Filtra os eventos se algum curso foi selecionado
if ($cursoSelecionado) {
    $eventos = array_filter($eventos, function($evento) use ($cursoSelecionado) {
        return $evento['curso'] === $cursoSelecionado;
    });
}

// Função que busca o nome do palestrante pelo ID
function buscarNomePalestrante($id, $palestrantes) {
    foreach ($palestrantes as $p) {
        if ($p['id'] == $id) {
            return $p['nome'];
        }
    }
    return 'A definir';
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Eventos Acadêmicos</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

 <style>
  .card-img-top {
    height: 180px;
    object-fit: cover;
  }

  .logo-img {
    width: 150px;
    height: auto;
    margin-right: 10px;
  }

  #carouselEventos .carousel-item img {
    height: 300px; 
    object-fit: cover;
  }

  body {
    background-color:rgb(202, 221, 240);
    color: #1c1c1c;
  }

  .navbar {
    background-color: #161b22 !important;
  }

  .navbar .navbar-brand,
  .navbar a {
    color: #ffffff !important;
  }

  h1 {
    color: #003366;
    font-weight: bold;
  }

  .card {
    background-color: #161b22;
    border: 1px solid #30363d;
    color: #c9d1d9;
  }

  .card-title {
    color: #ffffff;
  }

  .card-text,
  .card p {
    color:rgb(248, 248, 248);
  }

  .btn-primary {
    background-color: #2f81f7;
    border-color:rgb(255, 255, 255);
  }

  .btn-primary:hover {
    background-color: #1f6feb;
    border-color: #1f6feb;
  }

  .btn-outline-light {
    border-color: #2f81f7;
    color: #2f81f7;
  }

  .btn-outline-light:hover {
    background-color: #2f81f7;
    color: white;
  }

  .card-img-top {
    height: 180px;
    object-fit: cover;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
  }

  #carouselEventos .carousel-item img {
    height: 250px;
    object-fit: cover;
    border-radius: 10px;
  }

  .navbar {
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
</style>


<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
    <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
    <img src="imagens/logo.png" alt="Logo do site" class="logo-img">
    <span class="fw-bold fs-4">Eventos Acadêmicos</span>
    </a>

    <div class="ms-auto">
      <a href="index.php" class="btn btn-outline-light btn-sm me-2">🏠 Início</a>
      <a href="inscricoes.php" class="btn btn-outline-light btn-sm">📄 Minhas Inscrições</a>
    </div>
  </nav>

  <div class="container py-4">

    <div id="carouselEventos" class="carousel slide mb-5" data-bs-ride="carousel">
      <div class="carousel-inner rounded shadow-sm">
        <div class="carousel-item active">
          <img src="imagens/carrosel1.jpg" class="d-block w-100" alt="Evento 1">
        </div>
        <div class="carousel-item">
          <img src="imagens/carrosel2.jpg" class="d-block w-100" alt="Evento 2">
        </div>
        <div class="carousel-item">
          <img src="imagens/carrosel3.jpg" class="d-block w-100" alt="Evento 3">
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselEventos" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselEventos" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
      </button>
    </div>

    <h1 class="text-center mb-4">Lista de Eventos</h1>

    <div class="text-center mb-4">
    <h5>Filtrar por Curso:</h5>
    <div class="d-flex justify-content-center flex-wrap gap-2">
        <?php foreach($cursos as $curso): ?>
            <a href="index.php?curso=<?= urlencode($curso) ?>" 
               class="btn btn-outline-primary <?= ($curso == $cursoSelecionado) ? 'active' : '' ?>">
                <?= htmlspecialchars($curso) ?>
            </a>
        <?php endforeach; ?>
        <a href="index.php" class="btn btn-outline-secondary <?= !$cursoSelecionado ? 'active' : '' ?>">
            Todos
        </a>
    </div>
</div>


    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
      <?php foreach ($eventos as $evento): ?>
        <div class="col">
  <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden">
    <?php
      $caminhoImagem = $evento['imagem'] ?? 'imagens/evento1.jpg';
    ?>
    <img src="<?= htmlspecialchars($caminhoImagem) ?>" class="card-img-top" alt="Imagem do Evento">

    <div class="card-body">
      <h5 class="card-title"><?= htmlspecialchars($evento['nome']) ?></h5>
        <p class="card-text"><?= htmlspecialchars($evento['descricao']) ?></p>

          <p><strong>Palestrante:</strong> <?= htmlspecialchars(buscarNomePalestrante($evento['palestrante'], $palestrantes)) ?></p>

            <p>
            <strong>Data e Hora:</strong> 
            <?= date('d/m/Y', strtotime($evento    ['data']))  ?> às <?= date('H:i', strtotime($evento['data'])) ?>
            </p>
            <p><strong>Local:</strong> <?= htmlspecialchars($evento['local']) ?></p>
            <p><strong>Curso:</strong> <?= htmlspecialchars($evento['curso']) ?></p>
            <form action="evento.php" method="get">
            <input type="hidden" name="id" value="<?= $evento['id'] ?>">
            <button type="submit" class="btn btn-primary w-100">Ver Detalhes</button>
            </form>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
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
