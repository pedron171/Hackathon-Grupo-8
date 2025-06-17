// Arquivo principal que inicializa o servidor

import express from "express";
import cors from "cors";
import dotenv from "dotenv";

// Importação das rotas
import eventosRoutes from "./routes/event.routes";
import palestranteRoutes from "./routes/palestrante.routes";
import alunoRoutes from "./routes/aluno.routes";
import inscricaoRoutes from "./routes/inscricao.routes";

// Carregar variáveis de ambiente
dotenv.config();

const app = express();

// Configurações globais
app.use(cors());
app.use(express.json());

// Uso das rotas
app.use("/eventos", eventosRoutes);
app.use("/palestrantes", palestranteRoutes);
app.use("/alunos", alunoRoutes);
app.use("/inscricoes", inscricaoRoutes);

// Inicialização do servidor
const PORT = process.env.PORT || 3333;
app.listen(PORT, () => console.log(`🚀 Servidor rodando na porta ${PORT}`));
