<?php  
 if (!isset($_SESSION['IDNO'])){
      redirect("index.php");
     }


    $student = New Student();
    $res = $student->single_student($_SESSION['IDNO']);

    $course = New Course();
    $resCourse = $course->single_course($res->COURSE_ID);
	?>
    
  <style type="text/css">
  #img_profile{
    width: 100%;
    height:auto;
  }
    #img_profile >  a > img {
    width: 100%;
    height:auto;
}


  </style>
  		<div class="col-sm-3">
 
          <div class="panel">            
            <div id="img_profile" class="panel-body">
            <a href="" data-target="#myModal" data-toggle="modal" >
            <img title="profile image" class="img-hover"   src="<?php echo web_root. 'student/'.  $res->STUDPHOTO; ?>">
            </a>
             </div>
          <ul class="list-group  ">
               <li class="list-group-item text-right"><span class="pull-left"><strong>Real name</strong></span> <?php echo $res->FNAME .' '.$res->LNAME; ?> </li>
              <li class="list-group-item text-right"><span class="pull-left"><strong>Course</strong></span> <?php echo $resCourse->COURSE_NAME .'-'.$resCourse->COURSE_LEVEL; ?> </li>
               <li class="list-group-item text-right"><span class="pull-left"><strong>Status</strong></span> <?php echo $res->student_status; ?> </li>
               <li class="list-group-item text-right">
    <span class="pull-left"><strong>Tuition Status</strong></span> 
    <?php 
        if (!isset($res->enrollment_status) || empty($res->enrollment_status)) {
            echo '<span style="color: red;">Not Paid</span>';
        } else {
            if ($res->enrollment_status == 'Paid') {
                echo '<span style="color: green;">' . $res->enrollment_status . '</span>';
            } else {
                echo '<span style="color: red;">' . $res->enrollment_status . '</span>';
            }
        }
    ?> 
</li>
            
          </ul> 
                
        </div>
    </div>
         
        <!--/col-3-->
<div class="col-sm-9"> 

<div class="panel">            
  <div class="panel-body">
   <?php
       check_message();   
       ?>
  <ul class="nav nav-tabs" id="myTab">
    <li class="active"><a href="#home" data-toggle="tab">List of Subjects</a></li> 
    <li><a href="#grades" data-toggle="tab">Grades</a></li>
  
    <li><a href="#settings" data-toggle="tab">Update Account</a></li>
  </ul>
              
  <div class="tab-content">
    <div class="tab-pane active" id="home">
    <br/>
    <div class="col-md-12">
     <h3>Enrolled Subjects</h3> 
    </div>
      <div class="table-responsive" style="margin-top:5%;"> 
      <form action="controller.php?action=delete" Method="POST">  
			      <div class="table-responsive">			
				<table id="example" class="table table-striped table-bordered table-hover table-responsive" style="font-size:12px" cellspacing="0">
				
				  <thead>
				  	<tr>
				  	<th>#</th>
				  		 <th>
				  		  Subject</th>
				  		<th>Description</th> 
				  		<th>Unit</th>
					
				  		<th>Year Level</th>
				  		<th>Semester</th> 
				 
				  	</tr>	
				  </thead> 
				  <tbody>
				  	<?php  
				  	// `GRADE_ID`, `IDNO`, `SUBJ_ID`, `INST_ID`, `SYID`,
				  	//  `FIRST`, `SECOND`, `THIRD`, `FOURTH`, `AVE`, `DAY`, `G_TIME`, `ROOM`, `REMARKS`, `COMMENT`

						$sql = "SELECT * FROM `tblstudent` st, `grades` g,`subject` s ,studentsubjects ss
						WHERE st.`IDNO`=g.`IDNO` and g.`SUBJ_ID`=s.`SUBJ_ID`  and s.`SUBJ_ID`=ss.`SUBJ_ID` AND g.`IDNO`=ss.`IDNO`  AND g.`REMARKS` NOT IN ('Drop') and st.`IDNO`=".$_SESSION['IDNO'];
				  		$mydb->setQuery($sql);

				  		$cur = $mydb->loadResultList();

						foreach ($cur as $result) {
							switch ($result->LEVEL) {
								case 1:
									# code...
								$Level ='First Year';
									break;
								case 2:
									# code...
								$Level ='Second Year';
									break;
								case 3:
									# code...
								$Level ='Third Year';
									break;
								case 4:
									# code...
								$Level ='Fourth Year';
									break;

								default:
									# code...
								$Level ='First Year';
									break;
							}




				  		echo '<tr>';
				  		// echo '<td width="5%" align="center"></td>';
				  		echo '<td></td>';
				  		echo '<td>'. $result->SUBJ_CODE.'</td>';
				  		echo '<td>'. $result->SUBJ_DESCRIPTION.'</td>';
				  		echo '<td>' . $result->UNIT.'</a></td>'; 
						
				  		echo '<td>'. $Level.'</td>'; 
				  		echo '<td>'. $result->SEMESTER.'</td>';
				  	
				  		 
				  		// echo '<td align="center" > <a title="Edit" href="index.php?view=edit&id='.$result->SUBJ_ID.'"  class="btn btn-primary btn-xs  ">  <span class="fa fa-edit fw-fa"></span></a>
				  		// 			 <a title="Delete" href="controller.php?action=delete&id='.$result->SUBJ_ID.'" class="btn btn-danger btn-xs" ><span class="fa fa-trash-o fw-fa"></span> </a>
				  		// 			 </td>';
				  		echo '</tr>';
				  	} 
				  	?>
				  </tbody>
					
				</table>
 
				<!-- <div class="btn-group">
				  <a href="index.php?view=add" class="btn btn-default">New</a>
				  <button type="submit" class="btn btn-default" name="delete"><span class="glyphicon glyphicon-trash"></span> Delete Selected</button>
				</div>
 -->
			</div>
				</form>
	
         
              </div><!--/table-resp-->
               
             </div><!--/tab-pane-->
            <div class="tab-pane" id="grades">
         
              <?php require_once  ("studentgrades.php"); ?>
          
       
            </div>
             <div class="tab-pane" id="adddrop">
         
              
              <?php //require_once  ("changingdropping.php"); ?>
          
       
            </div>
             <div class="tab-pane" id="settings">
    		 
              <?php require_once  ("updateyearlevel.php"); ?>
          
       
            </div><!--/tab-pane-->
  </div><!--/tab-content-->
 </div>
</div><!--/col-9--> 
</div>

<div class="modal" tabindex="-1" role="dialog" id="notificationModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="margin-left: 100px; margin-top: 100px;">
            <div class="modal-header">
                <h5 class="modal-title"><img style="width: 100px; margin-left: 170px;" src="img/sfalogo.png" alt=""></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <p style="font-size: 12px; color: Red; font-weight: bold; ">Liabilities</p>
            <p>Hi !  <?php echo $res->FNAME .' '.$res->LNAME; ?> </p>
                <p>Your tuition payment is still pending.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and Popper.js scripts -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<!-- JavaScript code for the modal -->
<script>
    <?php if (!isset($res->enrollment_status) || $res->enrollment_status != 'Paid') { ?>
        $(document).ready(function () {
            $('#notificationModal').modal('show');
        });
    <?php } ?>
</script>




	  <!-- Modal photo -->
          <div class="modal fade" id="myModal" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button class="close" data-dismiss="modal" type=
                  "button">×</button>

                  <h4 class="modal-title" id="myModalLabel">Choose Image.</h4>
                </div>

                <form action="student/controller.php?action=photos" enctype="multipart/form-data" method=
                "post">
                  <div class="modal-body">
                    <div class="form-group">
                      <div class="rows">
                        <div class="col-md-12">
                          <div class="rows">
                            <div class="col-md-8">
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
                    name="savephoto" type="submit">Upload Photo</button>
                  </div>
                </form>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
          </div><!-- /.modal -->
   