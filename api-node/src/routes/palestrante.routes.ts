// Rotas para palestrantes
import { Router } from "express";
import { PalestranteController } from "../controllers/PalestranteController";

const router = Router();
const palestranteController = new PalestranteController();

router.get("/", palestranteController.index);
router.post("/", palestranteController.criar);
router.put("/:id", palestranteController.update);
router.delete("/:id", palestranteController.delete);

export default router;
