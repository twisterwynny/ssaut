
<!-- Modal -->
<div class="modal fade login" id="modal-acesso">
  <div class="modal-dialog ">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title">Login</h4>
              <button type="button" class="close ml-auto" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
              <div class="box">
                  <div class="content">
                      <div>
                          <img src="img/antares_modal.png" alt="icone" class="icone_antares" style="margin-top: -5px;">
                      </div>
                      <div class="error"></div>
                      <div class="form loginBox">
                          <form method="POST" action="access/checar.php" accept-charset="UTF-8" id="form_login">
                              <span style="display: none; color: red" class="text-center mb-2" id="invalido">Usuário/senha inválidos</span>
                              <input id="email" class="form-control" type="text" placeholder="Email" name="email">
                              <input id="senha_login" class="form-control" type="password" placeholder="Senha" name="senha">
                              <button class="btn btn-primary btn-block" type="submit" id="btn_login">Entrar</button>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
          <div class="modal-footer">
              <div class="forgot login-footer">
                  <span>Deseja <a href="#" data-toggle="modal" data-target="#cadastro" data-dismiss="modal" >criar uma conta</a>?</span>
              </div>
          </div>
      </div>
  </div>
</div>

<div class="modal fade" id="cadastro">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title mb-0">Cadastro da Instituição de Ensino</h4>
                    <button type="button" class="close ml-auto" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="box">
                        <div class="content">
                            <div class="form loginBox">
                                <form method="post" action="escola/proc-cad-escola.php" accept-charset="UTF-8" id="form_cadastro">
                                    <div class="form-row">
                                        <div class="col">
                                            <label>Nome da instituição</label>
                                            <input type="text" class="form-control" name="nome" id="nome" aria-describedby="emailHelp" placeholder="Nome da Instituição" required="">
                                        </div>
                                    </div>
                                    <div class="form-row mt-2 mb-1">
                                        <div class="col-5">
                                            <label>Email</label>
                                             <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="E-mail" required="">
                                        </div>
                                        <div class="col-3">
                                            <label>Senha (Apenas 4 digitos)</label>
                                            <input type="password" class="form-control" name="senha" id="senha" placeholder="Senha" required="">
                                        </div>
                                        <div class="col-4">
                                            <label>Telefone</label>
                                           <input type="text" class="form-control" name="fone" id="fone" placeholder="Telefone" required="">
                                        </div>
                                    </div>
                                    <div class="form-row mt-2 mb-1">
                                        <div class="col">
                                            <label>CEP</label>
                                             <input type="text" class="form-control" name="cep" id="cep" placeholder="CEP" required="">
                                        </div>
                                        <div class="col">
                                            <label for="rua"> Rua/Avenida/Caminho: </label>
                                            <input type="text" class="form-control" name="rua" id="rua" placeholder="Rua/Avenida/Caminho" required="">
                                        </div>
                                        <div class="col">
                                            <label for="numero"> Número: </label>
                                            <input type="text" class="form-control" name="numero" id="numero" placeholder="Número da casa / prédio" required="">
                                        </div>
                                    </div>
                                    <div class="form-row mt-2 mb-1">
                                        <div class="col">
                                            <label for="bairro"> Bairro/Conjunto: </label>
                                            <input type="text" class="form-control" name="bairro" id="bairro" placeholder="Bairro/Conjunto" required="">
                                        </div>
                                        <div class="col">
                                            <label for="complemento"> Complemento: </label>
                                            <input type="text" class="form-control" name="complemento" id="complemento" placeholder="Complemento" required="">
                                        </div>
                                        <div class="col">
                                            <label for="ponto_referencia"> Ponto de Referência: </label>
                                            <input type="text" class="form-control" name="ponto_referencia" id="ponto_referencia" placeholder="Ponto de Referência" required="">
                                        </div>
                                    </div>
                                    <div class="form-row mt-2 mb-1">
                                        <div class="col">
                                            <label for="estado"> Estado / UF: </label>
                                            <input type="text" class="form-control" name="estado" id="estado" placeholder="Estado / UF" required="">
                                        </div>
                                        <div class="col">
                                            <label for="pais"> País: </label>
                                            <input type="text" class="form-control" name="pais" id="pais" placeholder="País" required="">
                                        </div>
                                        <div class="col">
                                            <label for="cidade"> Cidade: </label>
                                            <input type="text" class="form-control" name="cidade" id="cidade" placeholder="Cidade" required="">
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-block mt-3 mb-0" type="submit">Cadastrar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="forgot login-footer">
                        <span>Deseja <a href="#" data-toggle="modal" data-target="#modal-acesso" data-dismiss="modal">fazer login</a>?</span>
                    </div>
                </div>
            </div>
        </div>
    </div>