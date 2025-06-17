<?php
// Busca dados das APIs
$dadosInscricoes = file_get_contents("http://localhost:3333/inscricoes");
$dadosAlunos = file_get_contents("http://localhost:3333/alunos");
$dadosEventos = file_get_contents("http://localhost:3333/eventos");

$inscricoes = json_decode($dadosInscricoes, true);
$alunos = json_decode($dadosAlunos, true);
$eventos = json_decode($dadosEventos, true);

// Recebe dados do formulário (nome e e-mail)
$nome = isset($_GET['nome']) ? trim($_GET['nome']) : '';
$email = isset($_GET['email']) ? trim($_GET['email']) : '';

$alunoEncontrado = null;
$inscricoesDoAluno = [];

// Busca o aluno pelo nome e e-mail
if ($nome && $email) {
    foreach ($alunos as $aluno) {
        if (strcasecmp($aluno['nome'], $nome) === 0 && strcasecmp($aluno['email'], $email) === 0) {
            $alunoEncontrado = $aluno;
            break;
        }
    }

    // Se achou, busca as inscrições desse aluno
    if ($alunoEncontrado) {
        foreach ($inscricoes as $inscricao) {
            if ($inscricao['aluno_id'] == $alunoEncontrado['id']) {
                foreach ($eventos as $evento) {
                    if ($evento['id'] == $inscricao['evento_id']) {
                        $inscricoesDoAluno[] = $evento;
                    }
                }
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Consulta de Inscrições</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
    <a class="navbar-brand" href="index.php">🏠 Início</a>
    <a class="navbar-brand" href="inscricoes.php">📄 Certificados</a>
</nav>

<div class="container py-5">
    <h1 class="mb-4">Consultar Inscrições</h1>

    <form method="GET" class="mb-4">
        <div class="row g-2">
            <div class="col-md-5">
                <input type="text" name="nome" class="form-control" placeholder="Digite seu nome" required>
            </div>
            <div class="col-md-5">
                <input type="email" name="email" class="form-control" placeholder="Digite seu e-mail" required>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Consultar</button>
            </div>
        </div>
    </form>

    <?php if($nome && $email): ?>
        <?php if($alunoEncontrado): ?>
            <h3>Eventos que você está inscrito:</h3>
            <ul class="list-group">
                <?php foreach ($inscricoesDoAluno as $evento): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong><?= htmlspecialchars($evento['nome']) ?></strong><br>
                            Data: <?= date('d/m/Y', strtotime($evento['data'])) ?><br>
                            Local: <?= htmlspecialchars($evento['local']) ?>
                        </div>
                        <a href="certificado.php?nome=<?= urlencode($alunoEncontrado['nome']) ?>&evento=<?= $evento['id'] ?>" class="btn btn-success">
                            Gerar Certificado
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <div class="alert alert-danger mt-4">Aluno não encontrado com esse nome e e-mail.</div>
        <?php endif; ?>
    <?php endif; ?>
</div>

</body>
</html>
