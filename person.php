<?php
include_once('configs/global.php');
include_once('library/functions.php');  

if(!isset($_SESSION['user']['valid'])){
    header('Location: login.php');
exit;
}
/*form processing for new person*/
if(isset($_REQUEST['personName']) && isset($_REQUEST['submit'])){
    //var_dump($_REQUEST);
    add_person($con,$_REQUEST);
}
/*end new person form processing*/

include_once('header.php');
include_once('template/nav.php');

?>
    <hr>
    <br>
        <h2>Add A New Person</h2>
        <span id="add-person-toggle" class="pseudo-link">Expand</span>
<div id="add-person">

<form method="POST" action="">
<table class="form">
    <tr>
        <td>Name </td><td><input type="text" name="personName" /></td>
    </tr>
    <tr>
        <td>Label </td><td><input type="text" name="personLabel" /></td>
    </tr>
    <tr>
        <td>Notes </td><td><textarea name="personNotes"></textarea></td>
    </tr>
    <tr>
        <td colspan="2"><input type="submit" name="submit" value="submit"></td>
    </tr>
</table>
</form>

    <br>
    <hr>
</div>
    <br>
<table class="list">
    <tr class="list">
        <th class="list">Person ID</th>
        <th class="list">Name</th>
        <th class="list">Notes</th>
    </tr>
<?php $people = list_people($con);
    for($i=0;$i<sizeof($people);$i++){ ?>
    <tr>
        <td><?php echo $people[$i]['personId']; ?></td>
        <td><?php echo $people[$i]['personLabel']; ?></td>
        <td><?php echo $people[$i]['personNotes']; ?></td>
    </tr>
    
<?php } ?>

<?php include_once(footer.php); ?>
<?php mysqli_close($con); ?>