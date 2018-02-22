<!DOCTYPE html>
<html>
<head>
<title>Band Library - <?php echo $_CONFIGS['site_title'];?></title>
<style type="text/css">
  
body {
  font-family:sans-serif;
}

.list {
  border: 1px solid #dddddd;
  border-collapse: collapse;
  border-spacing: 0px;
}
td.list {
  border: 1px solid #dddddd;
  border-collapse: collapse;
  border-spacing: 0px;
  text-align: center;
}
.list tr:hover {
  background-color: #ccf3ff;
}
.pseudo-link {
  cursor: pointer;
  cursor: hand;
}
#add-song{
  display: none;
}
#add-person{
  display: none;
}
#add-event{
  display: none;
}
a{
  text-decoration: none;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $("#add-song-toggle").click(function(){
        $('#add-song').toggle();
        //$('#add-song-toggle').html("Close New Song Addition");
    });
    $("#add-event-toggle").click(function(){
        $('#add-event').toggle();
    });
    $("#add-person-toggle").click(function(){
        $('#add-person').toggle();
    });
  });
</script>

</head>

<body>
  
  <div id='search_bar'>
    
    <form method="POST" action="searchResults.php" name="search">
      SEARCH:&nbsp;
      <input type="text" name="key" value="<?php if($_REQUEST['key']){ echo $_REQUEST['key']; } ?>"/>
      <input type="submit" name="submit" value="SEARCH"/>
    </form>
    
  </div>