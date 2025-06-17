import type { Knex } from "knex";

export async function up(knex: Knex): Promise<void> {
  await knex.schema.createTable("eventos", (table) => {
    table.increments("id").primary();
    table.string("nome").notNullable();
    table.text("descricao").notNullable();
    table.datetime("data").notNullable();
    table.string("local").notNullable();
    table.string("curso").notNullable();
  });

  await knex.schema.createTable("palestrantes", (table) => {
    table.increments("id").primary();
    table.string("nome").notNullable();
    table.text("descricao").notNullable();
  });

  await knex.schema.createTable("alunos", (table) => {
    table.increments("id").primary();
    table.string("nome").notNullable();
    table.string("email").notNullable();
    table.string("telefone").nullable();
    table.string("cep").nullable();
  });

  await knex.schema.createTable("inscricoes", (table) => {
  table.increments("id").primary();
  table.integer("evento_id").unsigned().notNullable()
    .references("id").inTable("eventos")
    .onDelete("CASCADE");
  table.integer("aluno_id").unsigned().notNullable()
    .references("id").inTable("alunos")
    .onDelete("CASCADE");
  table.datetime("data_inscricao").defaultTo(knex.fn.now());
  table.unique(["evento_id", "aluno_id"]);
});

}

export async function down(knex: Knex): Promise<void> {
  await knex.schema.dropTableIfExists("inscricoes");
  await knex.schema.dropTableIfExists("alunos");
  await knex.schema.dropTableIfExists("palestrantes");
  await knex.schema.dropTableIfExists("eventos");
}
