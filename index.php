<?php
include_once('configs/global.php');
include_once('library/functions.php');  

if(!isset($_SESSION['user']['valid'])){
    header('Location: login.php');
exit;
}

/*form processing for new event*/
if(isset($_REQUEST['songTitle']) && isset($_REQUEST['submit'])){

    add_song($con,$_REQUEST);

}
/*end new event form processing*/

    if(isset($_REQUEST['submit']) && is_numeric($_REQUEST['band_id'])){
        $song = fetch_library($con,$_REQUEST['band_id']);
    }else{
       $song = fetch_library($con,$_CONFIGS['default_band_id']); 
    }
 include_once('header.php');
 
 if(isset($_REQUEST['update'])){
   
   $playlist_updated = update_playlist($con,$_REQUEST); 
    
 }elseif(isset($_REQUEST['clear'])){
    
    $playlist_clear = clear_playlist($con,$_REQUEST);
    
 }
?>

<form action="" method="POST">
    <select name="band_id">
        <?php $band = fetch_bands($con);
            foreach($band as $element){
                echo "<option value='" . $element['bandId'] . "'";
                if($element['bandId'] == $_REQUEST['band_id']){
                    echo " selected = 'selected'";
                }
                echo ">" . $element['bandName'] . "</option>";
            } ?>
    </select>
    <select name="event_id">
        <?php $event = fetch_events($con);
            foreach($event as $event_element){
                echo "<option value='" . $event_element['eventId'] . "'";
                if($event_element['eventId'] == $_REQUEST['event_id']){
                    echo " selected = 'selected'";
                }
                echo ">" . $event_element['eventName'] . "</option>";
            } ?>
    </select>
    <input type="submit" name="submit" value="GO">
</form>
<br>
    
    <?php if(isset($_REQUEST['event_id'])){
       $event_detail = fetch_event_details($con,$_REQUEST['event_id']);
        echo "<span class='pseudo-h2'>Playlist For " . $event_detail[0]['eventName'] . " - " . $event_detail[0]['eventDate'] . "</span> - <a href='/band/tools/export.php?eid=" . $_REQUEST['event_id'] . "'>Export Playlist</a><br><br>";
        echo "<span class='event_notes'>" . $event_detail[0]['eventNotes'] . "</span>&nbsp;|&nbsp;";
    }?>

<?php include_once('template/nav.php'); ?>
    <hr>
    <br>
        <span class="pseudo-link" id="add-song-toggle">Add A New Song</span>
        <div id="add-song">
        <h2>Add A New Song</h2><br>
        
<table class='form'>
<form method="POST" action="">
    <tr>
    <td>Title</td><td><input type="text" name="songTitle" /></td>
    </tr><tr>
    <td>Notes</td><td><textarea name="songNotes"></textarea></td>
    </tr><tr>
    <td>Book</td><td><input type="text" name="bookNumber" /></td>
    </tr><tr>
    <td>Page</td><td><input type="text" name="pageNumber" /></td>
    </tr><tr>
    <td>Year</td><td><input type="text" name="recordingYear" /></td>
    </tr><tr>
    <td>Time</td><td><input type="text" name="performanceTime" /></td>
    </tr><tr>
    <td>Time Signature</td><td><input type="text" name="timeSignature" /></td>
    </tr><tr>
    <td>BPM</td><td><input type="text" name="beatsPerMinute" /></td>
    </tr><tr>
    <td>Vocal</td><td><input type="text" name="vocal" /></td>
    </tr><tr>
    <td>Genre</td><td><input type="text" name="genreId" /></td>
    </tr><tr>
    <td>Band</td><td><input type="text" name="bandId" /></td>
    </tr><tr>
    <td>Audio Location</td><td><input type="text" name="audioLocation" /></td>
    </tr><tr>
    <td colspan="2"><input type="submit" name="submit" value="submit" /></td>
    </tr>
</form>
</table>
    <br>
    <hr>
        </div>
    <br>
        <h2>Library</h2>
        <form method="POST" action="" name="playlist_select">
<table class="list">
    <tr class="list">
    <th class="list">Song ID</th>
    <th class="list">Title</th>
    <th class="list">Author</th>
    <th class="list">Arranger</th>
    <th class="list">Notes</th>
    <th class="list">Book</th>
    <th class="list">Page Number</th>
    <th class="list">Year Published</th>
    <th class="list">Play Time</th>
    <th class="list">Time Sig</th>
    <th class="list">BPM</th>
    <th class="list">Vocals</th>
    <th class="list">Genre ID</th>
    <th class="list">Band ID</th>
    <th class="list">Edit</th>
    <?php
    if(isset($_REQUEST['event_id'])){ ?>
        <th class="list">Select</th>
    <?php } ?>
    </tr>
        <?php
            for($i=0;$i<sizeof($song);$i++){
                echo "<tr class='list'>";
                echo "<td class='list'>" . $song[$i]['songId'] . "</td>";
                echo "<td class='list'>" . $song[$i]['title'] . "</td>";
                echo "<td class='list'>";
                    $auth = "";
                    $author = fetch_context_person($con,'author',$song[$i]['songId']);
                    foreach($author as $a){
            
                        $auth .= $a['personName'] . ", ";
                    }
                    echo rtrim($auth,", ");
                echo "</td>";
                echo "<td class='list'>";
                    $arr = "";
                    $arranger = fetch_context_person($con,'arranger',$song[$i]['songId']);
                    foreach($arranger as $ar){
            
                        $arr .= $ar['personName'] . ", ";
                    }
                    echo rtrim($arr,", ");
                echo "</td>";
                echo "<td class='list'>" . $song[$i]['songNotes'] . "</td>";
                echo "<td class='list'>" . $song[$i]['bookNumber'] . "</td>";
                echo "<td class='list'>" . $song[$i]['pageNumber'] . "</td>";
                echo "<td class='list'>" . $song[$i]['recordingYear'] . "</td>";
                echo "<td class='list'>" . $song[$i]['performanceTime'] . "</td>";
                echo "<td class='list'>" . $song[$i]['timeSignature'] . "</td>";
                echo "<td class='list'>" . $song[$i]['beatsPerMinute'] . "</td>";
                echo "<td class='list'>" . $song[$i]['vocal'] . "</td>";
                echo "<td class='list'>" . $song[$i]['genreId'] . "</td>";
                echo "<td class='list'>" . $song[$i]['songId'] . "</td>";
                echo "<td class='list'><a href='editSong.php?sid=" . $song[$i]['songId'] . "'>EDIT SONG</a></td>";
                
                if(isset($_REQUEST['event_id'])){
                    echo "<input type='hidden' name='event_id' value='" . $_REQUEST['event_id'] . "'>";
                    echo "<td><input type='checkbox' name='songselect[]' value='" . $song[$i]['songId'] . "'";
                
                    $checked = fetch_playlist_songs($con, $_REQUEST['event_id'], $song[$i]['songId']);
            
                    if($checked==1){
                        echo ' checked="checked"';
                    }
                    echo "'></td>";
                }
                echo "</tr>";
            }
        ?>
    <?php if(isset($_REQUEST['event_id'])){ ?>
    <tr>
        <td colspan=15 style="text-align:right">
            <input class="button" type="submit" name="clear" value="CLEAR">&nbsp;
            <input class="button" type="submit" name="update" value="UPDATE PLAYLIST">
        </td>
    </tr>
    <?php } ?>
</table>
        </form>
<br><br>
<?php include_once(footer.php); ?>
<?php mysqli_close($con); ?>
<?php/*
include_once('configs/global.php');
include_once('library/functions.php');  

if(!isset($_SESSION['user']['valid'])){
    header('Location: login.php');
exit;
}
/*form processing for new event
if(isset($_REQUEST['songTitle']) && isset($_REQUEST['submit'])){

    add_song($con,$_REQUEST);

}
/*end new event form processing


include_once('header.php');

include_once('template/nav.php');

?>
    <hr>
    <br>
        <h2>Add A New Song</h2>
<table class='form'>
<form method="POST" action="">
    <tr>
    <td>Title</td><td><input type="text" name="songTitle" /></td>
    </tr><tr>
    <td>Notes</td><td><textarea name="songNotes"></textarea></td>
    </tr><tr>
    <td>Book</td><td><input type="text" name="bookNumber" /></td>
    </tr><tr>
    <td>Page</td><td><input type="text" name="pageNumber" /></td>
    </tr><tr>
    <td>Year</td><td><input type="text" name="recordingYear" /></td>
    </tr><tr>
    <td>Time</td><td><input type="text" name="performanceTime" /></td>
    </tr><tr>
    <td>Time Signature</td><td><input type="text" name="timeSignature" /></td>
    </tr><tr>
    <td>BPM</td><td><input type="text" name="beatsPerMinute" /></td>
    </tr><tr>
    <td>Vocal</td><td><input type="text" name="vocal" /></td>
    </tr><tr>
    <td>Genre</td><td><input type="text" name="genreId" /></td>
    </tr><tr>
    <td>Band</td><td><input type="text" name="bandId" /></td>
    </tr><tr>
    <td>Audio Location</td><td><input type="text" name="audioLocation" /></td>
    </tr><tr>
    <td colspan="2"><input type="submit" name="submit" value="submit" /></td>
    </tr>
</form>
</table>
    <br>
    <hr>
    <br>
        <h2>Library</h2>
<table class="list">
    <tr>
        <th>Song ID</th>
        <th>Title</th>
        <th>Notes</th>
        <th>Book Number</th>
        <th>Page Number</th>
        <th>Year</th>
        <th>Play Time</th>
        <th>Time Signature</th>
        <th>Beats Per Minute</th>
        <th>Vocals</th>
        <th>Genre</th>
        <th>Band</th>
        <th>Audio</th>
    </tr>
<?php $songs = list_library($con);
    for($i=0;$i<sizeof($songs);$i++){ ?>
    <tr>
        <td><?php echo $songs[$i]['songId']; ?></td>
        <td><?php echo $songs[$i]['title']; ?></td>
        <td><?php echo $songs[$i]['songNotes']; ?></td>
        <td><?php echo $songs[$i]['bookNumber']; ?></td>
        <td><?php echo $songs[$i]['pageNumber']; ?></td>
        <td><?php echo $songs[$i]['recordingYear']; ?></td>
        <td><?php echo $songs[$i]['performanceTime']; ?></td>
        <td><?php echo $songs[$i]['timeSignature']; ?></td>
        <td><?php echo $songs[$i]['beatsPerMinute']; ?></td>
        <td><?php echo $songs[$i]['vocal']; ?></td>
        <td><?php echo $songs[$i]['genreId']; ?></td>
        <td><?php echo $songs[$i]['bandId']; ?></td>
        <td><?php echo $songs[$i]['audioLocation']; ?></td>

    </tr>
    
<?php } ?>

<?php include_once(footer.php); ?>
<?php mysqli_close($con); */?>