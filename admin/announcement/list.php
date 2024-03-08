<?php
 $user = New User();
$announcement = $user->single_user($_SESSION['ACCOUNT_ID']);

?> 

<div class="divpic"> 

<h1> Announcement</h1>


                            <a href="" data-target="#announce"  data-toggle="modal" > 
                           
                                <img title="profile image" width="900" height="900" src="<?php echo web_root.'admin/announcement/'.$announcement -> announce ?>">  
                            </a>
                          </div> 
           
                            <!-- Modal -->
                    <div class="modal fade" id="announce" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button class="close" data-dismiss="modal" type=
                                    "button">×</button>

                                    <h4 class="modal-title" id="myModalLabel">Upload Announcement</h4>
                                    <h4 class="modal-title" id="myModalLabel">Image Only</h4>
                                </div>

                                <form action="<?php echo web_root; ?>admin/announcement/controller.php?action=aphotos" enctype="multipart/form-data" method=
                                "post">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <div class="rows">
                                            <div class="col-md-12">
                                                <div class="rows">
                                              
                                                    <img title="profile image" width="500" height="500" src="<?php echo web_root.'admin/announcement/'.$announcement ->	announce ?>">  
                          
                                                </div>
                                            </div><br/>
                                                <div class="col-md-12">
                                                    <div class="rows">
                                                        <div class="col-md-8">

                                                            <input type="hidden" name="MIDNO" id="MIDNO" value="<?php echo $_SESSION['ACCOUNT_ID']; ?>">
                                                              <input name="MAX_FILE_SIZE" type=
                                                            "hidden" value="1000000"> <input id=
                                                            "photo" name="photo" type=
                                                            "file">
                                                        </div>

                                                        <div class="col-md-4"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-default" data-dismiss="modal" type=
                                        "button">Close</button> <button class="btn btn-primary"
                                        name="savephoto" type="submit">Upload Announcement</button>
                                    </div>
                                </form>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->

                    <p>Click below to change the Announcement</p>
    