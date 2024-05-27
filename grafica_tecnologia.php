<?php
require("PHPlot/phplot.php");
require("dbase.php");

$datab = new DataB;
$datab->DB_connect();

$plot = new PHPlot(800, 600);
# Disable auto-output:
$plot->SetPrintImage(0);
# Main plot title:
$title = "Graficas Telefonia Movil";
$plot->SetTitle($title);

/////////////////////////////////////////////////////////////////////////
// Abonados
$query = "select distinct anno from abonados";
$rslt_ano = $datab->DB_Select($query);
$data = array();
while ($row_ano = $datab->DB_Fetch_Array($rslt_ano)) {
	$ano = $row_ano["anno"];
	$query = "select distinct tecnologia from abonados where anno = " . $ano . " order by tecnologia";
	$rslt_tec = $datab->DB_Select($query);
	$data_ano = array();
	$data_ano[] = $row_ano["anno"];
	while ($row_tec = $datab->DB_Fetch_Array($rslt_tec)) {
		$tec = $row_tec["tecnologia"];
		$query = "select sum(cantidad_abonados) valor from abonados where anno = " . $ano . " and tecnologia = '" . $tec . "'";
		$rslt_val = $datab->DB_Select($query);
		while ($row_val = $datab->DB_Fetch_Array($rslt_val)) {
			$data_ano[] = $row_val["valor"];
		}
		$datab->DB_Free_Result($rslt_val);
	}
	$datab->DB_Free_Result($rslt_tec);
	$data[] = $data_ano;
}
$datab->DB_Free_Result($rslt_ano);

$plot->SetPlotType('stackedbars');
$plot->SetDataValues($data);

# Main plot title:
# Set up area for second plot:
$plot->SetXTitle('Abonados por Tecnologia');
$plot->SetYTitle('Cantidad');
$plot->SetLegend(array('2G', '3G', '4G'));
$plot->SetXTickLabelPos('none');
$plot->SetXTickPos('none');
		
$plot->DrawGraph();

# Output the image now:
$plot->PrintImage();
?>