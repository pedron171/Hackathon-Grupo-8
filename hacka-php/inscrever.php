<?php
date_default_timezone_set('America/Sao_Paulo'); // Define o fuso horário
?>

<?php
// Recebe os dados enviados pelo formulário
$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$telefone = $_POST['telefone'] ?? '';
$cep = $_POST['cep'] ?? '';
$evento_id = $_POST['evento_id'] ?? '';

$mensagem = '';
$sucesso = false;

// Se todos os dados foram preenchidos
if ($nome && $email && $telefone && $cep && $evento_id) {
    // Busca todos os alunos
    $alunos = json_decode(file_get_contents("http://localhost:3333/alunos"), true);
    $alunoExistente = null;

    // Verifica se o aluno já existe pelo e-mail
    foreach ($alunos as $aluno) {
        if ($aluno['email'] === $email) {
            $alunoExistente = $aluno;
            break;
        }
    }

    // Se não existe, cadastra novo aluno
    if (!$alunoExistente) {
        $novoAluno = [
            'nome' => $nome,
            'email' => $email,
            'telefone' => $telefone,
            'cep' => $cep
        ];

        $opcoes = [
            'http' => [
                'header'  => "Content-type: application/json",
                'method'  => 'POST',
                'content' => json_encode($novoAluno),
            ],
        ];
        $contexto = stream_context_create($opcoes);
        $resultado = file_get_contents("http://localhost:3333/alunos", false, $contexto);

        if (!$resultado) {
            $mensagem = "❌ Erro ao cadastrar aluno.";
        } else {
            $alunoExistente = json_decode($resultado, true);
        }
    }

    // Cria a inscrição se aluno existe
    if (isset($alunoExistente['id'])) {
        $novaInscricao = [
            'aluno_id' => $alunoExistente['id'],
            'evento_id' => $evento_id
        ];

        $opcoes = [
            'http' => [
                'header'  => "Content-type: application/json",
                'method'  => 'POST',
                'content' => json_encode($novaInscricao),
            ],
        ];
        $contexto = stream_context_create($opcoes);
        $resposta = file_get_contents("http://localhost:3333/inscricoes", false, $contexto);

        if ($resposta) {
            $mensagem = "✅ Inscrição realizada com sucesso!";
            $sucesso = true;
        } else {
            $mensagem = "❌ Erro ao realizar inscrição.";
        }
    } else {
        $mensagem = "❌ Aluno cadastrado, mas ID não retornado.";
    }
} else {
    $mensagem = "❌ Dados incompletos.";
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Confirmação de Inscrição</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <nav class="navbar navbar-dark bg-dark px-3">
    <a class="navbar-brand" href="index.php">Eventos Acadêmicos</a>
  </nav>

  <div class="container py-5 text-center">
    <div class="alert <?= $sucesso ? 'alert-success' : 'alert-danger' ?>" role="alert">
      <h4 class="alert-heading"><?= $mensagem ?></h4>
      <?php if ($sucesso): ?>
      <p class="mb-0">Aluno inscrito: <strong><?= htmlspecialchars($alunoExistente['nome']) ?></strong></p>
      <?php endif; ?>

    </div>

    <a href="index.php" class="btn btn-primary">🏠 Voltar para o Início</a>
  </div>

</body>
</html>
