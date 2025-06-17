import { Request, Response } from "express";
import knex from "../database/knex";

// Controller responsável por gerenciar os alunos
export class AlunoController {

  // Listar alunos (com filtro opcional por e-mail)
  async index(req: Request, res: Response) {
    const { email } = req.query;

    if (email) {
      const aluno = await knex("alunos").where("email", email).first();

      if (aluno) {
        return res.status(200).json([aluno]); // Retorna aluno encontrado
      } else {
        return res.status(200).json([]); // Retorna array vazio se não encontrou
      }
    }

    const alunos = await knex("alunos").select("*");
    return res.status(200).json(alunos); // Lista todos os alunos
  }

  // Criar novo aluno
  async criar(req: Request, res: Response) {
    const { nome, email, telefone, cep } = req.body;

    // Validação dos campos obrigatórios
    if (!nome || !email || !telefone || !cep) {
      return res.status(400).json({ mensagem: "Preencher todos os campos são obrigatórios." });
    }

    // Inserção no banco
    const [id] = await knex("alunos").insert({ nome, email, telefone, cep });
    return res.status(201).json({ id, nome, email, telefone, cep });
  }

  // Atualizar aluno
  async update(req: Request, res: Response) {
    const { id } = req.params;
    const { nome, email, telefone, cep } = req.body;

    await knex("alunos").where({ id }).update({ nome, email, telefone, cep });

    return res.status(200).json({ mensagem: "Aluno atualizado com sucesso!" });
  }

  // Deletar aluno
  async delete(req: Request, res: Response) {
    const { id } = req.params;

    await knex("alunos").where({ id }).del();

    return res.status(200).json({ mensagem: "Aluno deletado com sucesso!" });
  }
}
