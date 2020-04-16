<nav class="navbar fixed-top navbar-expand-lg navbar-dark nav_grande nav_transparente">    
    <div class="container">        
        <a class="navbar-brand h1 mb-0 mr-5 " id="observatorio_nav" href="index.php" style="font-family: 'Jomolhari'">
            Observatório Astronômico Antares
        </a>

         
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto ">
                <li class="nav-item mr-2 ">
                    <a class="nav-link scroll branco home" href="#home"> Início </a>
                </li>                        
                <li class="nav-item  mr-2 ">
                    <a class="nav-link scroll branco sobre" href="#sobre"> Sobre </a>
                </li>
                <li class="nav-item  mr-2 ">
                    <a class="nav-link scroll branco agendamento" href="#agendamento"> Agendamento </a>
                </li>                        
                <li class="nav-item  mr-2 ">
                    <a class="nav-link scroll branco contato2" href="#contato"> Contato </a>
                </li>
                
                <?php
                
                if (!isset($_SESSION['permissao'])) // SE USUÁRIO NÃO ESTIVER DEFINIDO ENTÃO MOSTRA ESTAS OPÇÕES
                {

                ?>
                    <li class="nav-item  mr-2 ">
                        <a class="nav-link branco " href="#"> - </a>
                    </li>
                    <li class="nav-item  mr-2 ">
                        <a class="nav-link branco" href="#" data-toggle="modal" data-target="#modal-acesso"> Efetuar Login  </a>
                    </li>
                
                <?php
                }
                else
                {
                    if ($_SESSION['permissao'] == 1) //ESTAGIÁRIO
                    {   ?>                     
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="img-profile rounded-circle" src="img/logado.jpeg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="home_adm.php">
                                    <i class="fas fa-lock fa-sm fa-fw mr-2 text-gray-400"></i>Minha Conta 
                                </a>
                                <a class="dropdown-item" href="estagiario/t-c-estagiario.php">
                                    <i class="fas fa-lock fa-sm fa-fw mr-2 text-gray-400"></i>Gerenciar Visitas 
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item "  href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Sair
                                </a>
                            </div>
                        </li>
                    <?php    
                    }
                    else if ($_SESSION['permissao'] == 2) // FUNCIONÁRIO
                    {    ?>  

                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="img-profile rounded-circle" src="img/logado.jpeg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="home_adm.php">
                                    <i class="fas fa-lock fa-sm fa-fw mr-2 text-gray-400"></i>Minha Conta 
                                </a>
                                <a class="dropdown-item" href="funcionario/gerir-eventos.php">
                                    <i class="fas fa-lock fa-sm fa-fw mr-2 text-gray-400"></i>Gerir Eeventos 
                                </a>
                                 <a class="dropdown-item" href="funcionario/gerir-usuarios.php">
                                    <i class="fas fa-lock fa-sm fa-fw mr-2 text-gray-400"></i>Gerir Usuários 
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item " href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Sair
                                </a>
                            </div>
                        </li>                 
                   <?php }                    
                    else if($_SESSION['permissao'] == 3) // ESCOLA
                    {       ?>

                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="img-profile rounded-circle" src="img/logado.jpeg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="home_adm.php">
                                    <i class="fas fa-lock fa-sm fa-fw mr-2 text-gray-400"></i>Minha Conta 
                                </a>
                                <a class="dropdown-item" href="escola/form-cad-turma.php">
                                    <i class="fas fa-lock fa-sm fa-fw mr-2 text-gray-400"></i>Cadastar Turmas 
                                </a>
                                 <a class="dropdown-item" href="agendamentos/t-c-agendamentos.php">
                                    <i class="fas fa-lock fa-sm fa-fw mr-2 text-gray-400"></i>Gerenciar Visitas 
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item " href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Sair
                                </a>
                            </div>
                        </li>

                     <?php   
                    }                    
                    else // ADMINISTRADOR (INCOMPLETO)
                    { ?>
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="img-profile rounded-circle" src="img/logado.jpeg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="home_adm.php">
                                    <i class="fas fa-lock fa-sm fa-fw mr-2 text-gray-400"></i>Minha Conta 
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item " href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Sair
                                </a>
                            </div>
                        </li>
                      <!--  //echo "<li class='nav-item  mr-2 '> <a class='btn btn-outline-light' href='MNGR/cad_usuario.php'>Cadastrar Usuário</a> </li>";
                        //echo "<li class='nav-item  mr-2 '> <a class='btn btn-outline-light' href='MNGR/listar_usuario.php'>Listar Usuários</a> </li>";
                        //echo "<li class='nav-item  mr-2 '> <a class='btn btn-outline-light' href='MNGR/pesquisar.php'>Pesquisar Usuários</a> </li>";
                        //echo "<a href='staff/T_FC_staff.php'>Gerenciar Eventos</a><br>"; -->
                    <?php    
                    }
                    ?>
                   <!-- <li class="nav-item  mr-2 ">
                        <a class="btn btn-warning" href="home_adm.php" role="button"></a>
                    </li>
                    <li class="nav-item  mr-2 ">
                        <a class="btn btn-danger" href="access/dar-o-fora.php" role="button">Sair</a>
                    </li> -->
                <?php
                }               
                ?>                
            </ul>                        
        </div>
    </div>
</nav>