<?php
require("PHPlot/phplot.php");
require("dbase.php");

$datab = new DataB;
$datab->DB_connect();

$plot = new PHPlot(1200, 600);
# Disable auto-output:
$plot->SetPrintImage(0);
# Main plot title:
$title = "Telefonia Movil / Abonados por Empresa";
$plot->SetTitle($title);

/////////////////////////////////////////////////////////////////////////
// Abonados
$query = "select empresa, sum(cantidad_abonados) valor from abonados where anno = 2022 group by empresa";
$rslt = $datab->DB_Select($query);
$data = array();
$legends = array();
while ($row = $datab->DB_Fetch_Array($rslt)) {
	$data[] = array($row["empresa"], $row["valor"]);
	$legends[] = $row["empresa"];
}
$datab->DB_Free_Result($rslt);

$plot->SetPlotType('pie');
$plot->SetDataValues($data);
$plot->SetDataType('text-data-single');

# Main plot title:
# Set up area for second plot:
$colors = array('SkyBlue','green','orange','blue','red','DarkGreen','purple','peru','cyan','salmon','SlateBlue','YellowGreen','magenta','aquamarine1','gold','violet');
$plot->SetDataColors($colors);
$plot->SetLegend($legends);
$plot->SetShading(0);
$plot->SetLabelScalePosition(0.2);
		
$plot->DrawGraph();

# Output the image now:
$plot->PrintImage();
?>