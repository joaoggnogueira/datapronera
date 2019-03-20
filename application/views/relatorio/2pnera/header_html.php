<?PHP
if (!isset($title_status)) {
    $title_status = "II PNERA";
}
?>
<style>
    body{
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    }
    
    table {
        border-collapse: collapse;
        width: 100%;
    }

    table td, table th {
        border: 1px solid #ddd;
        padding: 8px;
        font-size: 13px !important;
    }

    table tr:nth-child(even){background-color: #f2f2f2;}

    table tr:hover {background-color: #ddd;}

    table th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #4CAF50;
        color: white;
    }
</style>
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

