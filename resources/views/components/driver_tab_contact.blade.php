<?php
    if (Session::get('uploadPath')) {
        $picPath = Session::get('uploadPath');
        Session::forget(['uploadPath']);
    } else {
		$picPath = "";
		if(isset($dbTable)) {
        	$picPath = $dbTable->dvr_picture_file;
		}
    }
?>

	<div class="row">
		<div class="col"><label class="col-form-label">PowerUnit No. 1:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_pwr_unit_no_1\" name=\"dvr_pwr_unit_no_1\" value=\"".$dbTable->dvr_pwr_unit_no_1."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_pwr_unit_no_1\" name=\"dvr_pwr_unit_no_1\">";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">PowerUnit No. 2:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_pwr_unit_no_2\" name=\"dvr_pwr_unit_no_2\" value=\"".$dbTable->dvr_pwr_unit_no_2."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_pwr_unit_no_2\" name=\"dvr_pwr_unit_no_2\">";
				}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Name:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_name\" name=\"dvr_name\" value=\"".$dbTable->dvr_name."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_name\" name=\"dvr_name\">";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">Driver No.:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_no\" name=\"dvr_no\" value=\"".$dbTable->dvr_no."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_no\" name=\"dvr_no\">";
				}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Address:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_address\" name=\"dvr_address\" value=\"".$dbTable->dvr_address."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_address\" name=\"dvr_address\">";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">City:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_city\" name=\"dvr_city\" value=\"".$dbTable->dvr_city."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_city\" name=\"dvr_city\">";
				}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Province:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_province\" name=\"dvr_province\" value=\"".$dbTable->dvr_province."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_province\" name=\"dvr_province\">";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">Postal Code:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_postcode\" name=\"dvr_postcode\" value=\"".$dbTable->dvr_postcode."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_postcode\" name=\"dvr_postcode\">";
				}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Country:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_country\" name=\"dvr_country\" value=\"".$dbTable->dvr_country."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_country\" name=\"dvr_country\">";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">Cell Phone:&nbsp;</label></div>
		<div class="col">
			<?php
                use App\Helper\MyHelper;

                if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_cell_phone\" name=\"dvr_cell_phone\" value=\"".MyHelper::GetHyphenedPhoneNo($dbTable->dvr_cell_phone)."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_cell_phone\" name=\"dvr_cell_phone\">";
				}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Home Phone:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_home_phone\" name=\"dvr_home_phone\" value=\"".MyHelper::GetHyphenedPhoneNo($dbTable->dvr_home_phone)."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_home_phone\" name=\"dvr_home_phone\">";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">Other Phone:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_other_phone\" name=\"dvr_other_phone\" value=\"".MyHelper::GetHyphenedPhoneNo($dbTable->dvr_other_phone)."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_other_phone\" name=\"dvr_other_phone\">";
				}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Email:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_email\" name=\"dvr_email\" value=\"".$dbTable->dvr_email."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_email\" name=\"dvr_email\">";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">Ops Code:&nbsp;</label></div>
		<div class="col">
			<?php
			if(isset($dbTable)) {
				$tagHead = "<input list=\"dvr_ops_code\" name=\"dvr_ops_code\" id=\"opsCodeInput\" class=\"form-control mt-1 my-text-height\" value=\"".$dbTable->dvr_ops_code."\" ";
			} else {
				$tagHead = "<input list=\"dvr_ops_code\" name=\"dvr_ops_code\" id=\"opsCodeInput\" class=\"form-control mt-1 my-text-height\" ";
			}
			$tagTail = "><datalist id=\"dvr_ops_code\">";

			$allTypes = MyHelper::GetAllOpsCodes();
			foreach($allTypes as $eachType) {
				$tagTail.= "<option value=".str_replace(' ', '&nbsp;', $eachType).">";
			}
			$tagTail.= "</datalist>";
			echo $tagHead."placeholder=\"\" value=\"\"".$tagTail;
			?>
		</div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Emergency Contact:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_emergency_contact\" name=\"dvr_emergency_contact\" value=\"".$dbTable->dvr_emergency_contact."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_emergency_contact\" name=\"dvr_emergency_contact\">";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">Emergency Phone No.:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_emergency_phone\" name=\"dvr_emergency_phone\" value=\"".MyHelper::GetHyphenedPhoneNo($dbTable->dvr_emergency_phone)."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_emergency_phone\" name=\"dvr_emergency_phone\">";
				}
			?>
		</div>
	</div>
	<div class="row">
        <div class="col" id="pic_holder"><label class="col-form-label">Picture File:&nbsp;</label></div>
        <?php
            if(isset($dbTable)) {   // A specific driver is selected ==> to modify its data
                $origin_pic_path_array = explode("/", $dbTable->picture_file);
                $wanted_pic_path = url('')."/";
                for ($i=1; $i<sizeof($origin_pic_path_array); $i++) {
                    $wanted_pic_path .= $origin_pic_path_array[$i];
                    if($i != sizeof($origin_pic_path_array)-1) {
                        $wanted_pic_path .= "/";
                    }
                }
            }
        ?>
        <div class="col">
            <div class="row">
                <?php
                if(isset($dbTable)) {   // A specific driver is selected ==> to modify its data
                    echo "<div class=\"col-9 pr-0\"><input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_picture_file\" name=\"dvr_picture_file\" value=\"$dbTable->dvr_picture_file\" onmouseover=\"showImage('dvr_picture_file', '".$wanted_pic_path."')\" onmouseout=\"hideImage('dvr_picture_file')\"></div>";
                    echo "<div class=\"col-3 pl-2\"><button class=\"btn btn-info btn-sm mt-1\" type=\"button\" onclick=\"KeepInput()\"><a href=\"".route('system_user_pic_upload', 'driverId='.$dbTable->id)."\">Browse</a></button></div>";
                } else {                // To add a new driver
                    echo "<div class=\"col-9 pr-0\"><input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_picture_file\" name=\"dvr_picture_file\"></div>";
                    echo "<div class=\"col-3 pl-2\"><button class=\"btn btn-info btn-sm mt-1\" type=\"button\" onclick=\"KeepInput()\"><a href=\"system_user_pic_upload&noDriverId=1\">Browse</a></button></div>";
                }
                ?>
            </div>
        </div>
        <div class="col"><label class="col-form-label" id="driver_image" style="display: none;">Image:</label></div>
        <div class="col"><input class="form-control mt-1" type="hidden"></div>
	</div>
		
    <script>
        (function() {
            if (document.getElementById("dvr_picture_file").value) {
                document.getElementById("driver_image").style.display = "block";
                var picPath = {!! json_encode($picPath) !!};
                const popImage = new Image();
                //alert(picPath);
                popImage.src = "./pic/1671825252_1670285560_image2.jpeg";				// this hard coded picture path can work
                // popImage.src = "https://test.nueco.ca/NuEco/1670434551_1670285560_image2.jpeg";	// need to be tested if it's stored under domain_root/storage/app/public
                popImage.style.display = "absolute";
                popImage.style.zIndex = "1";
                popImage.style.width = "200px";
                popImage.style.height = "250px";
                // elem.appendChild(popImage);										// for future optimization
                popImage.style.marginLeft = "20";
                document.getElementById("driver_image").appendChild(popImage);		// for now
            }
        })();

        function showImage(elemId, imgSrc) {
            /*
            const elem = document.getElementById(elemId);
            if (elem.value) {	
                var picPath = {!! json_encode($picPath) !!};
                const popImage = new Image();
                //alert(picPath);
                popImage.src = "./pic/1671825252_1670285560_image2.jpeg";				// this hard coded picture path can work
                // popImage.src = "https://test.nueco.ca/NuEco/1670434551_1670285560_image2.jpeg";	// need to be tested if it's stored under domain_root/storage/app/public
                popImage.style.display = "absolute";
                popImage.style.zIndex = "1";
                popImage.style.width = "200px";
                popImage.style.height = "250px";
                // elem.appendChild(popImage);										// for future optimization
                document.getElementById("pic_holder").appendChild(popImage);		// for now
            }
            */
        }	
        
        function hideImage(elemId) {
            /*
            const elem = document.getElementById(elemId);
            if (elem.value) {	
                // console.log("elemId is: " + elemId);
                while (elem.childElementCount > 0) {
                elem.removeChild(elem.lastChild);
                }
                while (document.getElementById("pic_holder").childElementCount > 0) {
                document.getElementById("pic_holder").removeChild(document.getElementById("pic_holder").lastChild);
                break;
                }
            }
            */
        }			
    </script>

    <script>
        var picPath = {!! json_encode($picPath) !!};
        document.getElementById('dvr_picture_file').value = picPath;
    </script>
