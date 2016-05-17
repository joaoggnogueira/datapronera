<?php $this->session->set_userdata('curr_content', 'rel_dinamico'); ?>

<script type="text/javascript">

    $(document).ready(function() {

        var url = "<?php echo site_url('relatorio_dinamico').'/'; ?>";

        /**
         * Trotamento da seleção de tabelas principais, provindas do checkbox.
         * Aqui sera mostrado e 'escondido' o que for interessante e não relevante ao usuário.
         * @return {[type]} [description]
         */
        $( '#tabelas' ).change(function () {
            var str = "";

            //Isola a seleção
            $( "select option:selected" ).each(function() {
                str += $( this ).val();
            });

            //Esconde todos os dados e seus atributos primários
            $('#curso_op').css('display', 'none');
            $('#relacionamento_curso').css('display', 'none');

            $('#professor_op').css('display', 'none');
            $('#relacionamento_professor').css('display', 'none');

            $('#educando_op').css('display', 'none');
            $('#relacionamento_educando').css('display', 'none');

            $('#ies_op').css('display', 'none');
            $('#relacionamento_ies').css('display', 'none');

            $('#par_op').css('display', 'none');
            $('#relacionamento_par').css('display', 'none');

            //Mostra apenas o dado e o atributo selecionado
            switch(str){
                case 'curso':
                    $('#curso_op').css('display', 'block');
                    $('#relacionamento_curso').css('display', 'block');
                    break;

                case 'professor':
                    $('#professor_op').css('display', 'block');
                    $('#relacionamento_professor').css('display', 'block');
                    break;

                case 'educando':
                    $('#educando_op').css('display', 'block');
                    $('#relacionamento_educando').css('display', 'block');
                    break;

                case 'ies':
                    $('#ies_op').css('display', 'block');
                    $('#relacionamento_ies').css('display', 'block');
                    break;

                case 'parceiro':
                    $('#par_op').css('display', 'block');
                    $('#relacionamento_par').css('display', 'block');
                    break;
            }
        }).change(); //Executado na alteração do Combo

        /**
         * Select Join primário da tabela de curso.
         * @return {[type]} [description]
         */
        $( '#relacionamento_curso' ).on( "click", function() {

            //Esconde todos os dados e seus atributos primários
            $('#dados_modalidade').css('display', 'none');
            $('#dados_pesquisador').css('display', 'none');
            $('#relacionamento_curso_pessoa').css('display', 'none');
            $('#dados_superintendencia').css('display', 'none');

            //Mostra apenas o dado e o atributo selecionado
            if ($("#curMod").is(":checked"))
            {
                $('#dados_modalidade').css('display', 'block');
            }
            if ($("#curPes").is(":checked"))
            {
                $('#dadCur').css('display', 'block');
                $('#dados_pesquisador').css('display', 'block');
                $('#relacionamento_curso_pessoa').css('display', 'block');
            }
            if ($("#curSup").is(":checked"))
            {
                $('#dados_superintendencia').css('display', 'block');
            }
        });

        /**
         * Join secundário da tabela de pessoas com a tabela curso.
         * @return {[type]} [description]
         */
        $( '#relacionamento_curso_pessoa' ).on( "click", function() {

            //Esconde todos os dados e seus atributos primários
            $('#dados_pesquisador_sec_Func').css('display', 'none');

            //Mostra apenas o dado e o atributo selecionado
            if ($("#curPesFunc").is(":checked"))
            {
                $('#dados_pesquisador_sec_Func').css('display', 'block');
            }
        });

        /**
         * Select e Joins primários da tabela de professores.
         * @return {[type]} [description]
         */
        $( '#relacionamento_professor' ).on( "click", function() {

            //Esconde todos os dados e seus atributos primários
            $('#dados_modalidade_pro').css('display', 'none');
            $('#dados_curso_pro').css('display', 'none');
            $('#dados_superintendencia_pro').css('display', 'none');

            //Mostra apenas o dado e o atributo selecionado
            if ($("#proMod").is(":checked"))
            {
                $('#dados_modalidade_pro').css('display', 'block');
            }
            if ($("#proCur").is(":checked"))
            {
                $('#dados_curso_pro').css('display', 'block');
            }
            if ($("#proSup").is(":checked"))
            {
                $('#dados_superintendencia_pro').css('display', 'block');
            }
        });

        /**
         * Select e Joins primários da tabela de Educando.
         * @return {[type]} [description]
         */
        $( '#relacionamento_educando' ).on( "click", function() {

            //Esconde todos os dados e seus atributos primários
            $('#dados_superintendencia_edu').css('display', 'none');
            $('#dados_curso_edu').css('display', 'none');
            $('#dados_modalidade_edu').css('display', 'none');

            //Mostra apenas o dado e o atributo selecionado
            if ($("#eduSup").is(":checked"))
            {
                $('#dados_superintendencia_edu').css('display', 'block');
            }
            if ($("#eduCur").is(":checked"))
            {
                $('#dados_curso_edu').css('display', 'block');
            }
            if ($("#eduMod").is(":checked"))
            {
                $('#dados_modalidade_edu').css('display', 'block');
            }
        });

        /**
         * Join terciário da tabela de pessoas com a tabela de Instituição de Ensino.
         * @return {[type]} [description]
         */
        $( '#relacionamento_ies_funcao' ).on( "click", function() {

            //Esconde todos os dados e seus atributos primários
            $('#dados_pesquisador_ies_Func').css('display', 'none');

            //Mostra apenas o dado e o atributo selecionado
            if ($("#iesFun").is(":checked"))
            {
                $('#dados_pesquisador_ies_Func').css('display', 'block');
            }
        });

        /**
         * Join secundário da tabela de pessoas com a tabela de Instituição de Ensino.
         * @return {[type]} [description]
         */
        $( '#relacionamento_ies' ).on( "click", function() {

            //Esconde todos os dados e seus atributos primários
            $('#relacionamento_ies_curso').css('display', 'none');
            $('#dados_curso_ies').css('display', 'none');
            $('#relacionamento_ies_funcao').css('display', 'none');
            $('#dados_pesquisador_ies').css('display', 'none');
            $('#dados_modalidade_ies').css('display', 'none');
            $('#dados_pesquisador_ies').css('display', 'none');
            $('#dados_superintendencia_ies').css('display', 'none');

            //Mostra apenas o dado e o atributo selecionado
            if ($("#iesCur").is(":checked"))
            {
                $('#relacionamento_ies_curso').css('display', 'block');
                $('#dados_curso_ies').css('display', 'block');
                $( '#relacionamento_ies_curso' ).click();
            }
        });

        /**
         * Join terciário da tabela de pessoas com a tabela de Instituição de Ensino.
         * @return {[type]} [description]
         */
        $( '#relacionamento_ies_curso' ).on( "click", function() {

            //Esconde todos os dados e seus atributos primários
            $('#relacionamento_ies_funcao').css('display', 'none');
            $('#dados_pesquisador_ies').css('display', 'none');
            $('#dados_modalidade_ies').css('display', 'none');
            $('#dados_pesquisador_ies').css('display', 'none');
            $('#dados_superintendencia_ies').css('display', 'none');

            //Mostra apenas o dado e o atributo selecionado
            if ($("#iesPes").is(":checked"))
            {
                $('#relacionamento_ies_funcao').css('display', 'block');
                $('#dados_pesquisador_ies').css('display', 'block');
            }
            if ($("#iesMod").is(":checked"))
            {
                $('#dados_modalidade_ies').css('display', 'block');
            }
            if ($("#iesPes").is(":checked"))
            {
                $('#dados_pesquisador_ies').css('display', 'block');
            }
            if ($("#iesSup").is(":checked"))
            {
                $('#dados_superintendencia_ies').css('display', 'block');
            }
        });

        /**
         * Join terciário da tabela de pessoas com a tabela de Instituição de Ensino.
         * @return {[type]} [description]
         */
        $( '#relacionamento_par_funcao' ).on( "click", function() {

            //Esconde todos os dados e seus atributos primários
            $('#dados_pesquisador_par_Func').css('display', 'none');

            //Mostra apenas o dado e o atributo selecionado
            if ($("#parFun").is(":checked"))
            {
                $('#dados_pesquisador_par_Func').css('display', 'block');
            }
        });

        /**
         * Join secundário da tabela de pessoas com a tabela de Instituição de Ensino.
         * @return {[type]} [description]
         */
        $( '#relacionamento_par' ).on( "click", function() {

            //Esconde todos os dados e seus atributos primários
            $('#relacionamento_par_curso').css('display', 'none');
            $('#dados_curso_par').css('display', 'none');
            $('#relacionamento_par_funcao').css('display', 'none');
            $('#dados_pesquisador_par').css('display', 'none');
            $('#dados_modalidade_par').css('display', 'none');
            $('#dados_pesquisador_par').css('display', 'none');
            $('#dados_superintendencia_par').css('display', 'none');

            //Mostra apenas o dado e o atributo selecionado
            if ($("#parCur").is(":checked"))
            {
                $('#relacionamento_par_curso').css('display', 'block');
                $('#dados_curso_par').css('display', 'block');
                $( '#relacionamento_par_curso' ).click();
            }
        });

        /**
         * Join terciário da tabela de pessoas com a tabela de Instituição de Ensino.
         * @return {[type]} [description]
         */
        $( '#relacionamento_par_curso' ).on( "click", function() {

            //Esconde todos os dados e seus atributos primários
            $('#relacionamento_par_funcao').css('display', 'none');
            $('#dados_pesquisador_par').css('display', 'none');
            $('#dados_modalidade_par').css('display', 'none');
            $('#dados_pesquisador_par').css('display', 'none');
            $('#dados_superintendencia_par').css('display', 'none');

            //Mostra apenas o dado e o atributo selecionado
            if ($("#parPes").is(":checked"))
            {
                $('#relacionamento_par_funcao').css('display', 'block');
                $('#dados_pesquisador_par').css('display', 'block');
            }
            if ($("#parMod").is(":checked"))
            {
                $('#dados_modalidade_par').css('display', 'block');
            }
            if ($("#parPes").is(":checked"))
            {
                $('#dados_pesquisador_par').css('display', 'block');
            }
            if ($("#parSup").is(":checked"))
            {
                $('#dados_superintendencia_par').css('display', 'block');
            }
        });

        /**
         * Gerando relatórios de acordo com as opções selecionadas pelo usuário.
         * @return {[type]} [description]
         */
        $('#gerar').click( function() {

            var tipo_selecao = $('#tabelas').val();
            if(tipo_selecao == 'curso')
            {
                var Curso = new Array();
                $('#dados_curso input:checked').each(function() {
                    Curso.push("Cur.`" + $(this).attr('value') + "`");
                });
                var Superintendencia = new Array();
                $('#dados_superintendencia input:checked').each(function() {
                    Superintendencia.push("Sup.`" + $(this).attr('value') + "`");
                });
                var Modalidade = new Array();
                $('#dados_modalidade input:checked').each(function() {
                    Modalidade.push("Moda.`" + $(this).attr('value') + "`");
                });
                var Pesquisador = new Array();
                $('#dados_pesquisador_Principal input:checked').each(function() {
                    Pesquisador.push("Pes.`" + $(this).attr('value') + "`");
                });
                var Cidade = new Array();
                $('#dados_pesquisador_sec_cidade input:checked').each(function() {
                    Cidade.push("Cid.`" + $(this).attr('value') + "`");
                });
                var Estado = new Array();
                $('#dados_pesquisador_sec_estado input:checked').each(function() {
                    Estado.push("Est.`" + $(this).attr('value') + "`");
                });
                var Funcao = new Array();
                $('#dados_pesquisador_sec_Func input:checked').each(function() {
                    Funcao.push("Fun.`" + $(this).attr('value') + "`");
                });
                var DadosSolicitados = new Array();
                $.merge( $.merge( $.merge( $.merge( $.merge( $.merge( $.merge( DadosSolicitados, Curso ), Superintendencia ), Modalidade ), Pesquisador), Cidade), Estado), Funcao);

                if( DadosSolicitados.length > 0)
                {
                    $.post(url + 'Router/curso',{data:DadosSolicitados},function(){
                        window.open("<?php echo base_url('rldm.pdf'); ?>", '_blank');
                    });
                }
                else
                {
                    alert('Selecione ao menos uma informação para ser buscada.');
                }
            }
            else if (tipo_selecao == 'professor')
            {
                var Professor = new Array();
                $('#dados_pro input:checked').each(function() {
                    Professor.push("Pro.`" + $(this).attr('value') + "`");
                });
                var Curso = new Array();
                $('#dados_curso_pro input:checked').each(function() {
                    Curso.push("Cur.`" + $(this).attr('value') + "`");
                });
                var Superintendencia = new Array();
                $('#dados_superintendencia_pro input:checked').each(function() {
                    Superintendencia.push("Sup.`" + $(this).attr('value') + "`");
                });
                var Modalidade = new Array();
                $('#dados_modalidade_pro input:checked').each(function() {
                    Modalidade.push("Moda.`" + $(this).attr('value') + "`");
                });
                var DadosSolicitados = new Array();
                $.merge( $.merge( $.merge( $.merge( DadosSolicitados, Professor ), Curso ), Superintendencia), Modalidade);

                if( DadosSolicitados.length > 0)
                {
                    $.post(url + 'Router/professor',{data:DadosSolicitados},function(){
                        window.open("<?php echo base_url('rldm.pdf'); ?>", '_blank');
                    });
                }
                else
                {
                    alert('Selecione ao menos uma informação para ser buscada.');
                }
            }
            else if (tipo_selecao == 'educando')
            {
                var Educando = new Array();
                $('#dados_edu input:checked').each(function() {
                    Educando.push("Edu.`" + $(this).attr('value') + "`");
                });
                var Curso = new Array();
                $('#dados_curso_edu input:checked').each(function() {
                    Curso.push("Cur.`" + $(this).attr('value') + "`");
                });
                var Superintendencia = new Array();
                $('#dados_superintendencia_edu input:checked').each(function() {
                    Superintendencia.push("Sup.`" + $(this).attr('value') + "`");
                });
                var Modalidade = new Array();
                $('#dados_modalidade_edu input:checked').each(function() {
                    Modalidade.push("Moda.`" + $(this).attr('value') + "`");
                });
                var DadosSolicitados = new Array();
                $.merge( $.merge( $.merge( $.merge( DadosSolicitados, Educando ), Curso ), Superintendencia), Modalidade);

                if( DadosSolicitados.length > 0)
                {
                    $.post(url + 'Router/educando',{data:DadosSolicitados},function() {
                        window.open("<?php echo base_url('rldm.pdf'); ?>", '_blank');
                    });
                }
                else
                {
                    alert('Selecione ao menos uma informação para ser buscada.');
                }
            }
            else if (tipo_selecao == 'ies')
            {
                var IES = new Array();
                $('#dados_ies input:checked').each(function() {
                    IES.push("InsEn.`" + $(this).attr('value') + "`");
                });
                var Curso = new Array();
                $('#dados_curso_ies input:checked').each(function() {
                    Curso.push("Cur.`" + $(this).attr('value') + "`");
                });
                var Superintendencia = new Array();
                $('#dados_modalidade_ies input:checked').each(function() {
                    Superintendencia.push("Sup.`" + $(this).attr('value') + "`");
                });
                var Modalidade = new Array();
                $('#dados_pesquisador_ies input:checked').each(function() {
                    Modalidade.push("Moda.`" + $(this).attr('value') + "`");
                });
                var Pesquisador = new Array();
                $('#dados_pesquisador_ies_cidade input:checked').each(function() {
                    Pesquisador.push("Pes.`" + $(this).attr('value') + "`");
                });
                var Cidade = new Array();
                $('#dados_pesquisador_ies_estado input:checked').each(function() {
                    Cidade.push("Cid.`" + $(this).attr('value') + "`");
                });
                var Estado = new Array();
                $('#dados_pesquisador_ies_Func input:checked').each(function() {
                    Estado.push("Est.`" + $(this).attr('value') + "`");
                });
                var Funcao = new Array();
                $('#dados_superintendencia_ies input:checked').each(function() {
                    Funcao.push("Fun.`" + $(this).attr('value') + "`");
                });
                var DadosSolicitados = new Array();
                $.merge( $.merge( $.merge( $.merge( $.merge( $.merge( $.merge( $.merge( DadosSolicitados, IES ), Curso ), Superintendencia ), Modalidade ), Pesquisador), Cidade), Estado), Funcao);

                if( DadosSolicitados.length > 0)
                {
                    $.post(url + 'Router/ies',{data:DadosSolicitados},function(){
                        window.open("<?php echo base_url('rldm.pdf'); ?>", '_blank');
                    });
                }
                else
                {
                    alert('Selecione ao menos uma informação para ser buscada.');
                }
            }
            else if (tipo_selecao == 'parceiro')
            {
                var parceiro = new Array();
                $('#dados_par input:checked').each(function() {
                    parceiro.push("Par.`" + $(this).attr('value') + "`");
                });
                var Curso = new Array();
                $('#dados_curso_par input:checked').each(function() {
                    Curso.push("Cur.`" + $(this).attr('value') + "`");
                });
                var Superintendencia = new Array();
                $('#dados_modalidade_par input:checked').each(function() {
                    Superintendencia.push("Sup.`" + $(this).attr('value') + "`");
                });
                var Modalidade = new Array();
                $('#dados_pesquisador_par input:checked').each(function() {
                    Modalidade.push("Moda.`" + $(this).attr('value') + "`");
                });
                var Pesquisador = new Array();
                $('#dados_pesquisador_par_cidade input:checked').each(function() {
                    Pesquisador.push("Pes.`" + $(this).attr('value') + "`");
                });
                var Cidade = new Array();
                $('#dados_pesquisador_par_estado input:checked').each(function() {
                    Cidade.push("Cid.`" + $(this).attr('value') + "`");
                });
                var Estado = new Array();
                $('#dados_pesquisador_par_Func input:checked').each(function() {
                    Estado.push("Est.`" + $(this).attr('value') + "`");
                });
                var Funcao = new Array();
                $('#dados_superintendencia_par input:checked').each(function() {
                    Funcao.push("Fun.`" + $(this).attr('value') + "`");
                });
                var DadosSolicitados = new Array();
                $.merge( $.merge( $.merge( $.merge( $.merge( $.merge( $.merge( $.merge( DadosSolicitados, parceiro ), Curso ), Superintendencia ), Modalidade ), Pesquisador), Cidade), Estado), Funcao);

                if( DadosSolicitados.length > 0)
                {
                    $.post(url + 'Router/parceiro',{data:DadosSolicitados},function(){
                        window.open("<?php echo base_url('rldm.pdf'); ?>", '_blank');
                    });
                }
                else
                {
                    alert('Selecione ao menos uma informação para ser buscada.');
                }
            }
        });

    });
</script>

<form>
    <fieldset>
        <legend> Relatórios Dinâmicos </legend>

        <!-- --------------------------------------------------------- -->
        <!--   Relação de Selects principais demonstrados ao usuário   -->
        <!-- --------------------------------------------------------- -->
        <p> Selecione uma das tabelas primárias, para cada opção escolhida será oferecido ao usuário novas possibilidade
            de seleção baseado no relacionamento das informações, sendo possível escolher apenas os
            dados desejados pelo usuário.</p>
        <br><p>Escolha a Tabela Principal:</p>
        <div class="form-group">
            <select id="tabelas" style="">
                <option disabled selected>Selecione o Formulário</option>
                <option value="curso"> Curso e Adjacentes</option>
                <option value="professor"> Professor e Adjacentes</option>
                <option value="educando"> Educando e Adjacentes</option>
                <option value="ies"> Instituição de Ensino e Adjacentes</option>
                <option value="parceiro"> Parceiros e Adjacentes</option>
            </select>
        </div>

        <!-- --------------------------------------------------------- -->
        <!--    Relação de Joins primários e secundários de 'Curso'    -->
        <!-- --------------------------------------------------------- -->
        <div id="curso_op" style="display:none;">
            <p>Escolha os possíveis relacionamentos a "Cursos":</p>
            <!-- Joins Primários -->
            <div id="relacionamento_curso" style="display:none;">
                <input type="checkbox" id="curMod" value="cur_Mod"> Modalidade<br>
                <input type="checkbox" id="curPes" value="cur_Pes"> Pessoa (Pesquisador)<br>
                <input type="checkbox" id="curSup" value="cur_Sup"> Superintendência<br>
            </div>
            <!-- Joins Secundários -->
            <div id="relacionamento_curso_pessoa" style="display:none;">
                <br><p>Escolha os possíveis relacionamentos a "Pessoa (Pesquisador)":</p>
                <input type="checkbox" id="curPesFunc" value="cur_Pes_Func"> Função<br>
            </div>
            <!-- Dados Esperados -->
            <div>
                <br><p>Selecione os dados que deseja recuperar através do relatório.</p>
            </div>
            <div id="dadCur" class="row" style="display:block;">
                <!-- Dados Primários -->
                <div class="col-md-3">
                    <div id="dados_curso" style="display:block;">
                        <br><p>Informações de Curso: </p>

                        <input type="checkbox" value="nome"> Nome<br>
                        <input type="checkbox" value="ativo_inativo"> Estado (Ativo ou Inativo)<br>
                        <input type="checkbox" value="validacao"> Validação<br>
                        <input type="checkbox" value="obs"> Observações<br>
                    </div>
                </div>
                <!-- Dados Secundários -->
                <div class="col-md-3">
                    <div id="dados_modalidade" style="display:none;">
                        <br><p>Informações da Modalidade: </p>

                        <input type="checkbox" value="nome"> Nome<br>
                        <input type="checkbox" value="descricao"> Descrição<br>
                        <input type="checkbox" value="nivel"> Nível<br>
                    </div>
                </div>
                <!-- Dados Secundários -->
                <div class="col-md-3">
                    <div id="dados_pesquisador" style="display:none;">
                        <br><p>Informações de Pessoa (Pesquisador): </p>
                        <div id="dados_pesquisador_Principal">
                            <input type="checkbox" value="nome"> Nome<br>
                            <input type="checkbox" value="cpf"> CPF<br>
                            <input type="checkbox" value="rg"> RG<br>
                            <input type="checkbox" value="rg_emissor"> Orgão emissor<br>
                            <input type="checkbox" value="genero"> Gênero<br>
                            <input type="checkbox" value="data_nascimento"> Data de Nascimento<br>
                            <input type="checkbox" value="telefone_1"> Telefone Principal<br>
                            <input type="checkbox" value="telefone_2"> Telefone Secundário<br>
                            <input type="checkbox" value="ativo_inativo"> Estado (Ativo ou Inativo)<br>
                            <input type="checkbox" value="logradouro"> Logradouro<br>
                            <input type="checkbox" value="numero"> Numero Logradouro<br>
                            <input type="checkbox" value="bairro"> Bairro<br>
                            <input type="checkbox" value="cep"> CEP<br>
                            <input type="checkbox" value="complemento"> Complemento<br>
                        </div>
                        <div id="dados_pesquisador_sec_cidade">
                            <input type="checkbox" value="nome"> Cidade<br>
                        </div>
                        <div id="dados_pesquisador_sec_estado">
                            <input type="checkbox" value="sigla"> Estado (Sigla)<br>
                        </div>
                        <div id="dados_pesquisador_sec_Func" style="display:none;">
                            <input type="checkbox" value="funcao"> Função<br>
                        </div>
                    </div>
                </div>
                <!-- Dados Secundários -->
                <div class="col-md-3">
                    <div id="dados_superintendencia" style="display:none;">
                        <br><p>Informações de Superintendência: </p>

                        <input type="checkbox" value="nome"> Nome<br>
                        <input type="checkbox" value="nome_responsavel"> Responsável<br>
                        <input type="checkbox" value="ativo_inativo"> Estado (Ativo ou Inativo)<br>
                    </div>
                </div>
            </div>
        </div>

        <!-- --------------------------------------------------------- -->
        <!--  Relação de Joins primários e secundários de 'Professor'  -->
        <!-- --------------------------------------------------------- -->
        <div id="professor_op" style="display:none;">
            <p>Escolha os possíveis relacionamentos a "Professores":</p>
            <!-- Joins Primários -->
            <div id="relacionamento_professor" style="display:none;">
                <input type="checkbox" id="proCur" value="pro_Curso"> Curso<br>
                <input type="checkbox" id="proSup" value="pro_Sup"> Superintendência<br>
                <input type="checkbox" id="proMod" value="pro_Mod"> Modalidade<br>
            </div>
            <div>
                <br><p>Selecione os dados que deseja recuperar através do relatório.</p>
            </div>
            <div id="dadProf" class="row" style="display:block;">
                <!-- Dados Primários -->
                <div class="col-md-3">
                    <div id="dados_pro" style="display:block;">
                        <br><p>Informações de Professor: </p>

                        <input type="checkbox" value="nome"> Nome<br>
                        <input type="checkbox" value="cpf"> CPF<br>
                        <input type="checkbox" value="rg"> RG<br>
                        <input type="checkbox" value="data_nascimento"> Data de Nascimento<br>
                        <input type="checkbox" value="genero"> Gênero<br>
                        <input type="checkbox" value="titulacao"> Titulação<br>
                        <input type="checkbox" value="disciplina_ni"> Disciplina<br>
                    </div>
                </div>
                <!-- Dados Secundários -->
                <div class="col-md-3">
                    <div id="dados_curso_pro" style="display:none;">
                        <br><p>Informações de Curso: </p>

                        <input type="checkbox" value="nome"> Nome<br>
                        <input type="checkbox" value="ativo_inativo"> Estado (Ativo ou Inativo)<br>
                        <input type="checkbox" value="validacao"> Validação<br>
                        <input type="checkbox" value="obs"> Observações<br>
                    </div>
                </div>
                <!-- Dados Secundários -->
                <div class="col-md-3">
                    <div id="dados_superintendencia_pro" style="display:none;">
                        <br><p>Informações de Superintendência: </p>

                        <input type="checkbox" value="nome"> Nome<br>
                        <input type="checkbox" value="nome_responsavel"> Responsável<br>
                        <input type="checkbox" value="ativo_inativo"> Estado (Ativo ou Inativo)<br>
                    </div>
                </div>
                <!-- Dados Secundários -->
                <div class="col-md-3">
                    <div id="dados_modalidade_pro" style="display:none;">
                        <br><p>Informações da Modalidade: </p>

                        <input type="checkbox" value="nome"> Nome<br>
                        <input type="checkbox" value="descricao"> Descrição<br>
                        <input type="checkbox" value="nivel"> Nível<br>
                    </div>
                </div>
            </div>
        </div>

        <!-- --------------------------------------------------------- -->
        <!--   Relação de Joins primários e secundários de 'Educando'  -->
        <!-- --------------------------------------------------------- -->
        <div id="educando_op" style="display:none;">
            <p>Escolha os possíveis relacionamentos a "Educando":</p>
            <!-- Joins Primários -->
            <div id="relacionamento_educando" style="display:none;">
                <input type="checkbox" id="eduCur" value="edu_Curso"> Curso<br>
                <input type="checkbox" id="eduSup" value="edu_Super"> Superintendência<br>
                <input type="checkbox" id="eduMod" value="edu_Mod"> Modalidade<br>
            </div>
            <div>
                <br><p>Selecione os dados que deseja recuperar através do relatório.</p>
            </div>
            <div id="dadEdu" class="row" style="display:block;">
                <!-- Dados Primários -->
                <div class="col-md-3">
                    <div id="dados_edu" style="display:block;">
                        <br><p>Informações de Educando: </p>

                        <input type="checkbox" value="nome"> Nome<br>
                        <input type="checkbox" value="cpf"> CPF<br>
                        <input type="checkbox" value="rg"> RG<br>
                        <input type="checkbox" value="genero"> Gênero<br>
                        <input type="checkbox" value="data_nascimento"> Data de Nascimento<br>
                        <input type="checkbox" value="idade"> Idade<br>
                        <input type="checkbox" value="tipo_territorio"> Tipo Território<br>
                        <input type="checkbox" value="nome_territorio"> Nome Território<br>
                        <input type="checkbox" value="concluinte"> Concluinte<br>
                        <div id="dados_edu_cidade"> <!-- Prefixo diferente de Edu -->
                            <input type="checkbox" value="nome"> Cidade<br>
                        </div>
                        <div id="dados_edu_estado"> <!-- Prefixo diferente de Edu -->
                            <input type="checkbox" value="sigla"> Estado (Sigla)<br>
                        </div>
                    </div>
                </div>
                <!-- Dados Secundários -->
                <div class="col-md-3">
                    <div id="dados_curso_edu" style="display:none;">
                        <br><p>Informações de Curso: </p>

                        <input type="checkbox" value="nome"> Nome<br>
                        <input type="checkbox" value="ativo_inativo"> Estado (Ativo ou Inativo)<br>
                        <input type="checkbox" value="validacao"> Validação<br>
                        <input type="checkbox" value="obs"> Observações<br>
                    </div>
                </div>
                <!-- Dados Secundários -->
                <div class="col-md-3">
                    <div id="dados_superintendencia_edu" style="display:none;">
                        <br><p>Informações de Superintendência: </p>

                        <input type="checkbox" value="nome"> Nome<br>
                        <input type="checkbox" value="nome_responsavel"> Responsável<br>
                        <input type="checkbox" value="ativo_inativo"> Estado (Ativo ou Inativo)<br>
                    </div>
                </div>
                <!-- Dados Secundários -->
                <div class="col-md-3">
                    <div id="dados_modalidade_edu" style="display:none;">
                        <br><p>Informações da Modalidade: </p>

                        <input type="checkbox" value="nome"> Nome<br>
                        <input type="checkbox" value="descricao"> Descrição<br>
                        <input type="checkbox" value="nivel"> Nível<br>
                    </div>
                </div>
            </div>
        </div>

        <!-- --------------------------------------------------------- -->
        <!--     Relação de Joins primários e secundários de 'IES'     -->
        <!-- --------------------------------------------------------- -->
        <div id="ies_op" style="display:none;">
            <p>Escolha os possíveis relacionamentos a "Instituição de Ensino":</p>
            <!-- Joins Primários -->
            <div id="relacionamento_ies" style="display:none;">
                <input type="checkbox" id="iesCur" value="ies_Cur"> Curso<br>
            </div>
            <!-- Joins Secundários -->
            <div id="relacionamento_ies_curso" style="display:none;">
                <br><p>Escolha os possíveis relacionamentos a "Curso":</p>
                <input type="checkbox" id="iesMod" value="ies_Mod"> Modalidade<br>
                <input type="checkbox" id="iesPes" value="ies_Pes"> Pessoa (Pesquisador)<br>
                <input type="checkbox" id="iesSup" value="ies_Sup"> Superintendência<br>
            </div>
            <!-- Joins Terciários -->
            <div id="relacionamento_ies_funcao" style="display:none;">
                <br><p>Escolha os possíveis relacionamentos a "Pessoa (Pesquisador)":</p>
                <input type="checkbox" id="iesFun" value="ies_Func"> Função<br>
            </div>
            <!-- Dados Esperados -->
            <div>
                <br><p>Selecione os dados que deseja recuperar através do relatório.</p>
            </div>
            <div id="dadIes" class="row" style="display:block;">
                <!-- Dados Primários -->
                <div class="col-md-3">
                    <div id="dados_ies" style="display:block;">
                        <br><p>Informações de Instituição de Ensino: </p>

                        <input type="checkbox" value="nome"> Nome<br>
                        <input type="checkbox" value="sigla"> Sigla<br>
                        <input type="checkbox" value="unidade"> Unidade<br>
                        <input type="checkbox" value="departamento"> Departamento<br>
                        <input type="checkbox" value="rua"> Rua<br>
                        <input type="checkbox" value="numero"> Número<br>
                        <input type="checkbox" value="complemento"> Complemento<br>
                        <input type="checkbox" value="cep"> CEP<br>
                        <input type="checkbox" value="telefone1"> Telefone Principal<br>
                        <input type="checkbox" value="telefone2"> Telefone Secundário<br>
                        <input type="checkbox" value="pagina_web"> Página da WEB<br>
                        <input type="checkbox" value="campus"> Campus<br>
                        <input type="checkbox" value="natureza_instituicao"> Natureza Instituição<br>
                    </div>
                </div>
                <!-- Dados Secundários -->
                <div class="col-md-2">
                    <div id="dados_curso_ies" style="display:none;">
                        <br><p>Informações de Curso: </p>

                        <input type="checkbox" value="nome"> Nome<br>
                        <input type="checkbox" value="ativo_inativo"> Estado (Ativo ou Inativo)<br>
                        <input type="checkbox" value="validacao"> Validação<br>
                        <input type="checkbox" value="obs"> Observações<br>
                    </div>
                </div>
                <!-- Dados Secundários -->
                <div class="col-md-2">
                    <div id="dados_modalidade_ies" style="display:none;">
                        <br><p>Informações da Modalidade: </p>

                        <input type="checkbox" value="nome"> Nome<br>
                        <input type="checkbox" value="descricao"> Descrição<br>
                        <input type="checkbox" value="nivel"> Nível<br>
                    </div>
                </div>
                <!-- Dados Secundários -->
                <div class="col-md-3">
                    <div id="dados_pesquisador_ies" style="display:none;">
                        <br><p>Informações de Pessoa (Pesquisador): </p>
                        <div id="dados_pesquisador_Principal">
                            <input type="checkbox" value="nome"> Nome<br>
                            <input type="checkbox" value="cpf"> CPF<br>
                            <input type="checkbox" value="rg"> RG<br>
                            <input type="checkbox" value="rg_emissor"> Orgão emissor<br>
                            <input type="checkbox" value="genero"> Gênero<br>
                            <input type="checkbox" value="data_nascimento"> Data de Nascimento<br>
                            <input type="checkbox" value="telefone_1"> Telefone Principal<br>
                            <input type="checkbox" value="telefone_2"> Telefone Secundário<br>
                            <input type="checkbox" value="ativo_inativo"> Estado (Ativo ou Inativo)<br>
                            <input type="checkbox" value="logradouro"> Logradouro<br>
                            <input type="checkbox" value="numero"> Numero Logradouro<br>
                            <input type="checkbox" value="bairro"> Bairro<br>
                            <input type="checkbox" value="cep"> CEP<br>
                            <input type="checkbox" value="complemento"> Complemento<br>
                        </div>
                        <div id="dados_pesquisador_ies_cidade">
                            <input type="checkbox" value="nome"> Cidade<br>
                        </div>
                        <div id="dados_pesquisador_ies_estado">
                            <input type="checkbox" value="sigla"> Estado (Sigla)<br>
                        </div>
                        <div id="dados_pesquisador_ies_Func" style="display:none;">
                            <input type="checkbox" value="funcao"> Função<br>
                        </div>
                    </div>
                </div>
                <!-- Dados Secundários -->
                <div class="col-md-2">
                    <div id="dados_superintendencia_ies" style="display:none;">
                        <br><p>Informações de Superintendência: </p>

                        <input type="checkbox" value="nome"> Nome<br>
                        <input type="checkbox" value="nome_responsavel"> Responsável<br>
                        <input type="checkbox" value="ativo_inativo"> Estado (Ativo ou Inativo)<br>
                    </div>
                </div>
            </div>
        </div>


        <!-- --------------------------------------------------------- -->
        <!--   Relação de Joins primários e secundários de 'Parceiro'  -->
        <!-- --------------------------------------------------------- -->
        <div id="par_op" style="display:none;">
            <p>Escolha os possíveis relacionamentos a "Instituição de Ensino":</p>
            <!-- Joins Primários -->
            <div id="relacionamento_par" style="display:none;">
                <input type="checkbox" id="parCur" value="par_Cur"> Curso<br>
            </div>
            <!-- Joins Secundários -->
            <div id="relacionamento_par_curso" style="display:none;">
                <br><p>Escolha os possíveis relacionamentos a "Curso":</p>
                <input type="checkbox" id="parMod" value="par_Mod"> Modalidade<br>
                <input type="checkbox" id="parPes" value="par_Pes"> Pessoa (Pesquisador)<br>
                <input type="checkbox" id="parSup" value="par_Sup"> Superintendência<br>
            </div>
            <!-- Joins Terciários -->
            <div id="relacionamento_par_funcao" style="display:none;">
                <br><p>Escolha os possíveis relacionamentos a "Pessoa (Pesquisador)":</p>
                <input type="checkbox" id="parFun" value="par_Func"> Função<br>
            </div>
            <!-- Dados Esperados -->
            <div>
                <br><p>Selecione os dados que deseja recuperar através do relatório.</p>
            </div>
            <div id="dadIes" class="row" style="display:block;">
                <!-- Dados Primários -->
                <div class="col-md-3">
                    <div id="dados_par" style="display:block;">
                        <br><p>Informações de Parceiro: </p>

                        <input type="checkbox" value="nome"> Nome<br>
                        <input type="checkbox" value="sigla"> Sigla<br>
                        <input type="checkbox" value="rua"> Rua<br>
                        <input type="checkbox" value="numero"> Número<br>
                        <input type="checkbox" value="complemento"> Complemento<br>
                        <input type="checkbox" value="cep"> CEP<br>
                        <input type="checkbox" value="telefone1"> Telefone Principal<br>
                        <input type="checkbox" value="telefone2"> Telefone Secundário<br>
                        <input type="checkbox" value="pagina_web"> Página da WEB<br>
                        <input type="checkbox" value="natureza"> Natureza<br>
                        <input type="checkbox" value="abrangencia"> Abrangência<br>
                    </div>
                </div>
                <!-- Dados Secundários -->
                <div class="col-md-2">
                    <div id="dados_curso_par" style="display:none;">
                        <br><p>Informações de Curso: </p>

                        <input type="checkbox" value="nome"> Nome<br>
                        <input type="checkbox" value="ativo_inativo"> Estado (Ativo ou Inativo)<br>
                        <input type="checkbox" value="validacao"> Validação<br>
                        <input type="checkbox" value="obs"> Observações<br>
                    </div>
                </div>
                <!-- Dados Secundários -->
                <div class="col-md-2">
                    <div id="dados_modalidade_par" style="display:none;">
                        <br><p>Informações da Modalidade: </p>

                        <input type="checkbox" value="nome"> Nome<br>
                        <input type="checkbox" value="descricao"> Descrição<br>
                        <input type="checkbox" value="nivel"> Nível<br>
                    </div>
                </div>
                <!-- Dados Secundários -->
                <div class="col-md-3">
                    <div id="dados_pesquisador_par" style="display:none;">
                        <br><p>Informações de Pessoa (Pesquisador): </p>
                        <div id="dados_pesquisador_Principal">
                            <input type="checkbox" value="nome"> Nome<br>
                            <input type="checkbox" value="cpf"> CPF<br>
                            <input type="checkbox" value="rg"> RG<br>
                            <input type="checkbox" value="rg_emissor"> Orgão emissor<br>
                            <input type="checkbox" value="genero"> Gênero<br>
                            <input type="checkbox" value="data_nascimento"> Data de Nascimento<br>
                            <input type="checkbox" value="telefone_1"> Telefone Principal<br>
                            <input type="checkbox" value="telefone_2"> Telefone Secundário<br>
                            <input type="checkbox" value="ativo_inativo"> Estado (Ativo ou Inativo)<br>
                            <input type="checkbox" value="logradouro"> Logradouro<br>
                            <input type="checkbox" value="numero"> Numero Logradouro<br>
                            <input type="checkbox" value="bairro"> Bairro<br>
                            <input type="checkbox" value="cep"> CEP<br>
                            <input type="checkbox" value="complemento"> Complemento<br>
                        </div>
                        <div id="dados_pesquisador_par_cidade">
                            <input type="checkbox" value="nome"> Cidade<br>
                        </div>
                        <div id="dados_pesquisador_par_estado">
                            <input type="checkbox" value="sigla"> Estado (Sigla)<br>
                        </div>
                        <div id="dados_pesquisador_par_Func" style="display:none;">
                            <input type="checkbox" value="funcao"> Função<br>
                        </div>
                    </div>
                </div>
                <!-- Dados Secundários -->
                <div class="col-md-2">
                    <div id="dados_superintendencia_par" style="display:none;">
                        <br><p>Informações de Superintendência: </p>

                        <input type="checkbox" value="nome"> Nome<br>
                        <input type="checkbox" value="nome_responsavel"> Responsável<br>
                        <input type="checkbox" value="ativo_inativo"> Estado (Ativo ou Inativo)<br>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fim da relação de atributos que podem ser selecionados -->

        <br>

        <input type="button" id="gerar" class="btn btn-success" value="Gerar Relatório">

    </fieldset>
</form>