// Pacote onde está localizada a classe
package br.com.unialfa.eventos.model;

import java.time.LocalDateTime;

// Classe que representa o modelo de dados para um evento
public class Evento {

    //  Atributos do evento
    private int id;                    // ID único do evento
    private String nome;               // Nome do evento
    private String descricao;          // Descrição do evento
    private LocalDateTime data;        // Data e hora do evento (usa classe LocalDateTime)
    private String local;              // Local onde o evento acontecerá
    private String curso;              // Curso vinculado ao evento
    private String imagem;             // Caminho/nome da imagem do evento (ex.: evento1.png)
    private int palestranteId;         // ID do palestrante vinculado ao evento (chave estrangeira)

    //  Construtor padrão (vazio) - Permite criar um objeto sem definir os atributos inicialmente
    public Evento() {
    }

    //  Construtor completo - Permite criar um evento com todos os dados preenchidos
    public Evento(int id, String nome, String descricao, LocalDateTime data, String local, String curso, String imagem, int palestranteId) {
        this.id = id;
        this.nome = nome;
        this.descricao = descricao;
        this.data = data;
        this.local = local;
        this.curso = curso;
        this.imagem = imagem;
        this.palestranteId = palestranteId;
    }

    // Métodos Getters e Setters
    // Servem para acessar (get) e modificar (set) os valores dos atributos

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

    public String getDescricao() {
        return descricao;
    }

    public void setDescricao(String descricao) {
        this.descricao = descricao;
    }

    public LocalDateTime getData() {
        return data;
    }

    public void setData(LocalDateTime data) {
        this.data = data;
    }

    public String getLocal() {
        return local;
    }

    public void setLocal(String local) {
        this.local = local;
    }

    public String getCurso() {
        return curso;
    }

    public void setCurso(String curso) {
        this.curso = curso;
    }

    public String getImagem() {
        return imagem;
    }

    public void setImagem(String imagem) {
        this.imagem = imagem;
    }

    public int getPalestranteId() {
        return palestranteId;
    }

    public void setPalestranteId(int palestranteId) {
        this.palestranteId = palestranteId;
    }

    //  Método toString()
    // Define como o evento será exibido na interface gráfica (JList)
    // Neste caso, ele mostra o nome do evento seguido da data
    @Override
    public String toString() {
        return nome + " - " + data;
    }
}
