<?php
$user = New User();
$announcement = $user->single_user($_SESSION['ACCOUNT_ID']);

?> 
<h1 style="color: black; margin-left: 320px;">Announcement</h1>
<div class="rows">                            
            <img title="profile image" width="80%" height="80%" style=" margin-left: 100px;" src="<?php echo web_root.'admin/announcement/'.$announcement ->	announce ?>">  
                    
</div>