// Classe responsável pela interface gráfica (GUI) do sistema de gerenciamento de eventos
package br.com.unialfa.eventos.view;

import br.com.unialfa.eventos.dao.EventoDAO;
import br.com.unialfa.eventos.dao.PalestranteDAO;
import br.com.unialfa.eventos.model.Evento;
import br.com.unialfa.eventos.model.Palestrante;

import javax.swing.*;
import java.awt.*;
import java.awt.event.ActionEvent;
import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;
import java.util.List;

public class TelaEventos extends JFrame {

    // Campos do formulário
    private JTextField campoNome;
    private JTextField campoDescricao;
    private JTextField campoData;
    private JTextField campoLocal;
    private JTextField campoCurso;
    private JTextField campoImagem;
    private JComboBox<Palestrante> comboPalestrante;
    private JList<Evento> listaEventos;

    // Instâncias dos DAOs (Acesso ao banco de dados)
    private EventoDAO eventoDAO = new EventoDAO();
    private PalestranteDAO palestranteDAO = new PalestranteDAO();

    // Construtor da classe - Inicializa a janela
    public TelaEventos() {
        setTitle("Gerenciador de Eventos");
        setSize(800, 600);
        setDefaultCloseOperation(EXIT_ON_CLOSE);
        setLocationRelativeTo(null);
        setLayout(new BorderLayout());

        inicializarComponentes(); // Cria os componentes da tela
        atualizarListaEventos(); // Carrega a lista de eventos
        atualizarComboPalestrantes(); // Carrega o ComboBox de palestrantes

        setVisible(true);
    }

    // Criação dos componentes da tela
    private void inicializarComponentes() {
        JPanel painelFormulario = new JPanel(new GridLayout(8, 2));

        // Campos de formulário
        painelFormulario.add(new JLabel("Nome do Evento:"));
        campoNome = new JTextField();
        painelFormulario.add(campoNome);

        painelFormulario.add(new JLabel("Descrição:"));
        campoDescricao = new JTextField();
        painelFormulario.add(campoDescricao);

        painelFormulario.add(new JLabel("Data (yyyy-MM-dd HH:mm:ss):"));
        campoData = new JTextField();
        painelFormulario.add(campoData);

        painelFormulario.add(new JLabel("Local:"));
        campoLocal = new JTextField();
        painelFormulario.add(campoLocal);

        painelFormulario.add(new JLabel("Curso:"));
        campoCurso = new JTextField();
        painelFormulario.add(campoCurso);

        painelFormulario.add(new JLabel("Imagem (ex.: evento.png):"));
        campoImagem = new JTextField();
        painelFormulario.add(campoImagem);

        painelFormulario.add(new JLabel("Palestrante:"));
        comboPalestrante = new JComboBox<>();
        painelFormulario.add(comboPalestrante);

        // Botão para abrir o cadastro de palestrante
        JButton botaoNovoPalestrante = new JButton("Cadastrar Novo Palestrante");
        botaoNovoPalestrante.addActionListener(this::abrirCadastroPalestrante);
        painelFormulario.add(botaoNovoPalestrante);

        add(painelFormulario, BorderLayout.NORTH);

        // Lista de eventos no centro da tela
        listaEventos = new JList<>();
        listaEventos.addListSelectionListener(e -> {
            Evento eventoSelecionado = listaEventos.getSelectedValue();
            if (eventoSelecionado != null) {
                campoNome.setText(eventoSelecionado.getNome());
                campoDescricao.setText(eventoSelecionado.getDescricao());
                campoData.setText(eventoSelecionado.getData().format(DateTimeFormatter.ofPattern("yyyy-MM-dd HH:mm:ss")));
                campoLocal.setText(eventoSelecionado.getLocal());
                campoCurso.setText(eventoSelecionado.getCurso());
                campoImagem.setText(eventoSelecionado.getImagem());

                // Seleciona o palestrante correto no ComboBox
                for (int i = 0; i < comboPalestrante.getItemCount(); i++) {
                    Palestrante p = comboPalestrante.getItemAt(i);
                    if (p.getId() == eventoSelecionado.getPalestranteId()) {
                        comboPalestrante.setSelectedIndex(i);
                        break;
                    }
                }
            }
        });

        add(new JScrollPane(listaEventos), BorderLayout.CENTER);

        // Painel com os botões (Cadastrar, Editar, Excluir)
        JPanel painelBotoes = new JPanel();
        JButton botaoCadastrar = new JButton("Cadastrar");
        botaoCadastrar.addActionListener(this::cadastrarEvento);
        painelBotoes.add(botaoCadastrar);

        JButton botaoEditar = new JButton("Editar");
        botaoEditar.addActionListener(this::editarEvento);
        painelBotoes.add(botaoEditar);

        JButton botaoExcluir = new JButton("Excluir");
        botaoExcluir.addActionListener(this::excluirEvento);
        painelBotoes.add(botaoExcluir);

        add(painelBotoes, BorderLayout.SOUTH);
    }

    // Atualiza a lista de eventos na tela
    private void atualizarListaEventos() {
        List<Evento> eventos = eventoDAO.listar();
        listaEventos.setListData(eventos.toArray(new Evento[0]));
    }

    // Atualiza o ComboBox de palestrantes na tela
    private void atualizarComboPalestrantes() {
        comboPalestrante.removeAllItems();
        List<Palestrante> palestrantes = palestranteDAO.listar();
        for (Palestrante p : palestrantes) {
            comboPalestrante.addItem(p);
        }
    }

    // Método para cadastrar novo evento
    private void cadastrarEvento(ActionEvent e) {
        try {
            Evento evento = new Evento();
            evento.setNome(campoNome.getText());
            evento.setDescricao(campoDescricao.getText());
            evento.setData(LocalDateTime.parse(campoData.getText(), DateTimeFormatter.ofPattern("yyyy-MM-dd HH:mm:ss")));
            evento.setLocal(campoLocal.getText());
            evento.setCurso(campoCurso.getText());
            evento.setImagem(campoImagem.getText());

            // Pega o palestrante selecionado
            Palestrante palestranteSelecionado = (Palestrante) comboPalestrante.getSelectedItem();
            if (palestranteSelecionado == null) {
                JOptionPane.showMessageDialog(this, "Selecione um palestrante.");
                return;
            }
            evento.setPalestranteId(palestranteSelecionado.getId());

            eventoDAO.inserir(evento);
            atualizarListaEventos();
            limparCampos();

            JOptionPane.showMessageDialog(this, "Evento cadastrado com sucesso!");
        } catch (Exception ex) {
            JOptionPane.showMessageDialog(this, "Erro ao cadastrar evento: " + ex.getMessage());
        }
    }

    // Método para excluir evento selecionado
    private void excluirEvento(ActionEvent e) {
        Evento eventoSelecionado = listaEventos.getSelectedValue();
        if (eventoSelecionado != null) {
            eventoDAO.excluir(eventoSelecionado.getId());
            atualizarListaEventos();
            JOptionPane.showMessageDialog(this, "Evento excluído com sucesso!");
        } else {
            JOptionPane.showMessageDialog(this, "Selecione um evento para excluir.");
        }
    }

    // Método para editar evento selecionado
    private void editarEvento(ActionEvent e) {
        Evento eventoSelecionado = listaEventos.getSelectedValue();
        if (eventoSelecionado != null) {
            try {
                eventoSelecionado.setNome(campoNome.getText());
                eventoSelecionado.setDescricao(campoDescricao.getText());
                eventoSelecionado.setData(LocalDateTime.parse(campoData.getText(), DateTimeFormatter.ofPattern("yyyy-MM-dd HH:mm:ss")));
                eventoSelecionado.setLocal(campoLocal.getText());
                eventoSelecionado.setCurso(campoCurso.getText());
                eventoSelecionado.setImagem(campoImagem.getText());

                Palestrante palestranteSelecionado = (Palestrante) comboPalestrante.getSelectedItem();
                if (palestranteSelecionado == null) {
                    JOptionPane.showMessageDialog(this, "Selecione um palestrante.");
                    return;
                }
                eventoSelecionado.setPalestranteId(palestranteSelecionado.getId());

                eventoDAO.atualizar(eventoSelecionado);
                atualizarListaEventos();
                limparCampos();

                JOptionPane.showMessageDialog(this, "Evento atualizado com sucesso!");
            } catch (Exception ex) {
                JOptionPane.showMessageDialog(this, "Erro ao atualizar evento: " + ex.getMessage());
            }
        } else {
            JOptionPane.showMessageDialog(this, "Selecione um evento para editar.");
        }
    }

    // Método para abrir a janela de cadastro de palestrante
    private void abrirCadastroPalestrante(ActionEvent e) {
        JTextField campoNome = new JTextField();
        JTextField campoEmail = new JTextField();
        JTextField campoEspecialidade = new JTextField();

        Object[] mensagem = {
                "Nome:", campoNome,
                "Email:", campoEmail,
                "Especialidade:", campoEspecialidade
        };

        int opcao = JOptionPane.showConfirmDialog(this, mensagem, "Cadastrar Palestrante", JOptionPane.OK_CANCEL_OPTION);
        if (opcao == JOptionPane.OK_OPTION) {
            Palestrante palestrante = new Palestrante();
            palestrante.setNome(campoNome.getText());
            palestrante.setEmail(campoEmail.getText());
            palestrante.setEspecialidade(campoEspecialidade.getText());

            palestranteDAO.inserir(palestrante);
            atualizarComboPalestrantes();
            JOptionPane.showMessageDialog(this, "Palestrante cadastrado com sucesso!");
        }
    }

    // Método que limpa todos os campos após cadastrar, editar ou excluir
    private void limparCampos() {
        campoNome.setText("");
        campoDescricao.setText("");
        campoData.setText("");
        campoLocal.setText("");
        campoCurso.setText("");
        campoImagem.setText("");
        comboPalestrante.setSelectedIndex(-1);
    }
}
