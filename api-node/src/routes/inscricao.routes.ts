// Rotas para inscrições
import { Router } from "express";
import { InscricaoController } from "../controllers/InscricaoController";

const router = Router();
const inscricaoController = new InscricaoController();

router.get("/", inscricaoController.index);
router.post("/", inscricaoController.criar);
router.put("/:id", inscricaoController.update);
router.delete("/:id", inscricaoController.delete);

export default router;
