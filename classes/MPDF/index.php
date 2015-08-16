<?php
  
  include('../../../../../wp-config.php');
  
  $wpa_fialiado 					= $table_prefix . 'wpa_fialiado';
  $wpa_comissao 					= $table_prefix . 'wpa_comissao';
  
  // conecta ao banco de dados 
  $con = mysql_pconnect(DB_HOST, DB_USER, DB_PASSWORD) or trigger_error(mysql_error(),E_USER_ERROR); 
  // seleciona a base de dados em que vamos trabalhar 
  mysql_select_db(DB_NAME, $con); 
  
  $id_comissaoCidade = @$_GET['id_comissaoCidade']; 
   
  // cria a instrução SQL que vai selecionar os dados 
  $sql = "SELECT *

			  FROM ".$wpa_fialiado." 
	  
	  where id_comissao = '".$id_comissaoCidade."' and status = 2"; 
	  
  // executa a query 
  $query = mysql_query($sql, $con) or die(mysql_error()); 
  
  
  define('MPDF_PATH', '');
  include(MPDF_PATH.'mpdf.php');
  
  $html = "";
  $html .= "<style>@page { sheet-size: 209.97mm 296.93mm; margin: 8mm 6mm; } td{width:}</style>
	<body>
  	<table id='Table_01' border='0mm' cellpadding='0mm' cellspacing='0mm'>
		<tr>";
  
  $x=1;
  
  while($dados = mysql_fetch_array($query, MYSQL_ASSOC)){
  	  
	  $html .= "<td width='63mm' height='46mm'>
					<font color='#000000'>".$dados['nome']." <br/>
					".$dados['rua']." ".$dados['numero']."<br/>
					".$dados['bairro']." ".$dados['complemento']."<br/>
					".$dados['cidade']." ".$dados['estado']."<br/>
					".$dados['cep']."<br/></font>
				</td>";
	  
	  if($x==1){

		  $html .= "<td width='30' height='46mm' ></td>";
		  
	  }elseif($x==2){

		  $html .= "<td width='29' height='46mm' ></td>";
		  
	  }elseif($x==3){
		  
		   $html .= "</tr>
					  <tr>
						  <td width='63mm' height='0mm'>
							  </td>
						  <td>
							  </td>
						  <td width='63mm' height='0mm'>
							  </td>
						  <td>
							  </td>
						  <td width='63mm' height='0mm'>
							  </td>
					  </tr>
					  <tr>";
		  $x=0;
		  
	  }
				
	  $x++;		
  }
  
  $html .= "</tr>
  		</table>
  	</body>";
	
	#echo $html;
	
  
  $mpdf=new mPDF('utf-8', 'A4');
  //$mpdf=new mPDF();
  $mpdf->WriteHTML($html);
  $mpdf->Output();
  exit();