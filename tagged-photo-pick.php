<?php
echo "<title>Anderson Photo Library Tag Selector</title>";
echo "<body bgcolor='#248794'>";

$servername = "localhost";
$username = "images";
$password = "F0t0b0mb";
$dbname = "anderson_images";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if(!$conn)
{
    die("Connection failed: " . mysqli_connect_error());
}

$image_count = mysqli_query($conn, "select COUNT(*) from images where not image_path like '%printables%' and not image_file like '%copy%'");
$image_count_result = mysqli_fetch_array($image_count)[0];

$name_tags = mysqli_query($conn, "SELECT tag_id, tag_names, tag_type FROM tags where tag_type = 'individual' order by tag_names");

$holiday_event_tags = mysqli_query($conn, "SELECT tag_id, tag_names, tag_type FROM tags where tag_type = 'holiday' or tag_type = 'event' order by tag_names");

$other_tags = mysqli_query($conn, "SELECT * FROM anderson_images.tags where tag_type != 'individual' and tag_type != 'holiday' and tag_type != 'event' and tag_type != 'year'");

$year_tags = mysqli_query($conn, "SELECT tag_id, tag_names, tag_type FROM tags where tag_type = 'year' order by tag_names");

echo "<center><h2>Select a tag to search for from one of the four categories.<br><small>You can start typing search patterns after clicking in the menu.</small><br><br>Currently, only a single tag search is supported.</h2></center>";
echo "<center><h3>Fun Fact: There are currently $image_count_result unique images in the database.</h3></center>";

if (file_exists("/tools/webdocs/photos/rebuilding-thumbs"))
  echo "<center><h4>***** Thumbnail regeneration in progress; some thumbnails may not be available. *****</h4></center>";

// Person Selector

echo "<form method='get' action='tagged-photo-list.php'>" ; 
echo "<select name='tag_id'>";
echo "<option disabled selected>-- Select Person --</option>";

while($tag = mysqli_fetch_array($name_tags))
{
  echo "<option value='". $tag['tag_id'] ."'>" .$tag['tag_names'] ."</option>";
}
echo "</select>";
echo "   ";
echo "<input type='submit'>";
echo "</form>";

// Holiday or Event Selector

echo "<form method='get' action='tagged-photo-list.php'>" ; 
echo "<select name='tag_id'>";
echo "<option disabled selected>-- Select Holiday or Event --</option>";

while($tag = mysqli_fetch_array($holiday_event_tags))
{
  echo "<option value='". $tag['tag_id'] ."'>" .$tag['tag_names'] ."</option>";
}
echo "</select>";
echo "   ";
echo "<input type='submit'>";
echo "</form>";

// Other Tag Selector

echo "<form method='get' action='tagged-photo-list.php'>" ; 
echo "<select name='tag_id'>";
echo "<option disabled selected>-- Select Other Tag --</option>";

while($tag = mysqli_fetch_array($other_tags))
{
  echo "<option value='". $tag['tag_id'] ."'>" .$tag['tag_names'] ."</option>";
}
echo "</select>";
echo "   ";
echo "<input type='submit'>";
echo "</form>";

// Year Selector

echo "<form method='get' action='tagged-photo-list.php'>" ;
echo "<select name='tag_id'>";
echo "<option disabled selected>-- Select Year --</option>";

while($tag = mysqli_fetch_array($year_tags))
{
  echo "<option value='". $tag['tag_id'] ."'>" .$tag['tag_names'] ."</option>";
}
echo "</select>";
echo "   ";
echo "<input type='submit'>";
echo "</form>";
?>
