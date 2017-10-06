<div style="margin: 30px 0px 0px 100px;">

    <b>1. Nome do curso</b>
    <div style="margin-left: 20px;" ><?php echo $dados[0]->curso; ?> </div>
    <br>

    <b>2. &Aacute;rea de conhecimento</b>
    <div style="margin-left: 20px;" ><?php echo $dados[0]->area_conhecimento; ?> </div>
    <br>

    <b>3. Nome do(a) coordenador(a) geral do curso</b>
    <div style="margin-left: 20px;" ><?php echo $dados[0]->nome_coordenador_geral; ?> </div>
    <br>

    <b>4. Titula&ccedil;&atilde;o do(a) coordenador(a) geral do curso quando o curso foi desenvolvido</b>
    <div style="margin-left: 20px;" >
        <?php
            if ($dados[0]->titulacao_coordenador_geral == "NAOINFORMADO") echo 'NÃO ENCONTRADO';
            else echo $dados[0]->titulacao_coordenador_geral;
        ?>
    </div>
    <br>

    <b>5. Nome do coordenador(a) do projeto/curso</b>
    <div style="margin-left: 20px;" >
        <?php
            if ($dados[0]->nome_coordenador == "NAOAPLICA") echo 'NÃO SE APLICA';
            else echo $dados[0]->nome_coordenador;
        ?>
    </div>
    <br>

    <b>6. Titula&ccedil;&atilde;o do(a) coordenador(a) do curso quando o curso foi desenvolvido</b>
    <div style="margin-left: 20px;" >
        <?php
            if ($dados[0]->titulacao_coordenador == "NAOINFORMADO") echo 'NÃO ENCONTRADO';
            else if ($dados[0]->titulacao_coordenador == "NAOAPLICA") echo 'NÃO SE APLICA';
            else echo $dados[0]->titulacao_coordenador;
        ?>
    </div>
    <br>

    <b>7. Nome do vice-coordenador(a) do curso</b>
    <div style="margin-left: 20px;" >
        <?php
            if ($dados[0]->nome_vice_coordenador == "NAOAPLICA") echo 'NÃO SE APLICA';
            else echo $dados[0]->nome_vice_coordenador;
        ?>
    </div>
    <br>

    <b>8. Titula&ccedil;&atilde;o do(a) vice-coordenador(a) do curso quando o curso foi desenvolvido</b>
    <div style="margin-left: 20px;" >
        <?php
            if ($dados[0]->titulacao_vice_coordenador == "NAOINFORMADO") echo 'NÃO ENCONTRADO';
            else if ($dados[0]->titulacao_vice_coordenador == "NAOAPLICA") echo 'NÃO SE APLICA';
            else echo $dados[0]->titulacao_vice_coordenador;
        ?>
    </div>
    <br> <br> <br> <br> <br> <br>

    <b>9. Nome do coordenador(a) pedagogico(a) do curso</b>
    <div style="margin-left: 20px;" >
        <?php
            if ($dados[0]->nome_coordenador_pedagogico == "NAOAPLICA") echo 'NÃO SE APLICA';
            else echo $dados[0]->nome_coordenador_pedagogico;
        ?>
    </div>
    <br>

    <b>10. Titula&ccedil;&atilde;o do(a) coordenador(a) pedagógico(a) do curso quando o curso foi desenvolvido</b>
    <div style="margin-left: 20px;" >
        <?php
            if ($dados[0]->titulacao_coordenador_pedagogico == "NAOINFORMADO") echo 'NÃO ENCONTRADO';
            else if ($dados[0]->titulacao_coordenador_pedagogico == "NAOAPLICA") echo 'NÃO SE APLICA';
            else echo $dados[0]->titulacao_coordenador_pedagogico;
        ?>
    </div>

    <b>11. Dura&ccedil;&atilde;o do curso (anos)</b>
    <div style="margin-left: 20px;" >
        <?php
            if ($dados[0]->duracao_curso == "-1") echo 'NÃO ENCONTRADO';
            else echo $dados[0]->duracao_curso;
        ?>
    </div>
    <br>

    <b>12. Período previsto para a realização do curso</b>
    <br>
    <div style="margin-left: 15px;">
        <b>a. Início (m&ecirc;s/ano)</b>
        <div style="margin-left: 20px;" >
            <?php
                if($dados[0]->inicio_previsto == 'NI') echo 'NÃO ENCONTRADO';
                else echo $dados[0]->inicio_previsto;
            ?>
        </div>
    </div>
    <div style="margin-left: 15px;">
        <b>b. Término (m&ecirc;s/ano)</b>
        <div style="margin-left: 20px;" >
            <?php
                if($dados[0]->termino_previsto == 'NI') echo 'NÃO ENCONTRADO';
                else echo $dados[0]->termino_previsto;
            ?>
        </div>
    </div>
    <br>

    <b>13. Período em que o curso foi de fato realizado</b>
    <br>
    <div style="margin-left: 15px;">
        <b>a. Início (m&ecirc;s/ano)</b>
        <div style="margin-left: 20px;" >
            <?php
                if($dados[0]->inicio_realizado == 'NI') echo 'NÃO ENCONTRADO';
                else echo $dados[0]->inicio_realizado;
            ?>
        </div>
    </div>
    <div style="margin-left: 15px;">
        <b>b. Término (m&ecirc;s/ano)</b>
        <div style="margin-left: 20px;" >
            <?php
                if($dados[0]->termino_realizado == 'NI') echo 'NÃO ENCONTRADO';
                else echo $dados[0]->termino_realizado;
            ?>
        </div>
    </div>
    <div style="margin-left: 15px;">
        <b>c. Número de Turmas</b>
        <div style="margin-left: 20px;" >
            <?php
                if($dados[0]->numero_turmas == '-1') echo 'NÃO ENCONTRADO';
                else echo $dados[0]->numero_turmas;
            ?>
        </div>
    </div>
    <br>
    <div style="margin-left: 15px;">
        <b>Curso concluido ?</b>
        <div style="margin-left: 20px;" >
            <?php
                if ($dados[0]->curso_descricao != "NAOCONCLUIDO" && $dados[0]->curso_descricao != "") echo $dados[0]->curso_descricao;
                else echo 'NÃO CONCLUÍDO';
            ?>
        </div>
    </div>
    <br>

    <b>14. N&uacute;mero de alunos ingressantes em todas as turmas</b>
    <div style="margin-left: 20px;" >
        <?php
            if ($dados[0]->numero_ingressantes == '-1') echo 'NÃO ENCONTRADO';
            else echo $dados[0]->numero_ingressantes;
        ?>
    </div>
    <br>

    <b>15. N&uacute;mero de alunos concluintes em todas as turmas</b>
    <div style="margin-left: 20px;" >
        <?php
            if ($dados[0]->numero_concluintes == '-1') echo 'NÃO ENCONTRADO';
            else echo $dados[0]->numero_concluintes;
        ?>
    </div>
    <br>

    <b>16. Munic&iacute;pio</b>
    <?
        $contador = 0;
        foreach ($municipios as $item) {
            if ($contador % 3 == 0) echo '<br>';
            echo '<div style="margin-left: 20px; width: 300px; float: left;" >'. $item[1]. ' - ' .$item[0] .' </div>';
            $contador++;
        }
    ?>
    <br> <br> <br> <br> <br> <br>

    <b>17. Houve algum impedimento na implementa&ccedil;&atilde;o do curso ?</b>
    <div style="margin-left: 20px;" >
        <?php
            if ($dados[0]->impedimento_curso == "NI") echo 'NÃO ENCONTRADO';
            else if ($dados[0]->impedimento_curso != "NI" && $dados[0]->impedimento_curso == "NAO")
                echo 'NÃO';
            else if ($dados[0]->impedimento_curso != "NI" && $dados[0]->impedimento_curso == "SIM")
                echo $dados[0]->impedimento_curso.',  '.$dados[0]->impedimento_curso_descricao;
        ?>
    </div>
    <br>

    <b>18. O projeto/curso teve como refer&ecirc;ncia um curso regular da institui&ccedil;&atilde;o de ensino ?</b>
    <div style="margin-left: 20px;" >
        <?php
            if($dados[0]->referencia_curso == '-1') echo 'NÃO ENCONTRADO';
            else if($dados[0]->referencia_curso == '1') echo 'SIM';
            else echo 'NÃO';
        ?>
    </div>
    <br>

    <b>19. Em caso afirmativo da quest&atilde;o anterior, a matriz curricular do curso regular foi alterada para o curso do PRONERA ?</b>
    <div style="margin-left: 20px;" >
        <?php
            if($dados[0]->matriz_curricular_curso == '-1') echo 'NÃO ENCONTRADO';
            else if($dados[0]->matriz_curricular_curso == '1') echo 'SIM';
            else echo 'NÃO';
        ?>
    </div>
    <br>

    <b>20. Houve desdobramentos do curso ?</b>
    <div style="margin-left: 20px;" >
        <?php
            if ($dados[0]->desdobramento == "NI") echo 'NÃO ENCONTRADO';
            else if ($dados[0]->desdobramento != "OUTROS") echo $dados[0]->desdobramento;
            else
                echo $dados[0]->desdobramento_descricao;
        ?>
    </div>
    <br>

    <b>21. H&aacute; documentos normativos para garantir a Institucionaliza&ccedil;&atilde;o do curso nas instituições de ensino ?</b>
    <div style="margin-left: 20px;" >
        <?php
            if ($dados[0]->documentos_normativos == "NI") echo 'NÃO ENCONTRADO';
            else if ($dados[0]->documentos_normativos != "NI" && $dados[0]->documentos_normativos == "NAO")
                echo 'NÃO';
            else if ($dados[0]->documentos_normativos != "NI" && $dados[0]->documentos_normativos == "SIM")
                echo $dados[0]->documentos_normativos.',  '.$dados[0]->documentos_normativos_descricao;
        ?>
    </div>
    <br>

    <b>22. Houve um espa&ccedil;o espec&iacute;fico para o PRONERA onde o curso foi realizado ?</b>
    <div style="margin-left: 20px;" >
        <?php
            if ($dados[0]->espaco_especifico == "NI") echo 'NÃO ENCONTRADO';
            else if ($dados[0]->espaco_especifico != "NI" && $dados[0]->espaco_especifico == "NAO")
                echo 'NÃO';
            else if ($dados[0]->espaco_especifico != "NI" && $dados[0]->espaco_especifico == "SIM")
                echo $dados[0]->espaco_especifico.',  '.$dados[0]->espaco_especifico_descricao;
        ?>
    </div>
    <br>

    <b>23. Houve avalia&ccedil;&atilde;o do curso pelo MEC ou outras instituições ?</b>
    <div style="margin-left: 20px;" >
        <?php
            if ($dados[0]->avaliacao_mec == "NI") echo 'NÃO ENCONTRADO';
            else if ($dados[0]->avaliacao_mec != "NI" && $dados[0]->avaliacao_mec == "NAO")
                echo 'NÃO';
            else if ($dados[0]->avaliacao_mec != "NI" && $dados[0]->avaliacao_mec == "SIM")
                echo $dados[0]->avaliacao_mec.',  '.$dados[0]->avaliacao_mec_descricao;
        ?>
    </div>
    <br>

    <b>24. N&uacute;mero de estudantes universitários (bolsista / monitor) que se envolveram nos cursos do PRONERA </b>
    <div style="margin-left: 20px;" >
        <?php
            if ($dados[0]->numero_bolsistas == '-1') echo 'NÃO ENCONTRADO';
            else echo $dados[0]->numero_bolsistas;
        ?>
    </div>
    <br>
</div>