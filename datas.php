<?php
  $atual = new DateTime();
  $especifica = new DateTime('1990-01-22');
  $texto = new DateTime(' -3 days');
  
  $datahorasys = new DateTime();
  $data = $datahorasys->format('d-m-Y');
  echo "</br>"; 
  $datahorasys = new DateTime();
  $hora = $datahorasys->format('H:i');
  echo "</br>"; 
//$data = new DateTime('-6 year');
//echo $data->format('d-m-Y H:i:s');
  echo "</br>"; 
  echo "</br>"; 
			
?>
			
<?php
//$dataSistema = new DateTime();
  $dataevento = new DateTime('2022-11-13');
  $intervalo = $dataevento->diff($datahorasys);
 	echo $intervalo->format('%m meses, %d dias, %h horas e %i minutos');
  echo "</br>"; 
  echo "</br>"; 

?>