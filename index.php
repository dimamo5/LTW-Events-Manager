
<?php
include_once('header.php');
include_once('utils.php');

$invitedEvents = getEventsInvited();
$adminEvents = getEvensAdmin();

if(count($adminEvents) > 0){
    ?>
    <div class="spacer">
    <h1> Events that I manage: </h1>
    </div>
    
    <?php
    foreach($adminEvents as $adminEvent){
        getEventCard($adminEvent,false);
    }
}
if(count($invitedEvents) > 0){
    ?>
    <div class="spacer">
    <h1> Invited to: </h1>
    </div>
    <?php
    foreach($invitedEvents as $invitedEvent){
        getEventCard($invitedEvent,true);
    }
}
require_once('footer.php');
?>

