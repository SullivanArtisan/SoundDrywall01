	<!-- row 1 -->
	<div class="row">
		<div class="col"><label class="col-form-label">Invoice Period:&nbsp;</label></div>
		<div class="col">
			<?php
				$tagHead = "<input list=\"cstm_invoice_period\" name=\"cstm_invoice_period\" id=\"cstmInvoicePeriodInput\" class=\"form-control mt-1 my-text-height\" ";
				$tagTail = "><datalist id=\"cstm_invoice_period\">";
				$tagTail.= "<option value=\"Weekly\">";
				$tagTail.= "<option value=\"Fortnightly\">";
				$tagTail.= "<option value=\"Monthly\">";
				$tagTail.= "<option value=\"Daily\">";
				$tagTail.= "<option value=\"No Invoice\">";
				$tagTail.= "<option value=\"All\">";
				$tagTail.= "</datalist>";
				if(isset($dbTable)) {
					echo $tagHead."placeholder=\"".$dbTable->cstm_invoice_period."\" value=\"".$dbTable->cstm_invoice_period."\"".$tagTail;
				} else {
					echo $tagHead."placeholder=\"Weekly\" value=\"Weekly\"".$tagTail;
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">Invoice Email 1:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"cstm_invoice_email_addr1\" name=\"cstm_invoice_email_addr1\" value=\"".$dbTable->cstm_invoice_email_addr1."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"cstm_invoice_email_addr1\" name=\"cstm_invoice_email_addr1\">";
				}
			?>
		</div>
	</div>
	
	<!-- row 2 -->
	<div class="row">
		<div class="col"><label class="col-form-label">Invoice Layout:&nbsp;</label></div>
		<div class="col">
			<?php
				$tagHead = "<input list=\"cstm_invoice_layout\" name=\"cstm_invoice_layout\" id=\"cstmInvoiceLayoutInput\" class=\"form-control mt-1 my-text-height\" ";
				$tagTail = "><datalist id=\"cstm_invoice_layout\">";
				$tagTail.= "<option value=\"Normal\">";
				$tagTail.= "<option value=\"One Invoice per Reference\">";
				$tagTail.= "<option value=\"Once Invoice per Job\">";
				$tagTail.= "<option value=\"One Invoice per Day\">";
				$tagTail.= "</datalist>";
				if(isset($dbTable)) {
					echo $tagHead."placeholder=\"".$dbTable->cstm_invoice_layout."\" value=\"".$dbTable->cstm_invoice_layout."\"".$tagTail;
				} else {
					echo $tagHead."placeholder=\"Once Invoice per Job\" value=\"Once Invoice per Job\"".$tagTail;
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">Invoice Email 2:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"cstm_invoice_email_addr2\" name=\"cstm_invoice_email_addr2\" value=\"".$dbTable->cstm_invoice_email_addr2."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"cstm_invoice_email_addr2\" name=\"cstm_invoice_email_addr2\">";
				}
			?>
		</div>
	</div>
	
	<!-- row 3 -->
	<div class="row">
		<div class="col"><label class="col-form-label">Invoice Stytle:&nbsp;</label></div>
		<div class="col">
			<?php
				$tagHead = "<input list=\"cstm_invoice_style\" name=\"cstm_invoice_style\" id=\"cstmInvoiceStyle\" class=\"form-control mt-1 my-text-height\" ";
				$tagTail = "><datalist id=\"cstm_invoice_style\">";
				$tagTail.= "<option value=\"HLCSinvoice\">";
				$tagTail.= "<option value=\"HLCSinvoice Acorn\">";
				$tagTail.= "</datalist>";
				if(isset($dbTable)) {
					echo $tagHead."placeholder=\"".$dbTable->cstm_invoice_style."\" value=\"".$dbTable->cstm_invoice_style."\"".$tagTail;
				} else {
					echo $tagHead."placeholder=\"HLCSinvoice\" value=\"HLCSinvoice\"".$tagTail;
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">Invoice Email 3:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"cstm_invoice_email_addr3\" name=\"cstm_invoice_email_addr3\" value=\"".$dbTable->cstm_invoice_email_addr3."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"cstm_invoice_email_addr3\" name=\"cstm_invoice_email_addr3\">";
				}
			?>
		</div>
	</div>
	
	<!-- row 4 -->
	<div class="row">
		<div class="col"><label class="col-form-label">PDF Invoice Stytle:&nbsp;</label></div>
		<div class="col">
			<?php
				$tagHead = "<input list=\"cstm_invoice_pdf_style\" name=\"cstm_invoice_pdf_style\" id=\"cstmInvoicePdfStyleInput\" class=\"form-control mt-1 my-text-height\" ";
				$tagTail = "><datalist id=\"cstm_invoice_pdf_style\">";
				$tagTail.= "<option value=\"HLCSinvoice\">";
				$tagTail.= "<option value=\"HLCSinvoice Acorn\">";
				$tagTail.= "</datalist>";
				if(isset($dbTable)) {
					echo $tagHead."placeholder=\"".$dbTable->cstm_invoice_pdf_style."\" value=\"".$dbTable->cstm_invoice_pdf_style."\"".$tagTail;
				} else {
					echo $tagHead."placeholder=\"HLCSinvoice\" value=\"HLCSinvoice\"".$tagTail;
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">Invoice Email 4:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"cstm_invoice_email_addr4\" name=\"cstm_invoice_email_addr4\" value=\"".$dbTable->cstm_invoice_email_addr4."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"cstm_invoice_email_addr4\" name=\"cstm_invoice_email_addr4\">";
				}
			?>
		</div>
	</div>
	
	<!-- row 5 -->
	<div class="row">
		<div class="col"><label class="col-form-label">Local Office:&nbsp;</label></div>
		<div class="col">
			<?php
				$tagHead = "<input list=\"cstm_invoice_local_office\" name=\"cstm_invoice_local_office\" id=\"cstmInvoiceLocalOfficeInput\" class=\"form-control mt-1 my-text-height\" ";
				$tagTail = "><datalist id=\"cstm_invoice_local_office\">";
				$tagTail.= "<option value=\"HL\">";
				$tagTail.= "</datalist>";
				if(isset($dbTable)) {
					echo $tagHead."placeholder=\"".$dbTable->cstm_invoice_local_office."\" value=\"".$dbTable->cstm_invoice_local_office."\"".$tagTail;
				} else {
					echo $tagHead."placeholder=\"HL\" value=\"HL\"".$tagTail;
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">Invoice Email 5:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"cstm_invoice_email_addr5\" name=\"cstm_invoice_email_addr5\" value=\"".$dbTable->cstm_invoice_email_addr5."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"cstm_invoice_email_addr5\" name=\"cstm_invoice_email_addr5\">";
				}
			?>
		</div>
	</div>
	
	<!-- row 6 -->
	<div class="row">
		<div class="col"><label class="col-form-label">Account Status:&nbsp;</label></div>
		<div class="col">
			<?php
				$tagHead = "<input list=\"cstm_invoice_account_status\" name=\"cstm_invoice_account_status\" id=\"cstmInvoiceAccountStatusInput\" class=\"form-control mt-1 my-text-height\" ";
				$tagTail = "><datalist id=\"cstm_invoice_account_status\">";
				$tagTail.= "<option value=\"Clear\">";
				$tagTail.= "<option value=\"On Stop\">";
				$tagTail.= "<option value=\"Pending\">";
				$tagTail.= "</datalist>";
				if(isset($dbTable)) {
					echo $tagHead."placeholder=\"".$dbTable->cstm_invoice_account_status."\" value=\"".$dbTable->cstm_invoice_account_status."\"".$tagTail;
				} else {
					echo $tagHead."placeholder=\"Pending\" value=\"Pending\"".$tagTail;
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">Invoice Email 6:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"cstm_invoice_email_addr6\" name=\"cstm_invoice_email_addr6\" value=\"".$dbTable->cstm_invoice_email_addr6."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"cstm_invoice_email_addr6\" name=\"cstm_invoice_email_addr6\">";
				}
			?>
		</div>
	</div>
	
	<!-- row 7 -->
	<div class="row">
		<div class="col"><label class="col-form-label">Payment Terms:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"number\" id=\"cstm_invoice_payment_terms\" name=\"cstm_invoice_payment_terms\" value=\"".$dbTable->cstm_invoice_payment_terms."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"number\" id=\"cstm_invoice_payment_terms\" name=\"cstm_invoice_payment_terms\" value=\"0\">";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">Attachments Needed:&nbsp;</label></div>
		<div class="col">
			<?php
				$tagHead = "<input list=\"cstm_invoice_attachments_needed\" name=\"cstm_invoice_attachments_needed\" id=\"cstmInvoiceAttachmentsNeededInput\" class=\"form-control mt-1 my-text-height\" ";
				$tagTail = "><datalist id=\"cstm_invoice_attachments_needed\">";
				$tagTail.= "<option value=\"0\">";
				$tagTail.= "<option value=\"1\">";
				$tagTail.= "<option value=\"2\">";
				$tagTail.= "<option value=\"3\">";
				$tagTail.= "<option value=\"4\">";
				$tagTail.= "<option value=\"5\">";
				$tagTail.= "<option value=\"6\">";
				$tagTail.= "<option value=\"7\">";
				$tagTail.= "<option value=\"8\">";
				$tagTail.= "<option value=\"9\">";
				$tagTail.= "<option value=\"10\">";
				$tagTail.= "</datalist>";
				if(isset($dbTable)) {
					echo $tagHead."placeholder=\"".$dbTable->cstm_invoice_attachments_needed."\" value=\"".$dbTable->cstm_invoice_attachments_needed."\"".$tagTail;
				} else {
					echo $tagHead."placeholder=\"0\" value=\"0\"".$tagTail;
				}
			?>
		</div>
	</div>
	
	<!-- row 8 -->
	<div class="row">
		<div class="col"><label class="col-form-label">Credit Limit:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"number\" id=\"cstm_invoice_credit_limit\" name=\"cstm_invoice_credit_limit\" value=\"".$dbTable->cstm_invoice_credit_limit."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"number\" id=\"cstm_invoice_credit_limit\" name=\"cstm_invoice_credit_limit\" value=\"0.0\">";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">Invoice Currency:&nbsp;</label></div>
		<div class="col">
			<?php
				$tagHead = "<input list=\"cstm_invoice_currency\" name=\"cstm_invoice_currency\" id=\"cstmInvoiceCurrencyInput\" class=\"form-control mt-1 my-text-height\" ";
				$tagTail = "><datalist id=\"cstm_invoice_currency\">";
				$tagTail.= "<option value=\"CAD\">";
				$tagTail.= "<option value=\"USD\">";
				$tagTail.= "</datalist>";
				if(isset($dbTable)) {
					echo $tagHead."placeholder=\"".$dbTable->cstm_invoice_currency."\" value=\"".$dbTable->cstm_invoice_currency."\"".$tagTail;
				} else {
					echo $tagHead."placeholder=\"CAD\" value=\"CAD\"".$tagTail;
				}
			?>
		</div>
	</div>
	
	<!-- row 9 -->
	<div class="row">
		<div class="col"><label class="col-form-label">POD Required for Invoices:&nbsp;</label></div>
		<div class="col">
			<?php
				$tagHead = "<input style=\"margin-top:3%\" type=\"checkbox\" id=\"cstm_invoice_requires_pod\" name=\"cstm_invoice_requires_pod\" ";
				$tagTail = ">";
				if(isset($dbTable)) {
					if($dbTable->cstm_invoice_requires_pod) {
						echo $tagHead."checked".$tagTail;
					} else {
						echo $tagHead.$tagTail;
					}
				} else {
					echo $tagHead.$tagTail;
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">Invoice by Group Only:&nbsp;</label></div>
		<div class="col">
			<?php
				$tagHead = "<input style=\"margin-top:3%\" type=\"checkbox\" id=\"cstm_invoice_by_group_only\" name=\"cstm_invoice_by_group_only\" ";
				$tagTail = ">";
				if(isset($dbTable)) {
					if($dbTable->cstm_invoice_by_group_only) {
						echo $tagHead."checked".$tagTail;
					} else {
						echo $tagHead.$tagTail;
					}
				} else {
					echo $tagHead.$tagTail;
				}
			?>
		</div>
	</div>
	
	<!-- row 10 -->
	<div class="row">
		<div class="col"><label class="col-form-label">Tax:&nbsp;</label></div>
		<div class="col">
			<?php
				$tagHead = "<input style=\"margin-top:3%\" type=\"checkbox\" id=\"cstm_invoice_tax\" name=\"cstm_invoice_tax\" ";
				$tagTail = ">";
				if(isset($dbTable)) {
					if($dbTable->cstm_invoice_tax) {
						echo $tagHead."checked".$tagTail;
					} else {
						echo $tagHead.$tagTail;
					}
				} else {
					echo $tagHead.$tagTail;
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">No Bridge Toll:&nbsp;</label></div>
		<div class="col">
			<?php
				$tagHead = "<input style=\"margin-top:3%\" type=\"checkbox\" id=\"cstm_invoice_no_bridge_toll\" name=\"cstm_invoice_no_bridge_toll\" ";
				$tagTail = ">";
				if(isset($dbTable)) {
					if($dbTable->cstm_invoice_no_bridge_toll) {
						echo $tagHead."checked".$tagTail;
					} else {
						echo $tagHead.$tagTail;
					}
				} else {
					echo $tagHead.$tagTail;
				}
			?>
		</div>
	</div>
	
	<!-- row 11 -->
	<div class="row">
		<div class="col"><label class="col-form-label">Email Invoices (PDF Format):&nbsp;</label></div>
		<div class="col">
			<?php
				$tagHead = "<input style=\"margin-top:3%\" type=\"checkbox\" id=\"cstm_invoice_email_in_pdf_fmt\" name=\"cstm_invoice_email_in_pdf_fmt\" ";
				$tagTail = ">";
				if(isset($dbTable)) {
					if($dbTable->cstm_invoice_email_in_pdf_fmt) {
						echo $tagHead."checked".$tagTail;
					} else {
						echo $tagHead.$tagTail;
					}
				} else {
					echo $tagHead."checked".$tagTail;
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">Include in Print Run:&nbsp;</label></div>
		<div class="col">
			<?php
				$tagHead = "<input style=\"margin-top:3%\" type=\"checkbox\" id=\"cstm_invoice_include_in_print_run\" name=\"cstm_invoice_include_in_print_run\" ";
				$tagTail = ">";
				if(isset($dbTable)) {
					if($dbTable->cstm_invoice_include_in_print_run) {
						echo $tagHead."checked".$tagTail;
					} else {
						echo $tagHead.$tagTail;
					}
				} else {
					echo $tagHead.$tagTail;
				}
			?>
		</div>
	</div>
	
	<!-- row 12 -->
	<div class="row">
		<div class="col"><label class="col-form-label">Additional Invoice Email Address:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<textarea class=\"form-control mt-1\" rows=\"15\" id=\"cstm_invoice_additional_email_addr\" name=\"cstm_invoice_additional_email_addr\" >".$dbTable->cstm_invoice_additional_email_addr."</textarea>";
				} else {
					echo "<textarea class=\"form-control mt-1\" rows=\"15\" id=\"cstm_invoice_additional_email_addr\" name=\"cstm_invoice_additional_email_addr\"></textarea>";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">FSC Email:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<textarea class=\"form-control mt-1\" rows=\"15\" id=\"cstm_invoice_fsc_email_addr\" name=\"cstm_invoice_fsc_email_addr\">".$dbTable->cstm_invoice_fsc_email_addr."</textarea>";
				} else {
					echo "<textarea class=\"form-control mt-1\" rows=\"15\" id=\"cstm_invoice_fsc_email_addr\" name=\"cstm_invoice_fsc_email_addr\"></textarea>";
				}
			?>
		</div>
	</div>
	
	<!-- row 13 -->
	<div class="row">
		<div class="col"><label class="col-form-label">Account Opened:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1\" type=\"date\" id=\"cstm_invoice_account_opened\" name=\"cstm_invoice_account_opened\" value=\"".$dbTable->cstm_invoice_account_opened."\">";
				} else {
					echo "<input class=\"form-control mt-1\" type=\"date\" id=\"cstm_invoice_account_opened\" name=\"cstm_invoice_account_opened\" value=\"<?php echo date('Y-m-d'); ?>\">";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">Mark Account as Deleted:&nbsp;</label></div>
		<div class="col">
			<?php
				$tagHead = "<input style=\"margin-top:3%\" type=\"checkbox\" id=\"cstm_invoice_deleted\" name=\"cstm_invoice_deleted\" ";
				$tagTail = ">";
				if(isset($dbTable)) {
					if($dbTable->cstm_invoice_deleted) {
						echo $tagHead."checked".$tagTail;
					} else {
						echo $tagHead.$tagTail;
					}
				} else {
					echo $tagHead.$tagTail;
				}
			?>
		</div>
	</div>
