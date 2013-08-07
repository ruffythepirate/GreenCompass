<?php
    global $workshopTranslation;
?>

<h2>Background</h2>
<div class="background">
    <?php print "$workshopTranslation->background" ?>
</div>
<h2>Goals</h2>
<?php 
 //We divide the text for goals into a list.
 $goalList = explode("\n", $workshopTranslation->goals);
 print "<ul class=\"goals\">";
 foreach($goalList as $goal)
 {
     if(! ctype_space($goal)|| $goal == '')
     {
        print "<li>$goal</li>";
     }
 }
 print "</ul>"; 
 ?>
<h2>Timeplan</h2>
<?php 
 $timeLineList = explode("\n", $workshopTranslation->timeline);
 print "<ul class=\"timeplan\">";
 foreach($timeLineList as $timeItem)
 {
     if(! ctype_space($timeItem)|| $timeItem == '')
     {
        print "<li>$timeItem</li>";
     }
 }
 print "</ul>"; 
 ?>
<h2>Expected Information</h2>
<?php 
 $expectedInfos = explode("\n", $workshopTranslation->expectedresults);
 print "<ul class=\"expectedresults\">";
 foreach($expectedInfos as $info)
 {
     if(! ctype_space($info)|| $info == '')
     {
        print "<li>$info</li>";
     }
 }
 print "</ul>"; 
 ?>
