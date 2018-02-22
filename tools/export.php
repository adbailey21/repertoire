<?php
include_once('../configs/global.php');
include_once('../library/functions.php');  

if(!isset($_SESSION['user']['valid'])){
    header('Location: login.php');
exit;
}
if(isset($_REQUEST['eid']) && is_numeric($_REQUEST['eid'])){
    $event = fetch_event_details($con,$_REQUEST['eid']);

    // output headers so that the file is downloaded rather than displayed
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=playlist.csv');
    
    // create a file pointer connected to the output stream
    $output = fopen('php://output', 'w');
    
    // output the column headings
    fputcsv($output, array('Number', 'Page', 'Book', 'Title', 'Play Time', 'Vocals', 'Notes', 'Genre'));
    
    // fetch the data
    $get_playlist = "SELECT p.order,s.pageNumber,s.bookNumber,s.title,s.performanceTime,s.vocal,s.songNotes,g.genreLabel FROM song s, genre g, event e, playlist p WHERE p.songId = s.songId AND g.genreId = s.genreId AND p.eventId = e.eventId AND e.eventId = '" . mysqli_real_escape_string($con,$_REQUEST['eid']) . "' ORDER BY p.order ASC";

    $result = mysqli_query($con,$get_playlist);

        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {

                fputcsv($output, $row);
            }
            
        }
 
        return $event;
    
}
?>