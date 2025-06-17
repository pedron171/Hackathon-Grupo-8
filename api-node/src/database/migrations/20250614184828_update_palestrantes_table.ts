import { Knex } from "knex";

export async function up(knex: Knex): Promise<void> {
  return knex.schema.alterTable("palestrantes", (table) => {
    table.dropColumn("descricao");
    table.string("email").notNullable();
    table.string("especialidade").notNullable();
  });
}

export async function down(knex: Knex): Promise<void> {
  return knex.schema.alterTable("palestrantes", (table) => {
    table.dropColumn("email");
    table.dropColumn("especialidade");
    table.string("descricao");
  });
}
