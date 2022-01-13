<?php
namespace Ijdb\Controllers;
use \Ninja\DatabaseTable;
class Visit {
    private $loginsTable;
    private $domainTable;
    private $combinedInfoIPTable;
	private $authorsTable;
    private $tempTable;
    
	public function __construct(DatabaseTable $loginsTable, DatabaseTable $domainTable, DatabaseTable $tempTable, DatabaseTable $combinedInfoIPTable, DatabaseTable $authorsTable) {
		$this->loginsTable = $loginsTable;
        $this->domainTable = $domainTable;
        $this->tempTable = $tempTable;
        $this->combinedInfoIPTable = $combinedInfoIPTable;
		$this->authorsTable = $authorsTable;
	}

	public function list() {
        $result1 = $this->combinedInfoIPTable->main();
        //$joiners = [];
        $params = [];
        $z = 0;
        foreach ($params as $i => $value) {
            unset($array[$i]);
        }
                
        if($result1 == "IncorrectPassword"){
            echo "<p class='mainText' style = 'text-align: center;'><b>Incorrect Password.</b> Please make new selections above</p>";?><script>alert("Incorrect Password. Please make new selections above");</script><?php
        }else if($result1 == "empty"){
            echo "<p class='mainText' style = 'text-align: center;'><b>Please make selections above & enter Password</b></p>";
        }else if($result1 == "countedStudents" || $result1 == "countedDbs"){
            //echo "<b>Counted all student visits</b>";
        }else{
            foreach($result1 as $p){
                $params[$z] = $p;
                $z++;
            }
            
            if($params[0] == 0){
                echo("<p class='mainText' style = 'text-align: center;'><br><br>There is no data to display at the moment. <b>Please make new selections above</b></p>");
            }
                            
        } 
                 
            
		$title = 'Ezproxy';

	}
 
} //end of class
?>
</select></td>
</tr>
</form>
</table>

<!--
                    <table style = "text-align: center; width: 80%; align: center; margin-right: auto; margin-left: auto;">
                    <tr>
                    <th>Date</th>
                    <th>IP</th>
                    <th>Domain</th>
                    <th>Email</th>
                    </tr>
-->
