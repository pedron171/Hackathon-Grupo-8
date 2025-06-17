// Pacote onde está localizada a classe
package br.com.unialfa.eventos.model;

// Classe que representa o modelo de dados para um palestrante
public class Palestrante {

    // Atributos do palestrante
    private int id;                     // ID único do palestrante
    private String nome;                // Nome do palestrante
    private String email;               // Email do palestrante
    private String especialidade;       // Área de especialidade do palestrante

    // Construtor vazio (padrão) - necessário para criação de objetos sem definir atributos inicialmente
    public Palestrante() {
    }

    // Construtor completo - usado para criar um palestrante com todos os dados
    public Palestrante(int id, String nome, String email, String especialidade) {
        this.id = id;
        this.nome = nome;
        this.email = email;
        this.especialidade = especialidade;
    }

    // Métodos Getters e Setters
    // Permitem acessar (get) e alterar (set) os valores dos atributos

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getNome() {
        return nome;
    }

    public void setNome(String nome) {
        this.nome = nome;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public String getEspecialidade() {
        return especialidade;
    }

    public void setEspecialidade(String especialidade) {
        this.especialidade = especialidade;
    }

    // Método toString()
    // Define como o palestrante será exibido no ComboBox e na interface gráfica
    // Neste caso, retorna apenas o nome do palestrante
    @Override
    public String toString() {
        return nome;
    }
}
