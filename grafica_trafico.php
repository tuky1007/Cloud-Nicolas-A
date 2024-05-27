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
// Trafico
$query = "select distinct anno from trafico";
$rslt_ano = $datab->DB_Select($query);
$data = array();
while ($row_ano = $datab->DB_Fetch_Array($rslt_ano)) {
	$ano = $row_ano["anno"];
	$query = "select distinct id_modalidad_pago from trafico where anno = " . $ano . " order by id_modalidad_pago";
	$rslt_mod = $datab->DB_Select($query);
	$data_ano = array();
	$data_ano[] = $row_ano["anno"];
	while ($row_mod = $datab->DB_Fetch_Array($rslt_mod)) {
		$mod = $row_mod["id_modalidad_pago"];
		$query = "select sum(trafico) valor from trafico where anno = " . $ano . " and id_modalidad_pago = '" . $mod . "'";
		$rslt_val = $datab->DB_Select($query);
		while ($row_val = $datab->DB_Fetch_Array($rslt_val)) {
			$data_ano[] = $row_val["valor"];
		}
		$datab->DB_Free_Result($rslt_val);
	}
	$datab->DB_Free_Result($rslt_mod);
	$data[] = $data_ano;
}
$datab->DB_Free_Result($rslt_ano);

$plot->SetPlotType('bars');
$plot->SetDataValues($data);

# Set up area for first plot:
$plot->SetXTitle('Trafico por Modalidad');
$plot->SetYTitle('Trafico BytesPS');
$plot->SetLegend(array('Prepago', 'Postpago'));
$plot->SetXTickLabelPos('none');
$plot->SetXTickPos('none');
		
$plot->DrawGraph();

# Output the image now:
$plot->PrintImage();
?>