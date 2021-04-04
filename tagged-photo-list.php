<?php
$servername = "localhost";
$username = "images";
$password = "F0t0b0mb";
$dbname = "anderson_images";
//TODO CHANGE EVERYTHING LATER!!!!!!
$TAG = $_GET['tag_id'];

if (isset($_GET['pageno'])) {
  $pageno = $_GET['pageno'];
} else {
  $pageno = 1;
}
$no_of_records_per_page = 50;
$offset = ($pageno-1) * $no_of_records_per_page;



// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$total_pages_sql = "select COUNT(*) from tag_links where tag_id = $TAG";
$total_pages_result = mysqli_query($conn,$total_pages_sql);
$total_rows = mysqli_fetch_array($total_pages_result)[0];
$total_pages = ceil($total_rows / $no_of_records_per_page);

$tag_names_sql = "select tag_names from tags where tag_id = $TAG";
$tag_names_result = mysqli_query($conn,$tag_names_sql);
$tag_names = mysqli_fetch_array($tag_names_result) [0];

$main_sql = "SELECT i.image_path, i.image_file, t.tag_names
from tags t
  left join tag_links tl on t.tag_id = tl.tag_id
  left join images i on tl.image_id = i.image_id
  where t.tag_id = $TAG order by image_path, image_file
  LIMIT $offset, $no_of_records_per_page";


$main_result = $conn->query($main_sql);

echo "<html>";
echo "<body bgcolor='#248794'>";
echo "<title>Anderson Tagged Photo List</title>";
echo "<center><h2>$total_rows images contain the tag <i>$tag_names</i>.</h2></center>";
echo "<center><h3>Click on a thumbnail to open the image (if available).<br><small><cite>Thumbnail generation for newly added or recently moved images takes place every Sunday.</cite></small></h3></center>";
if (file_exists("/tools/webdocs/photos/rebuilding-thumbs"))
  echo "<center><h4>***** Thumbnail regeneration in progress; some thumbnails may not be available. *****</h4></center>";
?>
    <ul class="pagination">
        <table cellpadding=5 border=2>
	<tr><td><a href="<?php echo "?tag_id=$TAG&pageno=1"; ?>">First <?php echo "$no_of_records_per_page"; ?></a></td>
        <td class="<?php if($pageno <= 1){ echo 'disabled'; } ?>"> <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?tag_id=$TAG&pageno=".($pageno - 1); } ?>">Prev <?php echo "$no_of_records_per_page"; ?></a></td>
        <td class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>"> <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?tag_id=$TAG&pageno=".($pageno + 1); } ?>">Next <?php echo "$no_of_records_per_page"; ?></a> </td>
	<td><a href="<?php echo "?tag_id=$TAG&pageno=$total_pages"; ?>">Last Page</a></td>
        <td><a href="tagged-photo-pick.php">Back to Tag Picker</a></td></tr>
</table>
    </ul>
<?php

echo "<style type='text/css' media='screen'>";
  echo "#t1 tr:nth-child(odd) {background-color: gray;}";
  echo "#t1 tr:nth-child(even) {background-color: lightgray;}";
echo "</style>";

echo "<table id='t1' cellpadding=5>";
echo "<tr><th>Image Thumbnail</th><th align=left>Image Windows Path</th><th align=left>Image File Name</th></tr>";
if ($main_result->num_rows > 0) {
  // output data of each row
  while($row = $main_result->fetch_assoc()) {
    $db_image_path = $row["image_path"];
    $db_image_name = $row["image_file"];
    $web_image_path = str_replace ("\\", "/", $db_image_path);
    $web_image_path = str_replace ("D:/pictures", "https://photos.dbq-andersons.com/storage", $web_image_path);
    $web_thumb_path = str_replace ("storage", "thumbs", $web_image_path);
    $local_thumb_path = str_replace ("https://photos.dbq-andersons.com/storage", "/tools/webdocs/photos/thumbs", $web_image_path);
    //echo ("$local_thumb_path/$db_image_name");
    //echo ("Image Path: $web_image_path");
    if (file_exists("$local_thumb_path/$db_image_name")) {
      echo "<tr><td align=center><a href='$web_image_path/$db_image_name'><img align=center src='$web_thumb_path/$db_image_name'></a></td><td>$db_image_path</td><td>$db_image_name</td></tr>";
    } else {
    echo "<tr><td align=center><a href='$web_image_path/$db_image_name' style='text-decoration: none'>Thumbnail Currently<br>Not Available</a></td><td>$db_image_path</td><td>$db_image_name</td></tr>";
    }
  }
} else {
  echo "0 results";
}
$conn->close();
echo "</table>";
?>
    <ul class="pagination">
        <table cellpadding=5 border=2>
	<tr><td><a href="<?php echo "?tag_id=$TAG&pageno=1"; ?>">First <?php echo "$no_of_records_per_page"; ?></a></td>
        <td class="<?php if($pageno <= 1){ echo 'disabled'; } ?>"> <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?tag_id=$TAG&pageno=".($pageno - 1); } ?>">Prev <?php echo "$no_of_records_per_page"; ?></a></td>
        <td class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>"> <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?tag_id=$TAG&pageno=".($pageno + 1); } ?>">Next <?php echo "$no_of_records_per_page"; ?></a> </td>
	<td><a href="<?php echo "?tag_id=$TAG&pageno=$total_pages"; ?>">Last Page</a></td></tr>
</table>
    </ul>
