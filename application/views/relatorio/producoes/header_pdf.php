<div align="center">
    <b>
        Programa Nacional de Educação na Reforma Agrária (Pronera)
        <br><br>
        <div align="center" style="font-size: 12px;">Relatório: <?php echo $titulo_relatorio; ?> </div>
        <div align="center" style="font-size: 12px;">Status do Curso: <?php echo $status; ?> </div>
        <?PHP if ($this->session->userdata('access_level') <= 3): ?>
            <br>
             <div align="center" style="font-size: 12px;">Superintendência: <?= $nomeSR ?> </div>
        <?PHP endif; ?>
    </b>
</div>

