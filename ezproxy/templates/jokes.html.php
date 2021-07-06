<?php
    function displaying($array){
        foreach($array as $join):?>
            
                <tr>
                <td style = "border: 2px solid black; margin: 1%; font-size: 12px;"><?=htmlspecialchars($join['Date'], ENT_QUOTES, 'UTF-8')?></td>
                <td style = "border: 2px solid black; margin: 1%; font-size: 12px;"><?=htmlspecialchars($join['IP'], ENT_QUOTES, 'UTF-8')?></td>
                <td style = "border: 2px solid black; margin: 1%; font-size: 12px;"><?=htmlspecialchars($join['Domain'], ENT_QUOTES, 'UTF-8')?></td>
                <td style = "border: 2px solid black; margin: 1%; font-size: 12px;"><?=htmlspecialchars($join['User'], ENT_QUOTES, 'UTF-8')?></td>
                </tr>

            <?php endforeach;
    } //end of display function
                
       // displaying($joiners);
        ?>

</table>

<?php

    $counter = 0;
    //foreach($joiners as $join){
       // $counter = $counter + 1;
  //  }

    ?>
<br><br>


<?php
    
    ?>
                








































<!--



<form action = "index.php?joke/list" method = "post" style = "text-align: center; width: 100%; align: center; margin-right: auto; margin-left: auto;" >
<table style = "text-align: center; width: 60%; align: center; margin-top: 2%; margin-bottom: 2%; margin-right: auto; margin-left: auto;">
<tr>
<td>
</td>

<td>
<input type="submit" value = "View full data table" name = "submit" id = "submit" style = "margin-left: 5px;">
</td>

</tr>
</tr>
</table>

</form><br>


<table style = "text-align: center; align: center; margin-right: auto; margin-left: auto; width: 40%; ">
    <td><button style = "display: inline-block;; width: 10em; padding: 10%; height: auto; background-color: #29EEEE; border: grey 1px double; margin: 5px 5px 30% 5px;"><a href="index.php?joke/list?link=1">Logins Table</a></button></td>
   <td><button style = "display: inline; width: 10em; padding: 10%; height: auto; background-color: #29EEEE; border: grey 1px double; margin: 5px 5px 30% 5px;"><a href="index.php?joke/list?link=2">HTML Table</a></button></td>
   <td><button style = "display: inline; width: 10em; padding: 10%; height: auto; background-color: #29EEEE; border: grey 1px double; margin: 5px 5px 30% 5px;"><a href="index.php?joke/list?link=3">Domain Table</a></button></td>
   
</table>
-->



