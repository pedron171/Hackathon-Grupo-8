// Rotas para eventos
import { Router } from "express";
import { EventController } from "../controllers/EventController";

const router = Router();
const eventController = new EventController();

router.post("/", eventController.criar);
router.get("/", eventController.index);
router.get("/:id", eventController.show);

export default router;
