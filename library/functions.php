<?php

function fetch_bands($con){

        $show_all_bands = "SELECT * FROM `band`";
    
        $result = mysqli_query($con,$show_all_bands);

        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                $band[] = $row;
            }
            
        }
        
        return $band;
    }
    
    function fetch_events($con){

        $show_all_events = "SELECT * FROM `event`";
    
        $result = mysqli_query($con,$show_all_events);

        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                $event[] = $row;
            }
            
        }
        
        return $event;
    }
    
    function fetch_event_details($con,$event_id){

        $show_event = "SELECT * FROM `event` WHERE eventId = '" . $event_id . "'";

        $result = mysqli_query($con,$show_event);

        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                $event[] = $row;
            }
            
        }
 
        return $event;
    }
    
    //var_dump($song);
    function fetch_library($con,$band_id){
     
        if(is_numeric($band_id)){
            $bandId = $band_id;
        }else{
            $bandId = $_CONFIGS['default_band_id'];
        }

        $show_all_songs = "SELECT * FROM `song` WHERE `bandId` = '" . $bandId . "' ORDER BY `songId` ASC";
    
        $result = mysqli_query($con,$show_all_songs);

        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                $piece[] = $row;
            }
            
        } else {
        
            $piece[]['title'] = "No Results Found, Please select a band with a library to continue.";
        
        }
        
        return $piece;
    }
    
    function fetch_playlist_songs($con,$event_id,$song_id){
        
        if(isset($event_id) && isset($song_id)){

            $show_playlist = "SELECT * FROM `playlist` WHERE `eventId` = " . $event_id . " AND `songId` = " . $song_id;
 
            $result = mysqli_query($con,$show_playlist);

            if (mysqli_num_rows($result) > 0) {
            
                return 1;
            
            }else{ 
            
                return 0;
            
            }
            
        }else{
            
            return false;
        
        }
    
    }
    
    function fetch_person($con,$name){
        
        if(isset($name)){

            $fetch_person = "SELECT * FROM person WHERE `personName` = '" . $name . "'";

            $result = mysqli_query($con,$fetch_person);

            while($row = mysqli_fetch_assoc($result)) {
                
                $person[] = $row;
                
            }
            
            return $person;
            
        }else{
            
            return false;
        
        }
        
    }
    
    function fetch_context_person($con,$context,$song_id){
        
        if(isset($song_id)){

            $get_person = "SELECT * FROM person p, personMap pm WHERE pm.personId = p.personId AND pm.context = '" . $context . "' AND pm.contentId = " . $song_id;

            $result = mysqli_query($con,$get_person);

            while($row = mysqli_fetch_assoc($result)) {
                
                $context_person[] = $row;
                
            }
            
            return $context_person;
            
        }else{
            
            return false;
        
        }
        
    }
    
    function add_person($con,$request){
        
        $name = $request['personName'];
        $label = $request['personLabel'];
        $notes = $request['personNotes'];
        
        if(fetch_person($con,$name) != false){
        
                echo "PERSON ALREADY EXISTS. WHY? JUST WHY?";
        
                return false;
        
        }else{
                
                $insert_new_person = "INSERT INTO `person` SET `personName` = '" . mysqli_real_escape_string($con,$name) . "', `personLabel` = '" . mysqli_real_escape_string($con,$label) . "', `personNotes` = '" . mysqli_real_escape_string($con,$notes) . "'";
                
                $result = mysqli_query($con,$insert_new_person);
                
                return $name;
        
        }
        
    }
    
    function fetch_event($con,$name,$date){
        
        if(isset($name) && isset($date)){

            $fetch_event = "SELECT * FROM `event` WHERE `eventName` = '" . $name . "' AND `eventDate` = '" . $date . "'";
            
            $result = mysqli_query($con,$fetch_event);

            while($row = mysqli_fetch_assoc($result)) {
                
                $event[] = $row;
                
            }
            
            return $event;
            
        }else{
            
            return false;
        
        }
        
    }
    
    function add_event($con,$request){
        
        $name = $request['eventName'];
        $date = $request['eventDate'];
        $notes = $request['eventNotes'];
        
        if(fetch_event($con,$name,$date) != false){
        
                echo "EVENT ALREADY EXISTS. REALLY? ARE YOU EVEN TRYING?";
        
                return false;
        
        }else{
                
                $insert_new_event = "INSERT INTO `event` SET `eventName` = '" . mysqli_real_escape_string($con,$name) . "', `eventDate` = '" . mysqli_real_escape_string($con,$date) . "', `eventNotes` = '" . mysqli_real_escape_string($con,$notes) . "'";
                
                $result = mysqli_query($con,$insert_new_event);
                
                return $result;
        
        }
        
    }
    
    function list_events($con){
        
        $fetch_events = "SELECT * FROM `event`";
            
            $result = mysqli_query($con,$fetch_events);

            while($row = mysqli_fetch_assoc($result)) {
                
                $events[] = $row;
                
            }
            
            return $events;
    }
    
    function list_people($con){
        
        $fetch_people = "SELECT * FROM `person`";
            
            $result = mysqli_query($con,$fetch_people);

            while($row = mysqli_fetch_assoc($result)) {
                
                $people[] = $row;
                
            }
            
            return $people;
    }
    
    function list_library($con,$song_title=""){
        
        //if(isset($song_title)){
                
        //}else{

            $fetch_songs = "SELECT * FROM `song`";
            
            $result = mysqli_query($con,$fetch_songs);

            while($row = mysqli_fetch_assoc($result)) {
                
                $songs[] = $row;
                
            }

            return $songs;
        //}
    }
    
    function update_playlist($con,$request){
        
        if(isset($request['event_id']) && is_numeric($request['event_id'])){

                $delete_playlist = "DELETE FROM `playlist` WHERE `eventId` = '" . mysqli_real_escape_string($con,$request['event_id']) . "'";
                $result = mysqli_query($con,$delete_playlist);
                
                foreach($request['songselect'] as $song){
                        
                        $insert_new_song = "INSERT INTO `playlist` SET `eventId` = '" . mysqli_real_escape_string($con,$request['event_id']) . "', `songId` = '" . mysqli_real_escape_string($con,$song) . "'";
                        $result = mysqli_query($con,$insert_new_song);
                        
                }
        }
        
        return true;
        
    }
    
    /*function check_playlist($con,$song_id,$event_id){
        echo "Variables: " . $song_id . ":" . $event_id . "<br>";
        $inplaylist = "SELECT * FROM `playlist` WHERE `eventId` = " . $event_id . " AND `songId` = " . $song_id . "";
            echo $inplaylist;
            $result = mysqli_query($con,$inplaylist);

            if(mysqli_num_rows($result) >= 1) {
                
                //echo "TRUE - NUM ROWS " . mysqli_num_rows($result) . "<br>";
                return true;
                
            }else{
                
                //echo "FALSE - NUM ROWS " . mysqli_num_rows($result) . "<br>";
                return false;
                
            }
        
    }*/
    
    function fetch_song_details($con,$song_id){

        $show_song = "SELECT * FROM `song` WHERE songId = '" . $song_id . "'";

        $result = mysqli_query($con,$show_song);

        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                $song[] = $row;
            }
            
        }
 
        return $song;
    }
    
    function update_song($con,$request){

        if(isset($request['songId']) && isset($request['songTitle'])){
                
                $update_song="UPDATE `song` SET 
                `title`='" . mysqli_real_escape_string($con,$request['songTitle']) . "',
                `songNotes`='" . mysqli_real_escape_string($con,$request['songNotes']) . "',
                `bookNumber`='" . mysqli_real_escape_string($con,$request['bookNumber']) . "',
                `pageNumber`='" . mysqli_real_escape_string($con,$request['pageNumber']) . "',
                `recordingYear`='" . mysqli_real_escape_string($con,$request['recordingYear']) . "',
                `performanceTime`='" . mysqli_real_escape_string($con,$request['performanceTime']) . "',
                `timeSignature`='" . mysqli_real_escape_string($con,$request['timeSignature']) . "',
                `beatsPerMinute`='" . mysqli_real_escape_string($con,$request['beatsPerMinute']) . "',
                `vocal`='" . mysqli_real_escape_string($con,$request['vocal']) . "',
                `genreId`='" . mysqli_real_escape_string($con,$request['genreId']) . "',
                `bandId`='" . mysqli_real_escape_string($con,$request['bandId']) . "'
                `audioLocation`='" . mysqli_real_escape_string($con,$request['audioLocation']) . "' WHERE `songId`= '" . mysqli_real_escape_string($con,$request['songId']) . "'";
                
                //echo $update_song;
                
                $result = mysqli_query($con,$update_song);
                
        }
        
        //return true;
        
    }
    
    function add_song($con,$request){

        if(isset($request['songTitle'])){
                
                $add_song="INSERT INTO `song` SET 
                `title`='" . mysqli_real_escape_string($con,$request['songTitle']) . "',
                `songNotes`='" . mysqli_real_escape_string($con,$request['songNotes']) . "',
                `bookNumber`='" . mysqli_real_escape_string($con,$request['bookNumber']) . "',
                `pageNumber`='" . mysqli_real_escape_string($con,$request['pageNumber']) . "',
                `recordingYear`='" . mysqli_real_escape_string($con,$request['recordingYear']) . "',
                `performanceTime`='" . mysqli_real_escape_string($con,$request['performanceTime']) . "',
                `timeSignature`='" . mysqli_real_escape_string($con,$request['timeSignature']) . "',
                `beatsPerMinute`='" . mysqli_real_escape_string($con,$request['beatsPerMinute']) . "',
                `vocal`='" . mysqli_real_escape_string($con,$request['vocal']) . "',
                `genreId`='" . mysqli_real_escape_string($con,$request['genreId']) . "',
                `bandId`='" . mysqli_real_escape_string($con,$request['bandId']) . "',
                `audioLocation`='" . mysqli_real_escape_string($con,$request['audioLocation']) . "'";
                
                //echo $update_song;
                
                $result = mysqli_query($con,$add_song);
                
        }
        
        //return true;
        
    }
    
    function search_by_songId($con,$request){
        if(is_numeric($request['key'])){
                
                $song_details[] = fetch_song_details($con,$request['key']);
                
                $song_details[0]['author'] = fetch_context_person($con,'author',$request['key']);
                
                $song_details[0]['arranger'] = fetch_context_person($con,'arranger',$request['key']);
                
                return $song_details;
        }
           
    }
    
    function search_by_songTitle($con,$request){
        
        $findSongId = "SELECT songId FROM `song` WHERE `title` LIKE '%" . mysqli_real_escape_string($con,$request['key']) . "%'";
            
        $result = mysqli_query($con,$findSongId);

        while($row = mysqli_fetch_assoc($result)) {
                
                $ids[] = $row;
                
        }
        
        for($i=0;$i<sizeof($ids);$i++){
                
                if(is_numeric($ids[$i]['songId'])){
                
                        $song_details[$i] = fetch_song_details($con,$ids[$i]['songId']);
                
                        $song_details[$i]['author'] = fetch_context_person($con,'author',$ids[$i]['songId']);
                
                        $song_details[$i]['arranger'] = fetch_context_person($con,'arranger',$ids[$i]['songId']);
                
                }
                
        }
                
        return $song_details;
           
    }