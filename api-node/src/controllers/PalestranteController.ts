import { Request, Response } from "express";
import knex from "../database/knex";

// Controller responsável por gerenciar palestrantes
export class PalestranteController {

  // Listar todos os palestrantes
  async index(req: Request, res: Response) {
    const palestrantes = await knex("palestrantes").select("*");
    return res.status(200).json(palestrantes);
  }

  // Criar novo palestrante
  async criar(req: Request, res: Response) {
    const { nome, especialidade, email } = req.body;

    if (!nome || !especialidade || !email) {
      return res.status(400).json({ mensagem: "Preencher todos os campos são obrigatórios." });
    }

    await knex("palestrantes").insert({ nome, especialidade, email });
    return res.status(201).json({ mensagem: "Palestrante cadastrado com sucesso!" });
  }

  // Atualizar palestrante
  async update(req: Request, res: Response) {
    const { id } = req.params;
    const { nome, especialidade, email } = req.body;

    await knex("palestrantes").where({ id }).update({ nome, especialidade, email });
    return res.status(200).json({ mensagem: "Palestrante atualizado com sucesso!" });
  }

  // Deletar palestrante
  async delete(req: Request, res: Response) {
    const { id } = req.params;

    await knex("palestrantes").where({ id }).del();
    return res.status(200).json({ mensagem: "Palestrante deletado com sucesso!" });
  }
}
