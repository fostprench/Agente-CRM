<?php
require_once('Main.php');
class Grilla 
{
  protected $data=array();
   function asign($titulo,$controller,$cabecera,$rows,$pag,$query,$view,$imprimir=false)
    {
	    $objtotal = new Main();        
        $this->data['total'] = 10;
		$this->data['titulo']=$titulo;
        $this->data['cabecera'] = $cabecera;
        $this->data['rows'] = $rows;
        $this->data['query'] = $query;
        $this->data['view'] = $view;
        $this->data['imprimir'] = $imprimir;
        $this->data['controller'] = $controller;
        $this->data['pag'] = $pag;
	   return $this->_render();
    }
	function _render()
	{
	$grilla="";
	$grilla.=$this->_header();
    $grilla.=$this->_body();
	$grilla.=$this->_footer();
	$grilla.=$this->_paginador();
	$grilla.="<div style='padding-top:50px;'></div>";
	return $grilla;
	
	}
	 function _header()
	{
		$html='<script type="text/javascript" src="web/js/buscar.js"></script>';
		$html.="<div id='divBloqueador'></div>";
		$html.='<div class="bs-example" data-example-id="contextual-panels">';
		$html.='<div class="panel panel-primary">';
		$html.='<div class="panel-heading text-center"><h3 class="panel-title">'.$this->data['titulo'].'</h3></div>';
		$html.='<div class="panel-body">';
		$html.='<form class="form-horizontal" id="frmperfil" name="frmperfil" method="post" >';
		$html.='<div class="form-group">';
		$html.="<input type='hidden' name='c' id='c' value='".$this->data['controller']."' />";
		$html.="<input type='hidden' name='p' id='p' value='1' />";
		$html.='<label class="col-xs-12 col-sm-2 col-md-2 control-label text-center">BUSCAR:</label>';
		$html.='<div class="col-xs-12 col-sm-6 col-md-6"><input type="text" name="q" id="q" class="form-control" placeholder="Buscar"></div>';
		$html.='<div class="col-xs-12 col-sm-4 col-md-4 text-center">
							<input type="button" value="Buscar" class="btn btn-primary" name="_buscar" id="_buscar" />';
		// if($_SESSION['insertar']==1){
		// $html.=" <input type='button' value='Nuevo' onclick=\"paginacion('controller=".$this->data['controller']."&action=create');\" class='btn btn-primary' />";
		// }
		//$html.=' <input type="button" value="Reporte" onclick= "imprimir(this.form);" class="btn btn-primary" /></div>';
		$html.='</div></form></div></div></div>';
		return $html;
	}
	
	 function _body()
	{
	  $html ='<div class="table-responsive">';
	  $html .='<p class="text-center" style="display:none;" id="loader"><img src="web/images/cargando.gif" /></p>';
	  $html.="<table class='table table-bordered table-striped' >";
      $html.="<thead style='background-color:#428bca'><tr class='text-uppercase'>";
	   foreach($this->data['cabecera'] as $t)
	    {
	     $html.="<td><a href='javascript:void(0);'  class='order' id='Order".$t."' onclick=\"_order('".$t."','controller=".$this->data['controller']."');\">".$t."</a></td>";
        }
	   if( $this->data['view']){$html.=" <td style='color:#fff'>".'VER'."</td>";}
	   if( $this->data['imprimir']){$html.=" <td style='color:#fff'>".'IMP'."</td>";}
	   $html.="</tr></thead>";
	   $c=0;
	  $QUERY = $this->data['query'];
	  $html.=" <tbody>";
	   if($QUERY == 0)
		  {
			$r=count($this->data['cabecera']);
			$html.="<td colspan='12' align='center'>&nbsp;&nbsp;La consulta no obtuvo resultados </td>";
		 }
		
		$color="";
       foreach($this->data['rows'] as $val)
       {
          $c++;
		  $html.= "<tr>";
		   foreach($this->data['cabecera'] as $key=>$t)
		   {
		     if($key==4){ 
				$elemento = $val[$key];
				$total = $val[$key];
			 }else if($key==5){
				 if($val[$key]>1){
					$elemento = " <a href=\"javascript:paginacion('controller=".$this->data['controller']."&action=amortizar&id=".$val[0]."');\" title='Amortizar'><button type='button' class='btn btn-primary btn-xs'><span class='glyphicon glyphicon-usd' aria-hidden='true'></span> </button></a>";
				 }else{
					$elemento = "-.-";
				 }	              
	           }else{
			   $elemento = $val[$key];
			   }
			   
			   $html.="<td style='$color'>".($elemento)."</td>";
			   $color="";
		    }
			
		  
		 if( $this->data['view']){ $html.=" <td align='center'><a href=\"javascript:_ver('index.php?controller=". $this->data['controller']."&action=show&id=".$val[0]."');\" title='Ver'><button type='button' class='btn btn-info btn-xs'><span class='glyphicon glyphicon-zoom-in' aria-hidden='true'></span> </button></a></td>";}
		  if( $this->data['imprimir']){ $html.=" <td align='center'><a href=\"javascript:popup('index.php?controller=". $this->data['controller']."&action=_prinft&id=".$val[0]."',850,500);\" title='Ver'><button type='button' class='btn btn-warning btn-xs'><span class='glyphicon glyphicon-print' aria-hidden='true'></span> </button></a></td>";}
		 

		 $html.="</tr>";
		}
		
		for($i=0;$i<($this->data['total']-$c);$i++)
		{
		  $html.= "<tr>";
		   foreach($this->data['cabecera'] as $t)
	       {
	         $html.="<td>&nbsp;</td>";
		   }
		   
		   if($this->data['view']){ $html.="<td>&nbsp;</td>";}
		   if($this->data['imprimir']){ $html.="<td>&nbsp;</td>";}
		    $html.="<td>&nbsp;</td>";
		   if($_SESSION['editar']==1){ $html.="<td>&nbsp;</td>";}
		   if($_SESSION['delete']==1){ $html.="<td>&nbsp;</td>";}
		   $html.="</tr>";
		}
		$html.=" </tbody >";
		return $html;
	}
   function _footer()
	{
	  $html.="</table></div>";
	  $html.='<script type="text/javascript" src="web/js/focus_buscar.js"></script>';
	  return $html;
	}
	 function _paginador()
	{
	  return $this->data['pag'];
	}

}
?>