<?php
	$operations = new RevOperations();
	
	//set Slide settings
	$arrTransitions = $operations->getArrTransition();
	
	$slideSettings = new UniteSettingsAdvancedRev();
	
	//transition
	$params = array("description"=>"The appearance transition of this slide.");
	$slideSettings->addSelect("slide_transition",$arrTransitions,"Transition","random",$params);
		
	//slot amount
	$params = array("description"=>"The number of slots or boxes the slide is divided into. If you use boxfade, over 7 slots can be juggy."
		,"class"=>"small"
	);	
	$slideSettings->addTextBox("slot_amount","7","Slot Amount", $params);
	
	//rotation:
	$params = array("description"=>"Rotation (-720 -> 720, 999 = random) Only for Simple Transitions."
		,"class"=>"small"
	);
	$slideSettings->addTextBox("transition_rotation","0","Rotation", $params);
	
	//transition speed
	$params = array("description"=>"The duration of the transition (Default:300, min: 100 max 2000). "
		,"class"=>"small"
	);
	$slideSettings->addTextBox("transition_duration","300","Transition Duration", $params);		
	
	//delay
	$params = array("description"=>"A new Dealy value for the Slide. If no delay defined per slide, the dealy defined via Options will be used"
		,"class"=>"small"
	);
	$slideSettings->addTextBox("delay","","Delay", $params);
	
	//-----------------------
	
	//enable link
	$slideSettings->addSelect_boolean("enable_link", "Enable Link", false, "Enable","Disable");

	//link	
	$params = array("description"=>"A link on the whole slide pic");
	$slideSettings->addTextBox("link","","Slide Link", $params);
	
	//link target
	$params = array("description"=>"The target of the slide link");
	$slideSettings->addSelect("link_open_in",array("same"=>"Same Window","new"=>"New Window"),"Link Open In","same",$params);

	$slideSettings->addControl("enable_link", "link", UniteSettingsRev::CONTROL_TYPE_SHOW, "true");
	$slideSettings->addControl("enable_link", "link_open_in", UniteSettingsRev::CONTROL_TYPE_SHOW, "true");
	
	//-----------------------
	
	//enable video
	$params = array("description"=>"Put a full width video on the slide");
	$slideSettings->addSelect_boolean("enable_video", "Enable Full Width Video", false, "Enable","Disable");
	
	//video id	
	$params = array("description"=>"The field can take Youtube ID (example: QohUdrgbD2k) or Vidmeo ID (example: 30300114)",
					"class"=>"medium");
	$slideSettings->addTextBox("video_id","","Video ID", $params);

	//video autoplay
	$params = array("description"=>"Enable video autoplay on enter slide",
					"class"=>"medium");
	$slideSettings->addCheckbox("video_autoplay", false,"Video Autoplay");

	$slideSettings->addControl("enable_video", "video_id", UniteSettingsRev::CONTROL_TYPE_SHOW, "true");
	$slideSettings->addControl("enable_video", "video_autoplay", UniteSettingsRev::CONTROL_TYPE_SHOW, "true");
	
	//store settings
	self::storeSettings("slide_settings",$slideSettings);

?>
