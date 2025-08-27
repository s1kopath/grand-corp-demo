<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ route('dashboard') }}">
            <img src="{{ asset('assets/img/logo-ct-dark.png') }}" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">Grand Corp IMS</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-dark {{ request()->routeIs('dashboard') ? 'active bg-gradient-primary' : '' }}"
                    href="{{ route('dashboard') }}">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-symbols-rounded opacity-5">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-dark {{ request()->routeIs('dataBank.*') ? 'active bg-gradient-primary' : '' }}"
                    href="{{ route('dataBank.index') }}">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-symbols-rounded opacity-5">database</i>
                    </div>
                    <span class="nav-link-text ms-1">Data Bank & Sourcing</span>
                </a>
            </li>

            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#crmCollapse"
                    class="nav-link text-dark {{ request()->routeIs('crm.*') ? 'active bg-gradient-primary' : '' }}"
                    aria-controls="crmCollapse" role="button"
                    aria-expanded="{{ request()->routeIs('crm.*') ? 'true' : 'false' }}">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-symbols-rounded opacity-5">people</i>
                    </div>
                    <span class="nav-link-text ms-1">CRM</span>
                </a>
                <div class="collapse {{ request()->routeIs('crm.*') ? 'show' : '' }}" id="crmCollapse">
                    <ul class="nav ms-4">
                        <li class="nav-item">
                            <a class="nav-link text-dark {{ request()->routeIs('crm.customers.*') ? 'active' : '' }}"
                                href="{{ route('crm.customers.index') }}">
                                <span class="nav-link-text ms-1">Customers</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark {{ request()->routeIs('crm.principals.*') ? 'active' : '' }}"
                                href="{{ route('crm.principals.index') }}">
                                <span class="nav-link-text ms-1">Principals</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark {{ request()->routeIs('crm.products.*') ? 'active' : '' }}"
                                href="{{ route('crm.products.index') }}">
                                <span class="nav-link-text ms-1">Products</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#salesCollapse"
                    class="nav-link text-dark {{ request()->routeIs('quotations.*') || request()->routeIs('indents.*') || request()->routeIs('lcs.*') ? 'active bg-gradient-primary' : '' }}"
                    aria-controls="salesCollapse" role="button"
                    aria-expanded="{{ request()->routeIs('quotations.*') || request()->routeIs('indents.*') || request()->routeIs('lcs.*') ? 'true' : 'false' }}">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-symbols-rounded opacity-5">shopping_cart</i>
                    </div>
                    <span class="nav-link-text ms-1">Sales Ops</span>
                </a>
                <div class="collapse {{ request()->routeIs('quotations.*') || request()->routeIs('indents.*') || request()->routeIs('lcs.*') ? 'show' : '' }}"
                    id="salesCollapse">
                    <ul class="nav ms-4">
                        <li class="nav-item">
                            <a class="nav-link text-dark {{ request()->routeIs('quotations.*') ? 'active' : '' }}"
                                href="{{ route('quotations.index') }}">
                                <span class="nav-link-text ms-1">Quotations</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark {{ request()->routeIs('indents.*') ? 'active' : '' }}"
                                href="{{ route('indents.index') }}">
                                <span class="nav-link-text ms-1">Indents</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark {{ request()->routeIs('lcs.*') ? 'active' : '' }}"
                                href="{{ route('lcs.index') }}">
                                <span class="nav-link-text ms-1">Letters of Credit</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#logisticsCollapse"
                    class="nav-link text-dark {{ request()->routeIs('shipments.*') ? 'active bg-gradient-primary' : '' }}"
                    aria-controls="logisticsCollapse" role="button"
                    aria-expanded="{{ request()->routeIs('shipments.*') ? 'true' : 'false' }}">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-symbols-rounded opacity-5">local_shipping</i>
                    </div>
                    <span class="nav-link-text ms-1">Logistics</span>
                </a>
                <div class="collapse {{ request()->routeIs('shipments.*') ? 'show' : '' }}" id="logisticsCollapse">
                    <ul class="nav ms-4">
                        <li class="nav-item">
                            <a class="nav-link text-dark {{ request()->routeIs('shipments.*') ? 'active' : '' }}"
                                href="{{ route('shipments.index') }}">
                                <span class="nav-link-text ms-1">Shipments</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            @can('viewFinance')
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#financeCollapse"
                        class="nav-link text-dark {{ request()->routeIs('debit-notes.*') || request()->routeIs('finance.*') ? 'active bg-gradient-primary' : '' }}"
                        aria-controls="financeCollapse" role="button"
                        aria-expanded="{{ request()->routeIs('debit-notes.*') || request()->routeIs('finance.*') ? 'true' : 'false' }}">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-symbols-rounded opacity-5">account_balance</i>
                        </div>
                        <span class="nav-link-text ms-1">Finance</span>
                    </a>
                    <div class="collapse {{ request()->routeIs('debit-notes.*') || request()->routeIs('finance.*') ? 'show' : '' }}"
                        id="financeCollapse">
                        <ul class="nav ms-4">
                            <li class="nav-item">
                                <a class="nav-link text-dark {{ request()->routeIs('debit-notes.*') ? 'active' : '' }}"
                                    href="{{ route('debit-notes.index') }}">
                                    <span class="nav-link-text ms-1">Debit Notes</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark {{ request()->routeIs('finance.accounts.*') ? 'active' : '' }}"
                                    href="{{ route('finance.accounts.index') }}">
                                    <span class="nav-link-text ms-1">Accounts Summary</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endcan

            @can('viewReports')
                <li class="nav-item">
                    <a class="nav-link text-dark {{ request()->routeIs('reports.*') ? 'active bg-gradient-primary' : '' }}"
                        href="{{ route('reports.index') }}">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-symbols-rounded opacity-5">assessment</i>
                        </div>
                        <span class="nav-link-text ms-1">Reports</span>
                    </a>
                </li>
            @endcan

            @can('viewAdmin')
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#adminCollapse"
                        class="nav-link text-dark {{ request()->routeIs('admin.*') ? 'active bg-gradient-primary' : '' }}"
                        aria-controls="adminCollapse" role="button"
                        aria-expanded="{{ request()->routeIs('admin.*') ? 'true' : 'false' }}">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-symbols-rounded opacity-5">admin_panel_settings</i>
                        </div>
                        <span class="nav-link-text ms-1">Admin</span>
                    </a>
                    <div class="collapse {{ request()->routeIs('admin.*') ? 'show' : '' }}" id="adminCollapse">
                        <ul class="nav ms-4">
                            <li class="nav-item">
                                <a class="nav-link text-dark {{ request()->routeIs('admin.teams') ? 'active' : '' }}"
                                    href="{{ route('admin.teams') }}">
                                    <span class="nav-link-text ms-1">Teams & Members</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark {{ request()->routeIs('admin.users') ? 'active' : '' }}"
                                    href="{{ route('admin.users') }}">
                                    <span class="nav-link-text ms-1">Users</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark {{ request()->routeIs('admin.parameters') ? 'active' : '' }}"
                                    href="{{ route('admin.parameters') }}">
                                    <span class="nav-link-text ms-1">Master Setup</span>
                                </a>
                            </li>
                            @can('manageBranding')
                                <li class="nav-item">
                                    <a class="nav-link text-dark {{ request()->routeIs('admin.branding') ? 'active' : '' }}"
                                        href="{{ route('admin.branding') }}">
                                        <span class="nav-link-text ms-1">Branding</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>
            @endcan
        </ul>
    </div>
</aside>
