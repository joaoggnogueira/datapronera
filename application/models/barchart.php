<?php

/** Error reporting * */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

date_default_timezone_set('Europe/London');

/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2012 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2012 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.7.8, 2012-10-12
 */
class Barchart extends CI_Model {

    private $_chart_data = array(array('', '')); // Empty data
    private $_chartType = 'clustered';
    private $_legend = 'none';
    private $_showValues = true;
    private $_title = '';
    private $_yAxisLabel = '';
    private $_xAxisLabel = '';
    private $_filename = 'default.xlsx';
    private $_excelFile = false;
    private $_topLeftCell = 'G1';
    private $_bottomRightCell = 'Q33';
    private $_direction = 'bar'; // bar | col
    private $_objPHPExcel;
    private $_objWorksheet;
    private $_number_format = "0";
    private $_chart_colors = array();
    private $_legend_col = 'A';
    private $_num_legend_columns = 1;
    private $_include_charts = TRUE;

    public function __construct() {

        /** Include path * */
        set_include_path(__DIR__ . '/../third_party/phpexcel/classes');

        /** PHPExcel * */
        include 'PHPExcel.php';
        
        PHPExcel_Settings::setLocale('pt_br');

        $this->_objPHPExcel = new PHPExcel();
        $this->_objWorksheet = $this->_objPHPExcel->getActiveSheet();
    }

    public function set_excelFile() {
        $this->_excelFile = true;
    }

    public function set_include_charts($_bool) {
        $this->_include_charts = $_bool;
    }

    public function set_num_legend_columns($_col) {
        $this->_num_legend_columns = $_col;
    }

    public function set_legend_col($_col) {
        $this->_legend_col = $_col;
    }

    public function set_number_format($_format) {
        $this->_number_format = $_format;
    }

    public function set_chart_colors($_colors) {
        $this->_chart_colors = $_colors;
    }

    public function set_direction($_direction) {
        $this->_direction = $_direction;
    }

    public function set_chart_data($_chart_data) {
        $this->_chart_data = $_chart_data;
    }

    public function set_chartType($_chartType) {
        $this->_chartType = $_chartType;
    }

    public function set_legend($_legend) {
        $this->_legend = $_legend;
    }

    public function set_showValues($_showValues) {
        $this->_showValues = $_showValues;
    }

    public function set_title($_title) {
        $this->_title = $_title;
    }

    public function set_yAxisLabel($_yAxisLabel) {
        $this->_yAxisLabel = $_yAxisLabel;
    }

    public function set_xAxisLabel($_xAxisLabel) {
        $this->_xAxisLabel = $_xAxisLabel;
    }

    public function set_filename($_filename) {
        $this->_filename = $_filename;
    }

    public function set_topLeftCell($_topLeftCell) {
        $this->_topLeftCell = $_topLeftCell;
    }

    public function set_bottomRightCell($_bottomRightCell) {
        $this->_bottomRightCell = $_bottomRightCell;
    }

    public function set_string_column($interval) {
    }

    public function create_header() {

        $style_line = array(
            'font' => array(
                'bold' => true
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'AAFF80')
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );

        $style = array(
            'font' => array(
                'bold' => true
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'E6E6E6')
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );

        $sizeOfFirstRow = count($this->_chart_data[0]); // count the first row to apply the header style

        for ($i = 0; $i > -1; $i++) {
            if ($i == 0) {
                $this->_objPHPExcel->getActiveSheet()->mergeCells('A' . ($i + 1) . ':' . chr(64 + $sizeOfFirstRow) . '' . ($i + 1));
                $this->_objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 1) . ':' . chr(64 + $sizeOfFirstRow) . '' . ($i + 1))->applyFromArray($style_line);
            } else if ($this->_chart_data[$i + 1][0] == "") {
                $this->_objPHPExcel->getActiveSheet()->mergeCells('A' . ($i + 1) . ':' . chr(64 + $sizeOfFirstRow) . '' . ($i + 1));
                $this->_objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 1) . ':' . chr(64 + $sizeOfFirstRow) . '' . ($i + 1))->applyFromArray($style_line);
                break;
            } else {
                $this->_objPHPExcel->getActiveSheet()->mergeCells('A' . ($i + 1) . ':' . chr(64 + $sizeOfFirstRow) . '' . ($i + 1));
                $this->_objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 1) . ':' . chr(64 + $sizeOfFirstRow) . '' . ($i + 1))->applyFromArray($style);
            }
        }
    }

    public function create_chart() {

        //A manipulação dos dados do chart_data aumentou pelo fato da inclusão de linhas de cabeçalho

        if ($this->_chart_data == null) {
            return;
        }

        //Creating Header
        $this->create_header();

        // Prints table to worksheet		
        $this->_objWorksheet->fromArray($this->_chart_data);

        // Columnns data
        $numDataColumns = count($this->_chart_data[7]) - $this->_num_legend_columns -1; //Count -1 because of the first column
        // Rowsdata
        $numDataRows = count($this->_chart_data) - 1; // Count -1 because of the first row
        // Legend Column
        $legendCol = $this->_legend_col;
        $legendRow = 9;
        $firstDataRow = $legendRow + 1;

        // Formats the table with the format code received
        $contChar = $legendCol;
        
        
        for ($cont = 0; $cont < $numDataColumns; $cont++) {

            $contChar++;
            for ($cont2 = 7; $cont2 < $numDataRows; $cont2++) {
                $aux = $cont2 + 2;
                //$this->_objPHPExcel->getActiveSheet()->getStyle("$contChar$aux")->getNumberFormat()->setFormatCode($this->_number_format);
                $this->_objPHPExcel->getActiveSheet()->getStyle("$contChar$aux")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            }
        }
        

        $contChar = $legendCol;
        $dataseriesLabels = array();

        for ($cont = 0; $cont < $numDataColumns; $cont++) {
            $contChar++;

            //	Set the Labels for each data series we want to plot
            //	Datatype
            //	Cell reference for data
            //	Format Code
            //	Number of datapoints in series
            //	Data values
            //	Data Marker
            $dataseriesLabels[] = new PHPExcel_Chart_DataSeriesValues(
                    'String', 'Worksheet!$' . $contChar . '$' . $legendRow, null, 1, array(), null, (count($this->_chart_colors) > $cont ? $this->_chart_colors[$cont] : null)
            );
        }

        //	Set the X-Axis Labels
        //	Datatype
        //	Cell reference for data
        //	Format Code
        //	Number of datapoints in series
        //	Data values
        //	Data Marker
        $xAxisTickValues = array(
            new PHPExcel_Chart_DataSeriesValues(
                    'String', 'Worksheet!$' . $legendCol . '$' . $firstDataRow . ':$' . $legendCol . '$' . ($firstDataRow + $numDataRows - 9), null, 4
            ),
        );

        $contChar = $legendCol;
        $dataSeriesValues = array();
        $contx = 0;

        for ($cont = 0; $cont < $numDataColumns; $cont++) {
            $contChar++;

            // Set the Data values for each data series we want to plot
            // Datatype
            // Cell reference for data
            // Format Code
            // Number of datapoints in series
            // Data values
            // Data Marker
            $dataSeriesValues[] = new PHPExcel_Chart_DataSeriesValues(
                    'Number', 'Worksheet!$' . $contChar . '$' . $firstDataRow . ':$' . $contChar . '$' . ($firstDataRow + $numDataRows - 9), null, 4
            );
        }

        // Defines if chart is going to be clustered or stacked
        if ($this->_chartType == 'clustered') {
            $chartType = PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED;
        } else {
            $chartType = PHPExcel_Chart_DataSeries::GROUPING_STACKED;
        }

        //	Build the dataseries
        $series = new PHPExcel_Chart_DataSeries(
                PHPExcel_Chart_DataSeries::TYPE_BARCHART, // plotType
                $chartType, // plotGrouping
                range(0, count($dataSeriesValues) - 1), // plotOrder
                $dataseriesLabels, // plotLabel
                $xAxisTickValues, // plotCategory
                $dataSeriesValues        // plotValues
        );

        //	Set additional dataseries parameters
        //	Make it a horizontal bar rather than a vertical column graph
        if ($this->_direction == 'col') {
            $series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);
        } else if ($this->_direction == 'bar') {
            $series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_BAR);
        }

        //	Set the series in the plot area
        $layout = new PHPExcel_Chart_Layout();
        $layout->setShowVal($this->_showValues);

        //	Set the series in the plot area
        $plotarea = new PHPExcel_Chart_PlotArea($layout, array($series));

        //	Set the chart legend
        if ($this->_legend == 'top') {
            $legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_TOP, null, false);
        } else if ($this->_legend == 'bottom') {
            $legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_BOTTOM, null, false);
        } else if ($this->_legend == 'left') {
            $legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_LEFT, null, false);
        } else if ($this->_legend == 'right') {
            $legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, null, false);
        } else {
            $legend = null;
        }

        //	Create the chart
        $chart = new PHPExcel_Chart(
                'chart1', // name
                $title = new PHPExcel_Chart_Title($this->_title), // title
                $legend, // legend
                $plotarea, // plotArea
                true, // plotVisibleOnly
                0, // displayBlanksAs
                new PHPExcel_Chart_Title($this->_yAxisLabel), // yAxisLabel
                new PHPExcel_Chart_Title($this->_xAxisLabel)     // xAxisLabel
        );

        //	Add the chart to the worksheet
        $this->_objWorksheet->addChart($chart);
        $chart->setTopLeftPosition($this->_topLeftCell);
        $chart->setBottomRightPosition($this->_bottomRightCell);

        // Save Excel 2007 file
        $objWriter = PHPExcel_IOFactory::createWriter($this->_objPHPExcel, 'Excel2007');
        $objWriter->setIncludeCharts($this->_include_charts);

        if ($this->_excelFile) {
            header('Content-type: application/vnd.ms-excel');
        }

        header('Content-Disposition: attachment; filename=" ' . $this->_filename . '"');
        echo $objWriter->save('php://output');
    }

}
