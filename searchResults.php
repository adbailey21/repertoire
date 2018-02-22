<?php
include_once('configs/global.php');
include_once('library/functions.php');  

if(!isset($_SESSION['user']['valid'])){
    header('Location: login.php');
exit;
}
/*form processing for new event*/
if(isset($_REQUEST['key'])){

    if(is_numeric($_REQUEST['key'])){
        $results = search_by_songId($con,$_REQUEST);
    }else{
        $results = search_by_songTitle($con,$_REQUEST);
    }

}
/*end new event form processing*/


include_once('header.php');

include_once('template/nav.php');

?>
    <br>
    <hr>
    <br>
        <h2>Song Details</h2>
<table class="list">
    <tr class="list">
        <th class="list">Song ID</th>
        <th class="list">Title</th>
        <th class="list">Author</th>
        <th class="list">Arranger</th>
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
<?php for($i=0;$i<sizeof($results);$i++){ ?>
    <tr class="list">
        <td class="list"><a href="editSong.php?sid=<?php echo $results[$i][0]['songId']; ?>"><?php echo $results[$i][0]['songId']; ?></a></td>
        <td class="list"><a href="editSong.php?sid=<?php echo $results[$i][0]['songId']; ?>"><?php echo $results[$i][0]['title']; ?></a></td>
        <td class="list"><a href="editSong.php?sid=<?php echo $results[$i][0]['songId']; ?>"><?php echo $results[$i][0]['author'][0]['personLabel']; ?></a></td>
        <td class="list"><a href="editSong.php?sid=<?php echo $results[$i][0]['songId']; ?>"><?php echo $results[$i][0]['arranger'][0]['personLabel']; ?></a></td>
        <td class="list"><a href="editSong.php?sid=<?php echo $results[$i][0]['songId']; ?>"><?php echo $results[$i][0]['songNotes']; ?></a></td>
        <td class="list"><a href="editSong.php?sid=<?php echo $results[$i][0]['songId']; ?>"><?php echo $results[$i][0]['bookNumber']; ?></a></td>
        <td class="list"><a href="editSong.php?sid=<?php echo $results[$i][0]['songId']; ?>"><?php echo $results[$i][0]['pageNumber']; ?></a></td>
        <td class="list"><a href="editSong.php?sid=<?php echo $results[$i][0]['songId']; ?>"><?php echo $results[$i][0]['recordingYear']; ?></a></td>
        <td class="list"><a href="editSong.php?sid=<?php echo $results[$i][0]['songId']; ?>"><?php echo $results[$i][0]['performanceTime']; ?></a></td>
        <td class="list"><a href="editSong.php?sid=<?php echo $results[$i][0]['songId']; ?>"><?php echo $results[$i][0]['timeSignature']; ?></a></td>
        <td class="list"><a href="editSong.php?sid=<?php echo $results[$i][0]['songId']; ?>"><?php echo $results[$i][0]['beatsPerMinute']; ?></a></td>
        <td class="list"><a href="editSong.php?sid=<?php echo $results[$i][0]['songId']; ?>"><?php echo $results[$i][0]['vocal']; ?></a></td>
        <td class="list"><a href="editSong.php?sid=<?php echo $results[$i][0]['songId']; ?>"><?php echo $results[$i][0]['genreId']; ?></a></td>
        <td class="list"><a href="editSong.php?sid=<?php echo $results[$i][0]['songId']; ?>"><?php echo $results[$i][0]['bandId']; ?></a></td>
        <td class="list"><a href="editSong.php?sid=<?php echo $results[$i][0]['songId']; ?>"><?php echo $results[$i][0]['audioLocation']; ?></a></td>
    </tr></a>
    
<?php } ?>

<?php include_once(footer.php); ?>
<?php mysqli_close($con); ?>