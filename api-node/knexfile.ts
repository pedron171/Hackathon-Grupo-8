// Configuração do knex (conexão com banco)

import type { Knex } from "knex";
import dotenv from "dotenv";

dotenv.config();

const config: { [key: string]: Knex.Config } = {
  development: {
    client: "mysql2", // Cliente do banco
    connection: {
      host: process.env.DB_HOST,
      user: process.env.DB_USER,
      password: process.env.DB_PASS,
      database: process.env.DB_NAME,
      port: Number(process.env.DB_PORT) || 3306,
    },
    migrations: {
      directory: "./src/database/migrations", // Diretório das migrations
    },
  },
};

export default config;
