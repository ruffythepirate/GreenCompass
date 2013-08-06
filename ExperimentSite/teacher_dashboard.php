<?php
require_once("Includes/session.php");
require_role('teacher');

require_once("Includes/header.php");
?>
<div class="section">
    <h1>Workshops</h1>
    <?php include("Partials/partial_teacher_workshops.php");?>
</div>
</div>
<?php
require_once("Includes/footer.php");
