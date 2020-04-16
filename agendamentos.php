<?php
session_start();
/**
include 'php/conexao.php';
$sql="SELECT * FROM contato";
$query = mysqli_query($conexao,$sql);
$contato = mysqli_fetch_assoc($query); **/
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Observatório Astronômico Antares</title>

    <!-- Custom fonts for this template-->
    <link href="vendor_adm/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <!-- Custom styles for this template-->
    <link href="css/adm.css" rel="stylesheet">
    <link rel="sortcut icon" href="img/antares.png" type=".png" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Tabela -->

    <link href="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.css">
    <link rel="stylesheet"
          href="https://unpkg.com/bootstrap-table@1.15.5/dist/extensions/filter-control/bootstrap-table-filter-control.css">

    <style>
        .like,
        .remove {
            margin-right: 10px;
            color: grey;
        }
        label{
            margin-top: 5px;
        }
        body{
            background-color: #eeeeee;
        }
        .mini-sidebar .expand-logo{
            margin-top: -10px;
        }

        .full .topbar{
            margin-top: -10px;
        }

        .mini-sidebar .expand-logo .navbar-brand .logo-icon{
            margin-top: 10px;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
            <div class="sidebar-brand-icon">
                <img id="img_adm_ecmat" src="img/antares2.png">
            </div>
            <div class="sidebar-brand-text mx-3">Antares</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider">
        <!-- Heading -->
        <div class="sidebar-heading">
            Gerenciamento
        </div>
        <li class="nav-item">
            <a class="nav-link" href="#" data-toggle="modal" data-target="#minhaconta">
                <span>Minha Conta</span>
            </a>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider">
        <?php
        if ($_SESSION['permissao']==1) {
            ?>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span>Cadastrar Horarios</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="agendamentos..php" data-toggle="modal" data-target="#usuarios">
                    <span>Agendamentos</span>
                </a>
            </li>

        <?php }?>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="img-profile rounded-circle" src="img/logado.jpeg">
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="home_adm.php">
                                <i class="fas fa-lock fa-sm fa-fw mr-2 text-gray-400"></i> Area do adm
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Sair
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>

            <div class="page-wrapper">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Container fluid  -->
                <!-- ============================================================== -->
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-md-12">

                            <div class="page-breadcrumb">
                                <div class="row">
                                    <div class="col-12 d-flex no-block align-items-center">
                                        <h4 class="page-title" >Agendamentos</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <div class="card-body">
                                    <div class="table-responsive">

                                        <table id="table" data-toolbar="#toolbar" data-search="true" data-show-print="true"
                                               data-advanced-search="true" data-id-table="advancedTable"
                                               data-show-refresh="true" data-show-toggle="true" data-show-fullscreen="true"
                                               data-show-columns="true" data-show-columns-toggle-all="true"
                                               data-detail-view="true" data-show-export="true" data-click-to-select="true"
                                               data-detail-formatter="detailFormatter" data-minimum-count-columns="2"
                                               data-show-pagination-switch="true" data-pagination="true" data-id-field="id"
                                               data-url="./estagiario/tabelaAgendamentos.php"
                                               data-page-list="[10, 25, 50, 100, all]" data-show-footer="true"
                                               data-locale="pt-BR" data-mobile-responsive="true"
                                               data-response-handler="responseHandler">
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- ============================================================== -->
                <!-- End Container fluid  -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- footer -->
                <!-- ============================================================== -->
                <footer class="footer text-center">
                    &copy; Todos os Direitos Reservados - Antares
                </footer>
                <!-- ============================================================== -->
                <!-- End footer -->
                <!-- ============================================================== -->
            </div>



        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Tem certeza que deseja sair?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-primary" href="php/logout.php">Sair</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="minhaconta" tabindex="-1" role="dialog" aria-labelledby="minhaconta" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 style="margin-bottom: 0px;">Minha Conta:</h3>
                    <button class="btn btn-primary ml-auto " type=" button" data-toggle="modal" data-target="#att_senha">Trocar senha</button>
                </div>
                <form method="post" action="./php/troca-senha.php" id="form_troca_senha">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col">
                                <label>Nome:</label>
                                <input type="password" name="nova_senha_repete" class="form-control" required="">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <label>E-mail</label>
                                <input type="email" name="email" class="form-control" required="">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                        <a class="btn btn-primary" href="#" onclick="att_minhaconta()">Confirmar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="att_senha" tabindex="-1" role="dialog" aria-labelledby="att_senha" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 style="margin-bottom: 0px;">Trocar senha:</h3>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form method="post" action="./php/troca-senha.php" id="form_troca_senha">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col">
                                <label>E-mail</label>
                                <input type="email" name="e-mail" class="form-control" required="">
                            </div>
                            <div class="col">
                                <label>Senha atual:</label>
                                <input type="password" name="senha_atual" class="form-control" required="">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <label>Nova senha:</label>
                                <input type="password" name="nova_senha" class="form-control" required="">
                            </div>
                            <div class="col">
                                <label>Repita a nova senha:</label>
                                <input type="password" name="nova_senha_repete" class="form-control" required="">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                        <a class="btn btn-primary" href="#" onclick="att_senha()">Confirmar</a>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <!-- Modal Remover -->

    <div class="modal" tabindex="-1" role="dialog" id="modal_remover">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Título do modal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Deseja remover o item selecionado?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-danger" onclick="remover()" data-dismiss="modal">Remover</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="contatoModal" tabindex="-1" role="dialog" aria-labelledby="contatoModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 style="margin-bottom: 0px;">Informações de contato</h3>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form method="post" action="php/att_contato.php" id="form_informacoes_contato">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col">
                                <label>Rua:</label>
                                <input type="text" id="rua" name="rua" class="form-control" value="<?php echo $contato['rua']; ?>" required="">
                            </div>
                            <div class="col">
                                <label>Complemento:</label>
                                <input type="text" name="complemento" id="complemento" class="form-control" value="<?php echo $contato['complemento']; ?>" required="">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <label>Numero:</label>
                                <input type="text" name="numero" id="numero" class="form-control" value="<?php echo $contato['numero']; ?>" required="">
                            </div>
                            <div class="col">
                                <label>Cidade:</label>
                                <input type="text" name="cidade" id="cidade" class="form-control" value="<?php echo $contato['cidade']; ?>" required="">
                            </div>
                            <div class="col">
                                <label>Estado:</label>
                                <input type="text" name="estado" id="estado" class="form-control" value="<?php echo $contato['estado']; ?>" required="">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <label>E-mail 1:</label>
                                <input type="email" name="email" id="email" class="form-control" value="<?php echo $contato['email1']; ?>" required="">
                            </div>
                            <div class="col">
                                <label>E-mail 2:</label>
                                <input type="email" name="email2" id="email2" class="form-control" value="<?php echo $contato['email2']; ?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <label>Telefone 1:</label>
                                <input type="text" name="telefone" id="telefone" class="form-control" value="<?php echo $contato['telefone1']; ?>" required="">
                            </div>
                            <div class="col">
                                <label>Telefone 2:</label>
                                <input type="text" name="telefone2" id="telefone2" class="form-control" value="<?php echo $contato['telefone2']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                        <button class="btn btn-primary" type="button" onclick="att_contato()">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor_adm/jquery/jquery.min.js"></script>
    <script src="vendor_adm/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor_adm/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js_adm/sb-admin-2.min.js"></script>

    <script type="text/javascript">
        function addAdm(){
            var dados =  $("#form_add_adm").serialize();
            $.ajax({
                type: "post",
                url: "./php/add_adm.php",
                data: dados,
                success : function(data){
                    if (data == "sucesso" ){
                        alert("Administrador adicionado com sucesso!");
                    }else if(data =="erro"){
                        alert("Não foi possivel adicionar o administrador. Tente novamente mais tarde!");
                    }else if(data == "email"){
                        alert("O e-mail inserido já está em uso!");
                    }
                }
            });
        };
        function att_contato(){
            var dados = $("#form_informacoes_contato").serialize();
            $.ajax({
                type: "post",
                url: "./php/att_contato.php",
                data: dados,
                success : function(retorno){
                    if (retorno == "<sucesso" ){
                        alert("Informações de contato atualizadas com sucesso!");
                    }else if(retorno =="<erro"){
                        alert("Não foi possivel atualizar as Informações. Tente novamente !");
                    }
                }
            });
        };
    </script>


    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================
    <script src="./assets/libs/jquery/dist/jquery.min.js"></script>================================== -->
    <!-- Bootstrap tether Core JavaScript -->
    <script src="./assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="./assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="./assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="./assets/extra-libs/sparkline/sparkline.js"></script>
    <!--Table JavaScript -->
    <script src="https://unpkg.com/tableexport.jquery.plugin/tableExport.min.js"></script>
    <!-- Tabela -->

    <script type="module" src="https://unpkg.com/bootstrap-table@1.15.5/src/bootstrap-table.js"></script>
    <script type="module"
            src="https://unpkg.com/bootstrap-table@1.15.5/src/extensions/editable/bootstrap-table-editable.js"></script>
    <script type="module"
            src="https://unpkg.com/bootstrap-table@1.15.5/src/extensions/export/bootstrap-table-export.js"></script>
    <script type="module"
            src="https://unpkg.com/bootstrap-table@1.15.5/src/extensions/filter-control/bootstrap-table-filter-control.js"></script>
    <script type="module"
            src="https://unpkg.com/bootstrap-table@1.15.5/src/extensions/mobile/bootstrap-table-mobile.js"></script>
    <script type="module"
            src="https://unpkg.com/bootstrap-table@1.15.5/src/extensions/toolbar/bootstrap-table-toolbar.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.js"></script>

    <script src="https://unpkg.com/tableexport.jquery.plugin/libs/jsPDF/jspdf.min.js"></script>
    <script src="https://unpkg.com/tableexport.jquery.plugin/libs/jsPDF-AutoTable/jspdf.plugin.autotable.js"></script>


    <!-- Traduzir -->
    <script src="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.js"></script>
    <script type="module" src="./dist/js/locale.js"></script>

    <script>
        var $table = $('#table')
        var $remove = $('#remove')
        var selections = []

        function getIdSelections() {
            return $.map($table.bootstrapTable('getSelections'), function (row) {
                return row.id
            })
        }

        function responseHandler(res) {
            $.each(res.rows, function (i, row) {
                row.state = $.inArray(row.id, selections) !== -1
            })
            return res
        }

        function detailFormatter(index, row) {
            var html = []
            $.each(row, function (key, value) {
                html.push('<p><b>' + key + ':</b> ' + value + '</p>')
            })
            return html.join('')
        }

        function operateFormatter(value, row, index) {
            return [
                '<a class="like" href="javascript:void(0)" title="Editar Conteúdo" data-toggle="modal" data-target="#edit_conteudo">',
                '<i class="fa fa-edit"></i>',
                '</a>  '
            ].join('')
        }

        window.operateEvents = {
            'click .like': function (e, value, row, index) {
                window.location.href= "./visitantes.php?id=" + row.id;
            },
            'click .remove': function (e, value, row, index) {
            }
        }

        function totalTextFormatter(data) {
            return 'Total'
        }

        function totalNameFormatter(data) {
            return data.length
        }

        function totalPriceFormatter(data) {
            var field = this.field
            return '$' + data.map(function (row) {
                return +row[field].substring(1)
            }).reduce(function (sum, i) {
                return sum + i
            }, 0)
        }

        function initTable() {
            $table.bootstrapTable('destroy').bootstrapTable({
                exportDataType: "all", // '', 'selected'
                exportTypes: ['txt', 'excel', 'pdf'],
                height: '',
                locale: $('#locale').val(),
                columns: [
                    [{
                        field: 'state',
                        checkbox: true,
                        rowspan: 2,
                        align: 'center',
                        valign: 'middle'
                    }, {
                        title: 'ID',
                        field: 'id',
                        rowspan: 2,
                        align: 'center',
                        valign: 'middle',
                        sortable: true
                    }, {
                        title: 'Informações',
                        colspan: 4,
                        align: 'center'
                    }],
                    [{
                        field: 'nome',
                        title: 'Nome Estagiário',
                        sortable: true,
                        align: 'center'
                    },{
                        field: 'start',
                        title: 'Início',
                        sortable: true,
                        align: 'center'
                    },{
                        field: 'end',
                        title: 'Fim',
                        sortable: true,
                        align: 'center'
                    },{
                        field: 'operate',
                        title: 'Operações',
                        align: 'center',
                        clickToSelect: false,
                        events: window.operateEvents,
                        formatter: operateFormatter
                    }]
                ]
            })
            $table.on('check.bs.table uncheck.bs.table ' +
                'check-all.bs.table uncheck-all.bs.table',
                function () {
                    $remove.prop('disabled', !$table.bootstrapTable('getSelections').length)

                    // save your data, here just save the current page
                    selections = getIdSelections()
                    // push or splice the selections if you want to save all data selections
                })
            $table.on('all.bs.table', function (e, name, args) {
                console.log(name, args)
            })
        }

        function remover(){
            $.ajax({
                url: './administrador/proc-excluir-usuario.php',
                method: 'post',
                data: { id: $('#modal_remover').val() }
            })

            $table.bootstrapTable('remove', {
                field: 'id',
                values: [$('#modal_remover').val()]
            })

        }

        $(function() {
            initTable()

            $('#locale').change(initTable)
        })
    </script>

</body>

</html>