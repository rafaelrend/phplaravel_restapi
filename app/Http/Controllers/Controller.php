<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;

abstract class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests;
	
	function executeScalar( $sql ){
		$ar = DB::select($sql);
		
		//print_r( $ar ); die(" ");
		
		return $ar[0]->res;
	}
	
	
	function SetaRsetPaginacao($selQtdeRegistro, $selPagina,$totalRegistro,
					  &$inicio, &$fim)
	 {
						
						
						if ( ! is_numeric($selQtdeRegistro))
						  $selQtdeRegistro = 0;
						
						
						if ( ! is_numeric($totalRegistro))
						  $totalRegistro = 0;
						
						
						$pageCount =  @($totalRegistro / $selQtdeRegistro);
						
						if ($pageCount < 1)
							$pageCount = 1; 
						
						if ($pageCount > round($pageCount))
							{    $pageCount++;}
						else 
							{  $pageCount = round($pageCount); }
						
						$pageCount = (int)$pageCount;
						
						
						//echo  $selPagina . "-- ".$pageCount;
						
						if ( $selPagina > (int)$pageCount)
							$selPagina = (int)$pageCount;
						
						//die ( $selPagina );
						
						 $inicio = $selQtdeRegistro * ($selPagina -1);
						 $fim = $inicio + $selQtdeRegistro;
						// die ( $inicio . " -- AAAAAAAAA  ". $selPagina );
						 
						 if ($fim > $totalRegistro)
							 @($fim = $totalRegistro);

							 //die($inicio."----".$selQtdeRegistro."-".$selPagina."-".$fim."-".$totalRegistro);

							 return $inicio."_".$fim;
	}


}
