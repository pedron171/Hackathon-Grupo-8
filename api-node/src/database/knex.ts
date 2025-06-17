// Criação da conexão com o banco de dados usando knex

import knex from "knex";
import config from "../../knexfile";
import { Knex } from "knex";

const environment = process.env.NODE_ENV || "development";
const connection: Knex = knex(config[environment]);

export default connection;
