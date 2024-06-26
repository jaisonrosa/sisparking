<div class="sidebar">
    <ul>
        <li>
            <a href="index.php">Inicio</a>
        </li>
        <li onclick="toggleMenu(this)">
            Cliente
            <ul>
                <li><a href="cadastrar_cliente.php">Cadastrar Cliente</a></li>
                <li><a href="listar_clientes.php">Listar Clientes</a></li>
            </ul>
        </li>
        <li onclick="toggleMenu(this)">
            Veículo
            <ul>
                <li><a href="cadastrar_veiculo.php">Cadastrar Veículo</a></li>
                <li><a href="listar_veiculos.php">Listar Veículos</a></li>
            </ul>
        </li>
        <li onclick="toggleMenu(this)">
            Locação
            <ul>
                <li><a href="registrar_locacao.php">Registrar Locação</a></li>
                <li><a href="index.php">Listar Locações</a></li>
            </ul>
        </li>
    </ul>
</div>
<script>
    function toggleMenu(element) {
        element.classList.toggle('active');
    }

    function reloadPage() {
        window.location.reload();
    }

    // Configurar o intervalo para recarregar a página a cada 1 minuto (60.000 milissegundos)
    setInterval(reloadPage, 60000);
</script>