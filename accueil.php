<body>
    <div class="container">
        <aside>
            <div class="top">
                <div class="logo">
                    <img src="./files/logo_copiercare.png" alt="CopierCare logo">
                    <h2><span class="danger">COPIER</span>CARE</h2>
                </div>
                <div class="close" id="close-btn">
                    <span class="material-icons-sharp">close</span>
                </div>
            </div>

            <div class="sidebar">
                <a href="#" class="active">
                    <span class="material-icons-sharp">home</span>
                    <h3>Accueil</h3>
                </a>
                <a href="#">
                    <span class="material-icons-sharp">report_gmailerrorred</span>
                    <h3>Alertes</h3>
                </a>
                <a href="#">
                    <span class="material-icons-sharp">groups</span>
                    <h3>Clients</h3>
                </a>
                <a href="#">
                    <span style="width: 24px;" class="material-icons-sharp">print_outline</span>
                    <h3>Copieurs</h3>
                </a>
                <a href="#">
                    <span class="material-icons-sharp">construction</span>
                    <h3>Pièces</h3>
                </a>
                <a href="#">
                    <span class="material-icons-sharp">settings</span>
                    <h3>Paramètres</h3>
                </a>
                <a href="#">
                    <span class="material-icons-sharp">admin_panel_settings</span>
                    <h3>Administrateur</h3>
                </a>
                <a href="#">
                    <span class="material-icons-sharp">logout</span>
                    <h3>Se déconnecter</h3>
                </a>
            </div>
        </aside>
        <!----------------------- END OF ASIDE ------------------------->
        <main>
            <h1>Tableau de bord</h1>

            <div class="date">
                <input type="date">
            </div>

            <div class="insights">
                <div class="sales">
                    <span class="material-icons-sharp">analytics</span>
                    <div class="middle">
                        <div class="left">
                            <h3>Total Sales</h3>
                            <h1>$25,024</h1>
                        </div>
                        <div class="progress">
                            <svg>
                                <circle cx='38' cy='38' r='36'></circle>
                            </svg>
                            <div class="number">
                                <p>81%</p>
                            </div>
                        </div>
                    </div>
                    <small class="text-muted">Last 24 Hours</small>
                </div>
                <!--------------- END OF SALES ------------>
                <div class="expenses">
                    <span class="material-icons-sharp">bar_chart</span>
                    <div class="middle">
                        <div class="left">
                            <h3>Total Expenses</h3>
                            <h1>$14,160</h1>
                        </div>
                        <div class="progress">
                            <svg>
                                <circle cx='38' cy='38' r='36'></circle>
                            </svg>
                            <div class="number">
                                <p>62%</p>
                            </div>
                        </div>
                    </div>
                    <small class="text-muted">Last 24 Hours</small>
                </div>
                <!--------------- END OF EXPENSES ------------>
                <div class="income">
                    <span class="material-icons-sharp">stacked_line_chart</span>
                    <div class="middle">
                        <div class="left">
                            <h3>Total Expenses</h3>
                            <h1>$10,864</h1>
                        </div>
                        <div class="progress">
                            <svg>
                                <circle cx='38' cy='38' r='36'></circle>
                            </svg>
                            <div class="number">
                                <p>44%</p>
                            </div>
                        </div>
                    </div>
                    <small class="text-muted">Last 24 Hours</small>
                </div>
                <!--------------- END OF INCOME ------------>
            </div>
            <!--------------- END OF INSIGHTS ------------>

            <div class="alert">
                <h2>Alertes</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Pièce</th>
                            <th>Copieur</th>
                            <th>Client</th>
                            <th>Limittes de la pièce</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Fordable Mini Drone</td>
                            <td>85631</td>
                            <td>Due</td>
                            <td class="warning">Pending</td>
                            <td class="primary">Details</td>
                        </tr>
                        <tr>
                            <td>Fordable Mini Drone</td>
                            <td>85631</td>
                            <td>Due</td>
                            <td class="warning">Pending</td>
                            <td class="primary">Details</td>
                        </tr>
                        <tr>
                            <td>Fordable Mini Drone</td>
                            <td>85631</td>
                            <td>Due</td>
                            <td class="warning">Pending</td>
                            <td class="primary">Details</td>
                        </tr>
                        <tr>
                            <td>Fordable Mini Drone</td>
                            <td>85631</td>
                            <td>Due</td>
                            <td class="warning">Pending</td>
                            <td class="primary">Details</td>
                        </tr>
                        <tr>
                            <td>Fordable Mini Drone</td>
                            <td>85631</td>
                            <td>Due</td>
                            <td class="warning">Pending</td>
                            <td class="primary">Details</td>
                        </tr>
                    </tbody>
                </table>
                <a href="#">Show All</a>
            </div>
        </main>
        <!--------------- END OF MAIN ------------>

        <div class="right">
            <div class="top">
                <buton id="menu-btn">
                    <span class="material-icons-sharp">menu</span>
                </buton>
                <div class="theme-toggler">
                    <span class="material-icons-sharp">light_mode</span>
                    <span class="material-icons-sharp">dark_mode</span>
                </div>
                <div class="profile">
                    <div class="info">
                        <p>Hey, <b>Daniel</b></p>
                        <small class="text-muted">Admin</small>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>

</html>