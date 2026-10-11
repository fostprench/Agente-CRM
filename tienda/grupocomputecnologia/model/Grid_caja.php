<?php
require_once('Main.php');
class Grilla 
{  
  protected $data=array();
   function asign($titulo,$controller,$cabecera,$rows,$pag,$query,$view,$imprimir=false)
    {
	    $objtotal = new Main();        
        $this->data['total'] = $objtotal->getnum();
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
		$html.='<form class="form-horizontal" id="frmperfil" name="frmperfil"method="post" >';
		$html.='<div class="form-group">';
		$html.="<input type='hidden' name='c' id='c' value='".$this->data['controller']."' />";
		$html.="<input type='hidden' name='p' id='p' value='1' />";
		$html.='<label class="col-xs-12 col-sm-2 col-md-2 control-label text-center">BUSCAR:</label>';
		$html.='<div class="col-xs-12 col-sm-6 col-md-6"><input type="text" name="q" id="q"class="form-control" placeholder="Buscar"></div>';
		$html.='<div class="col-xs-12 col-sm-4 col-md-4 text-center">
							<input type="button" value="Buscar" class="btn btn-primary" name="_buscar" id="_buscar"/>';
		$html.=" <input type='button' value='Aperturar Caja para Hoy Dia' onclick=\"paginacion('controller=".$this->data['controller']."&action=create');\" class='btn btn-primary' /></div>";
		$html.='</div></form></div></div></div>';
		return $html;
		
		
	}
	 function _body()
	{
		
		
	  $html ='<div class="table-responsive">';
	  $html .='<p class="text-center" style="display:none;" id="loader"><img src="web/images/cargando.gif" /></p>';
	  $html.="<table class='table table-bordered table-striped'>";
	  $html.="<thead style='background-color:#428bca'><tr class='text-uppercase'>";
	   foreach($this->data['cabecera'] as $t)
	    {
	     $html.="<td><a href='javascript:void(0);'  class='order' id='Order".$t."' onclick=\"_order('".$t."','controller=".$this->data['controller']."');\">".$t."</a></td>";
        }
		$html.="<td style='color:#fff'>Reporte</td>";
		$html.="</tr></thead>";
	    $c=0;
		$html.=" <tbody>";
	   if($this->data['query']==0)
		  {
			$r=count($this->data['cabecera']);
			$html.="<td colspan='".$r."' align='center'>&nbsp;&nbsp;la consulta no obtuvo resultados</td>";
		 }
		
       foreach($this->data['rows'] as $val)
       {
          $c++;
		  $html.= "<tr>";
		   foreach($this->data['cabecera'] as $key=>$t)
		   {
		     if($key==0){$html.="<td  class='caja'>".$val[$key]."<input type='hidden' id='cod$val[0]' name='cod$val[0]'/></td>";}
			 if($key==1){$html.="<td  class='caja'>".validar_fecha($val[$key])."</td>"; }	
			 if($key==2){$html.="<td  class='caja'>".$val[$key]."</td>";}
			 if($key==3){$html.="<td  class='caja'>".$val[$key]."</td>";}
			 if($key==4){
			 $estado = $val[$key];
					if($estado == 1){
					$html.=" <td align='center' ><a href=\"javascript:_cerrarcaja('index.php?controller=". $this->data['controller']."&action=show&id=".$val[0]."');\" class='cerrar' title='Cerrar Caja'>CERRAR CAJA</a></td>";
					}else{
					$html.="<td><center>-.-</center></td>";
					}
				}
			}
		 $html.="<td align='center' >";
		 
		 $html.="<a href=\"javascript:_reportecaja('index.php?controller=". $this->data['controller']."&action=reporte_caja&fecha_reporte=".$val[1]."&id=".$val[0]."');\" title='HTML'><img src='web/images/html.png' border='0'></a>";
		 
		 if($_SESSION['insertar']==1){$html.="  <a href=\"javascript:_ver('index.php?controller=ReporteCaja_Excel&action=reporte_caja_excel&fecha_=".$val[1]."&id=".$val[0]."');\"  title='EXCEL'><img src='web/images/excel.png' border='0'></a>";}
		 if($_SESSION['perfil']=='su'){
			$html.=" <a href=\"javascript:_reportecaja_pdf('".$val[0]."');\"  title='Reporte PDF'><img src='web/images/pdf.png' border='0'></a>";
		    $html.=" <a href=\"javascript:_reportecaja('index.php?controller=". $this->data['controller']."&action=reporte_Grafico_caja&id=".$val[0]."');\"   title='Reporte Grafico'><img src='web/images/torta.png' border='0'></a>";
			$html.=" <a href='javascript:void(0);'onClick=\"paginacion('controller=".$this->data['controller']."&action=_edit&id=".$val[0]."');\" title='Editar'><img src='web/images/edit.png' border='0'></a>";
		}
		 $html.="</td>";
		 
		 $html.="</tr>";
		}
		for($i=0;$i<($this->data['total']-$c);$i++)
		{
		    $html.= "<tr>";
		    foreach($this->data['cabecera'] as $t)
			   {
				 $html.="<td>&nbsp;</td>";
			   }
				$html.="<td>&nbsp;</td>";
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