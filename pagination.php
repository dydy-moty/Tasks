<?php
	error_reporting(E_ALL);
    ini_set('display_errors','on');
	
	
	//connecting to DB:
	
	$host = 'localhost'; 
	$user = 'root'; 
	$password = 'root'; 
	$db_name = 'test';


    try {
        #  PDO_MYSQL
        $DBH = new PDO("mysql:host=$host;dbname=$db_name", $user, $password);
        $DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

        #аналог mysqli_query($link, "SET NAMES 'utf8'");
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
    }
    catch(PDOException $e) {

        echo $e->getMessage();
    }

	//pagination
	
	$notesOnPage = 3;
	
	if(isset($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
    } else {
    $page = 1;
    }
		
	$from = ($page - 1) * $notesOnPage;

    $STM = $DBH->prepare("SELECT COUNT(*) as count FROM book");
    $STM->execute();
    $count = $STM->fetch(PDO::FETCH_ASSOC)['count'];
	$pagesCount = ceil($count/$notesOnPage);
?>
 <div>
    <nav>
	    <ul class="pagination">   
  
  
<?php
    //arrow Previous: 
    if($page > 1) {
    $previous = $page - 1;
    echo "<li><a href=\"?page=$previous\" aria-label=\"Previous\"><span aria-hidden=\"true\">&laquo;</span></a></li>";
    } else {
    echo "<li class=\"disabled\"><a href=\"?page=1\" aria-label=\"Previous\"><span aria-hidden=\"true\">&laquo;</span></a></li>";
    }

    //Formation of pages:
	$paginationStr = '';
	for ($i = 1; $i <= $pagesCount; $i++) {
	
    if ($page == $i) {
		$Active = "class = 'active'";
    } else {	
        $Active = "";
	}
		echo "<li $Active><a href=\"?page=$i\">$i</a></li>";
	}
	echo $paginationStr;
	
	//arrow Next:
	if($page < $pagesCount) {
    $next = $page + 1;
	echo "<li><a href=\"?page=".$next. "\"  aria-label=\"Next\"><span aria-hidden=\"true\">&raquo;</span></a>";
	} 
	if($page == $pagesCount) {
    echo "<li class=\"disabled\><a href=\"?page=$pagesCount\"  aria-label=\"Next\"><span aria-hidden=\"true\">&raquo;</span></a></li>";	
	}
			
?>

        </ul>
    </nav>
</div>

<?php
        
	// Saving new comment (before sending!):
	$isAdded = false;
	if (!empty($_POST['name'])) {
	$isAdded = true;
	$name = $_POST['name'];
	$comment = $_POST['comment'];
	$date = date('Y-m-d H:i:s');

    $STM = $DBH->prepare("INSERT INTO book SET name='$name', date='$date', comment='$comment'");
    $STM->execute();

	}

    //show comments according to the variable $notesOnPage:
    $STM = $DBH->prepare("SELECT * FROM book LIMIT $from, $notesOnPage");
    $STM->execute();
    $data = $STM->fetchAll(PDO::FETCH_ASSOC);

	$str = '';
    foreach($data as $elem) {
	$dateFromDB = strtotime($elem['date']);
				
	$str .= "<div class='note'><p>";
	$str .= "<b><span class='date'>".date('d.m.Y H:i:s',$dateFromDB)."</span></b>  ";
	$str .= "<span class='name'>".$elem['name']."</span></p>";
	$str .= "<p>".$elem['comment']."</p></div>";
    }
		 
    echo $str;
    			
?>


			