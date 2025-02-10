<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('home') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-heading">Cadastros</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('categorias.index') }}">
                <i class="bi bi-journal-text"></i>
                <span>Categorias</span>
            </a>
        </li><!-- End Profile Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('produtos.index') }}">
                <i class="bi bi-menu-button-wide"></i>
                <span>Produtos</span>
            </a>
        </li><!-- End F.A.Q Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('fornecedores.index') }}">
                <i class="bi bi-person"></i>
                <span>Fornecedores</span>
            </a>
        </li><!-- End Contact Page Nav -->




        <li class="nav-heading">Financeiro</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('contaspagar.index') }}">
                <i class="bi bi-cash"></i>
                <span>Contas a Pagar</span>
            </a>
        </li><!-- End Contact Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('orcamentos.index') }}">
                <i class="bi bi-card-checklist"></i>
                <span>Cotações</span>
            </a>
        </li><!-- End Contact Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('pedidos.index') }}">
                <i class="bi bi-layout-text-window-reverse"></i>
                <span>Pedidos</span>
            </a>
        </li><!-- End Contact Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="#">
                <i class="bi bi-calculator"></i>
                <span>Mapa Preços</span>
            </a>
        </li><!-- End Contact Page Nav -->

        <li class="nav-heading">Configurações</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('usuarios.index') }}">
                <i class="bi bi-file-earmark-person"></i>
                <span>Usuários</span>
            </a>
        </li><!-- End Contact Page Nav -->


        <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a class="nav-link collapsed" href="logout"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                    <i class="bi bi-arrow-return-left"></i>
                    <span>Sair</span>
                </a>
            </form>
        </li><!-- End Register Page Nav -->


    </ul>

</aside><!-- End Sidebar-->
