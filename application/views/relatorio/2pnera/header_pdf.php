<?PHP 

if(!isset($title_status)){
    $title_status = "II PNERA";
}
?>
<div align="center">
    <b>
        Programa Nacional de Educação na Reforma Agrária (Pronera)
        <br>
        <b>Cursos - <?= $title_status ?></b>
        <br><br>
        <div align="center" style="font-size: 15px;">Relatório: <?php echo $titulo_relatorio; ?> </div>
        <?PHP if ($this->session->userdata('access_level') <= 3): ?>
            <br>
            <div align="center" style="font-size: 12px;">Superintendência: <?= $nomeSR ?> </div>
        <?PHP endif; ?>
    </b>
</div>

