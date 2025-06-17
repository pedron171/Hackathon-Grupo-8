// Rotas para aluno
import { Router } from "express";
import { AlunoController } from "../controllers/AlunoController";

const router = Router();
const alunoController = new AlunoController();

router.get("/", alunoController.index);
router.post("/", alunoController.criar);
router.put("/:id", alunoController.update);
router.delete("/:id", alunoController.delete);

export default router;
