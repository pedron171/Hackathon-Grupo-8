import { Request, Response } from "express";
import knex from "../database/knex";

// Controller responsável por gerenciar inscrições
export class InscricaoController {

  // Listar todas as inscrições
  async index(req: Request, res: Response) {
    try {
      const inscricoes = await knex("inscricoes").select("*");
      return res.status(200).json(inscricoes);
    } catch (error) {
      return res.status(500).json({ mensagem: "Erro ao buscar inscrições." });
    }
  }

  // Criar nova inscrição
  async criar(req: Request, res: Response) {
    const { aluno_id, evento_id } = req.body;

    if (!aluno_id || !evento_id) {
      return res.status(400).json({ mensagem: "Aluno e Evento são obrigatórios." });
    }

    try {
      await knex("inscricoes").insert({ aluno_id, evento_id });
      return res.status(201).json({ mensagem: "Inscrição criada com sucesso!" });
    } catch (error) {
      return res.status(500).json({ mensagem: "Erro ao criar inscrição." });
    }
  }

  // Atualizar inscrição
  async update(req: Request, res: Response) {
    const { id } = req.params;
    const { aluno_id, evento_id } = req.body;

    try {
      const atualizado = await knex("inscricoes").where({ id }).update({ aluno_id, evento_id });
      if (atualizado === 0) {
        return res.status(404).json({ mensagem: "Inscrição não encontrada." });
      }
      return res.status(200).json({ mensagem: "Inscrição atualizada com sucesso!" });
    } catch (error) {
      console.error("Erro ao atualizar inscrição:", error);
      return res.status(500).json({ mensagem: "Erro ao atualizar inscrição." });
    }
  }

  // Deletar inscrição
  async delete(req: Request, res: Response) {
    const { id } = req.params;

    try {
      const deletado = await knex("inscricoes").where({ id }).del();
      if (deletado === 0) {
        return res.status(404).json({ mensagem: "Inscrição não encontrada." });
      }
      return res.status(200).json({ mensagem: "Inscrição deletada com sucesso!" });
    } catch (error) {
      return res.status(500).json({ mensagem: "Erro ao deletar inscrição." });
    }
  }
}
