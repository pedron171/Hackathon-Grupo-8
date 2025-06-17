<?php
// Recebe dados do formulário
$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$telefone = $_POST['telefone'] ?? '';
$cep = $_POST['cep'] ?? '';
$evento_id = $_POST['evento_id'] ?? '';

// Valida campos obrigatórios
if (!$nome || !$email || !$telefone || !$cep || !$evento_id) {
    die("❌ Todos os campos são obrigatórios.");
}

$aluno_api = "http://localhost:3333/alunos";
$aluno_existente = null;

// Busca alunos existentes na API
$alunos_json = file_get_contents($aluno_api);
$alunos = json_decode($alunos_json, true);

// Verifica se o aluno já está cadastrado pelo e-mail
foreach ($alunos as $a) {
    if ($a['email'] === $email) {
        $aluno_existente = $a;
        break;
    }
}

// Se aluno não existe, cadastra
if (!$aluno_existente) {
    $novoAluno = [
        "nome" => $nome,
        "email" => $email,
        "telefone" => $telefone,
        "cep" => $cep
    ];

    $opts = [
        "http" => [
            "method" => "POST",
            "header" => "Content-Type: application/json",
            "content" => json_encode($novoAluno)
        ]
    ];
    $context = stream_context_create($opts);
    $resposta = file_get_contents($aluno_api, false, $context);
    $aluno_existente = json_decode($resposta, true);
}

$aluno_id = $aluno_existente['id'] ?? null;

if (!$aluno_id) {
    die("❌ Não foi possível identificar o aluno.");
}

// Verifica se já está inscrito neste evento
$inscricoes_json = file_get_contents("http://localhost:3333/inscricoes");
$inscricoes = json_decode($inscricoes_json, true);

foreach ($inscricoes as $i) {
    if ($i['evento_id'] == $evento_id && $i['aluno_id'] == $aluno_id) {
        header("Location: erro-duplicado.php");
        exit;
    }
}

// Realiza a inscrição
$novaInscricao = [
    "evento_id" => $evento_id,
    "aluno_id" => $aluno_id
];

$opts = [
    "http" => [
        "method" => "POST",
        "header" => "Content-Type: application/json",
        "content" => json_encode($novaInscricao)
    ]
];

$context = stream_context_create($opts);
$resposta = file_get_contents("http://localhost:3333/inscricoes", false, $context);

// Se deu certo, vai pra tela de sucesso
if ($resposta) {
    header("Location: sucesso-confirmado.php");
    exit;
} else {
    die("❌ Erro ao realizar inscrição.");
}
?>
