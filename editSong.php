<?php
include_once('configs/global.php');
include_once('library/functions.php');  

if(!isset($_SESSION['user']['valid'])){
    header('Location: login.php');
exit;
}

    
 include_once('header.php');
 
 if(isset($_REQUEST['update'])){
   
   //$playlist_updated = update_playlist($con,$_REQUEST); 
    
 }elseif(isset($_REQUEST['clear'])){
    
    //$playlist_clear = clear_playlist($con,$_REQUEST);
    
 }
?>

<?php include_once('template/nav.php'); ?>
    <hr>
        <?php
        if(isset($_REQUEST['sid']) && $_REQUEST['update']=='UPDATE SONG'){

            update_song($con,$_REQUEST);
        }
        if(isset($_REQUEST['sid']) && isset($_REQUEST['sid'])){
            $song = fetch_song_details($con,$_REQUEST['sid']);
        }else{
            echo "Nothin' to see here. No SID was provided.";
        }
    
        ?>
    <br>
        <form method="POST" action="" name="update_song">
<table>
        <?php
            for($i=0;$i<sizeof($song);$i++){
                echo "<tr>";
                echo "<td>Song ID </td><td>" . $song[$i]['songId'] . "<input type='hidden' name='songId' value='" . $song[$i]['songId'] . "'></td>";
                echo "</tr><tr>";
                echo "<td>Title </td><td><input type='text' name='songTitle' value='" . $song[$i]['title'] . "'></td>";
                echo "</tr><tr>";
                echo "<td>Author </td><td>";
                    $auth = "";
                    $author = fetch_context_person($con,'author',$song[$i]['songId']);
                    foreach($author as $a){
                        
                        $auth_id .= $a['personId'] . ", ";
                        $auth .= $a['personName'] . ", ";
                    }
                    echo rtrim($auth,", ");
                    echo " - ";
                    echo rtrim($auth_id,", ");
                echo "</td>";
                echo "</tr><tr>";
                echo "<td>Arranger </td><td>";
                    $arr = "";
                    $arranger = fetch_context_person($con,'arranger',$song[$i]['songId']);
                    foreach($arranger as $ar){
                        
                        $arr_id .= $ar['personId'] . ", ";
                        $arr .= $ar['personName'] . ", ";
                    }
                    echo rtrim($arr,", ");
                    echo " - ";
                    echo rtrim($arr_id,", ");
                echo "</td>";
                echo "</tr><tr>";
                echo "<td>Notes </td><td><input type='text' name='songNotes' value='" . $song[$i]['songNotes'] . "'></td>";
                echo "</tr><tr>";
                echo "<td>Book Number </td><td><input type='text' name='bookNumber' value='" . $song[$i]['bookNumber'] . "'></td>";
                echo "</tr><tr>";
                echo "<td>Page Number </td><td><input type='text' name='pageNumber' value='" . $song[$i]['pageNumber'] . "'></td>";
                echo "</tr><tr>";
                echo "<td>Band ID </td><td><input type='text' name='bandId' value='" . $song[$i]['bandId'] . "'></td>";
                echo "</tr><tr>";
                echo "<td>Recording Year </td><td><input type='text' name='recordingYear' value='" . $song[$i]['recordingYear'] . "'></td>";
                echo "</tr><tr>";
                echo "<td>Performance Time </td><td><input type='text' name='performanceTime' value='" . $song[$i]['performanceTime'] . "'></td>";
                echo "</tr><tr>";
                echo "<td>Time Signature </td><td><input type='text' name='timeSignature' value='" . $song[$i]['timeSignature'] . "'></td>";
                echo "</tr><tr>";
                echo "<td>Beats Per Minute </td><td><input type='text' name='beatsPerMinute' value='" . $song[$i]['beatsPerMinute'] . "'></td>";
                echo "</tr><tr>";
                echo "<td>Vocals </td><td><select name='vocal'>
                        <option value='none'";
                            if($song[$i]['vocal'] == 'none'){ echo " selected='selected'"; }
                            echo ">None</option>";
                        echo "<option value='male'";
                            if($song[$i]['vocal'] == 'male'){ echo " selected='selected'"; }
                            echo ">Male</option>";
                        echo "<option value='female'";
                            if($song[$i]['vocal'] == 'female'){ echo " selected='selected'"; }
                            echo ">Female</option>";
                        echo "<option value='both'";
                            if($song[$i]['vocal'] == 'both'){ echo " selected='selected'"; }
                            echo ">Both</option>";
                        echo "</select></td>";
                echo "</tr><tr>";
                echo "<td>Genre </td><td><input type='text' name='genreId' value='" . $song[$i]['genreId'] . "'></td>";
                echo "</tr>";
                echo "<td>Audio Location </td><td><input type='text' name='genreId' value='" . $song[$i]['audioLocation'] . "'></td>";
                echo "</tr>";
                
            }
        ?>
    <?php if(isset($_REQUEST['sid'])){ ?>
    <tr>
        <td colspan=15 style="text-align:right">
            <input class="button" type="submit" name="clear" value="CLEAR">&nbsp;
            <input class="button" type="submit" name="update" value="UPDATE SONG">
        </td>
    </tr>
    <?php } ?>
</table>
        </form>
<br><br>
<?php include_once(footer.php); ?>
<?php mysqli_close($con); ?>