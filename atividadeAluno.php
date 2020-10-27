<?php
require_once 'include/topo.php';
require_once 'classes.php';

$alunoAtividade = new AlunoAtividade();
$atividade = new Atividade();

?>
<div class="container-fluid">
    <div class="form-row">
        <div class="form-group col-md-10">
            <h1>Atividades Cadastradas</h1>
        </div>
        <div class="form-group col-md-2">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#cadastrar">Cadastrar</button>
        </div>
    </div>
    <table id="listar" class="display" style="width:100%">
        <thead class="text-center">
            <tr>
                <th>Nome da Atividade</th>    
                <th>Tipo de Atividade</th>    
                <th>Horas</th>
                <th>Data do Cadastro</th>
                <th>Situação</th>
                <th>Arquivo</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <?php foreach ($alunoAtividade->findAtividadesCadastradas($_SESSION['idAluno']) as $key => $value) : ?>
            <tr>
            <td><?php echo $value->descricao; ?></td>    
            <td><?php echo $value->nome; ?></td>
                <td class="text-center"><?php echo $value->horas_registradas; ?></td>
                
                <td class="text-center"><?php echo date("d/m/Y", strtotime($value->data_atividade));?></td>
                <td class="text-center"><?php echo $alunoAtividade->situacao($value->status); ?></td>
                <td class="text-center">
                    <a class="btn btn-info" href="arquivos/<?php echo $value->arquivo; ?>" download="<?php echo $value->descricao; ?>">
                        <i class="fas fa-cloud-download-alt"></i> Download
                    </a>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editar" onclick="preencheDados('editar', <?php echo '\''. $value->id . '\',' . '\''. $value->descricao . '\',' . '\''. $value->nome . '\',' . '\''. $value->horas_registradas . '\',' . '\''. $value->data_atividade . '\'' ?>)">Editar</button>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#excluir" onclick="preencheDados('excluir', <?php echo $value->id; ?>)">Excluir</button>
                </td>
            </tr>




        <?php endforeach; ?>
    </table>
</div>
<!-- Modal Excluir -->
<div class="modal fade" id="excluir" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Deseja Excluir esse registro?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="cursoController.php">
                <input type="hidden" name="idExcluir" id="idExcluir">

                <div class="modal-footer">
                    <button type='submit' name="excluir" class='btn btn-danger'>Excluir</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edição de Curso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form enctype="multipart/form-data" method="post" action="atividadeAlunoController.php">
                <div class="modal-body text-left">
                    <input type="hidden" value="<?php echo $value->id; ?>" name="id" id="id">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Nome da Atividade</label>
                            <input type="text" name="descricao" id="descricao" class="form-control" aria-describedby="helpId">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Tipo de Atividade</label>
                            <select class="form-control" name="atividade" id="atividade">
                                <option value="">Selecione</option>
                                <?php foreach ($atividade->findAll() as $key => $value) : ?>
                                    <option value="<?php echo $value->id; ?>" <?php ($value->id == VALOR_DO_BANCO) ? 'selected' : '';?>><?php echo $value->nome; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Horas</label>
                            <input type="time" name="horas" id="horas" class="form-control" aria-describedby="helpId">
                        </div>

                        <div class="form-group col-md-6">
                            <label>Data de Realização</label>
                            <input type="date" name="datas" id="datas" class="form-control" aria-describedby="helpId">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-10">
                            <label>Anexar Arquivo</label>
                            <input type="file" name="arquivo" id="arquivo" class="form-control-file" aria-describedby="helpId">
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="submit" name="editar" class="btn btn-success">Editar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Cadastrar -->
<div class="modal fade" id="cadastrar" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cadastro de Atividades</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" action="atividadeAlunoController.php">
                <div class="modal-body text-left">

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Nome da Atividade</label>
                            <input type="text" name="descricao" id="descricao" class="form-control" aria-describedby="helpId">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Tipo de Atividade</label>
                            <select class="form-control" name="atividade" id="atividade">
                                <option value="">Selecione</option>
                                <?php foreach ($atividade->findAll() as $key => $value) : ?>
                                    <option value="<?php echo $value->id; ?>"><?php echo $value->nome; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Horas</label>
                            <input type="time" name="horas" id="horas" class="form-control" aria-describedby="helpId">
                        </div>

                        <div class="form-group col-md-6">
                            <label>Data de Realização</label>
                            <input type="date" name="data" id="data" class="form-control" aria-describedby="helpId">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-10">
                            <label>Anexar Arquivo</label>
                            <input type="file" name="arquivo" id="arquivo" class="form-control-file" aria-describedby="helpId">
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="submit" name="cadastrar" class="btn btn-success">Salvar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once 'include/rodape.php' ?>

<script>
    $(document).ready(function() {
        $('#listar').dataTable({
            searching: false
        });
    });

    function preencheDados(tipo, id, descricao, atividade, hora, data) {
        if (tipo == 'editar') {
            $('#id').val(id);
            $('#descricao').val(descricao);
            $('#atividade').val(atividade);
            $('#horas').val(hora);
            $('#datas').val(data);
        } else if (tipo == 'excluir') {
            $('#idExcluir').val(id);
        }

    }
</script>