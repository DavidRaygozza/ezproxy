<?php namespace Ninja;?>

<!--

Later:
Change to inline block display for respinsiveness?
Add a loading animatin while queries are loading
Update functionality to run report one-by-one query
Update documentation

Nows:
Update variable names across all files (for sure change findAll function)
comments
Update documentation
Create pop up alerts for necessary queries to display counter text & paramteres used (use html & css to make a div that dynamicaalt adds/displa='block')
create scroll to certian section when query is sent and executed to show there is text at the bottom

-->

<?php
    
    // converts a character digit into an integer
    function toInt($s){
       $numsArray = array('1','2','3','4','5','6','7','8','9','0');
       for ($j = 0; $j < sizeof($numsArray); $j=$j+1){
            if($s == $numsArray[$j]){
                return intval($numsArray[$j]);
            }
       }
        return -1;
    }
    
    // sceurity feature for date (reads string entered in reverse)
    function grabVariables(&$d,&$m,&$y, &$date){
        $splitter = (str_split($date));
        $sum = 0;
        $counter = sizeof($splitter) - 1;
        $tenCounter = 1;
        $paramCounter = 1;
        
        //eror handling
        if(sizeof($splitter) != 10){
            //date value was inavlid
            $d = -1;
            return;
        }
        
        //error handling to make sure '/' were used in correct place
        if($splitter[2] != '/'){
            $d = -1;
            return;
        }

        if($splitter[5] != '/'){
            $d = -1;
            return;
        }
        
        
        while($counter >= 0){
           if($splitter[$counter] != '/'){
               $num = toInt($splitter[$counter]);
               //eror handling to make sure date entered is a number
             if($num == -1){
                $d = $num;
                return;
             }
               $num = $num * $tenCounter;
               $sum = $sum + $num;
               $tenCounter = $tenCounter * 10;
            }else if($splitter[$counter] == '/'){
                $tenCounter = 1;
                
                //reaches first '/' breakpoint & uses this number as year
                if($paramCounter == 1){
                    $y = $sum;
                    
                //reaches second '/' breakpoint & uses this number as day
                }else if($paramCounter == 2){
                    if($sum < 0 || $sum > 31){
                        $d = -1;
                        return;
                    }
                    $d = $sum;
                }
                $paramCounter = $paramCounter+1;
                $sum = 0;
            } //end main if-else
            
            //final edge case, gets month
            if($counter == 0){
                //if end of string use this number as month
                $m = $sum;
                if($sum < 0 || $sum > 12){
                    $d = -1;
                    return;
                }
                $paramCounter = $paramCounter+1;
                $sum = 0;
            }
        $counter = $counter - 1;
        } //ejnd while
    } //end of func
    
    //checks if any date entered should have a zero before the day or month
    function checkForZeroes(&$d1, &$m1, &$d2, &$m2){
        if($d1 < 10){
            $d1 = "0" . $d1;
        }
        if($m1 < 10){
            $m1 = "0" . $m1;
        }
        if($d2 < 10){
            $d2 = "0" . $d2;
        }
        if($m2 < 10){
            $m2 = "0" . $m2;
        }
    }
    
    //checks to see if the grab variables function returned a proper date, if not then returns -1 and propgram will not run
    function isValidDate($d1, $d2){
        if($d1 == -1 || $d2 == -1){
            echo "Invalid Date Value(s): Use format 'MM/DD/YYYY'<br>";
            return false;
        }
        return true;
    }
        
    
class DatabaseTable {
    private $pdo;
    private $table;
    private $primaryKey;

    public function __construct(\PDO $pdo, string $table, string $primaryKey) {
        $this->pdo = $pdo;
        $this->table = $table;
        $this->primaryKey = $primaryKey;
    }

    private function query($sql, $parameters = []) {
        $query = $this->pdo->prepare($sql);
        $query->execute($parameters);
        return $query;
    }
    
//change to main function later
public function findAll() {
    ?>



<div>
<header>
<svg id="headerSvg"xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#FFFFFF" fill-opacity="1" d="M0,128L34.3,133.3C68.6,139,137,149,206,170.7C274.3,192,343,224,411,240C480,256,549,256,617,229.3C685.7,203,754,149,823,138.7C891.4,128,960,160,1029,149.3C1097.1,139,1166,85,1234,69.3C1302.9,53,1371,75,1406,85.3L1440,96L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path></svg>
    <h1>Ezproxy Logs Database</h1>
    <div class="weather">
        <p class="temp"></p>
        <img class="icon"></img>
    </div>
</header>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="classes/Ninja/script.js"></script>
<script>
$(document).ready(function(){
      $.getJSON('classes/Ninja/JSON.json', function(data) {
              var correctAdminCode = data.adminCode;
              document.getElementById('correctAdminCode2').value = correctAdminCode;
                console.log(correctAdminCode);
      });
});
  
//used to determine which type of dynamic query to run
function check1(){
    document.getElementById("box1").checked = true;
    document.getElementById("box2").checked = false;
    document.getElementById("box3").checked = false;
}
 

function check2(){
    document.getElementById("box1").checked = false;
    document.getElementById("box2").checked = true;
    document.getElementById("box3").checked = false;
}

function check3(){
   
    document.getElementById("box1").checked = false;
    document.getElementById("box2").checked = false;
    document.getElementById("box3").checked = true;
}

//used to grab data from tabel being displayed for download
function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'countData.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}

function queryEachDatabase(){
    check2();
    document.getElementById('submitButton').click();
}

function runStudentCounter(){
    check3();
    document.getElementById('submitButton').click();
}

function submitClicked(){
    document.getElementById('loadingDiv').style.display="block";
    document.getElementByClassName('loader').style.display="block";
}

</script>



<?php
    //grabs and filters out distinct database names to be used in dropdwon. Removes all gateways before main domain name
    $dbArray = [];
    $result100 = $this->query("SELECT * FROM newdbnames;");
    $result101 = $result100->fetchAll();
    foreach ($result101 as $d){
            array_push($dbArray, $d['Domain']);
     }
    $countArray = 0;
    while($countArray < sizeof($dbArray)){
        $charCounter = 1;
        $dotCounter = 0;
        $currentString = str_split($dbArray[$countArray]);
        $lengthOfCurrentString = sizeof($currentString);
        while($charCounter <= $lengthOfCurrentString){
            $currentChar = $currentString[$lengthOfCurrentString-$charCounter];
            if($currentChar == '.'){
                $dotCounter += 1;
            }
            if($dotCounter > 1){
                array_splice($currentString, 0, 1);
            }
            $charCounter += 1;
        } // end of looping through string
        if($dotCounter == 0){
            $dbArray[$countArray] = "ebscohost.com";
        }else{
            $newString = implode("", $currentString);
            $dbArray[$countArray] = $newString;
        }
        $countArray += 1;
    } // end of looping through all db names
    $dbArray = array_values(array_unique($dbArray, SORT_REGULAR));
    asort($dbArray);
    
    
    
    /*
     if i use one view it will be O(N) instea dof O(3N) and i wont have to use 3 veiws in Database
     how cna i go trhough a full-site and check if it belogns to G, P, or E??
            dont wanmt to use .find() bevause it's an O(N) operation anyways,
    
     while i am not at the 9th characters to the end check if letters will be 'ebscohost'
     
     */
    
    
    //grabs and filters out distinct profile names for ebscohost to be used in dropdwon
    $ebscohostProfilesArray = [];
    $proquesttProfilesArray = [];
    $galeProfilesArray = [];
    $profilesArray = [];

    $profilesQuery = $this->query("SELECT * FROM distinctfullsites;");
    $profilesQueryResults = $profilesQuery->fetchAll();
    foreach ($profilesQueryResults as $p){
            array_push($profilesArray, $p['FullSite']);
     }
    
    $countArray = 0;
    while($countArray < sizeof($profilesArray)){
        $charCounter = 0;
        $currentString = str_split($profilesArray[$countArray]);
        $lengthOfCurrentString = sizeof($currentString);
        while($charCounter <= $lengthOfCurrentString-9){
            if($currentString[$charCounter] == 'e' && $currentString[$charCounter+1] == 'b' && $currentString[$charCounter+2] == 's' && $currentString[$charCounter+3] == 'c' && $currentString[$charCounter+4] == 'o' && $currentString[$charCounter+5] == 'h' && $currentString[$charCounter+6] == 'o' && $currentString[$charCounter+7] == 's' && $currentString[$charCounter+8] == 't'){
                $charCounter += 9;
                $profileName = "";
                while($charCounter <= $lengthOfCurrentString-8){
                    if($currentString[$charCounter] == 'p' && $currentString[$charCounter+1] == 'r' && $currentString[$charCounter+2] == 'o' && $currentString[$charCounter+3] == 'f' && $currentString[$charCounter+4] == 'i' && $currentString[$charCounter+5] == 'l' && $currentString[$charCounter+6] == 'e'  && $currentString[$charCounter+7] == '='){
                        $charCounter += 8;
                        while($charCounter < $lengthOfCurrentString && $currentString[$charCounter] != '&' && $currentString[$charCounter] != ':'){
                            $currentChar = $currentString[$charCounter];
                            $updatedChar = preg_replace('/\s+/', '', $currentChar);
                            if($updatedChar == $currentChar){
                                $profileName .= $currentChar;
                            }
                            $charCounter += 1;
                        }
                        break;
                    }
                    $charCounter += 1;
                }
                if($profileName != "" && $profileName[0] != ' '){
                    array_push($ebscohostProfilesArray, $profileName);
                }
                break;
            }else if($currentString[$charCounter] == 'p' && $currentString[$charCounter+1] == 'r' && $currentString[$charCounter+2] == 'o' && $currentString[$charCounter+3] == 'q' && $currentString[$charCounter+4] == 'u' && $currentString[$charCounter+5] == 'e' && $currentString[$charCounter+6] == 's' && $currentString[$charCounter+7] == 't'){
                $charCounter += 8;
                $profileName = "";
//                STILL NEED TO FIND AN IDENTIFIER FOR THIS
//                while($charCounter <= $lengthOfCurrentString-8){
//                    if($currentString[$charCounter] == 'p' && $currentString[$charCounter+1] == 'r' && $currentString[$charCounter+2] == 'o' && $currentString[$charCounter+3] == 'f' && $currentString[$charCounter+4] == 'i' && $currentString[$charCounter+5] == 'l' && $currentString[$charCounter+6] == 'e'  && $currentString[$charCounter+7] == '='){
//                        $charCounter += 8;
//                        while($charCounter < $lengthOfCurrentString && $currentString[$charCounter] != '&'){
//                            $profileName.= $currentString[$charCounter];
//                            $charCounter += 1;
//                        }
//                        break;
//                    }
//                    $charCounter += 1;
//                }
                if($profileName != "" && $profileName[0] != ' '){
                    $profileName = preg_replace('/\s+/', '', $profileName);
                    array_push($proquesttProfilesArray, $profileName);
                }
                break;
            }else if($currentString[$charCounter] == 'g' && $currentString[$charCounter+1] == 'a' && $currentString[$charCounter+2] == 'l' && $currentString[$charCounter+3] == 'e'){
                $charCounter += 5;
                $profileName = "";
                while($charCounter <= $lengthOfCurrentString-2){
                    if($currentString[$charCounter] == 'p' && $currentString[$charCounter+1] == '='){
                        $charCounter += 2;
                        while($charCounter < $lengthOfCurrentString && $currentString[$charCounter] != '&'){
                            $currentChar = $currentString[$charCounter];
                            $updatedChar = preg_replace('/\s+/', '', $currentChar);
                            if($updatedChar == $currentChar){
                                $profileName .= $currentChar;
                            }
                            $charCounter += 1;
                        }
                        break;
                    }
                    $charCounter += 1;
                }
                if($profileName != "" && $profileName[0] != ' '){
                    $profileName = preg_replace('/\s+/', '', $profileName);
                    array_push($galeProfilesArray, $profileName);
                }
                break;
            }
            $charCounter += 1;
        } // end of looping through one string
        $countArray += 1;
    } // end of looping through all full site names
    $ebscohostProfilesArray = array_values(array_unique($ebscohostProfilesArray, SORT_REGULAR));
    asort($ebscohostProfilesArray);
    $proquesttProfilesArray = array_values(array_unique($proquesttProfilesArray, SORT_REGULAR));
    asort($proquesttProfilesArray);
    $galeProfilesArray = array_values(array_unique($galeProfilesArray, SORT_REGULAR));
    asort($galeProfilesArray);
    
    //grabs distinct major names and stores into an array to be used in dropdwon
    $majorArray = [];
    $resultForMajors = $this->query("SELECT * FROM newmajors;");
    $resultForMajorsFetched = $resultForMajors->fetchAll();
    //grabs distinct major names to be used in dropdwon
    foreach ($resultForMajorsFetched as $m){
            array_push($majorArray, $m['Major']);
     }
    $majorArray = array_values(array_unique($majorArray, SORT_REGULAR));
      
    //grabs distinct campus names and stores into an array to be used in dropdwon
   $campusArray = [];
   $resultForCampuses = $this->query("SELECT * FROM newcampuses;");
   $resultForCampusesFetched = $resultForCampuses->fetchAll();

   foreach ($resultForCampusesFetched as $c){
           array_push($campusArray, $c['Campuses']);
    }
   $campusArray = array_values(array_unique($campusArray, SORT_REGULAR));
?>


<table id="myDiv"style = " margin-top: 2%; margin-bottom: 2%; height: 80%; margin-right: auto; margin-left: auto;">
<form action = "index.php?visit/list" id = "queryForm" method = "post">

<!--password input-->
    <tr>
        <td></td>
        <td>
        <input type = "password" id = "adminCode" name = "adminCode" value="" placeholder="PASSWORD">
        </td>
    </tr>

<!--date range input-->
    <tr>
        <td><input type="text" id = "date1" name = "date1" placeholder="MM/DD/YYY" style="background:none; border:0; border-bottom: 1px solid #0093B2; outline:none;">
        </td>
        <td style="text-align:center; color: #0093B2"><p>–</p></td>
        <td><input type="text" id = "date2" name = "date2" placeholder="MM/DD/YYY" style="background:none; border:0; border-bottom: 1px solid #0093B2; outline:none;"></td>
    </tr>


<!--database selector-->
    <tr>
        <td></td>
        <input type="checkbox" id="box1" name="box1" value="box1" onchange="check1()" checked style="display:none;">
        <td><select id = "dbSelector2" name = "dbSelector2" onchange="check1()" style = "margin-left: 5px; background:none; border:0; border-bottom: 1px solid #0093B2; border-radius:0;">
        <option name = "Total For All Databases" value = "Total For All Databases" selected>Total For All Databases</option>
        <?php
        foreach($dbArray as $t){
            if($t == "ebscohost.com"){ ?>
                <option><?=htmlspecialchars($t, ENT_QUOTES, 'UTF-8')?></option>
<?php           foreach($ebscohostProfilesArray as $e){ ?>
                        <option><?=htmlspecialchars(". " . ". " . ". " . $e, ENT_QUOTES, 'UTF-8')?></option>
<?php           }
            }else if($t == "proquest.com"){?>
                <option><?=htmlspecialchars($t, ENT_QUOTES, 'UTF-8')?></option>
<?php           foreach($proquestProfilesArray as $p){ ?>
                        <option><?=htmlspecialchars(". " . ". " . ". " . $p, ENT_QUOTES, 'UTF-8')?></option>
<?php           }
            }else if($t == "gale.com"){?>
                <option><?=htmlspecialchars($t, ENT_QUOTES, 'UTF-8')?></option>
<?php           foreach($galeProfilesArray as $g){ ?>
                        <option><?=htmlspecialchars(". " . ". " . ". " . $g, ENT_QUOTES, 'UTF-8')?></option>
<?php           }
            }else{ ?>
                <option><?=htmlspecialchars($t, ENT_QUOTES, 'UTF-8')?></option>
<?php       }
        } ?>
            
        </select></td>
    </tr>

<!--major selector-->
    <tr>
        <td></td>
        <td>

        <select id = "majorSelector" name = "majorSelector" onchange="check1()" style = "margin: 0 auto; text-align: center; background:none; border:0; border-bottom: 1px solid #0093B2; border-radius:0;">
        <option name = "Total For All Majors" value = "Total For All Majors" selected>Total For All Majors</option>
        <?php
        foreach($majorArray as $t){
            if($t != "" && $t != " "){?>
                <option><?=htmlspecialchars($t, ENT_QUOTES, 'UTF-8')?></option>
        <?php
            }
        } ?>
        </select></td>
    </tr>

<!--level selector-->
    <tr>
        <td></td>
        <td>
        <select id = "levelSelector" name = "levelSelector" onchange="check1()" style = "margin: 0 auto; text-align: center; background:none; border:0; border-bottom: 1px solid #0093B2; border-radius:0;"">
            <option name = "Total For All Levels" value = "Total For All Levels" selected>Total For All Levels</option>
            <option name = "Freshman" value = "Freshman">Freshman</option>
            <option name = "Sophomore" value = "Sophomore">Sophomore</option>
            <option name = "Junior" value = "Junior">Junior</option>
            <option name = "Senior" value = "Senior">Senior</option>
        </select></td>
    </tr>

<!--campus selector-->
    <tr>
        <td></td>
        <td>
        <select id = "campusSelector" name = "campusSelector" onchange="check1()" style = "margin: 0 auto; text-align: center; background:none; border:0; border-bottom: 1px solid #0093B2; border-radius:0;">
        <option name = "Total For All Campuses" value = "Total For All Campuses" selected>Total For All Campuses</option>
        <?php
        foreach($campusArray as $t){
            if($t != "" && $t != " "){?>
                <option><?=htmlspecialchars($t, ENT_QUOTES, 'UTF-8')?></option>
        <?php
            }
        } ?>
        </select></td>
    </tr>


<!--submit button-->
    <tr>
        <td></td>
        <td>
        <input type="submit" value = "Submit" name = "submit" class = "submitButton" id = "submitButton" onsubmit="submitClicked()" style = "margin-left: 5px; width: 100%;">
        </td>
    </tr>


<!--Button to query each database Selector-->
    <tr>
        <td></td>
        <input type="checkbox" id="box2" name="box2" value="box2" onchange="check2()" style="display:none;">
        <td><button onclick="queryEachDatabase()" style="text-align:center; width: 12vw;" class = "queryButton">Query Each Database</button></td>
    </tr>


<!--Button to run student counter-->
    <tr>
        <td></td>
        <input type="checkbox" id="box3" name="box3" value="box3" onchange="check3()" style="display:none;">
        <input type="text" name = "correctAdminCode2" id="correctAdminCode2" value="<?php echo $code?>" style="display:none;">
        <td><button onclick="runStudentCounter()" style="text-align:center; width: 12vw;" class = "queryButton">Student Counter</button></td>

        </select></td>
    </tr>



</table>
</form>
</div>


<?php
    $box1 = $_POST['box1'];
    $box2 = $_POST['box2'];
    $box3 = $_POST['box3'];
    $db2 = $_POST['dbSelector2'];
    $level = $_POST['levelSelector'];
   $major = $_POST['majorSelector'];
   $campus = $_POST['campusSelector'];
    $adminCode = $_POST['adminCode'];
    
    $code = $_POST['correctAdminCode2'];
    $date1 = $_POST['date1'];
    $date2 = $_POST['date2'];
    grabVariables($d1,$m1,$y1, $date1);
    grabVariables($d2,$m2,$y2, $date2);


    if($adminCode == $code && $code != ""){?>
        <hr>
        <div id = "results">
        <?php
        echo("<br><p id = 'resultsSection'>Password Successful</p><br>");?>
        <script>
            function closeDiv(){
                document.getElementById('alertBox').style.display="none";
            }
              var div1 = "<div id='alertBox'><p id='replacableText'>Password Successful</p><a href='#resultsSection'><button class = 'submitButton' id='viewResultsButton' onclick='closeDiv()'>View Results</button></a><button onclick='closeDiv()' style='position: absolute; top:5%;right:5%; background:none; border: 0; color: white;'>X</button></a></div>";
              $("header").append(div1);
        </script>
        <?php
        if(!isValidDate($d1, $d2)){
            return "empty";
        }
        checkForZeroes($d1,$m1,$d2,$m2);
        echo("You selected: From <b>$date1</b> To <b>$date2</b><br>");
        
        //runs by default
        if($box1 == "box1"){
            $queryString = "SELECT COUNT(distinct `Session`,`Domain`) FROM ezproxy.groupingdata3 WHERE `Date` BETWEEN '$y1/$m1/$d1' AND '$y2/$m2/$d2'";
            if($db2 != "Total For All Databases"){
                if($db2[0] == '.'){
                    $db2 = substr($db2, 6);
                    $queryString .= " AND (FullSite like '%profile=$db2%' OR FullSite like '%p=$db2%')"; //add gale identifier here later
                    echo("Profile: $db2<br>");
                }else{
                    $queryString .= " AND Domain like '%$db2%'";
                    echo("Database: $db2<br>");
                }
            }
            if($level != "Total For All Levels"){
                $queryString .= " AND stat_category_description1 like '%$level%'";
                echo("Level: $level<br>");
            }
            if($major != "Total For All Majors"){
                $queryString .= " AND stat_category_code3_1 like '%$major%'";
                echo("Major: $major<br>");
            }
            if($campus != "Total For All Campuses"){
                $queryString .= " AND stat_category_description2 like '%$campus%'";
                echo("Campus: $campus<br>");
            }
            $q = $this->query($queryString);
            $row = $q->fetch();
            $paramArray[0] = $row[0];
            echo("Total visits in this date range<br>");
            echo("<h2 id = 'visitsCounter'>$paramArray[0]</h2>");
            return $paramArray;
            
        } // if first checkbox isnt clicked, selected by default
        
        else if($box2 == "box2"){
            $d = 0;
            echo("You selected to query each database<br>");
?>
            <button type = "button" id = "downloadIt2" onclick="exportTableToExcel('dbCounter')">Download</button>
            <table id = "dbCounter"style = "text-align: center; width: 50%; align: center; margin-top: 2%; margin-bottom: 2%; margin-right: auto; margin-left: auto;">
            <tr>
                <th>#</th>
                <th>Domain</th>
                <th>Visits</th>
            </tr>

            <?php
                $dateRange = "`Date` BETWEEN '$y1/$m1/$d1' AND '$y2/$m2/$d2';";
            foreach($dbArray as $dbName){
                if($dbName != ""){
                    $d+=1;
                    if($dbName == "ebscohost.com"){
                        $c = $this->query("SELECT COUNT(distinct `Session`,`Domain`) FROM ezproxy.groupingdata3 WHERE Domain Like '%" . $dbName . "%' AND " . $dateRange);
                        $dbCounter = $c->fetch(); ?>
                        <tr>
                               <td style = "border: 2px solid black; margin: 1%; font-size: 15px;"><?=htmlspecialchars($d, ENT_QUOTES, 'UTF-8')?></td>
                               <td style = "border: 2px solid black; margin: 1%; font-size: 15px;"><?=htmlspecialchars($dbName, ENT_QUOTES, 'UTF-8')?></td>
                               <td style = "border: 2px solid black; margin: 1%; font-size: 15px;"><?=htmlspecialchars($dbCounter[0], ENT_QUOTES, 'UTF-8')?></td>
                        </tr>
                <?php   foreach($ebscohostProfilesArray as $profileName){
                            $d+=1;
                            $c = $this->query("SELECT COUNT(distinct `Session`,`Domain`) FROM ezproxy.groupingdata3 WHERE FullSite Like '%profile=" . $profileName . "%' AND " . $dateRange);
                            $dbCounter = $c->fetch();?>
                            <tr>
                                   <td style = "border: 2px solid black; margin: 1%; font-size: 15px;"><?=htmlspecialchars($d, ENT_QUOTES, 'UTF-8')?></td>
                                   <td style = "border: 2px solid black; margin: 1%; font-size: 15px;"><?=htmlspecialchars("Profile: " . $profileName, ENT_QUOTES, 'UTF-8')?></td>
                                   <td style = "border: 2px solid black; margin: 1%; font-size: 15px;"><?=htmlspecialchars($dbCounter[0], ENT_QUOTES, 'UTF-8')?></td>
                            </tr>
                <?php    }
//                        runThroughProfiles($dbName, $ebscohostProfilesArray, $d, $dateRange);
                    }else if($dbName == "proquest.com"){
                        $c = $this->query("SELECT COUNT(distinct `Session`,`Domain`) FROM ezproxy.groupingdata3 WHERE Domain Like '%" . $dbName . "%' AND " . $dateRange);
                        $dbCounter = $c->fetch(); ?>
                        <tr>
                               <td style = "border: 2px solid black; margin: 1%; font-size: 15px;"><?=htmlspecialchars($d, ENT_QUOTES, 'UTF-8')?></td>
                               <td style = "border: 2px solid black; margin: 1%; font-size: 15px;"><?=htmlspecialchars($dbName, ENT_QUOTES, 'UTF-8')?></td>
                               <td style = "border: 2px solid black; margin: 1%; font-size: 15px;"><?=htmlspecialchars($dbCounter[0], ENT_QUOTES, 'UTF-8')?></td>
                        </tr>
                <?php   foreach($proquestProfilesArray as $profileName){
                            $d+=1;
                            $c = $this->query("SELECT COUNT(distinct `Session`,`Domain`) FROM ezproxy.groupingdata3 WHERE FullSite Like '%" . $profileName . "%' AND " . $dateRange);
                            $dbCounter = $c->fetch();?>
                            <tr>
                                   <td style = "border: 2px solid black; margin: 1%; font-size: 15px;"><?=htmlspecialchars($d, ENT_QUOTES, 'UTF-8')?></td>
                                   <td style = "border: 2px solid black; margin: 1%; font-size: 15px;"><?=htmlspecialchars("Profile: " . $profileName, ENT_QUOTES, 'UTF-8')?></td>
                                   <td style = "border: 2px solid black; margin: 1%; font-size: 15px;"><?=htmlspecialchars($dbCounter[0], ENT_QUOTES, 'UTF-8')?></td>
                            </tr>
                <?php    }
//                        runThroughProfiles($dbName, $proquestProfilesArray, $d, $dateRange);
                    }else if($dbName == "gale.com"){
                        $c = $this->query("SELECT COUNT(distinct `Session`,`Domain`) FROM ezproxy.groupingdata3 WHERE Domain Like '%" . $dbName . "%' AND " . $dateRange);
                        $dbCounter = $c->fetch(); ?>
                        <tr>
                               <td style = "border: 2px solid black; margin: 1%; font-size: 15px;"><?=htmlspecialchars($d, ENT_QUOTES, 'UTF-8')?></td>
                               <td style = "border: 2px solid black; margin: 1%; font-size: 15px;"><?=htmlspecialchars($dbName, ENT_QUOTES, 'UTF-8')?></td>
                               <td style = "border: 2px solid black; margin: 1%; font-size: 15px;"><?=htmlspecialchars($dbCounter[0], ENT_QUOTES, 'UTF-8')?></td>
                        </tr>
                <?php   foreach($galeProfilesArray as $profileName){
                            $d+=1;
                            $c = $this->query("SELECT COUNT(distinct `Session`,`Domain`) FROM ezproxy.groupingdata3 WHERE FullSite Like '%p=" . $profileName . "%' AND " . $dateRange);
                            $dbCounter = $c->fetch();?>
                            <tr>
                                   <td style = "border: 2px solid black; margin: 1%; font-size: 15px;"><?=htmlspecialchars($d, ENT_QUOTES, 'UTF-8')?></td>
                                   <td style = "border: 2px solid black; margin: 1%; font-size: 15px;"><?=htmlspecialchars("Profile: " . $profileName, ENT_QUOTES, 'UTF-8')?></td>
                                   <td style = "border: 2px solid black; margin: 1%; font-size: 15px;"><?=htmlspecialchars($dbCounter[0], ENT_QUOTES, 'UTF-8')?></td>
                            </tr>
                <?php    }
//                        runThroughProfiles($dbName, $galeProfilesArray, $d, $dateRange);
                    }else{
                        $c = $this->query("SELECT COUNT(distinct `Session`,`Domain`) FROM ezproxy.groupingdata3 WHERE Domain Like '%" . $dbName . "%' AND " . $dateRange);
                        $dbCounter = $c->fetch(); ?>
                        <tr>
                               <td style = "border: 2px solid black; margin: 1%; font-size: 15px;"><?=htmlspecialchars($d, ENT_QUOTES, 'UTF-8')?></td>
                               <td style = "border: 2px solid black; margin: 1%; font-size: 15px;"><?=htmlspecialchars($dbName, ENT_QUOTES, 'UTF-8')?></td>
                               <td style = "border: 2px solid black; margin: 1%; font-size: 15px;"><?=htmlspecialchars($dbCounter[0], ENT_QUOTES, 'UTF-8')?></td>
                        </tr>
<?php               }
                } // end of if dbName is not empty
            } // end for
            ?>
            </table>
            <?php
            $str = "countedDbs";
            return $str;
        }// end of if 2nd box is clicked
                
        else if($box3 == "box3"){
            echo("Greatest-Least order<br><br>");
            ?>
            <button type = "button" id = "downloadIt" onclick="exportTableToExcel('countData')">Download</button>
            <?php
            $dict = [];
            //do i need this??
            foreach ($dict as $i => $value) {
                unset($dict[$i]);
            } //end foreach
            $d = 0;
            $n = $this->query("SELECT distinct(univ_id) FROM groupingdata3;");
    ?>
            <table id = "countData"style = "text-align: center; width: 50%; align: center; margin-top: 2%; margin-bottom: 2%; margin-right: auto; margin-left: auto;">
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Lifetime Visits</th>
            </tr>
            <?php
            foreach($n as $arr){
                if($arr['univ_id'] != ""){
                    $d += 1;
                    $c = $this->query("SELECT COUNT(distinct `Session`,`Domain`) FROM ezproxy.groupingdata3 WHERE univ_id Like '%" . $arr['univ_id'] . "%' AND `Date` BETWEEN '$y1/$m1/$d1' AND '$y2/$m2/$d2';");
                    $studentCounter = $c->fetch();
                    $dict[$arr['univ_id']] = $studentCounter[0];
                }
            } // end for
            arsort($dict);
            $d = 0;
            foreach($dict as $key => $val){
                $d += 1;?>
                <tr>
                <td style = "border: 2px solid black; margin: 1%; font-size: 15px;"><?=htmlspecialchars($d, ENT_QUOTES, 'UTF-8')?></td>
                <td style = "border: 2px solid black; margin: 1%; font-size: 15px;"><?=htmlspecialchars(strval($key), ENT_QUOTES, 'UTF-8')?></td>
                <td style = "border: 2px solid black; margin: 1%; font-size: 15px;"><?=htmlspecialchars($val, ENT_QUOTES, 'UTF-8')?></td>
                </tr>
                <?php
            } //end foreach
            ?>
            </table>
            <?php
            $str = "countedStudents";
            return $str;
        }//end of if boxes are clicked
        else{
            //this is returned when no checkbox is clicked OR other default error
            $result2 = "empty";
            return $result2;
        }
    }else if($adminCode == "" || $code == ""){
        $result2 = "empty";
        return $result2;
    }else{
        $result2 = "IncorrectPassword";
        return $result2;
    } //end of admin code if-elses
     ?>
<!--Used to center all text within this area-->
    </div>
<?php
} //end of function
      
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    /*
     
     
     
     <Y NEED THIS VIEW FOR DATABASE
     CREATE
         ALGORITHM = UNDEFINED
         DEFINER = `root`@`localhost`
         SQL SECURITY DEFINER
     VIEW `distinctebscohostfullsites` AS
         SELECT DISTINCT
             `domain`.`FullSite` AS `FullSite`
         FROM
             `domain`
         WHERE
             (`domain`.`FullSite` LIKE '%ebscohost%')
     
     these are methods of the main class, will oi ever need them?
     public function total() {
         $query = $this->query('SELECT COUNT(*) FROM `' . $this->table . '`');
         $row = $query->fetch();
         return $row[0];
     }

     public function findById($value) {
         $query = 'SELECT * FROM `' . $this->table . '` WHERE `' . $this->primaryKey . '` = :value';

         $parameters = [
             'value' => $value
         ];

         $query = $this->query($query, $parameters);

         return $query->fetch();
     }

     public function find($column, $value) {
         $query = 'SELECT * FROM ' . $this->table . ' WHERE ' . $column . ' = :value';

         $parameters = [
             'value' => $value
         ];

         $query = $this->query($query, $parameters);

         return $query->fetchAll();
     }

     private function insert($fields) {
         $query = 'INSERT INTO `' . $this->table . '` (';

         foreach ($fields as $key => $value) {
             $query .= '`' . $key . '`,';
         }

         $query = rtrim($query, ',');

         $query .= ') VALUES (';


         foreach ($fields as $key => $value) {
             $query .= ':' . $key . ',';
         }

         $query = rtrim($query, ',');

         $query .= ')';

         $fields = $this->processDates($fields);

         $this->query($query, $fields);
     }


     private function update($fields) {
         $query = ' UPDATE `' . $this->table .'` SET ';

         foreach ($fields as $key => $value) {
             $query .= '`' . $key . '` = :' . $key . ',';
         }

         $query = rtrim($query, ',');

         $query .= ' WHERE `' . $this->primaryKey . '` = :primaryKey';

         //Set the :primaryKey variable
         $fields['primaryKey'] = $fields['id'];

         $fields = $this->processDates($fields);

         $this->query($query, $fields);
     }


     public function delete($id) {
         $parameters = [':id' => $id];

         $this->query('DELETE FROM `' . $this->table . '` WHERE `' . $this->primaryKey . '` = :id', $parameters);
     }
     
     
     
     
     
     
     
     
     
     
     
     
    public function getData($day, $month, $year, $db, $counting, $nd){
        if($day == "All"){
            if($month == "All"){
                if($year == "All"){
                    if($db == "All"){
                        $q = $this->query("SELECT * FROM combinedInfoIP2 order by date asc LIMIT 1000 Offset $nd;");
                    }else{
                        $q = $this->query("SELECT * FROM combinedInfoIP2 where domain Like '%" . $db . "%' order by date asc LIMIT 1000 Offset $nd");
                    } // end of if db is not All
                }else{
                    if($db == "All"){
                        $q = $this->query("SELECT * FROM combinedInfoIP2 where Date Like '%" . $year . "' order by date asc LIMIT 1000 Offset $nd;");
                    }else{
                        $q = $this->query("SELECT * FROM combinedInfoIP2  where date Like '%" . $year . "' AND domain Like '%" . $db . "%' order by date asc LIMIT 1000 Offset $nd;");
                    } // end of if db is not All
                } // end of if year is not All
            }else{
                if($year == "All"){
                    if($db == "All"){
                        $q = $this->query("SELECT * FROM combinedInfoIP2 where date Like '%/" . $month . "/%' order by date asc LIMIT 1000 Offset $nd;");
                    }else{
                        $q = $this->query("SELECT * FROM combinedInfoIP2 where domain Like '%" . $db . "%' AND date Like '%/" . $month . "/%' order by date asc LIMIT 1000 Offset $nd");
                    } // end of if db is not All
                }else{
                    if($db == "All"){
                        $q = $this->query("SELECT * FROM combinedInfoIP2 where date Like '%/" . $month . "/%' AND date Like '%" . $year . "' order by date asc LIMIT 1000 Offset $nd;");
                    }else{
                        $q = $this->query("SELECT * FROM combinedInfoIP2 where date Like '%/" . $month . "/%' AND date Like '%" . $year . "' AND domain Like '%" . $db . "%' order by date asc LIMIT 1000 Offset $nd;");
                    } // end of if db is not All
                } // end of if year is not All
            } //end of if month is not All
        }else{ //when day is not All
            if($month == "All"){
                if($year == "All"){
                    if($db == "All"){
                        $q = $this->query("SELECT * FROM combinedInfoIP2 where date Like '" . $day . "%' order by date asc LIMIT 1000 Offset $nd;");
                       //re enter code here
                    }else{
                        $q = $this->query("SELECT * FROM combinedInfoIP2 where date Like '" . $day . "%' AND domain like '%" . $db . "%' order by date asc LIMIT 1000 Offset $nd;");
                    } // end of if db is not All
                }else{
                    if($db == "All"){
                        $q = $this->query("SELECT * FROM combinedInfoIP2 where date Like '" . $day . "%' AND date Like '%" . $year . "' order by date asc LIMIT 1000 Offset $nd;");
                    }else{
                        $q = $this->query("SELECT * FROM combinedInfoIP2  where date Like '" . $day . "%' AND date Like '%" . $year . "' AND domain Like '%" . $db . "%' order by date asc LIMIT 1000 Offset $nd;");
                    } // end of if db is not All
                } // end of if year is not All
            }else{
                if($year == "All"){
                    if($db == "All"){
                        $q = $this->query("SELECT * FROM combinedInfoIP2 where date Like '" . $day . "%' AND date Like '%/" . $month . "/%' order by date asc LIMIT 1000 Offset $nd;");
                    }else{
                        $q = $this->query("SELECT * FROM combinedInfoIP2 where domain Like '%" . $db . "%' AND date Like '%/" . $month . "/%' AND date Like '" . $day . "%' order by date asc LIMIT 1000 Offset $nd");
                    } // end of if db is not All
                }else{
                    if($db == "All"){
                        $q = $this->query("SELECT * FROM combinedInfoIP2 where date Like '" . $day . "%' AND date Like '%/" . $month . "/%' AND date Like '%" . $year . "'order by date asc LIMIT 1000 Offset $nd;");
                    }else{
                        $q = $this->query("SELECT * FROM combinedInfoIP2 where date Like '" . $day . "%' AND date Like '%/" . $month . "/%' AND date Like '%" . $year . "' AND domain Like '%" . $db . "%' order by date asc LIMIT 1000 Offset $nd;");
                    } // end of if db is not All
                } // end of if year is not All
            } //end of if month is not All
        }//end of if day is not All
        return $q->fetchAll();
    }
    */
    
                            
    
    public function findBasicRows() {
            $result2 = $this->query("SELECT domain FROM " . $this->table . " order by date asc;");
            return $result2->fetchAll();
    }
    
    private function processDates($fields) {
        foreach ($fields as $key => $value) {
            if ($value instanceof \date) {
                $fields[$key] = $value->format('Y-m-d');
            }
        }

        return $fields;
    }


    public function save($record) {
        try {
            if ($record[$this->primaryKey] == '') {
                $record[$this->primaryKey] = null;
            }
            $this->insert($record);
        }
        catch (\PDOException $e) {
            $this->update( $record);
        }
    }
}
                
                
                
//code i might need later
                /*
                 //1: Grab dates and remove slashes, grab day, month, year
                 //return param array and create dynamic query to return counter
                 //3: Create error handling if date ranges are invalid then return invalid dates string, else return counter of dynamic query
                 //only need query fior when day month and year are unique, db must be set to all
                 
                 //check that date 2 is greater than date 1
                 //if year2 < year1
                     //not valid date
                 
                 //if(year2 == year1)
                     //if(month < month2)
                         //not valid date
                     //if(month == month2)
                         //if(day2<day1)
                             //notvaid date
                         
                 //10/10/2020 - 02/02/2021
                 //have to iterate tgrough all days, all monhs, and all years entered
                 
                 //set sum = 0;
                 //while(year 2>=year1)
                     //if(month2 = 0)
                         //change month2 to 12
                     //while(month2 >= month1 && month2 >= 1){
                         //if(day = 0)
                             //change day to 31
         
                         //while(day2 >= day1 && day2 >= 1)
                             //query counter where like day, month, year);
                             //sum += query counter
                             //$day -= 1;
                         //before month while closes, change to month -= 1
                 //before year while ends change to $year -= 1;
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 else if($box1 == "box1"){
                     $paramArray = [];
                     if($day == "All"){
                         if($month == "All"){
                             if($year == "All"){
                                 if($db == "All"){
                                     $q = $this->query("SELECT COUNT(distinct `Session`,`Domain`) FROM test.sessionJoinner2;");
                                 }else{
                                     $q = $this->query("SELECT COUNT(distinct `Session`,`Domain`) FROM test.sessionJoinner2 where Domain Like '%" . $db . "%';");
                                 } // end of if db is not All
                             }else{
                                 if($db == "All"){
                                     $q = $this->query("SELECT COUNT(distinct `Session`,`Domain`) FROM test.sessionJoinner2 where Date Like '" . $year . "-%';");
                                 }else{
                                     $q = $this->query("SELECT COUNT(distinct `Session`,`Domain`) FROM test.sessionJoinner2  where Date Like '" . $year . "-%' AND Domain Like '%" . $db . "%';");
                                 } // end of if db is not All
                             } // end of if year is not All
                         }else{
                             if($year == "All"){
                                 if($db == "All"){
                                     $q = $this->query("SELECT COUNT(distinct `Session`,`Domain`) FROM test.sessionJoinner2 where Date Like '%-" . $month . "-%';");
                                 }else{
                                     $q = $this->query("SELECT COUNT(distinct `Session`,`Domain`) FROM test.sessionJoinner2 where Domain Like '%" . $db . "%' AND Date Like '%-" . $month . "-%'");
                                 } // end of if db is not All
                             }else{
                                 if($db == "All"){
                                     $q = $this->query("SELECT COUNT(distinct `Session`,`Domain`) FROM test.sessionJoinner2 where Date Like '%-" . $month . "-%' AND Date Like '" . $year . "-%';");
                                 }else{
                                     $q = $this->query("SELECT COUNT(distinct `Session`,`Domain`) FROM test.sessionJoinner2 where Date Like '%-" . $month . "-%' AND Date Like '" . $year . "-%' AND Domain Like '%" . $db . "%';");
                                 } // end of if db is not All
                             } // end of if year is not All
                         } //end of if month is not All
                     }else{ //when day is not All
                         if($month == "All"){
                             if($year == "All"){
                                 if($db == "All"){
                                     $q = $this->query("SELECT COUNT(distinct `Session`,`Domain`) FROM test.sessionJoinner2 where date Like '%-" . $day . "'");
                                 }else{
                                     $q = $this->query("SELECT COUNT(distinct `Session`,`Domain`) FROM test.sessionJoinner2 where Date Like '%-" . $day . "' AND Domain like '%" . $db . "%';");
                                 } // end of if db is not All
                             }else{
                                 if($db == "All"){
                                     $q = $this->query("SELECT COUNT(distinct `Session`,`Domain`) FROM test.sessionJoinner2 where Date Like '%-" . $day . "' AND Date Like '" . $year . "-%';");
                                 }else{
                                     $q = $this->query("SELECT COUNT(distinct `Session`,`Domain`) FROM test.sessionJoinner2  where Date Like '%_" . $day . "' AND Date Like '" . $year . "-%' AND Domain Like '%" . $db . "%';");
                                 } // end of if db is not All
                             } // end of if year is not All
                         }else{
                             if($year == "All"){
                                 if($db == "All"){
                                     $q = $this->query("SELECT COUNT(distinct `Session`,`Domain`) FROM test.sessionJoinner2 where Date Like '%-" . $day . "' AND Date Like '%-" . $month . "-%';");
                                 }else{
                                     $q = $this->query("SELECT COUNT(distinct `Session`,`Domain`) FROM test.sessionJoinner2 where Domain Like '%" . $db . "%' AND Date Like '%-" . $month . "-%' AND Date Like '%_" . $day . "'");
                                 } // end of if db is not All
                             }else{
                                 if($db == "All"){
                                     $q = $this->query("SELECT COUNT(distinct `Session`,`Domain`) FROM test.sessionJoinner2 where Date Like '%-" . $day . "' AND Date Like '%-" . $month . "-%' AND Date Like '" . $year . "-%';");
                                 }else{
                                     $q = $this->query("SELECT COUNT(distinct `Session`,`Domain`) FROM test.sessionJoinner2 where Date Like '%-" . $day . "' AND Date Like '%-" . $month . "-%' AND Date Like '" . $year . "-%' AND Domain Like '%" . $db . "%'");
                                 } // end of if db is not All
                             } // end of if year is not All
                         } //end of if month is not All
                     }//end of if day is not All
                     $row = $q->fetch();
                     $paramArray[0] = $row[0];
                     echo("<br>Password Successful<br>");
                     echo("You selected: Day - $day, Month - $month, Year - $year, Database - $db<br>");
                     echo("There are <b>" . $paramArray[0] . "</b> total visits in this database table<br><br>");
                     return $paramArray;
                 } // end of if box 1 is clicked
                         
                 */
                
                
                
                
                
                
                
     
?>




















<!--
OLD CODE FOR SELECTED DAY/MONTH/YEAR

foreach ($campusArray as $i => $value) {
    unset($campusArray[$i]);
}

        <tr>
        <td>
        <input type="checkbox" id="box1" name="box1" value="box1">
        </td>
        <td><p>Day:</p><select id = "daySelector" name = "daySelector" onchange="check1()" style = "margin-left: 5px;">
        <option name = "All" value = "All" selected>All</option>
        <?php
            for($j = 1; $j <= 31; $j++){
        if($j < 10){ ?>
            <option>0<?=htmlspecialchars($j, ENT_QUOTES, 'UTF-8')?></option>
            <?php
        }else{ ?>
            <option><?=htmlspecialchars($j, ENT_QUOTES, 'UTF-8')?></option>
        <?php
            }
        } ?>

        </select></td>

            <td><p>Month:</p><select id = "selector" onchange="check1()" name = "selector">
        <option name = "All" value = "ALl" selected>All</option>
            <option name = "01" value = "01">January</option>
            <option name = "02" value = "02">February</option>
            <option name = "03" value = "03">March</option>
            <option name = "04" value = "04">April</option>
            <option name = "05" value = "05">May</option>
            <option name = "06" value = "06">June</option>
            <option name = "07" value = "07">July</option>
            <option name = "08" value = "08">August</option>
            <option name = "09" value = "09">September</option>
            <option name = "10" value = "10">October</option>
            <option name = "11" value = "11">November</option>
            <option name = "12" value = "12">December</option>
            </select></td>
            <td><p>Year:</p><select id = "yearSelector" onchange="check1()" name = "yearSelector" style = "margin-left: 5px;">
            <option name = "All" value = "All" selected>All</option>

        <?php
            $y = date("Y");
            for($t = $y; $t >= 2020; $t--){?>
        <option><?=htmlspecialchars($t, ENT_QUOTES, 'UTF-8')?></option>
        <?php   } ?>
            </select></td>
            


        <td><p>Database:</p><select id = "dbSelector" name = "dbSelector" onchange="check1()" style = "margin-left: 5px;">
        <option name = "All" value = "All" selected>All</option>
        <?php
            foreach($dbArray as $t){?>
        <option><?=htmlspecialchars($t, ENT_QUOTES, 'UTF-8')?></option>
        <?php   } ?>
        </select></td>


        </tr>
-->




