<div align="center">
    <b>
        Programa Nacional de Educação na Reforma Agrária (Pronera)
        <br>
        Cursos com status em andamento
        <br><br>
        <div align="center" style="font-size: 12px;">Relatório: <?php echo $titulo_relatorio; ?> </div>
        <?PHP if ($this->session->userdata('access_level') <= 3): ?>
            <br>
            <div align="center" style="font-size: 12px;">Superintendência: <?= $nomeSR ?> </div>
        <?PHP endif; ?>
    </b>
</div>

