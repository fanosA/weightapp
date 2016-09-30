<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WeightApp - διαχείριση σωματικού βάρους</title>
</head>

<body>
 	<?php
		$create_xml ="
    <!DOCTYPE diatrofi[
        <!ELEMENT diatrofi (pelatis*)>
        <!ELEMENT pelatis (onoma, epitheto, baros, filo, ilikia, geyma+)>
        <!ELEMENT onoma (#PCDATA)> 
        <!ELEMENT epitheto (#PCDATA)>
        <!ELEMENT baros (#PCDATA)> 
        <!ELEMENT filo (#PCDATA)> 
        <!ELEMENT ilikia (#PCDATA)> 
        <!ELEMENT geyma (sxolia-diaitologou, typos-geymatos, imerominia)> 
        <!ELEMENT sxolia-diaitologou (#PCDATA)> 
        <!ELEMENT typos-geymatos (#PCDATA)> 
        <!ELEMENT imerominia (#PCDATA)>
    ]>

		<diatrofi>";

    session_start();  
  	include('config.php');
    // Connect to server and select databse.
    $con=mysqli_connect($host, $username, $password, $db_name);

    // Check connection
    if (mysqli_connect_errno($con))
      {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }

    // Change character set to utf8
    mysqli_set_charset($con,"utf8");
    $userId = $_SESSION['login_id'];
    
    // Select the client
    $sqlget = "SELECT pelatis.`id-pelati` as id, onoma, epitheto, baros, filo, ilikia FROM `pelatis` JOIN `geyma` ON pelatis.`id-pelati`=geyma.`id-pelati` AND geyma.`id-diaitologou`='$userId' GROUP BY id ORDER BY epitheto, onoma";
    $result = mysqli_query($con, $sqlget) or die('error getting data');


    if ($result)
    {
      while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $A_apotelesma[$row['id']]['pelatis'] = array('onoma'=>$row['onoma'], 'epitheto'=>$row['epitheto'], 'baros'=>$row['baros'], 'filo'=>$row['filo'], 'ilikia'=>$row['ilikia']);

        $rowId = $row['id'];

        $sqlget2 = "SELECT pelatis.`id-pelati` as id, geyma.`id-geymatos` as idGeymatos, `sxolia-diaitologou`, `typos-geymatos`, imerominia FROM `pelatis` JOIN `geyma` ON pelatis.`id-pelati`=geyma.`id-pelati` AND geyma.`id-diaitologou`='$userId' AND geyma.`id-pelati`='$rowId'";
        $result2 = mysqli_query($con, $sqlget2) or die('error getting data');

        while($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
          $A_apotelesma[$row['id']]['pelatis']['geyma'][$row2['idGeymatos']] = array('sxolia-diaitologou'=>$row2['sxolia-diaitologou'], 'typos-geymatos'=>$row2['typos-geymatos'], 'imerominia'=>$row2['imerominia']);
        }
       }
    }


    if(is_array($A_apotelesma))
    {
      foreach($A_apotelesma as $in => $value)  // for every client in the DB
      {         
        $create_xml .="<pelatis><onoma>".$value['pelatis']['onoma']."</onoma>";
        $create_xml .="<epitheto>".$value['pelatis']['epitheto']."</epitheto>";
        $create_xml .="<baros>".$value['pelatis']['baros']."</baros>";
        $create_xml .="<filo>".$value['pelatis']['filo']."</filo>";
        $create_xml .="<ilikia>".$value['pelatis']['ilikia']."</ilikia>";
      if(is_array($value['pelatis']['geyma']))
      foreach($value['pelatis']['geyma'] as $i_ => $geymavalue)
      {
        $create_xml .="<geyma><sxolia-diaitologou>".$geymavalue['sxolia-diaitologou']."</sxolia-diaitologou>";
        $create_xml .="<typos-geymatos>".$geymavalue['typos-geymatos']."</typos-geymatos>";
        $create_xml .="<imerominia>".$geymavalue['imerominia']."</imerominia></geyma>";     
      }
        $create_xml .="</pelatis>";  
        
      }

    $create_xml .="</diatrofi>";

    //Load the file created
    $error1 = false;
    if ($create_xml)
    { 
       
      $xsl_filename  = "xml_diatrofi.xsl";
 
      $doc = new DOMDocument();
      $xsl = new XSLTProcessor();

      $doc->load($xsl_filename);
      $xsl->importStyleSheet($doc);

      $doc->loadXML($create_xml);
      if(!$doc->validate()){
        echo "<p>Το αρχείο δεν είναι έγκυρο σύμφωνα με το DTD<p>";
      }               
      else
      {
        echo $xsl->transformToXML($doc);
      }   
    }
  } 
  else{
    echo "<p align='center'>Δεν υπάρχουν πελάτες για παρουσίαση με XML</p>";
  }
?>
</body>
</html>