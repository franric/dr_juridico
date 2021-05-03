<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Dashboard
                    <!-- <span class="right badge badge-danger">New</span> -->
                </p>
            </a>
        </li>
        <li class="nav-item has-treeview menu">
            <a href="#" class="nav-link bg-info">
                <i class="nav-icon fa fa-user-circle"></i>
                <p>
                    Clientes
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('pessoa.index') }}" class="nav-link bg-white">
                        <i class="fa fa-save nav-icon"></i>
                        <p>Cadastrar</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('historico.index') }}" class="nav-link bg-white">
                        <i class="fa fa-pen-alt"></i>
                        <p>Relato dos Fatos</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('procuracao.index') }}" class="nav-link bg-white">
                        <i class="nav-icon fa fa-file"></i>
                        <p>
                            Procuração
                            <!-- <span class="right badge badge-danger">New</span> -->
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link bg-white">
                        <i class="nav-icon fa fa-book-reader"></i>
                        <p>
                            Documentos
                            <!-- <span class="right badge badge-danger">New</span> -->
                        </p>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item has-treeview menu">
            <a href="#" class="nav-link bg-info">
                <i class="nav-icon fa fa-balance-scale"></i>
                <p>
                    Contratos
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('contrato.index') }}" class="nav-link bg-white">
                        <i class="nav-icon fa fa-save"></i>
                        <p>
                            Gerar
                            <!-- <span class="right badge badge-danger">New</span> -->
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('historicoProcesso.index') }}" class="nav-link bg-white">
                        <i class="nav-icon fa fa-list-alt"></i>
                        <p>
                            Histórico
                            <!-- <span class="right badge badge-danger">New</span> -->
                        </p>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item has-treeview menu">
            <a href="#" class="nav-link bg-info">
                <i class="nav-icon fa fa-user-circle"></i>
                <p>
                    Financeiro
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('contasReceber.index') }}" class="nav-link bg-white">
                        <i class="fa fa-save nav-icon"></i>
                        <p>Contas a Receber</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link bg-white">
                        <i class="fa fa-save nav-icon"></i>
                        <p>Contas Recebidas</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('receita.index') }}" class="nav-link bg-white">
                        <i class="fa fa-pen-alt"></i>
                        <p>Receitas</p>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>
<!-- /.sidebar-menu -->
