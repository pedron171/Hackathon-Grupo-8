// Classe responsável pela conexão com o banco de dados
package br.com.unialfa.eventos.util;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

public class ConnectionFactory {

    // Configurações de conexão
    private static final String URL = "jdbc:mysql://localhost:3306/hackathon_unialfa";
    private static final String USER = "root";
    private static final String PASSWORD = "";

    // Método que retorna uma conexão ativa com o banco
    public static Connection getConnection() {
        try {
            return DriverManager.getConnection(URL, USER, PASSWORD);
        } catch (SQLException e) {
            throw new RuntimeException("❌ Erro na conexão com o banco de dados: ", e);
        }
    }
}
