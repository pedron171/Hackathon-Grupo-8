import { Request, Response } from "express";
import knex from "../database/knex";

// Controller responsável por gerenciar eventos
export class EventController {

  // Listar todos os eventos
  async index(req: Request, res: Response) {
    try {
      const eventos = await knex("eventos").select("*");
      return res.json(eventos);
    } catch (error) {
      console.error(error);
      return res.status(500).json({ mensagem: "Erro ao listar eventos" });
    }
  }

  // Buscar evento específico pelo ID
  async show(req: Request, res: Response) {
    const { id } = req.params;

    try {
      const evento = await knex("eventos").where({ id }).first();

      if (!evento) {
        return res.status(404).json({ mensagem: "Evento não encontrado" });
      }

      return res.json(evento);
    } catch (error) {
      console.error(error);
      return res.status(500).json({ mensagem: "Erro ao buscar evento" });
    }
  }

  // Criar novo evento
  async criar(req: Request, res: Response) {
    const { nome, descricao, data, local, curso, imagem } = req.body;

    await knex("eventos").insert({
      nome,
      descricao,
      data,
      local,
      curso,
      imagem,
    });

    res.status(201).json({ mensagem: "Evento criado com sucesso!" });
  }
}
