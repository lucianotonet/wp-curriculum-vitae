<?php

include( dirname ( __FILE__ ) ."/../../../wp-config.php" );

mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die ('Erro ao conectar');
mysql_select_db(DB_NAME) or die ('Erro ao conectar com o banco de dados');
$rs = mysql_query("SELECT * FROM ".$table_prefix."wls_curriculo ORDER BY nome");


$xml = "<?xml version='1.0' encoding='UTF-8'?>\n";//cabeçalho do arquivo
       $xml .= "<newsletter>\n";
 	   
	   while($reg = mysql_fetch_object($rs)){
           $xml .= "\t<contato>\n";
           $xml .= "\t\t<nome>".$reg->nome."</nome>\n";
           $xml .= "\t\t<email>".$reg->email."</email>\n";
           $xml .= "\t</contato>\n";
       }
       $xml .= "</newsletter>";

       $ponteiro = fopen('emails.xml', 'w'); //cria um arquivo com o nome backup.xml
       fwrite($ponteiro, $xml); // salva conteúdo da variável $xml dentro do arquivo backup.xml
 
       $ponteiro = fclose($ponteiro); //fecha o arquivo
 	
	   echo "<script>location.href='emails.xml'</script>";
?>