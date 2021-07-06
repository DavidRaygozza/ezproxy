<?php
namespace Ijdb\Controllers;
use \Ninja\DatabaseTable;
use \Ninja\Authentication;
class Joke {
    private $loginsTable;
    private $domainTable;
    private $combinedInfoIPTable;
	private $authorsTable;
    private $tempTable;
    
	public function __construct(DatabaseTable $loginsTable, DatabaseTable $domainTable, DatabaseTable $tempTable, DatabaseTable $combinedInfoIPTable, DatabaseTable $authorsTable, Authentication $authentication) {
		$this->loginsTable = $loginsTable;
        $this->domainTable = $domainTable;
        $this->tempTable = $tempTable;
        $this->combinedInfoIPTable = $combinedInfoIPTable;
		$this->authorsTable = $authorsTable;
		$this->authentication = $authentication;
	}
    
    
    /*
     Now i just need to send pageNum as a param to getData function and offfset accordingly in each sql query
     */

	public function list() {
        $result1 = $this->combinedInfoIPTable->findAll();
        //$joiners = [];
        $params = [];
        $z = 0;
        $pages = $_POST['pages'];
        
//        echo("<br>Page Selected: $pages<br>");
//        if(isset($_POST['pages'])){
//            echo("<br>was set<br>");
//        }else{
//            echo("<br>Notset<br>");
//            $_POST['pages'] = 1;
//        }
        
        foreach ($params as $i => $value) {
            unset($array[$i]);
        }
        
        
        
        if($result1 == "IncorrectPassword"){
            echo "<p class='mainText'><b>Incorrect Password.</b> Please make new selections above</p>";?><script>alert("polease make new selctions");</script><?php
        }else if($result1 == "empty"){
            echo "<p class='mainText'><b>Please make selections above & enter Password</b></p>";
        }else if($result1 == "countedStudents" || $result1 == "countedDbs"){
            //echo "<b>Counted all student visits</b>";
        }else{
            foreach($result1 as $p){
                $params[$z] = $p;
                $z++;
            }
            
            if($params[0] == 0){
                echo("<p class='mainText'><br><br>There is no data to display at the moment. <b>Please make new selections above</b></p>");
            }
            
            /*
        foreach ($resultData as $join) {
            $joiners[] = [
            'id' => $join['id'],
            'Date' => $join['Date'],
            'IP' => $join['IP'],
            'Domain' => $join['Domain'],
            'User' => $join['User']
            ];
        } // end foreach
             */
            
            /*
             Must pass array opf params somehwere so it can be remmebred when page is changed so i cna run dynamic query
            if($params[4] > 1000){
                $resultData = $this->combinedInfoIPTable->getData($params[0], $params[1], $params[2], $params[3], $params[4], $params[5]);
            }else{
                $resultData = $this->combinedInfoIPTable->getData($params[0], $params[1], $params[2], $params[3], $params[4], $params[5]);
            } // end of if > 1000 rows
         */
                
        } // end of if password is correct
                 
            
		$title = 'Ezproxy';
		$author = $this->authentication->getUser();

        return ['template' => 'jokes.html.php',
				'title' => $title, 
				'variables' => [
                    //'joiners' => $joiners,
            'totalJokes' => $totalJokes
                ]
            ];
	}

	public function home() {
		$title = 'Exproxy';

		return ['template' => 'jokes.html.php', 'title' => $title];
	}
 
} //end of class
    
    
    
    
    
   










    /*
     
     
     //        for($y = 0; $y<3; $y++){
     //            ${'var' . $y} = "hi";
     //        }
     //        print("Result 2: $var2");
     
     
     
     while($r < $dataClumps){
         print("Clump #:" . ($r+1));
         $r+=1;
         $resultData = $this->combinedInfoIPTable->getData($params[0], $params[1], $params[2], $params[3], $params[4], $params[5], $params[6]);
         $params[5] += 1000;
         $params[6] += 1000;
     } // end of if > 1000
     
     
     
    
    
    
    $domains = [];
    foreach ($result3 as $domain) {
       
        $domains[] = [
            'id' => $domain['id'],
            'Datetime' => $domain['Datetime'],
            'IP' => $domain['IP'],
            'Session' => $domain['Session'],
            'Do' => $domain['Domain'],
            'Full Site' => $domain['Full Site']
        ];
    
}
    
    
    
    
    
        public function delete() {

            $author = $this->authentication->getUser();

            $joke = $this->jokesTable->findById($_POST['id']);

            if ($joke['authorId'] != $author['id']) {
                return;
            }
            

            $this->jokesTable->delete($_POST['id']);
            header('location: index.php?joke/list');  // 5/25/18 JG NEW1L
        }

        public function saveEdit() {
            $author = $this->authentication->getUser();


            if (isset($_GET['id'])) {
                $joke = $this->jokesTable->findById($_GET['id']);

                if ($joke['authorId'] != $author['id']) {
                    return;
                }
            }

            $joke = $_POST['joke'];
            $joke['workoutdate'] = new \DateTime();
            $joke['authorId'] = $author['id'];

            $this->jokesTable->save($joke);
            header('location: index.php?joke/list');  //5/25/18 JG NEW1L
            
        }

        public function edit() {
    //        $author = $this->authentication->getUser();

            if (isset($_GET['id'])) {
                $joke = $this->jokesTable->findById($_GET['id']);
            }

            $title = 'Edit joke';

            return ['template' => 'editjoke.html.php',
                    'title' => $title,
                    'variables' => [
                            'joke' => $joke ?? null,
                            'userId' => $author['id'] ?? null
                        ]
                    ];
        }
     */
?>

<!--
            <table style = "text-align: center; width: 60%; align: center; margin-top: 2%; margin-bottom: 2%; margin-right: auto; margin-left: auto;">
            <tr>
            <form id = "pagesForm" method = "post" style = "text-align: center; width: 100%; align: center; margin-right: auto; margin-left: auto;">
            <td><select id = "pages" name = "pages" style = "margin-left: 5px;">
            <option value = "1" selected>Page 1 of <?=htmlspecialchars($dataClumps, ENT_QUOTES, 'UTF-8')?></option>
            <?php
                for($g = 2; $g<= $dataClumps; $g++){?>
            <option value = "<?php echo $g?>">Page <?=htmlspecialchars($g, ENT_QUOTES, 'UTF-8')?> of <?=htmlspecialchars($dataClumps, ENT_QUOTES, 'UTF-8')?></option>
            <?php   } ?>
                    </select></td>
                    </tr>
                    </form>
                    </table>


                    <table style = "text-align: center; width: 80%; align: center; margin-right: auto; margin-left: auto;">
                    <tr>
                    <th>Date</th>
                    <th>IP</th>
                    <th>Domain</th>
                    <th>Email</th>
                    </tr>

-->
