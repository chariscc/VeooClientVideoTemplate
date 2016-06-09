<?php
function html_showvideo_players( $rows,  $pageNav,$sort,$cat_row){
	global $wpdb;
	?>
    <script language="javascript">
		function ordering(name,as_or_desc)
		{
			document.getElementById('asc_or_desc').value=as_or_desc;		
			document.getElementById('order_by').value=name;
			document.getElementById('admin_form').submit();
		}
		function saveorder()
		{
			document.getElementById('saveorder').value="save";
			document.getElementById('admin_form').submit();
			
		}
		function listItemTask(this_id,replace_id)
		{
			document.getElementById('oreder_move').value=this_id+","+replace_id;
			document.getElementById('admin_form').submit();
		}
		function doNothing() {  
			var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
			if( keyCode == 13 ) {


				if(!e) var e = window.event;

				e.cancelBubble = true;
				e.returnValue = false;

				if (e.stopPropagation) {
						e.stopPropagation();
						e.preventDefault();
				}
			}
		}
	</script>

<div class="wrap">
        <?php $path_site2 = plugins_url("../images", __FILE__); ?>
	<div class="free_version_banner">
		<img class="manual_icon" src="<?php echo $path_site2; ?>/icon-user-manual.png" alt="user manual" />
		<p class="usermanual_text">If you have any difficulties in using the options, Follow the link to <a href="http://huge-it.com/wordpress-video-player-user-manual/" target="_blank">User Manual</a></p>
		<a class="get_full_version" href="http://huge-it.com/video-player/" target="_blank">GET THE FULL VERSION</a>
                <a href="http://huge-it.com" target="_blank"><img class="huge_it_logo" src="<?php echo $path_site2; ?>/Huge-It-logo.png"/></a>
                <div style="clear: both;"></div>
		<div  class="description_text"><p>This is the free version of the plugin. In order to use options from this section, get the full version. We appreciate every customer.</p></div>
	</div>
	<div id="poststuff">
		<div id="video_players-list-page">
			<form method="post"  onkeypress="doNothing()" action="admin.php?page=video_players_huge_it_video_player" id="admin_form" name="admin_form">
			<h2>Huge-IT Video Albums
				<a onclick="window.location.href='admin.php?page=video_players_huge_it_video_player&task=add_cat'" class="add-new-h2" >Add New Video Album</a>
			</h2>
			<?php
			$serch_value='';
			if(isset($_POST['serch_or_not'])) {if($_POST['serch_or_not']=="search"){ $serch_value=esc_html(stripslashes($_POST['search_events_by_title'])); }else{$serch_value="";}} 
			$serch_fields='<div class="alignleft actions"">
				<label for="search_events_by_title" style="font-size:14px">Filter: </label>
					<input type="text" name="search_events_by_title" value="'.$serch_value.'" id="search_events_by_title" onchange="clear_serch_texts()">
			</div>
			<div class="alignleft actions">
				<input type="button" value="Search" onclick="document.getElementById(\'page_number\').value=\'1\'; document.getElementById(\'serch_or_not\').value=\'search\';
				 document.getElementById(\'admin_form\').submit();" class="button-secondary action">
				 <input type="button" value="Reset" onclick="window.location.href=\'admin.php?page=video_players_huge_it_video_player\'" class="button-secondary action">
			</div>';

		
			?>
			<table class="wp-list-table widefat fixed pages" style="width:95%">
				<thead>
				 <tr>
					<th scope="col" id="id" style="width:30px" ><span>ID</span><span class="sorting-indicator"></span></th>
					<th scope="col" id="name" style="width:85px" ><span>Name</span><span class="sorting-indicator"></span></th>
					<th scope="col" id="prod_count"  style="width:75px;" ><span>Videos</span><span class="sorting-indicator"></span></th>
					<th style="width:40px">Delete</th>
				 </tr>
				</thead>
				<tbody>
				 <?php 
				 $trcount=1;
				  for($i=0; $i<count($rows);$i++){
					$trcount++;
					$ka0=0;
					$ka1=0;


					$uncat=$rows[$i]->par_name;
					if(isset($rows[$i]->prod_count))
						$pr_count=$rows[$i]->prod_count;
					else
						$pr_count=0;


					?>
					<tr <?php if($trcount%2==0){ echo 'class="has-background"';}?>>
						<td><?php echo $rows[$i]->id; ?></td>
						<td><a  href="admin.php?page=video_players_huge_it_video_player&task=edit_cat&id=<?php echo $rows[$i]->id?>"><?php echo esc_html(stripslashes($rows[$i]->name)); ?></a></td>
						<td>(<?php if(!($pr_count)){echo '0';} else{ echo $rows[$i]->prod_count;} ?>)</td>
						<td><a  href="admin.php?page=video_players_huge_it_video_player&task=remove_cat&id=<?php echo $rows[$i]->id?>">Delete</a></td>
					</tr> 
				 <?php } ?>
				</tbody>
			</table>
			 <input type="hidden" name="oreder_move" id="oreder_move" value="" />
			 <input type="hidden" name="asc_or_desc" id="asc_or_desc" value="<?php if(isset($_POST['asc_or_desc'])) echo $_POST['asc_or_desc'];?>"  />
			 <input type="hidden" name="order_by" id="order_by" value="<?php if(isset($_POST['order_by'])) echo $_POST['order_by'];?>"  />
			 <input type="hidden" name="saveorder" id="saveorder" value="" />

			 <?php
			?>
			
			
		   
			</form>
		</div>
	</div>
</div>
    <?php

}
function Html_editvideo_player($ord_elem,$row,$cat_row, $rowim, $rowsld, $paramssld, $rowsposts, $rowsposts8, $postsbycat)

{
 global $wpdb;
	
	if(isset($_GET["addslide"])){
	if($_GET["addslide"] == 1){
	header('Location: admin.php?page=video_players_huge_it_video_player&id='.$row->id.'&task=apply');
	}
	}
		
	
?>
<script type="text/javascript">
jQuery("#save-buttom").click(function(){
	submitbutton("apply");
})
function submitbutton(pressbutton) 
{
	if(!document.getElementById('name').value){
	alert("Name is required.");
	return;
	
	}
	
	document.getElementById("adminForm").action=document.getElementById("adminForm").action+"&task="+pressbutton;
	document.getElementById("adminForm").submit();
	
}
function change_select()
{
		submitbutton('apply'); 
	
}
jQuery(function() {
        
	jQuery( "#images-list" ).sortable({
	  stop: function() {
			jQuery("#images-list > li").removeClass('has-background');
			count=jQuery("#images-list > li").length;
			for(var i=0;i<=count;i+=2){
					jQuery("#images-list > li").eq(i).addClass("has-background");
			}
			jQuery("#images-list > li").each(function(){
				jQuery(this).find('.order_by').val(jQuery(this).index());
			});
	  },
	  revert: true
	});
   // jQuery( "ul, li" ).disableSelection();
	});
</script>

<!-- GENERAL PAGE, ADD IMAGES PAGE -->

<div class="wrap">
<?php $path_site2 = plugins_url("../images", __FILE__); ?>
	<div class="free_version_banner">
		<img class="manual_icon" src="<?php echo $path_site2; ?>/icon-user-manual.png" alt="user manual" />
		<p class="usermanual_text">If you have any difficulties in using the options, Follow the link to <a href="http://huge-it.com/wordpress-video-player-user-manual/" target="_blank">User Manual</a></p>
		<a class="get_full_version" href="http://huge-it.com/video-player/" target="_blank">GET THE FULL VERSION</a>
                <a href="http://huge-it.com" target="_blank"><img class="huge_it_logo" src="<?php echo $path_site2; ?>/Huge-It-logo.png"/></a>
                <div style="clear: both;"></div>
		<div  class="description_text"><p>This is the free version of the plugin. In order to use options from this section, get the full version. We appreciate every customer.</p></div>
	</div>
<form action="admin.php?page=video_players_huge_it_video_player&id=<?php echo $row->id; ?>" method="post" name="adminForm" id="adminForm">

	<div id="poststuff" >
	<div id="video_player-header">
		<ul id="video_players-list">
			
			<?php
			foreach($rowsld as $rowsldires){
				if($rowsldires->id != $row->id){
				?>
					<li>
						<a href="#" onclick="window.location.href='admin.php?page=video_players_huge_it_video_player&task=edit_cat&id=<?php echo $rowsldires->id; ?>'" ><?php echo $rowsldires->name; ?></a>
					</li>
				<?php
				}
				else{ ?>
					<li class="active" style="background-image:url(<?php echo plugins_url('../images/edit.png', __FILE__) ;?>)">
						<input class="text_area" onfocus="this.style.width = ((this.value.length + 1) * 8) + 'px'" type="text" name="name" id="name" maxlength="250" value="<?php echo esc_html(stripslashes($row->name));?>" />
					</li>
				<?php	
				}
			}
		?>
			<li class="add-new">
				<a onclick="window.location.href='admin.php?page=video_players_huge_it_video_player&amp;task=add_cat'">+</a>
			</li>
		</ul>
		</div>
		<div id="post-body" class="metabox-holder columns-2">
			<!-- Content -->
			<div id="post-body-content">


			<?php add_thickbox(); ?>

				<div id="post-body">
					<div id="post-body-heading">
						<h3>Projects/Images</h3>
						


						<script>
jQuery(document).ready(function($){
	jQuery(".wp-media-buttons-icon").click(function() {
		jQuery(".attachment-filters").css("display","none");
	});
  var _custom_media = true,
      _orig_send_attachment = wp.media.editor.send.attachment;
	 

  jQuery('.huge-it-newuploader .button').click(function(e) {
    var send_attachment_bkp = wp.media.editor.send.attachment;
	
    var button = jQuery(this);
    var id = button.attr('id').replace('_button', '');
    _custom_media = true;

	jQuery("#"+id).val('');
	wp.media.editor.send.attachment = function(props, attachment){
      if ( _custom_media ) {
	     jQuery("#"+id).val(attachment.url+';;;'+jQuery("#"+id).val());
		 jQuery("#save-buttom").click();
      } else {
        return _orig_send_attachment.apply( this, [props, attachment] );
      };
    }
  
    wp.media.editor.open(button);
	 
    return false;
  });

  jQuery('.add_media').on('click', function(){
    _custom_media = false;
	
  });
});
</script>
						<input type="hidden" name="imagess" id="_unique_name" />
						<span class="wp-media-buttons-icon"></span>						
						<div class="huge-it-newuploader uploader add-new-image">
							<input type="button" class="button button-primary wp-media-buttons-icon" name="_unique_name_button" id="_unique_name_button" value="Upload Video" />
						</div>
						<a href="admin.php?page=video_players_huge_it_video_player&task=video_player_video&id=<?php echo $_GET['id']; ?>&TB_iframe=1" class="button button-primary add-video-slide thickbox"  id="slideup3s" value="iframepop">
							<span class="wp-media-buttons-icon"></span>Add Video From Url
						</a>
						<!--<a href="admin.php?page=video_players_huge_it_video_player&task=video_player_vimeo&id=<?php // echo $_GET['id']; ?>&TB_iframe=1" class="button button-primary add-video-slide thickbox"  id="slideup3s" value="iframepop">
							<span class="wp-media-buttons-icon"></span>Add Vimeo Video
						</a>-->
					</div>
					<ul id="images-list">
					<?php
					
					function get_youtube_id_from_url($url){						
						if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
							return $match[1];
						}
					}
					
					$i=2;
					foreach ($rowim as $key=>$rowimages){ ?>
					<?php if($rowimages->sl_type == ''){$rowimages->sl_type = 'video';} ?>
						<?php switch ($rowimages->sl_type) {
						case 'video':	?>
						<li <?php if($i%2==0){echo "class='has-background'";}$i++; ?>>
						<input class="order_by" type="hidden" name="order_by_<?php echo $rowimages->id; ?>" value="<?php echo $rowimages->ordering; ?>" />
							<div class="image-container">
								<?php $path_site = plugins_url("../images", __FILE__); ?>
								<?php if($rowimages->image_url == ''){ ?>
								<img src="<?php echo $path_site; ?>/noimage.jpg" />
								<?php } else { ?>
								<img src="<?php echo $rowimages->image_url; ?>" />
								<?php } ?>
								<div>
										<script>
										jQuery(document).ready(function($){
										  var _custom_media = true,
											  _orig_send_attachment = wp.media.editor.send.attachment;

										  jQuery('.huge-it-editnewuploader .button<?php echo $rowimages->id; ?>').click(function(e) {
											var send_attachment_bkp = wp.media.editor.send.attachment;
											var button = jQuery(this);
											var id = button.attr('id').replace('_button', '');
											_custom_media = true;
											wp.media.editor.send.attachment = function(props, attachment){
											  if ( _custom_media ) {
												jQuery("#"+id).val(attachment.url);
												jQuery("#save-buttom").click();
											  } else {
												return _orig_send_attachment.apply( this, [props, attachment] );
											  };
											}
											wp.media.editor.open(button);
											return false;
										  });

										  jQuery('.add_media').on('click', function(){
											_custom_media = false;
										  });
											jQuery(".huge-it-editnewuploader").click(function() {
											});
												jQuery(".wp-media-buttons-icon").click(function() {
												jQuery(".wp-media-buttons-icon").click(function() {
												jQuery(".media-menu .media-menu-item").css("display","none");
												jQuery(".media-menu-item:first").css("display","block");
												jQuery(".separator").next().css("display","none");
												jQuery('.attachment-filters').val('image').trigger('change');
												jQuery(".attachment-filters").css("display","none");

											});
										});

										});
											function deleteproject<?php echo $rowimages->id; ?>(){
											   jQuery('#adminForm').attr('action', 'admin.php?page=video_players_huge_it_video_player&task=edit_cat&id=<?php echo $row->id; ?>&removeslide=<?php echo $rowimages->id; ?>');
											}
										</script>
								<input type="hidden" name="imagess<?php echo $rowimages->id; ?>" id="_unique_name<?php echo $rowimages->id; ?>" value="<?php echo $rowimages->image_url; ?>" />
								<span class="wp-media-buttons-icon"></span>
								<div class="editimgbutton_block huge-it-editnewuploader uploader button<?php echo $rowimages->id; ?> add-new-image">
									<span class="edit_image_info">Set Custom Thumbnail</span>
									<input type="button" class="editimgbutton button<?php echo $rowimages->id; ?> wp-media-buttons-icon" name="_unique_name_button<?php echo $rowimages->id; ?>" id="_unique_name_button<?php echo $rowimages->id; ?>" value="" />
								</div>
									</div>
							</div>
							<div data-video-type="video" class="image-options">
								<div class="description-block">
									<label for="titleimage<?php echo $rowimages->id; ?>">Title:</label>
									<input  class="text_area" type="text" id="titleimage<?php echo $rowimages->id; ?>" name="titleimage<?php echo $rowimages->id; ?>" id="titleimage<?php echo $rowimages->id; ?>"  value="<?php echo $rowimages->name; ?>">
								</div>
								<div class="description-block">
									<label for="for_video_1<?php echo $rowimages->id; ?>">Url:</label>
									<input style="padding-right:20px;" type="text" name="for_video_1<?php echo $rowimages->id; ?>" id="for_video_1<?php echo $rowimages->id; ?>" value="<?php echo $rowimages->video_url_1; ?>" />
									<div class="huge-it-editnewuploader uploader button<?php echo $rowimages->id; ?>">
										<input type="button" class="button<?php echo $rowimages->id; ?> wp-media-buttons-icon editimageicon" name="for_video_1_button<?php echo $rowimages->id; ?>" id="for_video_1_button<?php echo $rowimages->id; ?>" value="" />
									</div>
								</div>
								<div class="remove-image-container">
									<a onclick="deleteproject<?php echo $rowimages->id; ?>(); submitbutton('apply');" id="remove_image<?php echo $rowimages->id; ?>" class="button remove-image">X</a>
								</div>
							</div>
						<div class="clear"></div>
						</li>
						<?php break;
						case 'youtube':
?>
						<li <?php if($i%2==0){echo "class='has-background'";}$i++; ?>>
						<input class="order_by" type="hidden" name="order_by_<?php echo $rowimages->id; ?>" value="<?php echo $rowimages->ordering; ?>" />
							<div class="image-container">
								<?php $path_site = plugins_url("../images", __FILE__); ?>
								<?php if($rowimages->image_url == ''){ ?>
								<img src="<?php echo $path_site; ?>/noimage.jpg" />
								<?php }else{ ?>
								<img src="<?php echo $rowimages->image_url; ?>" />
								<?php } ?>
								<div>
										<script>
										jQuery(document).ready(function($){
											var _custom_media = true,
											  _orig_send_attachment = wp.media.editor.send.attachment;

											jQuery('.huge-it-editnewuploader .button<?php echo $rowimages->id; ?>').click(function(e) {
												var send_attachment_bkp = wp.media.editor.send.attachment;
												var button = jQuery(this);
												var id = button.attr('id').replace('_button', '');
												_custom_media = true;
												wp.media.editor.send.attachment = function(props, attachment){
												  if ( _custom_media ) {
													jQuery("#"+id).val(attachment.url);
													jQuery("#save-buttom").click();
												  } else {
													return _orig_send_attachment.apply( this, [props, attachment] );
												  };
												}

												wp.media.editor.open(button);
												return false;
											});

											jQuery('.add_media').on('click', function(){
												_custom_media = false;
											});
											jQuery(".huge-it-editnewuploader").click(function() {
											});
											jQuery(".wp-media-buttons-icon").click(function() {
												jQuery(".wp-media-buttons-icon").click(function() {
													jQuery(".media-menu .media-menu-item").css("display","none");
													jQuery(".media-menu-item:first").css("display","block");
													jQuery(".separator").next().css("display","none");
													jQuery('.attachment-filters').val('image').trigger('change');
													jQuery(".attachment-filters").css("display","none");
												});
											});
											
											
										});
										function deleteproject<?php echo $rowimages->id; ?>() {
										   jQuery('#adminForm').attr('action', 'admin.php?page=video_players_huge_it_video_player&task=edit_cat&id=<?php echo $row->id; ?>&removeslide=<?php echo $rowimages->id; ?>');
										}
									</script>
									<input class="hidden_image_url" type="hidden" name="imagess<?php echo $rowimages->id; ?>" id="_unique_name<?php echo $rowimages->id; ?>" value="<?php echo $rowimages->image_url; ?>" />
									<span class="wp-media-buttons-icon"></span>
									<div class="editimgbutton_block huge-it-editnewuploader uploader button<?php echo $rowimages->id; ?> add-new-image">
										<span class="edit_image_info">Set Custom Thumbnail</span>
										<input type="button" class="editimgbutton button<?php echo $rowimages->id; ?> wp-media-buttons-icon" name="_unique_name_button<?php echo $rowimages->id; ?>" id="_unique_name_button<?php echo $rowimages->id; ?>" value="" />
									</div>
								</div>
								<div class="default_thumbnail">
									<div class="button set_default_thumbnail" data-video-type="youtube" data-video-id="<?=get_youtube_thumb_id_from_url($rowimages->video_url_1); ?>">Set Default Thumbnail</div>
								</div>
							</div>
							
							<div data-video-type="youtube" class="image-options">
								<div class="description-block">
									<label for="titleimage<?php echo $rowimages->id; ?>">Title:</label>
									<input  class="text_area" type="text" id="titleimage<?php echo $rowimages->id; ?>" name="titleimage<?php echo $rowimages->id; ?>" id="titleimage<?php echo $rowimages->id; ?>"  value="<?php echo $rowimages->name; ?>">
								</div>
								<div class="description-block">
									<label for="for_video_1<?php echo $rowimages->id; ?>">Url:</label>
									<input class="youtube_link video_link_change" type="text" name="for_video_1<?php echo $rowimages->id; ?>" id="for_video_1<?php echo $rowimages->id; ?>" value="<?php echo $rowimages->video_url_1; ?>" />
									<div class="button update_video_link">Update</div>
								</div>
								<div class="link-block">
									<input type="hidden" name="for_video_2<?php echo $rowimages->id; ?>" id="for_video_2<?php echo $rowimages->id; ?>" value="<?php echo $rowimages->video_url_2; ?>" />
								</div>
								<div class="video_preview_container">
									<?php 
										$video_thumb_url=get_youtube_thumb_id_from_url($rowimages->video_url_1);
									?>
									<img src="<?php echo "http://img.youtube.com/vi/".$video_thumb_url."/mqdefault.jpg" ?>" alt="" />
									<div class="yt_play_center"></div>
								</div>
								<div class="remove-image-container">
									<a onclick="deleteproject<?php echo $rowimages->id; ?>(); submitbutton('apply');" id="remove_image<?php echo $rowimages->id; ?>" class="button remove-image">X</a>
								</div>
							</div>
							
						<div class="clear"></div>
						</li>
						<?php
						break;
						case "vimeo":
							?>
						<li <?php if($i%2==0){echo "class='has-background'";}$i++; ?>>
						<input class="order_by" type="hidden" name="order_by_<?php echo $rowimages->id; ?>" value="<?php echo $rowimages->ordering; ?>" />
							<div class="image-container">
								<?php $path_site = plugins_url("../images", __FILE__); ?>
								<?php if($rowimages->image_url == ''){ ?>
								<img src="<?php echo $path_site; ?>/noimage.jpg" />
								<?php } else { ?>
								<img src="<?php echo $rowimages->image_url; ?>" />
								<?php } ?>
								<div>
										<script>
										jQuery(document).ready(function($){
											var _custom_media = true,
											  _orig_send_attachment = wp.media.editor.send.attachment;

											  jQuery('.huge-it-editnewuploader .button<?php echo $rowimages->id; ?>').click(function(e) {
												var send_attachment_bkp = wp.media.editor.send.attachment;
												var button = jQuery(this);
												var id = button.attr('id').replace('_button', '');
												_custom_media = true;
												wp.media.editor.send.attachment = function(props, attachment){
												  if ( _custom_media ) {
													jQuery("#"+id).val(attachment.url);
													jQuery("#save-buttom").click();
												  } else {
													return _orig_send_attachment.apply( this, [props, attachment] );
												  };
												}

												wp.media.editor.open(button);
												return false;
											  });

											  jQuery('.add_media').on('click', function(){
												_custom_media = false;
											  });
												jQuery(".huge-it-editnewuploader").click(function() {
												});
													jQuery(".wp-media-buttons-icon").click(function() {
													jQuery(".wp-media-buttons-icon").click(function() {
													jQuery(".media-menu .media-menu-item").css("display","none");
													jQuery(".media-menu-item:first").css("display","block");
													jQuery(".separator").next().css("display","none");
													jQuery('.attachment-filters').val('image').trigger('change');
													jQuery(".attachment-filters").css("display","none");

												});
											});
											jQuery("#album_name").on("keyup change",function(){
												jQuery("#name").val(jQuery(this).val());
											})
											jQuery("#name").on("keyup change",function(){
												jQuery("#album_name").val(jQuery(this).val());
											})

										});
										function deleteproject<?php echo $rowimages->id; ?>() {
										   jQuery('#adminForm').attr('action', 'admin.php?page=video_players_huge_it_video_player&task=edit_cat&id=<?php echo $row->id; ?>&removeslide=<?php echo $rowimages->id; ?>');
										}
											
									</script>
									<input class="hidden_image_url" type="hidden" name="imagess<?php echo $rowimages->id; ?>" id="_unique_name<?php echo $rowimages->id; ?>" value="<?php echo $rowimages->image_url; ?>" />
									<span class="wp-media-buttons-icon"></span>
									<div class="editimgbutton_block huge-it-editnewuploader uploader button<?php echo $rowimages->id; ?> add-new-image">
										<span class="edit_image_info">Set Custom Thumbnail</span>
										<input type="button" class="editimgbutton button<?php echo $rowimages->id; ?> wp-media-buttons-icon" name="_unique_name_button<?php echo $rowimages->id; ?>" id="_unique_name_button<?php echo $rowimages->id; ?>" value="" />
									</div>

								
								</div>
								<div class="default_thumbnail">
									<?php 
									$vidid = explode( "/", $rowimages->video_url_1);
									$vidid=end($vidid);
									?>
									<div class="button set_default_thumbnail" data-video-type="vimeo" data-video-id="<?=$vidid; ?>">Set Default Thumbnail</div>
								</div>
							</div>
							<div data-video-type="vimeo" class="image-options">
								<div class="description-block">
									<label for="titleimage<?php echo $rowimages->id; ?>">Title:</label>
									<input  class="text_area" type="text" id="titleimage<?php echo $rowimages->id; ?>" name="titleimage<?php echo $rowimages->id; ?>" id="titleimage<?php echo $rowimages->id; ?>"  value="<?php echo $rowimages->name; ?>">
								</div>
								<div class="description-block">
									<label for="for_video_1<?php echo $rowimages->id; ?>">Url:</label>
									<input class="vimeo_link video_link_change" type="text" name="for_video_1<?php echo $rowimages->id; ?>" id="for_video_1<?php echo $rowimages->id; ?>" value="<?php echo $rowimages->video_url_1; ?>" />
									<div class="button update_video_link">Update</div>
								</div>
								<div class="link-block">
									<input type="hidden" name="for_video_2<?php echo $rowimages->id; ?>" id="for_video_2<?php echo $rowimages->id; ?>" value="<?php echo $rowimages->video_url_2; ?>" />
								</div>
								<div class="video_preview_container">
									<?php 
										$vidid = explode( "/", $rowimages->video_url_1);
										$vidid=end($vidid);
										$hash=file_get_contents("http://vimeo.com/api/v2/video/".$vidid.".php");
										$vidurl="https://player.vimeo.com/video/".$vidid;
										$hash = unserialize($hash);
										$video_thumb_url=$hash[0]['thumbnail_large'];
									?>
									<img src="<?php echo $video_thumb_url; ?>" alt="" />
									<div class="vimeo_play_center"></div>
								</div>
								<div class="remove-image-container">
									<a onclick="deleteproject<?php echo $rowimages->id; ?>(); submitbutton('apply');" id="remove_image<?php echo $rowimages->id; ?>" class="button remove-image">X</a>
								</div>
							</div>
							<div class="clear"></div>
						</li>
<?php
						break;
						} ?>
					<?php } ?>
					</ul>
				</div>

			</div>
				
			<!-- SIDEBAR -->
			<div id="postbox-container-1" class="postbox-container">
				<div id="side-sortables" class="meta-box-sortables ui-sortable">
					<div id="video_player-unique-options" class="postbox">
					<h3 class="hndle"><span>Select The Video Player View</span></h3>
					<ul id="video_player-unique-options-list">						
					<div id="video_player-current-options-3" class="video_player-current-options">
					<ul id="slider-unique-options-list">
						<li>
							<label for="album_name">Player Name</label>
							<input type="text" id="album_name" name="album_name" value="<?php echo $row->name; ?>" />
						</li>
						<li>
							<label for="album_single">Player Type</label>
							<select name="album_single" id="album_single">
									<option <?php if($row->album_single == 'album'){ echo 'selected'; } ?>  value="album">Album</option>
									<option <?php if($row->album_single == 'single'){ echo 'selected'; } ?>   value="single">Single</option>
							</select>
						</li>
						<li>
							<label for="album_playlist_layout">Playlist Layout</label>
							<select name="album_playlist_layout" id="album_playlist_layout">
								<option value="left" <?php if($row->layout=="left"){ echo 'selected="selected"'; } ?>>Left</option>
								<option value="right" <?php if($row->layout=="right"){ echo 'selected="selected"'; } ?>>Right</option>
								<option value="bottom" <?php if($row->layout=="bottom"){ echo 'selected="selected"'; } ?>>Bottom</option>
							</select>
						</li>
						<li>
							<label for="album_autoplay">Autoplay</label>
							<select name="album_autoplay" id="album_autoplay" >
								<option value="1" <?php if($row->autoplay=="1"){ echo 'selected="selected"'; } ?>>On</option>
								<option value="0" <?php if($row->autoplay=="0"){ echo 'selected="selected"'; } ?>>Off</option>
							</select>
						</li>
						<li>
							<label for="album_width">Video Width(px)</label>
							<input type="number" name="album_width" id="album_width" min="250" value="<?php echo $row->width; ?>" />
						</li>
						
						

					</ul>
					</div>


					</ul>
						<div id="major-publishing-actions">
							<div id="publishing-action">
								<input type="button" onclick="submitbutton('apply')" value="Save Video Player" id="save-buttom" class="button button-primary button-large">
							</div>
							<div class="clear"></div>
							<!--<input type="button" onclick="window.location.href='admin.php?page=video_players_huge_it_video_player'" value="Cancel" class="button-secondary action">-->
						</div>
					</div>
					<div id="video_player-shortcode-box" class="postbox shortcode ms-toggle">
					<h3 class="hndle"><span>Usage</span></h3>
					<div class="inside">
						<ul>
							<li rel="tab-1" class="selected">
								<h4>Shortcode</h4>
								<p>Copy &amp; paste the shortcode directly into any WordPress post or page.</p>
								<textarea class="full" readonly="readonly">[huge_it_video_player id="<?php echo $row->id; ?>"]</textarea>
							</li>
							<li rel="tab-2">
								<h4>Template Include</h4>
								<p>Copy &amp; paste this code into a template file to include the slideshow within your theme.</p>
								<textarea class="full" readonly="readonly">&lt;?php echo do_shortcode("[huge_it_video_player id='<?php echo $row->id; ?>']"); ?&gt;</textarea>
							</li>
						</ul>
					</div>
				</div>
				</div>
			</div>
		</div>
	</div>
	<input type="hidden" name="task" value="" />
</form>
</div>

<?php

}


function html_popup_posts($ord_elem, $count_ord,$row,$cat_row, $rowim, $rowsld, $paramssld, $rowsposts, $rowsposts8, $postsbycat){
	global $wpdb;

?>
			<style>
				html.wp-toolbar {
					padding:0px !important;
				}
				#wpadminbar,#adminmenuback,#screen-meta, .update-nag,#dolly {
					display:none;
				}
				#wpbody-content {
					padding-bottom:30px;
				}
				#adminmenuwrap {display:none !important;}
				.auto-fold #wpcontent, .auto-fold #wpfooter {
					margin-left: 0px;
				}
				#wpfooter {display:none;}
			</style>
			<script type="text/javascript">
				jQuery(document).ready(function() {

					jQuery('.huge-it-insert-post-button').on('click', function() {
						var ID1 = jQuery('#huge-it-add-posts-params').val();
						if(ID1==""){alert("Please select images to insert into video_player.");return false;}
						
						window.parent.uploadID.val(ID1);
						
						tb_remove();
						jQuery("#save-buttom").click();
						
					});
						
					jQuery('.huge-it-post-checked').change(function(){
						if(jQuery(this).is(':checked')){
							jQuery(this).addClass('active');
							jQuery(this).parent().addClass('active');
						}else {
							jQuery(this).removeClass('active');
							jQuery(this).parent().removeClass('active');
						}
						
						var inputval="";
						jQuery('#huge-it-add-posts-params').val("");
						jQuery('.huge-it-post-checked').each(function(){
							if(jQuery(this).is(':checked')){
								inputval+=jQuery(this).val()+";";
							}
						});
						jQuery('#huge-it-add-posts-params').val(inputval);
					});
	
					
					jQuery("#huge-it-categories-list").change(function(){
						var currentCategoryID=jQuery(this).val();
					
						jQuery('#huge-it-posts-list li').not("#huge-it-posts-list-heading").css({"display":"none"});
						jQuery('li[data-id*="'+currentCategoryID+'"]').css({"display":"block"});
						
					});
					//jQuery("#huge-it-categories-list").change();
										
					jQuery('#huge_it_video_player_add_posts_wrap .view-type-block a').click(function(){
						jQuery('#huge_it_video_player_add_posts_wrap .view-type-block a').removeClass('active');
						jQuery(this).addClass('active');
						var strtype=jQuery(this).attr('href').replace('#','');
						jQuery('#huge-it-posts-list').removeClass('list').removeClass('thumbs');
						jQuery('#huge-it-posts-list').addClass(strtype);
						return false;
					});
					
					
					jQuery('.updated').css({"display":"none"});
				<?php	if($_GET["closepop"] == 1){ ?>
					jQuery("#closepopup").click();
					self.parent.location.reload();
				<?php	} ?>
				});
				
			</script>
			<a id="closepopup"  onclick=" parent.eval('tb_remove()')" style="display:none;" > [X] </a>
	
	
	<div id="huge_it_video_player_add_posts">
					<div id="huge_it_video_player_add_posts_wrap">
						<h2>Add post</h2>
						<div class="control-panel">
						<form method="post"  onkeypress="doNothing()" action="admin.php?page=video_players_huge_it_video_player&task=popup_posts&id=<?php echo $_GET['id']; ?>" id="huge-it-category-form" name="admin_form">
							<label for="huge-it-categories-list">Select Category <select id="huge-it-categories-list" name="iframecatid" onchange="this.form.submit()">

							 <?php $categories = get_categories(  ); ?>

							<?php	 foreach ($categories as $strcategories){
							if(isset($_POST["iframecatid"])){
?>
								 <option value="<?php echo $strcategories->cat_ID; ?>" <?php if($strcategories->cat_ID == $_POST["iframecatid"]){echo 'selected="selected"';} ?>><?php echo $strcategories->cat_name; ?></option>';
								
							<?php	}
else
{
?>
								<option value="<?php echo $strcategories->cat_ID; ?>"><?php echo $strcategories->cat_name; ?></option>';
<?php
}							}
							?> 
							</select></label>
							</form>
							<form method="post"  onkeypress="doNothing()" action="admin.php?page=video_players_huge_it_video_player&task=popup_posts&id=<?php echo $_GET['id']; ?>&closepop=1" id="admin_form" name="admin_form">
							<button class='save-video_player-options button-primary huge-it-insert-post-button' id='huge-it-insert-post-button-top'>Insert Posts</button>
							<label for="huge-it-description-length">Description Length <input id="huge-it-description-length" type="text" name="posthuge-it-description-length" value="<?php echo $row->published; ?>" placeholder="Description length" /></label>
							<div class="view-type-block">
								<a class="view-type list active" href="#list">View List</a>
								<a class="view-type thumbs" href="#thumbs">View List</a>
							</div>
						</div>
						<div style="clear:both;"></div>
						<ul id="huge-it-posts-list" class="list">
							<li id="huge-it-posts-list-heading" class="hascolor">
								<div class="huge-it-posts-list-image">Image</div>
								<div class="huge-it-posts-list-title">Title</div>
								<div class="huge-it-posts-list-description">
									Description
									
								</div>
								<div class="huge-it-posts-list-link">Link</div>
								<div class="huge-it-posts-list-category">Category</div>
							</li>
							<?php 



							$strx=1;
							foreach($rowsposts8 as $rowspostspop1){
								 $query=$wpdb->prepare("SELECT * FROM ".$wpdb->prefix."posts where post_type = 'post' and post_status = 'publish' and ID = %d  order by ID ASC", $rowspostspop1->object_id);
							$rowspostspop=$wpdb->get_results($query);
							//print_r($rowspostspop);
							
							
								$post_categories =  wp_get_post_categories( $rowspostspop[0]->ID, $rowspostspop[0]->ID ); 
								$cats = array();
								
								
								foreach($post_categories as $c){
									$cat = get_category( $c );
									$cats[] = array( 'name' => $cat->name, 'slug' => $cat->slug, 'id' => $cat->term_id );
									//echo	$cat->slug;
								}
								if(get_the_post_thumbnail($rowspostspop[0]->ID, 'thumbnail') != ''){
									$strx++;
									$hascolor="";
									if($strx%2==0){$hascolor='class="hascolor"';}
							?>
								
								<li <?php echo $hascolor; ?>>
									<input type="checkbox" class="huge-it-post-checked"  value="<?php echo $rowspostspop[0]->ID; ?>">
									<div class="huge-it-posts-list-image"><?php echo get_the_post_thumbnail($rowspostspop[0]->ID, 'thumbnail'); ?></div>
									<div class="huge-it-posts-list-title"><?php echo $rowspostspop[0]->post_title;	?></div>
									<div class="huge-it-posts-list-description"><?php echo	$rowspostspop[0]->post_content;	?></div>
									<div class="huge-it-posts-list-link"><?php echo	$rowspostspop[0]->guid; ?></div>
									<div class="huge-it-posts-list-category"><?php echo	$cat->slug;	?></div>
								</li>
							<?php }
								}	?>
						</ul>
						<input id="huge-it-add-posts-params" type="hidden" name="popupposts" value="" />
						<div class="clear"></div>
						<button class='save-video_player-options button-primary huge-it-insert-post-button' id='huge-it-insert-post-button-bottom'>Insert Posts</button>
						</form>
						
					</div>
				</div>		
	<?php
}
?>
<?php
function html_video_player_video(){
	global $wpdb;

?>
	<style>
		html.wp-toolbar {
			padding:0px !important;
		}
		#wpadminbar,#adminmenuback,#screen-meta, .update-nag,#dolly {
			display:none;
		}
		#wpbody-content {
			padding-bottom:30px;
		}
		#adminmenuwrap {display:none !important;}
		.auto-fold #wpcontent, .auto-fold #wpfooter {
			margin-left: 0px;
		}
		#wpfooter {display:none;}
		iframe {height:250px !important;}
		#TB_window {height:250px !important;}
	</style>
	<script type="text/javascript">
		jQuery(document).ready(function() {			
		
		jQuery('.huge-it-insert-video-button').click(function(){				
				jQuery('.huge-it-insert-post-button').on('click', function() {
				var ID1 = jQuery('#huge_it_add_video_input').val();
				if(ID1==""){alert("Please copy and past url form Youtobe or Vimeo to insert into slider.");return false;}
				
				window.parent.uploadID.val(ID1);
				
				tb_remove();
				jQuery("#save-buttom").click();
			});

			jQuery('#huge_it_add_video_input').change(function(){
				
				if (jQuery(this).val().indexOf("youtube") >= 0){
					jQuery('#add-video-popup-options > div').removeClass('active');
					jQuery('#add-video-popup-options  .youtube').addClass('active');
				}else if (jQuery(this).val().indexOf("vimeo") >= 0){
					jQuery('#add-video-popup-options > div').removeClass('active');
					jQuery('#add-video-popup-options  .vimeo').addClass('active');
				}else {
					jQuery('#add-video-popup-options > div').removeClass('active');
					jQuery('#add-video-popup-options  .error-message').addClass('active');
				}
			})	
				});
					<?php	
			if(isset($_GET["closepop"])){
			if($_GET["closepop"] == 1){ ?>
					jQuery("#closepopup").click();
					self.parent.location.reload();
			<?php	}	} ?>
			jQuery('.updated').css({"display":"none"});
			
			jQuery("#huge_it_add_video_input").on("change keyup",function(){
				var url=jQuery(this).val();
				var data={
					action:"video_player_ajax",
					task:"get_video_meta_from_url",
					url:url,
				}
				jQuery.post('<?php echo admin_url( 'admin-ajax.php' ); ?>',data,function(response){
					if(response.success){
						jQuery("#show_title").val(response.title);
						jQuery("#show_description").val(response.image_url);
						if(jQuery("#add-video-popup-options .thumb_block").length){
							jQuery("#add-video-popup-options .thumb_block").remove();
							jQuery("#add-video-popup-options").append("<div class='thumb_block'><img class='"+response.type+"' src='"+response.image_url+"' alt='"+response.title+"' /><div class='"+response.type+"_play'></div></div>");
						}else{
							jQuery("#add-video-popup-options").append("<div class='thumb_block'><img class='"+response.type+"' src='"+response.image_url+"' alt='"+response.title+"' /><div class='"+response.type+"_play'></div></div>");
						}
					}else{
						if(response.fail){
							//do nothing
						}
					}
				},"json");
			});
		});
	</script>
	<a id="closepopup"  onclick=" parent.eval('tb_remove()')" style="display:none;"> [X] </a>

	<div id="huge_it_slider_add_videos">
		<div id="huge_it_slider_add_videos_wrap">
			<h2>Add Video From Url (Youtube/Vimeo Or Custom Video)</h2>
			<div class="control-panel">
				<form method="post" action="admin.php?page=video_players_huge_it_video_player&task=video_player_video&id=<?php echo $_GET['id']; ?>&closepop=1" >
					<input type="text" id="huge_it_add_video_input" name="show_video_url_1" placeholder="http://" />
					<button class='save-slider-options button-primary huge-it-insert-video-button' id='huge-it-insert-video-button'>Insert Video Url</button>
					<div id="add-video-popup-options">
						<div>
							<div>
								<label for="show_title">Title:</label>	
								<div>
									<input id="show_title" name="show_title" value="" type="text" />
								</div>
							</div>
							<div>
								<label for="show_video_url_2">Image Url:</label>
								<input type="text" id="show_description" name="show_video_image_url" />
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>	
	</div>
<?php
}
?>
<?php
function html_video_player_youtube(){
	global $wpdb;

?>
	<style>
		html.wp-toolbar {
			padding:0px !important;
		}
		#wpadminbar,#adminmenuback,#screen-meta, .update-nag,#dolly {
			display:none;
		}
		#wpbody-content {
			padding-bottom:30px;
		}
		#adminmenuwrap {display:none !important;}
		.auto-fold #wpcontent, .auto-fold #wpfooter {
			margin-left: 0px;
		}
		#wpfooter {display:none;}
		iframe {height:250px !important;}
		#TB_window {height:250px !important;}
	</style>
	<script type="text/javascript">
		jQuery(document).ready(function() {			
		
		jQuery('.huge-it-insert-video-button').click(function(){	
				jQuery('.huge-it-insert-post-button').on('click', function() {
					var ID1 = jQuery('#huge_it_add_video_input').val();
					if(ID1==""){alert("Please copy and past url form Youtobe or Vimeo to insert into slider.");return false;}
					
					window.parent.uploadID.val(ID1);
					
					tb_remove();
					jQuery("#save-buttom").click();
				});

					jQuery('#huge_it_add_video_input').change(function(){
						
						if (jQuery(this).val().indexOf("youtube") >= 0){
							jQuery('#add-video-popup-options > div').removeClass('active');
							jQuery('#add-video-popup-options  .youtube').addClass('active');
						}else if (jQuery(this).val().indexOf("vimeo") >= 0){
							jQuery('#add-video-popup-options > div').removeClass('active');
							jQuery('#add-video-popup-options  .vimeo').addClass('active');
						}else {
							jQuery('#add-video-popup-options > div').removeClass('active');
							jQuery('#add-video-popup-options  .error-message').addClass('active');
						}
					})	
				});
					<?php	
			if(isset($_GET["closepop"])){
			if($_GET["closepop"] == 1){ ?>
					jQuery("#closepopup").click();
					self.parent.location.reload();
			<?php	}	} ?>
			jQuery('.updated').css({"display":"none"});
		});
	</script>
	<a id="closepopup"  onclick="parent.eval('tb_remove()')" style="display:none;">[X]</a>
	<div id="huge_it_slider_add_videos">
		<div id="huge_it_slider_add_videos_wrap">
			<h2>Add Youtube Video</h2>
			<div class="control-panel">
				<form method="post" action="admin.php?page=video_players_huge_it_video_player&task=video_player_youtube&id=<?php echo $_GET['id']; ?>&closepop=1" >
					<input type="text" id="huge_it_add_video_input" name="show_video_url_1" />
					<button class='save-slider-options button-primary huge-it-insert-video-button' id='huge-it-insert-video-button'>Insert Video Url</button>
					<div id="add-video-popup-options">
						<div>
							<div>
								<label for="show_title">Title:</label>	
								<div>
									<input name="show_title" value="" type="text" />
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>	
	</div>
<?php
}

function html_video_player_vimeo(){
	global $wpdb;

?>
	<style>
		html.wp-toolbar {
			padding:0px !important;
		}
		#wpadminbar,#adminmenuback,#screen-meta, .update-nag,#dolly {
			display:none;
		}
		#wpbody-content {
			padding-bottom:30px;
		}
		#adminmenuwrap {display:none !important;}
		.auto-fold #wpcontent, .auto-fold #wpfooter {
			margin-left: 0px;
		}
		#wpfooter {display:none;}
		iframe {height:250px !important;}
		#TB_window {height:250px !important;}
	</style>
	<script type="text/javascript">
		jQuery(document).ready(function() {			
		
		jQuery('.huge-it-insert-video-button').click(function(){	
				jQuery('.huge-it-insert-post-button').on('click', function() {
					var ID1 = jQuery('#huge_it_add_video_input').val();
					if(ID1==""){alert("Please copy and past url form Youtobe or Vimeo to insert into slider.");return false;}
					
					window.parent.uploadID.val(ID1);
					
					tb_remove();
					jQuery("#save-buttom").click();
				});

					jQuery('#huge_it_add_video_input').change(function(){
						
						if (jQuery(this).val().indexOf("youtube") >= 0){
							jQuery('#add-video-popup-options > div').removeClass('active');
							jQuery('#add-video-popup-options  .youtube').addClass('active');
						}else if (jQuery(this).val().indexOf("vimeo") >= 0){
							jQuery('#add-video-popup-options > div').removeClass('active');
							jQuery('#add-video-popup-options  .vimeo').addClass('active');
						}else {
							jQuery('#add-video-popup-options > div').removeClass('active');
							jQuery('#add-video-popup-options  .error-message').addClass('active');
						}
					})	
				});
					<?php	
			if(isset($_GET["closepop"])){
			if($_GET["closepop"] == 1){ ?>
					jQuery("#closepopup").click();
					self.parent.location.reload();
			<?php	}	} ?>
			jQuery('.updated').css({"display":"none"});
		});
	</script>
	<a id="closepopup"  onclick="parent.eval('tb_remove()')" style="display:none;">[X]</a>
	<div id="huge_it_slider_add_videos">
		<div id="huge_it_slider_add_videos_wrap">
			<h2>Add Vimeo Video</h2>
			<div class="control-panel">
				<form method="post" action="admin.php?page=video_players_huge_it_video_player&task=video_player_vimeo&id=<?php echo $_GET['id']; ?>&closepop=1" >
					<input type="text" id="huge_it_add_video_input" name="show_video_url_1" />
					<button class='save-slider-options button-primary huge-it-insert-video-button' id='huge-it-insert-video-button'>Insert Video Url</button>
					<div id="add-video-popup-options">
						<div>
							<div>
								<label for="show_title">Title:</label>	
								<div>
									<input name="show_title" value="" type="text" />
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>	
	</div>
<?php
}

function html_video_player_upload(){
	global $wpdb;
	?>
	<style>
		html.wp-toolbar {
			padding:0px !important;
		}
		#wpadminbar,#adminmenuback,#screen-meta, .update-nag,#dolly {
			display:none;
		}
		#wpbody-content {
			padding-bottom:30px;
		}
		#adminmenuwrap {display:none !important;}
		.auto-fold #wpcontent, .auto-fold #wpfooter {
			margin-left: 0px;
		}
		#wpfooter {display:none;}
		iframe {height:250px !important;}
		#TB_window {height:250px !important;}
	</style>
	<script type="text/javascript">
		jQuery(document).ready(function() {			
		
		jQuery('.huge-it-insert-video-button').click(function(){	
				jQuery('.huge-it-insert-post-button').on('click', function() {
					var ID1 = jQuery('#huge_it_add_video_input').val();
					if(ID1==""){alert("Please copy and past url form Youtobe or Vimeo to insert into slider.");return false;}
					
					window.parent.uploadID.val(ID1);
					
					tb_remove();
					jQuery("#save-buttom").click();
				});

					/*jQuery('#huge_it_add_video_input').change(function(){
						
						if (jQuery(this).val().indexOf("youtube") >= 0){
							jQuery('#add-video-popup-options > div').removeClass('active');
							jQuery('#add-video-popup-options  .youtube').addClass('active');
						}else if (jQuery(this).val().indexOf("vimeo") >= 0){
							jQuery('#add-video-popup-options > div').removeClass('active');
							jQuery('#add-video-popup-options  .vimeo').addClass('active');
						}else {
							jQuery('#add-video-popup-options > div').removeClass('active');
							jQuery('#add-video-popup-options  .error-message').addClass('active');
						}
					})	*/
				});
					<?php	
			if(isset($_GET["closepop"])){
			if($_GET["closepop"] == 1){ ?>
					jQuery("#closepopup").click();
					self.parent.location.reload();
			<?php	}	} ?>
			jQuery('.updated').css({"display":"none"});
		});
	</script>
	<script>
	jQuery(document).ready(function($){
	  var _custom_media = true,
		  _orig_send_attachment = wp.media.editor.send.attachment;
		 

	  jQuery('#huge_it_add_video_input').click(function(e) {
		var send_attachment_bkp = wp.media.editor.send.attachment;
		
		var button = jQuery(this);
		//var id = button.attr('id').replace('_button', '');
		_custom_media = true;

		//jQuery("#"+id).val('');
		wp.media.editor.send.attachment = function(props, attachment){
		  if ( _custom_media ) {
			console.log(attachment);
			jQuery("#show_title").val(attachment.title);
			jQuery("#show_video_url_1").val(attachment.url);
		  } else {
			return _orig_send_attachment.apply( this, [props, attachment] );
		  };
		}
	  
		wp.media.editor.open(button);
		 
		return false;
	  });

	  jQuery('.add_media').on('click', function(){
		_custom_media = false;
		
	  });
		/*jQuery(".wp-media-buttons-icon").click(function() {
			jQuery(".media-menu-item").css("display","none");
			jQuery(".media-menu-item:first").css("display","block");
			jQuery(".separator").next().css("display","block");
			jQuery('.attachment-filters').val('image').trigger('change');
			jQuery(".attachment-filters").css("display","none");
		});*/
	});
	</script>
	<a id="closepopup"  onclick="parent.eval('tb_remove()')" style="display:none;">[X]</a>
	<div id="huge_it_slider_add_videos">
		<div id="huge_it_slider_add_videos_wrap">
			<h2>Upload Video</h2>
			<div class="control-panel">
				<form method="post" action="admin.php?page=video_players_huge_it_video_player&task=video_player_upload&id=<?php echo $_GET['id']; ?>&closepop=1" >
					<input type="button" class="button" id="huge_it_add_video_input" name="show_video_url_12" value="Upload Video" />
					<input type="hidden" id="show_video_url_1" name="show_video_url_1" value="" />
					<button class='save-slider-options button-primary huge-it-insert-video-button' id='huge-it-insert-video-button'>Insert Video Url</button>
					<div id="add-video-popup-options">
						<div>
							<div>
								<label for="show_title">Title:</label>	
								<div>
									<input name="show_title" id="show_title" value="" type="text" />
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>	
	</div>
	<?php
}