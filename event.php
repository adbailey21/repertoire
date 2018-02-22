<?php
include_once('configs/global.php');
include_once('library/functions.php');  

if(!isset($_SESSION['user']['valid'])){
    header('Location: login.php');
exit;
}
/*form processing for new event*/
if(isset($_REQUEST['eventName']) && isset($_REQUEST['submit'])){

    add_event($con,$_REQUEST);

}
/*end new event form processing*/


include_once('header.php');

include_once('template/nav.php');

?>
    <hr>
    <br>

<form method="POST" action="">
    Name <input type="text" name="eventName" /><br>
    Date <input type="text" name="eventDate" /> (ex. 2018-02-07)<br>
    Notes <textarea name="eventNotes"></textarea><br>
    <input type="submit" name="submit" value="submit">
</form>

    <br>
    <hr>
    <br>
<table>
    <tr>
        <th>Event ID</th>
        <th>Name</th>
        <th>Date</th>
        <th>Notes</th>
        <th></th>
    </tr>
<?php $events = list_events($con);
    for($i=0;$i<sizeof($events);$i++){ ?>
    <tr>
        <td><?php echo $events[$i]['eventId']; ?></td>
        <td><?php echo $events[$i]['eventName']; ?></td>
        <td><?php echo $events[$i]['eventDate']; ?></td>
        <td><?php echo $events[$i]['eventNotes']; ?></td>
        <td><form method="POST" action="" name="event-<?php echo $events[$i]['eventId']; ?>"></form><input type="button" name="Edit" value="edit"><input type="hidden" name="eventId" value="<?php echo $events[$i]['eventId']; ?>"></td>
    </tr>
    
<?php } ?>

<?php include_once(footer.php); ?>
<?php mysqli_close($con); ?>