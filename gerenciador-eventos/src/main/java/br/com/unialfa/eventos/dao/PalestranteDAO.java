// Pacote onde está localizada a classe
package br.com.unialfa.eventos.dao;

// Importações das classes necessárias
import br.com.unialfa.eventos.model.Palestrante;
import br.com.unialfa.eventos.util.ConnectionFactory;

import java.sql.*;
import java.util.ArrayList;
import java.util.List;

// Classe responsável pelo acesso e manipulação dos dados da tabela 'palestrantes'
public class PalestranteDAO {

    //  Método para inserir um novo palestrante no banco de dados
    public void inserir(Palestrante palestrante) {
        // Comando SQL para inserção
        String sql = "INSERT INTO palestrantes (nome, email, especialidade) VALUES (?, ?, ?)";

        try (
                // Abre a conexão com o banco de dados
                Connection connection = ConnectionFactory.getConnection();
                // Prepara a execução do comando SQL
                PreparedStatement stmt = connection.prepareStatement(sql)
        ) {
            // Define os valores nos parâmetros do SQL
            stmt.setString(1, palestrante.getNome());
            stmt.setString(2, palestrante.getEmail());
            stmt.setString(3, palestrante.getEspecialidade());

            // Executa o comando de inserção
            stmt.executeUpdate();

            System.out.println(" Palestrante cadastrado com sucesso!");

        } catch (SQLException e) {
            // Caso aconteça algum erro na execução
            throw new RuntimeException("❌ Erro ao cadastrar palestrante: ", e);
        }
    }

    //  Método para listar todos os palestrantes cadastrados no banco de dados
    public List<Palestrante> listar() {
        // Cria uma lista para armazenar os palestrantes encontrados
        List<Palestrante> palestrantes = new ArrayList<>();

        // Comando SQL para buscar todos os registros da tabela 'palestrantes'
        String sql = "SELECT * FROM palestrantes";

        try (
                // Abre a conexão com o banco de dados
                Connection connection = ConnectionFactory.getConnection();
                // Prepara a execução do comando SQL
                PreparedStatement stmt = connection.prepareStatement(sql);
                // Executa a consulta e obtém o resultado
                ResultSet rs = stmt.executeQuery()
        ) {
            // Percorre o resultado da consulta
            while (rs.next()) {
                // Cria um objeto Palestrante para cada registro encontrado
                Palestrante palestrante = new Palestrante();
                palestrante.setId(rs.getInt("id"));
                palestrante.setNome(rs.getString("nome"));
                palestrante.setEmail(rs.getString("email"));
                palestrante.setEspecialidade(rs.getString("especialidade"));

                // Adiciona o palestrante na lista
                palestrantes.add(palestrante);
            }

        } catch (SQLException e) {
            // Caso aconteça algum erro na execução
            throw new RuntimeException(" Erro ao listar palestrantes: ", e);
        }

        // Retorna a lista de palestrantes encontrados
        return palestrantes;
    }
}
