
				
<?php
	error_reporting(E_ALL);
    ini_set('display_errors','on');
	
	
	//connecting to DB:
	
	$host = 'localhost'; 
	$user = 'root'; 
	$password = 'root'; 
	$db_name = 'test'; 

	$link = mysqli_connect($host, $user, $password, $db_name);
	mysqli_query($link, "SET NAMES 'utf8'");
		
		
	//pagination
	
	$notesOnPage = 3;
	
	if(isset($_GET['page'])) {
    $page = $_GET['page'];
    } else {
    $page = 1;
    }
		
	$from = ($page - 1) * $notesOnPage;
		
	$query = "SELECT COUNT(*) as count FROM book";
	$result = mysqli_query($link, $query) or die(mysqli_error($link));
	$count = mysqli_fetch_assoc($result)['count'];
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
					
	$query = "INSERT INTO book SET name='$name', date='$date', comment='$comment'";
	mysqli_query($link, $query) or die(mysqli_error($link));
	}

    //show comments according to the variable $notesOnPage:
    $query = "SELECT * FROM book LIMIT $from, $notesOnPage";
	$result = mysqli_query($link, $query) or die(mysqli_error($link));
	for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
		
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


			