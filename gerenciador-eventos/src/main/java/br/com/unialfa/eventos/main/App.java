// Pacote principal do projeto
package br.com.unialfa.eventos.main;

// Importação da classe responsável pela interface gráfica
import br.com.unialfa.eventos.view.TelaEventos;

// Classe principal do projeto, responsável por inicializar o sistema
public class App {

    // Método main → ponto de entrada da aplicação
    public static void main(String[] args) {

        // Inicializa a interface gráfica (abre a janela do sistema)
        new TelaEventos();
    }
}
