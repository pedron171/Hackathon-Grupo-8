// Pacote onde está localizada a classe
package br.com.unialfa.eventos.dao;

// Importações necessárias
import br.com.unialfa.eventos.model.Evento;
import br.com.unialfa.eventos.util.ConnectionFactory;

import java.sql.*;
import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;
import java.util.ArrayList;
import java.util.List;

//  Classe responsável por acessar e manipular os dados da tabela 'eventos'
public class EventoDAO {

    // Definindo o formato padrão da data para ser compatível com o banco de dados
    private static final DateTimeFormatter formatter = DateTimeFormatter.ofPattern("yyyy-MM-dd HH:mm:ss");

    //  Método para inserir um novo evento no banco de dados
    public void inserir(Evento evento) {
        String sql = "INSERT INTO eventos (nome, descricao, data, local, curso, imagem, palestrante) VALUES (?, ?, ?, ?, ?, ?, ?)";

        try (
                // Abre a conexão
                Connection connection = ConnectionFactory.getConnection();
                // Prepara o comando SQL
                PreparedStatement stmt = connection.prepareStatement(sql)
        ) {

            // Define os valores nos parâmetros do SQL
            stmt.setString(1, evento.getNome());
            stmt.setString(2, evento.getDescricao());
            stmt.setString(3, evento.getData().format(formatter));
            stmt.setString(4, evento.getLocal());
            stmt.setString(5, evento.getCurso());
            stmt.setString(6, evento.getImagem());
            stmt.setInt(7, evento.getPalestranteId());

            // Executa a inserção
            stmt.executeUpdate();

            System.out.println(" Evento cadastrado com sucesso!");

        } catch (SQLException e) {
            throw new RuntimeException(" Erro ao cadastrar evento: ", e);
        }
    }

    //  Método para listar todos os eventos cadastrados no banco
    public List<Evento> listar() {
        List<Evento> eventos = new ArrayList<>();
        String sql = "SELECT * FROM eventos";

        try (
                // Abre a conexão
                Connection connection = ConnectionFactory.getConnection();
                // Prepara o comando SQL
                PreparedStatement stmt = connection.prepareStatement(sql);
                // Executa a consulta e obtém o resultado
                ResultSet rs = stmt.executeQuery()
        ) {

            // Percorre os resultados da consulta
            while (rs.next()) {
                Evento evento = new Evento();
                evento.setId(rs.getInt("id"));
                evento.setNome(rs.getString("nome"));
                evento.setDescricao(rs.getString("descricao"));

                String dataStr = rs.getString("data");
                evento.setData(LocalDateTime.parse(dataStr, formatter));

                evento.setLocal(rs.getString("local"));
                evento.setCurso(rs.getString("curso"));
                evento.setImagem(rs.getString("imagem"));
                evento.setPalestranteId(rs.getInt("palestrante"));

                // Adiciona o evento à lista
                eventos.add(evento);
            }

        } catch (SQLException e) {
            throw new RuntimeException(" Erro ao listar eventos: ", e);
        }

        return eventos;
    }

    //  Método para excluir um evento do banco pelo seu ID
    public void excluir(int id) {
        String sql = "DELETE FROM eventos WHERE id = ?";

        try (
                // Abre a conexão
                Connection connection = ConnectionFactory.getConnection();
                // Prepara o comando SQL
                PreparedStatement stmt = connection.prepareStatement(sql)
        ) {

            stmt.setInt(1, id); // Define o ID do evento a ser excluído
            stmt.executeUpdate(); // Executa a exclusão

            System.out.println(" Evento excluído com sucesso!");

        } catch (SQLException e) {
            throw new RuntimeException(" Erro ao excluir evento: ", e);
        }
    }

    //  Método para atualizar um evento existente no banco
    public void atualizar(Evento evento) {
        String sql = "UPDATE eventos SET nome = ?, descricao = ?, data = ?, local = ?, curso = ?, imagem = ?, palestrante = ? WHERE id = ?";

        try (
                // Abre a conexão
                Connection connection = ConnectionFactory.getConnection();
                // Prepara o comando SQL
                PreparedStatement stmt = connection.prepareStatement(sql)
        ) {

            // Define os novos valores dos campos
            stmt.setString(1, evento.getNome());
            stmt.setString(2, evento.getDescricao());
            stmt.setString(3, evento.getData().format(formatter));
            stmt.setString(4, evento.getLocal());
            stmt.setString(5, evento.getCurso());
            stmt.setString(6, evento.getImagem());
            stmt.setInt(7, evento.getPalestranteId());
            stmt.setInt(8, evento.getId()); // ID do evento a ser atualizado

            // Executa a atualização
            stmt.executeUpdate();

            System.out.println(" Evento atualizado com sucesso!");

        } catch (SQLException e) {
            throw new RuntimeException(" Erro ao atualizar evento: ", e);
        }
    }
}
