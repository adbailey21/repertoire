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


include_once('header.php');

include_once('template/nav.php');

?>
    <hr>
    <br>
        <h2>Add A New Song</h2><span id="add_song_toggle" class="pseudo_link">Expand</a>
<div id="add_song">
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
<table class="list">
    <tr class="list">
        <th class="list">Song ID</th>
        <th class="list">Title</th>
        <th class="list">Notes</th>
        <th class="list">Book Number</th>
        <th class="list">Page Number</th>
        <th class="list">Year</th>
        <th class="list">Play Time</th>
        <th class="list">Time Signature</th>
        <th class="list">Beats Per Minute</th>
        <th class="list">Vocals</th>
        <th class="list">Genre</th>
        <th class="list">Band</th>
        <th class="list">Audio</th>
    </tr>
<?php $songs = list_library($con);
    for($i=0;$i<sizeof($songs);$i++){ ?>
    <tr>
        <td class="list"><?php echo $songs[$i]['songId']; ?></td>
        <td class="list"><?php echo $songs[$i]['title']; ?></td>
        <td class="list"><?php echo $songs[$i]['songNotes']; ?></td>
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
<?php mysqli_close($con); ?>