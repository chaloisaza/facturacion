<html>
  <head>
  </head>
  <body>
    <h1> Hola </h1>
	<?php
	include 'reader.php';
    	$excel = new Spreadsheet_Excel_Reader();
	?>
	Sheet 1:<br/>
    <table border="1">
    <?php
      $excel->read('sample.xls'); // set the excel file name here   
      $x=1;
        while($x<=$excel->sheets[0]['numRows']) { // reading row by row 
          if($x == 1){
            echo "\t<thead>\n";
            echo "\t<tr>\n";
            $y=1;
            while($y<=$excel->sheets[0]['numCols']) {// reading column by column 
              $cell = isset($excel->sheets[0]['cells'][$x][$y]) ? $excel->sheets[0]['cells'][$x][$y] : '';
              echo "\t\t<th>$cell.$x</th>\n";  // get each cells values
              $y++;
            }  
            echo "\t</tr>\n";
            echo "\t</thead>\n";
          }else{

            echo "\t<tr>\n";
            $y=1;
            while($y<=$excel->sheets[0]['numCols']) {// reading column by column 
              $cell = isset($excel->sheets[0]['cells'][$x][$y]) ? $excel->sheets[0]['cells'][$x][$y] : '';
              echo "\t\t<td>$cell</td>\n";  // get each cells values
              $y++;
            }  
            echo "\t</tr>\n";

          }
          $x++;
        }
        echo "\t</tbody>\n";
    ?>    
    </table>
  </body>
</html>