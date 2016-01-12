<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "nos_membersinfo.php" ?>
<?php include_once "nos_roster_admininfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$nos_members_edit = NULL; // Initialize page object first

class cnos_members_edit extends cnos_members {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{035BB177-6A34-4418-A6BD-DF1DD7A296CE}";

	// Table name
	var $TableName = 'nos_members';

	// Page object name
	var $PageObjName = 'nos_members_edit';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		global $UserTable, $UserTableConn;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (nos_members)
		if (!isset($GLOBALS["nos_members"]) || get_class($GLOBALS["nos_members"]) == "cnos_members") {
			$GLOBALS["nos_members"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["nos_members"];
		}

		// Table object (nos_roster_admin)
		if (!isset($GLOBALS['nos_roster_admin'])) $GLOBALS['nos_roster_admin'] = new cnos_roster_admin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'nos_members', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// User table object (nos_roster_admin)
		if (!isset($UserTable)) {
			$UserTable = new cnos_roster_admin();
			$UserTableConn = Conn($UserTable->DBID);
		}
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->IsLoggedIn()) $this->Page_Terminate(ew_GetUrl("login.php"));

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $nos_members;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($nos_members);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		 // Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $DbMasterFilter;
	var $DbDetailFilter;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Load key from QueryString
		if (@$_GET["memberID"] <> "") {
			$this->memberID->setQueryStringValue($_GET["memberID"]);
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->memberID->CurrentValue == "")
			$this->Page_Terminate("nos_memberslist.php"); // Invalid key, return to list

		// Validate form if post back
		if (@$_POST["a_edit"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("nos_memberslist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->GetViewUrl();
				if (ew_GetPageName($sReturnUrl) == "nos_memberslist.php")
					$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->name->FldIsDetailKey) {
			$this->name->setFormValue($objForm->GetValue("x_name"));
		}
		if (!$this->_email->FldIsDetailKey) {
			$this->_email->setFormValue($objForm->GetValue("x__email"));
		}
		if (!$this->joined->FldIsDetailKey) {
			$this->joined->setFormValue($objForm->GetValue("x_joined"));
		}
		if (!$this->facebook->FldIsDetailKey) {
			$this->facebook->setFormValue($objForm->GetValue("x_facebook"));
		}
		if (!$this->twitter->FldIsDetailKey) {
			$this->twitter->setFormValue($objForm->GetValue("x_twitter"));
		}
		if (!$this->twitch->FldIsDetailKey) {
			$this->twitch->setFormValue($objForm->GetValue("x_twitch"));
		}
		if (!$this->skype->FldIsDetailKey) {
			$this->skype->setFormValue($objForm->GetValue("x_skype"));
		}
		if (!$this->birthday->FldIsDetailKey) {
			$this->birthday->setFormValue($objForm->GetValue("x_birthday"));
			$this->birthday->CurrentValue = ew_UnFormatDateTime($this->birthday->CurrentValue, 5);
		}
		if (!$this->profession->FldIsDetailKey) {
			$this->profession->setFormValue($objForm->GetValue("x_profession"));
		}
		if (!$this->game_type->FldIsDetailKey) {
			$this->game_type->setFormValue($objForm->GetValue("x_game_type"));
		}
		if (!$this->division->FldIsDetailKey) {
			$this->division->setFormValue($objForm->GetValue("x_division"));
		}
		if (!$this->has_expansion->FldIsDetailKey) {
			$this->has_expansion->setFormValue($objForm->GetValue("x_has_expansion"));
		}
		if (!$this->notes->FldIsDetailKey) {
			$this->notes->setFormValue($objForm->GetValue("x_notes"));
		}
		if (!$this->memberID->FldIsDetailKey)
			$this->memberID->setFormValue($objForm->GetValue("x_memberID"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->memberID->CurrentValue = $this->memberID->FormValue;
		$this->name->CurrentValue = $this->name->FormValue;
		$this->_email->CurrentValue = $this->_email->FormValue;
		$this->joined->CurrentValue = $this->joined->FormValue;
		$this->facebook->CurrentValue = $this->facebook->FormValue;
		$this->twitter->CurrentValue = $this->twitter->FormValue;
		$this->twitch->CurrentValue = $this->twitch->FormValue;
		$this->skype->CurrentValue = $this->skype->FormValue;
		$this->birthday->CurrentValue = $this->birthday->FormValue;
		$this->birthday->CurrentValue = ew_UnFormatDateTime($this->birthday->CurrentValue, 5);
		$this->profession->CurrentValue = $this->profession->FormValue;
		$this->game_type->CurrentValue = $this->game_type->FormValue;
		$this->division->CurrentValue = $this->division->FormValue;
		$this->has_expansion->CurrentValue = $this->has_expansion->FormValue;
		$this->notes->CurrentValue = $this->notes->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->memberID->setDbValue($rs->fields('memberID'));
		$this->name->setDbValue($rs->fields('name'));
		$this->_email->setDbValue($rs->fields('email'));
		$this->joined->setDbValue($rs->fields('joined'));
		$this->facebook->setDbValue($rs->fields('facebook'));
		$this->twitter->setDbValue($rs->fields('twitter'));
		$this->twitch->setDbValue($rs->fields('twitch'));
		$this->skype->setDbValue($rs->fields('skype'));
		$this->birthday->setDbValue($rs->fields('birthday'));
		$this->profession->setDbValue($rs->fields('profession'));
		$this->game_type->setDbValue($rs->fields('game_type'));
		$this->division->setDbValue($rs->fields('division'));
		$this->has_expansion->setDbValue($rs->fields('has_expansion'));
		$this->notes->setDbValue($rs->fields('notes'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->memberID->DbValue = $row['memberID'];
		$this->name->DbValue = $row['name'];
		$this->_email->DbValue = $row['email'];
		$this->joined->DbValue = $row['joined'];
		$this->facebook->DbValue = $row['facebook'];
		$this->twitter->DbValue = $row['twitter'];
		$this->twitch->DbValue = $row['twitch'];
		$this->skype->DbValue = $row['skype'];
		$this->birthday->DbValue = $row['birthday'];
		$this->profession->DbValue = $row['profession'];
		$this->game_type->DbValue = $row['game_type'];
		$this->division->DbValue = $row['division'];
		$this->has_expansion->DbValue = $row['has_expansion'];
		$this->notes->DbValue = $row['notes'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// memberID
		// name
		// email
		// joined
		// facebook
		// twitter
		// twitch
		// skype
		// birthday
		// profession
		// game_type
		// division
		// has_expansion
		// notes

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// memberID
		$this->memberID->ViewValue = $this->memberID->CurrentValue;
		$this->memberID->ViewCustomAttributes = "";

		// name
		$this->name->ViewValue = $this->name->CurrentValue;
		$this->name->ViewCustomAttributes = "";

		// email
		$this->_email->ViewValue = $this->_email->CurrentValue;
		$this->_email->ViewCustomAttributes = "";

		// joined
		$this->joined->ViewValue = $this->joined->CurrentValue;
		$this->joined->ViewValue = ew_FormatDateTime($this->joined->ViewValue, undefined);
		$this->joined->ViewCustomAttributes = "";

		// facebook
		$this->facebook->ViewValue = $this->facebook->CurrentValue;
		$this->facebook->ViewCustomAttributes = "";

		// twitter
		$this->twitter->ViewValue = $this->twitter->CurrentValue;
		$this->twitter->ViewCustomAttributes = "";

		// twitch
		$this->twitch->ViewValue = $this->twitch->CurrentValue;
		$this->twitch->ViewCustomAttributes = "";

		// skype
		$this->skype->ViewValue = $this->skype->CurrentValue;
		$this->skype->ViewCustomAttributes = "";

		// birthday
		$this->birthday->ViewValue = $this->birthday->CurrentValue;
		$this->birthday->ViewValue = ew_FormatDateTime($this->birthday->ViewValue, 5);
		$this->birthday->ViewCustomAttributes = "";

		// profession
		if (strval($this->profession->CurrentValue) <> "") {
			$this->profession->ViewValue = "";
			$arwrk = explode(",", strval($this->profession->CurrentValue));
			$cnt = count($arwrk);
			for ($ari = 0; $ari < $cnt; $ari++) {
				$this->profession->ViewValue .= $this->profession->OptionCaption(trim($arwrk[$ari]));
				if ($ari < $cnt-1) $this->profession->ViewValue .= ew_ViewOptionSeparator($ari);
			}
		} else {
			$this->profession->ViewValue = NULL;
		}
		$this->profession->ViewCustomAttributes = "";

		// game_type
		if (strval($this->game_type->CurrentValue) <> "") {
			$this->game_type->ViewValue = "";
			$arwrk = explode(",", strval($this->game_type->CurrentValue));
			$cnt = count($arwrk);
			for ($ari = 0; $ari < $cnt; $ari++) {
				$this->game_type->ViewValue .= $this->game_type->OptionCaption(trim($arwrk[$ari]));
				if ($ari < $cnt-1) $this->game_type->ViewValue .= ew_ViewOptionSeparator($ari);
			}
		} else {
			$this->game_type->ViewValue = NULL;
		}
		$this->game_type->ViewCustomAttributes = "";

		// division
		if (strval($this->division->CurrentValue) <> "") {
			$this->division->ViewValue = "";
			$arwrk = explode(",", strval($this->division->CurrentValue));
			$cnt = count($arwrk);
			for ($ari = 0; $ari < $cnt; $ari++) {
				$this->division->ViewValue .= $this->division->OptionCaption(trim($arwrk[$ari]));
				if ($ari < $cnt-1) $this->division->ViewValue .= ew_ViewOptionSeparator($ari);
			}
		} else {
			$this->division->ViewValue = NULL;
		}
		$this->division->ViewCustomAttributes = "";

		// has_expansion
		if (strval($this->has_expansion->CurrentValue) <> "") {
			$this->has_expansion->ViewValue = $this->has_expansion->OptionCaption($this->has_expansion->CurrentValue);
		} else {
			$this->has_expansion->ViewValue = NULL;
		}
		$this->has_expansion->ViewCustomAttributes = "";

		// notes
		$this->notes->ViewValue = $this->notes->CurrentValue;
		$this->notes->ViewCustomAttributes = "";

			// name
			$this->name->LinkCustomAttributes = "";
			$this->name->HrefValue = "";
			$this->name->TooltipValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";
			$this->_email->TooltipValue = "";

			// joined
			$this->joined->LinkCustomAttributes = "";
			$this->joined->HrefValue = "";
			$this->joined->TooltipValue = "";

			// facebook
			$this->facebook->LinkCustomAttributes = "";
			if (!ew_Empty($this->facebook->CurrentValue)) {
				$this->facebook->HrefValue = ((!empty($this->facebook->ViewValue)) ? ew_RemoveHtml($this->facebook->ViewValue) : $this->facebook->CurrentValue); // Add prefix/suffix
				$this->facebook->LinkAttrs["target"] = "_blank"; // Add target
				if ($this->Export <> "") $this->facebook->HrefValue = ew_ConvertFullUrl($this->facebook->HrefValue);
			} else {
				$this->facebook->HrefValue = "";
			}
			$this->facebook->TooltipValue = "";

			// twitter
			$this->twitter->LinkCustomAttributes = "";
			if (!ew_Empty($this->twitter->CurrentValue)) {
				$this->twitter->HrefValue = ((!empty($this->twitter->ViewValue)) ? ew_RemoveHtml($this->twitter->ViewValue) : $this->twitter->CurrentValue); // Add prefix/suffix
				$this->twitter->LinkAttrs["target"] = "_blank"; // Add target
				if ($this->Export <> "") $this->twitter->HrefValue = ew_ConvertFullUrl($this->twitter->HrefValue);
			} else {
				$this->twitter->HrefValue = "";
			}
			$this->twitter->TooltipValue = "";

			// twitch
			$this->twitch->LinkCustomAttributes = "";
			if (!ew_Empty($this->twitch->CurrentValue)) {
				$this->twitch->HrefValue = ((!empty($this->twitch->ViewValue)) ? ew_RemoveHtml($this->twitch->ViewValue) : $this->twitch->CurrentValue); // Add prefix/suffix
				$this->twitch->LinkAttrs["target"] = "_blank"; // Add target
				if ($this->Export <> "") $this->twitch->HrefValue = ew_ConvertFullUrl($this->twitch->HrefValue);
			} else {
				$this->twitch->HrefValue = "";
			}
			$this->twitch->TooltipValue = "";

			// skype
			$this->skype->LinkCustomAttributes = "";
			$this->skype->HrefValue = "";
			$this->skype->TooltipValue = "";

			// birthday
			$this->birthday->LinkCustomAttributes = "";
			$this->birthday->HrefValue = "";
			$this->birthday->TooltipValue = "";

			// profession
			$this->profession->LinkCustomAttributes = "";
			$this->profession->HrefValue = "";
			$this->profession->TooltipValue = "";

			// game_type
			$this->game_type->LinkCustomAttributes = "";
			$this->game_type->HrefValue = "";
			$this->game_type->TooltipValue = "";

			// division
			$this->division->LinkCustomAttributes = "";
			$this->division->HrefValue = "";
			$this->division->TooltipValue = "";

			// has_expansion
			$this->has_expansion->LinkCustomAttributes = "";
			$this->has_expansion->HrefValue = "";
			$this->has_expansion->TooltipValue = "";

			// notes
			$this->notes->LinkCustomAttributes = "";
			if (!ew_Empty($this->notes->CurrentValue)) {
				$this->notes->HrefValue = ((!empty($this->notes->ViewValue)) ? ew_RemoveHtml($this->notes->ViewValue) : $this->notes->CurrentValue); // Add prefix/suffix
				$this->notes->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->notes->HrefValue = ew_ConvertFullUrl($this->notes->HrefValue);
			} else {
				$this->notes->HrefValue = "";
			}
			$this->notes->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// name
			$this->name->EditAttrs["class"] = "form-control";
			$this->name->EditCustomAttributes = "";
			$this->name->EditValue = ew_HtmlEncode($this->name->CurrentValue);
			$this->name->PlaceHolder = ew_RemoveHtml($this->name->FldCaption());

			// email
			$this->_email->EditAttrs["class"] = "form-control";
			$this->_email->EditCustomAttributes = "";
			$this->_email->EditValue = ew_HtmlEncode($this->_email->CurrentValue);
			$this->_email->PlaceHolder = ew_RemoveHtml($this->_email->FldCaption());

			// joined
			// facebook

			$this->facebook->EditAttrs["class"] = "form-control";
			$this->facebook->EditCustomAttributes = "";
			$this->facebook->EditValue = ew_HtmlEncode($this->facebook->CurrentValue);
			$this->facebook->PlaceHolder = ew_RemoveHtml($this->facebook->FldCaption());

			// twitter
			$this->twitter->EditAttrs["class"] = "form-control";
			$this->twitter->EditCustomAttributes = "";
			$this->twitter->EditValue = ew_HtmlEncode($this->twitter->CurrentValue);
			$this->twitter->PlaceHolder = ew_RemoveHtml($this->twitter->FldCaption());

			// twitch
			$this->twitch->EditAttrs["class"] = "form-control";
			$this->twitch->EditCustomAttributes = "";
			$this->twitch->EditValue = ew_HtmlEncode($this->twitch->CurrentValue);
			$this->twitch->PlaceHolder = ew_RemoveHtml($this->twitch->FldCaption());

			// skype
			$this->skype->EditAttrs["class"] = "form-control";
			$this->skype->EditCustomAttributes = "";
			$this->skype->EditValue = ew_HtmlEncode($this->skype->CurrentValue);
			$this->skype->PlaceHolder = ew_RemoveHtml($this->skype->FldCaption());

			// birthday
			$this->birthday->EditAttrs["class"] = "form-control";
			$this->birthday->EditCustomAttributes = "";
			$this->birthday->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->birthday->CurrentValue, 5));
			$this->birthday->PlaceHolder = ew_RemoveHtml($this->birthday->FldCaption());

			// profession
			$this->profession->EditAttrs["class"] = "form-control";
			$this->profession->EditCustomAttributes = "";
			$this->profession->EditValue = $this->profession->Options(FALSE);

			// game_type
			$this->game_type->EditCustomAttributes = "";
			$this->game_type->EditValue = $this->game_type->Options(FALSE);

			// division
			$this->division->EditCustomAttributes = "";
			$this->division->EditValue = $this->division->Options(FALSE);

			// has_expansion
			$this->has_expansion->EditCustomAttributes = "";
			$this->has_expansion->EditValue = $this->has_expansion->Options(TRUE);

			// notes
			$this->notes->EditAttrs["class"] = "form-control";
			$this->notes->EditCustomAttributes = "";
			$this->notes->EditValue = ew_HtmlEncode($this->notes->CurrentValue);
			$this->notes->PlaceHolder = ew_RemoveHtml($this->notes->FldCaption());

			// Edit refer script
			// name

			$this->name->LinkCustomAttributes = "";
			$this->name->HrefValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";

			// joined
			$this->joined->LinkCustomAttributes = "";
			$this->joined->HrefValue = "";

			// facebook
			$this->facebook->LinkCustomAttributes = "";
			if (!ew_Empty($this->facebook->CurrentValue)) {
				$this->facebook->HrefValue = ((!empty($this->facebook->EditValue)) ? ew_RemoveHtml($this->facebook->EditValue) : $this->facebook->CurrentValue); // Add prefix/suffix
				$this->facebook->LinkAttrs["target"] = "_blank"; // Add target
				if ($this->Export <> "") $this->facebook->HrefValue = ew_ConvertFullUrl($this->facebook->HrefValue);
			} else {
				$this->facebook->HrefValue = "";
			}

			// twitter
			$this->twitter->LinkCustomAttributes = "";
			if (!ew_Empty($this->twitter->CurrentValue)) {
				$this->twitter->HrefValue = ((!empty($this->twitter->EditValue)) ? ew_RemoveHtml($this->twitter->EditValue) : $this->twitter->CurrentValue); // Add prefix/suffix
				$this->twitter->LinkAttrs["target"] = "_blank"; // Add target
				if ($this->Export <> "") $this->twitter->HrefValue = ew_ConvertFullUrl($this->twitter->HrefValue);
			} else {
				$this->twitter->HrefValue = "";
			}

			// twitch
			$this->twitch->LinkCustomAttributes = "";
			if (!ew_Empty($this->twitch->CurrentValue)) {
				$this->twitch->HrefValue = ((!empty($this->twitch->EditValue)) ? ew_RemoveHtml($this->twitch->EditValue) : $this->twitch->CurrentValue); // Add prefix/suffix
				$this->twitch->LinkAttrs["target"] = "_blank"; // Add target
				if ($this->Export <> "") $this->twitch->HrefValue = ew_ConvertFullUrl($this->twitch->HrefValue);
			} else {
				$this->twitch->HrefValue = "";
			}

			// skype
			$this->skype->LinkCustomAttributes = "";
			$this->skype->HrefValue = "";

			// birthday
			$this->birthday->LinkCustomAttributes = "";
			$this->birthday->HrefValue = "";

			// profession
			$this->profession->LinkCustomAttributes = "";
			$this->profession->HrefValue = "";

			// game_type
			$this->game_type->LinkCustomAttributes = "";
			$this->game_type->HrefValue = "";

			// division
			$this->division->LinkCustomAttributes = "";
			$this->division->HrefValue = "";

			// has_expansion
			$this->has_expansion->LinkCustomAttributes = "";
			$this->has_expansion->HrefValue = "";

			// notes
			$this->notes->LinkCustomAttributes = "";
			if (!ew_Empty($this->notes->CurrentValue)) {
				$this->notes->HrefValue = ((!empty($this->notes->EditValue)) ? ew_RemoveHtml($this->notes->EditValue) : $this->notes->CurrentValue); // Add prefix/suffix
				$this->notes->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->notes->HrefValue = ew_ConvertFullUrl($this->notes->HrefValue);
			} else {
				$this->notes->HrefValue = "";
			}
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->name->FldIsDetailKey && !is_null($this->name->FormValue) && $this->name->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->name->FldCaption(), $this->name->ReqErrMsg));
		}
		if (!$this->_email->FldIsDetailKey && !is_null($this->_email->FormValue) && $this->_email->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->_email->FldCaption(), $this->_email->ReqErrMsg));
		}
		if (!$this->birthday->FldIsDetailKey && !is_null($this->birthday->FormValue) && $this->birthday->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->birthday->FldCaption(), $this->birthday->ReqErrMsg));
		}
		if (!ew_CheckEuroDate($this->birthday->FormValue)) {
			ew_AddMessage($gsFormError, $this->birthday->FldErrMsg());
		}
		if ($this->profession->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->profession->FldCaption(), $this->profession->ReqErrMsg));
		}
		if ($this->game_type->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->game_type->FldCaption(), $this->game_type->ReqErrMsg));
		}
		if (!$this->has_expansion->FldIsDetailKey && !is_null($this->has_expansion->FormValue) && $this->has_expansion->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->has_expansion->FldCaption(), $this->has_expansion->ReqErrMsg));
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// name
			$this->name->SetDbValueDef($rsnew, $this->name->CurrentValue, "", $this->name->ReadOnly);

			// email
			$this->_email->SetDbValueDef($rsnew, $this->_email->CurrentValue, "", $this->_email->ReadOnly);

			// joined
			$this->joined->SetDbValueDef($rsnew, ew_CurrentUserIP(), 0);
			$rsnew['joined'] = &$this->joined->DbValue;

			// facebook
			$this->facebook->SetDbValueDef($rsnew, $this->facebook->CurrentValue, NULL, $this->facebook->ReadOnly);

			// twitter
			$this->twitter->SetDbValueDef($rsnew, $this->twitter->CurrentValue, NULL, $this->twitter->ReadOnly);

			// twitch
			$this->twitch->SetDbValueDef($rsnew, $this->twitch->CurrentValue, NULL, $this->twitch->ReadOnly);

			// skype
			$this->skype->SetDbValueDef($rsnew, $this->skype->CurrentValue, NULL, $this->skype->ReadOnly);

			// birthday
			$this->birthday->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->birthday->CurrentValue, 5), NULL, $this->birthday->ReadOnly);

			// profession
			$this->profession->SetDbValueDef($rsnew, $this->profession->CurrentValue, NULL, $this->profession->ReadOnly);

			// game_type
			$this->game_type->SetDbValueDef($rsnew, $this->game_type->CurrentValue, NULL, $this->game_type->ReadOnly);

			// division
			$this->division->SetDbValueDef($rsnew, $this->division->CurrentValue, NULL, $this->division->ReadOnly);

			// has_expansion
			$this->has_expansion->SetDbValueDef($rsnew, $this->has_expansion->CurrentValue, "", $this->has_expansion->ReadOnly);

			// notes
			$this->notes->SetDbValueDef($rsnew, $this->notes->CurrentValue, NULL, $this->notes->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("nos_memberslist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($nos_members_edit)) $nos_members_edit = new cnos_members_edit();

// Page init
$nos_members_edit->Page_Init();

// Page main
$nos_members_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$nos_members_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fnos_membersedit = new ew_Form("fnos_membersedit", "edit");

// Validate form
fnos_membersedit.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_name");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $nos_members->name->FldCaption(), $nos_members->name->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "__email");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $nos_members->_email->FldCaption(), $nos_members->_email->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_birthday");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $nos_members->birthday->FldCaption(), $nos_members->birthday->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_birthday");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($nos_members->birthday->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_profession[]");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $nos_members->profession->FldCaption(), $nos_members->profession->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_game_type[]");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $nos_members->game_type->FldCaption(), $nos_members->game_type->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_has_expansion");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $nos_members->has_expansion->FldCaption(), $nos_members->has_expansion->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
fnos_membersedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fnos_membersedit.ValidateRequired = true;
<?php } else { ?>
fnos_membersedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fnos_membersedit.Lists["x_profession[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fnos_membersedit.Lists["x_profession[]"].Options = <?php echo json_encode($nos_members->profession->Options()) ?>;
fnos_membersedit.Lists["x_game_type[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fnos_membersedit.Lists["x_game_type[]"].Options = <?php echo json_encode($nos_members->game_type->Options()) ?>;
fnos_membersedit.Lists["x_division[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fnos_membersedit.Lists["x_division[]"].Options = <?php echo json_encode($nos_members->division->Options()) ?>;
fnos_membersedit.Lists["x_has_expansion"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fnos_membersedit.Lists["x_has_expansion"].Options = <?php echo json_encode($nos_members->has_expansion->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $nos_members_edit->ShowPageHeader(); ?>
<?php
$nos_members_edit->ShowMessage();
?>
<form name="fnos_membersedit" id="fnos_membersedit" class="<?php echo $nos_members_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($nos_members_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $nos_members_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="nos_members">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<div>
<?php if ($nos_members->name->Visible) { // name ?>
	<div id="r_name" class="form-group">
		<label id="elh_nos_members_name" for="x_name" class="col-sm-2 control-label ewLabel"><?php echo $nos_members->name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $nos_members->name->CellAttributes() ?>>
<span id="el_nos_members_name">
<input type="text" data-table="nos_members" data-field="x_name" data-page="1" name="x_name" id="x_name" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($nos_members->name->getPlaceHolder()) ?>" value="<?php echo $nos_members->name->EditValue ?>"<?php echo $nos_members->name->EditAttributes() ?>>
</span>
<?php echo $nos_members->name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($nos_members->_email->Visible) { // email ?>
	<div id="r__email" class="form-group">
		<label id="elh_nos_members__email" for="x__email" class="col-sm-2 control-label ewLabel"><?php echo $nos_members->_email->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $nos_members->_email->CellAttributes() ?>>
<span id="el_nos_members__email">
<input type="text" data-table="nos_members" data-field="x__email" data-page="1" name="x__email" id="x__email" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($nos_members->_email->getPlaceHolder()) ?>" value="<?php echo $nos_members->_email->EditValue ?>"<?php echo $nos_members->_email->EditAttributes() ?>>
</span>
<?php echo $nos_members->_email->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($nos_members->facebook->Visible) { // facebook ?>
	<div id="r_facebook" class="form-group">
		<label id="elh_nos_members_facebook" for="x_facebook" class="col-sm-2 control-label ewLabel"><?php echo $nos_members->facebook->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $nos_members->facebook->CellAttributes() ?>>
<span id="el_nos_members_facebook">
<input type="text" data-table="nos_members" data-field="x_facebook" data-page="1" name="x_facebook" id="x_facebook" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($nos_members->facebook->getPlaceHolder()) ?>" value="<?php echo $nos_members->facebook->EditValue ?>"<?php echo $nos_members->facebook->EditAttributes() ?>>
</span>
<?php echo $nos_members->facebook->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($nos_members->twitter->Visible) { // twitter ?>
	<div id="r_twitter" class="form-group">
		<label id="elh_nos_members_twitter" for="x_twitter" class="col-sm-2 control-label ewLabel"><?php echo $nos_members->twitter->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $nos_members->twitter->CellAttributes() ?>>
<span id="el_nos_members_twitter">
<input type="text" data-table="nos_members" data-field="x_twitter" data-page="1" name="x_twitter" id="x_twitter" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($nos_members->twitter->getPlaceHolder()) ?>" value="<?php echo $nos_members->twitter->EditValue ?>"<?php echo $nos_members->twitter->EditAttributes() ?>>
</span>
<?php echo $nos_members->twitter->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($nos_members->twitch->Visible) { // twitch ?>
	<div id="r_twitch" class="form-group">
		<label id="elh_nos_members_twitch" for="x_twitch" class="col-sm-2 control-label ewLabel"><?php echo $nos_members->twitch->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $nos_members->twitch->CellAttributes() ?>>
<span id="el_nos_members_twitch">
<input type="text" data-table="nos_members" data-field="x_twitch" data-page="1" name="x_twitch" id="x_twitch" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($nos_members->twitch->getPlaceHolder()) ?>" value="<?php echo $nos_members->twitch->EditValue ?>"<?php echo $nos_members->twitch->EditAttributes() ?>>
</span>
<?php echo $nos_members->twitch->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($nos_members->skype->Visible) { // skype ?>
	<div id="r_skype" class="form-group">
		<label id="elh_nos_members_skype" for="x_skype" class="col-sm-2 control-label ewLabel"><?php echo $nos_members->skype->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $nos_members->skype->CellAttributes() ?>>
<span id="el_nos_members_skype">
<input type="text" data-table="nos_members" data-field="x_skype" data-page="1" name="x_skype" id="x_skype" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($nos_members->skype->getPlaceHolder()) ?>" value="<?php echo $nos_members->skype->EditValue ?>"<?php echo $nos_members->skype->EditAttributes() ?>>
</span>
<?php echo $nos_members->skype->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($nos_members->birthday->Visible) { // birthday ?>
	<div id="r_birthday" class="form-group">
		<label id="elh_nos_members_birthday" for="x_birthday" class="col-sm-2 control-label ewLabel"><?php echo $nos_members->birthday->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $nos_members->birthday->CellAttributes() ?>>
<span id="el_nos_members_birthday">
<input type="text" data-table="nos_members" data-field="x_birthday" data-page="1" data-format="5" name="x_birthday" id="x_birthday" placeholder="<?php echo ew_HtmlEncode($nos_members->birthday->getPlaceHolder()) ?>" value="<?php echo $nos_members->birthday->EditValue ?>"<?php echo $nos_members->birthday->EditAttributes() ?>>
</span>
<?php echo $nos_members->birthday->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($nos_members->profession->Visible) { // profession ?>
	<div id="r_profession" class="form-group">
		<label id="elh_nos_members_profession" for="x_profession" class="col-sm-2 control-label ewLabel"><?php echo $nos_members->profession->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $nos_members->profession->CellAttributes() ?>>
<span id="el_nos_members_profession">
<select data-table="nos_members" data-field="x_profession" data-page="1" data-value-separator="<?php echo ew_HtmlEncode(is_array($nos_members->profession->DisplayValueSeparator) ? json_encode($nos_members->profession->DisplayValueSeparator) : $nos_members->profession->DisplayValueSeparator) ?>" id="x_profession[]" name="x_profession[]" multiple="multiple"<?php echo $nos_members->profession->EditAttributes() ?>>
<?php
if (is_array($nos_members->profession->EditValue)) {
	$arwrk = $nos_members->profession->EditValue;
	$armultiwrk = (strval($nos_members->profession->CurrentValue) <> "") ? explode(",", strval($nos_members->profession->CurrentValue)) : array();
	$cnt = count($armultiwrk);
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = "";
		for ($ari = 0; $ari < $cnt; $ari++) {
			if (ew_SameStr($arwrk[$rowcntwrk][0], $armultiwrk[$ari]) && !is_null($armultiwrk[$ari])) {
				$armultiwrk[$ari] = NULL; // Marked for removal
				$selwrk = " selected";
				if ($selwrk <> "") $emptywrk = FALSE;
				break;
			}
		}		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $nos_members->profession->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	for ($ari = 0; $ari < $cnt; $ari++) {
		if (!is_null($armultiwrk[$ari])) {
?>
<option value="<?php echo ew_HtmlEncode($armultiwrk[$ari]) ?>" selected><?php echo $armultiwrk[$ari] ?></option>
<?php
		}
	}
}
?>
</select>
</span>
<?php echo $nos_members->profession->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($nos_members->game_type->Visible) { // game_type ?>
	<div id="r_game_type" class="form-group">
		<label id="elh_nos_members_game_type" for="x_game_type" class="col-sm-2 control-label ewLabel"><?php echo $nos_members->game_type->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $nos_members->game_type->CellAttributes() ?>>
<span id="el_nos_members_game_type">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $nos_members->game_type->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x_game_type" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php
$arwrk = $nos_members->game_type->EditValue;
if (is_array($arwrk)) {
	$armultiwrk = (strval($nos_members->game_type->CurrentValue) <> "") ? explode(",", strval($nos_members->game_type->CurrentValue)) : array();
	$cnt = count($armultiwrk);
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = "";
		for ($ari = 0; $ari < $cnt; $ari++) {
			if (ew_SameStr($arwrk[$rowcntwrk][0], $armultiwrk[$ari]) && !is_null($armultiwrk[$ari])) {
				$armultiwrk[$ari] = NULL; // Marked for removal
				$selwrk = " checked";
				if ($selwrk <> "") $emptywrk = FALSE;
				break;
			}
		}
?>
<input type="checkbox" data-table="nos_members" data-field="x_game_type" data-page="1" name="x_game_type[]" id="x_game_type_<?php echo $rowcntwrk ?>[]" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $nos_members->game_type->EditAttributes() ?>><?php echo $nos_members->game_type->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
	}
	for ($ari = 0; $ari < $cnt; $ari++) {
		if (!is_null($armultiwrk[$ari])) {
?>
<input type="checkbox" data-table="nos_members" data-field="x_game_type" data-page="1" name="x_game_type[]" value="<?php echo ew_HtmlEncode($armultiwrk[$ari]) ?>" checked<?php echo $nos_members->game_type->EditAttributes() ?>><?php echo $armultiwrk[$ari] ?>
<?php
		}
	}
}
?>
		</div>
	</div>
	<div id="tp_x_game_type" class="ewTemplate"><input type="checkbox" data-table="nos_members" data-field="x_game_type" data-page="1" data-value-separator="<?php echo ew_HtmlEncode(is_array($nos_members->game_type->DisplayValueSeparator) ? json_encode($nos_members->game_type->DisplayValueSeparator) : $nos_members->game_type->DisplayValueSeparator) ?>" name="x_game_type[]" id="x_game_type[]" value="{value}"<?php echo $nos_members->game_type->EditAttributes() ?>></div>
</div>
</span>
<?php echo $nos_members->game_type->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($nos_members->division->Visible) { // division ?>
	<div id="r_division" class="form-group">
		<label id="elh_nos_members_division" for="x_division" class="col-sm-2 control-label ewLabel"><?php echo $nos_members->division->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $nos_members->division->CellAttributes() ?>>
<span id="el_nos_members_division">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $nos_members->division->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x_division" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php
$arwrk = $nos_members->division->EditValue;
if (is_array($arwrk)) {
	$armultiwrk = (strval($nos_members->division->CurrentValue) <> "") ? explode(",", strval($nos_members->division->CurrentValue)) : array();
	$cnt = count($armultiwrk);
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = "";
		for ($ari = 0; $ari < $cnt; $ari++) {
			if (ew_SameStr($arwrk[$rowcntwrk][0], $armultiwrk[$ari]) && !is_null($armultiwrk[$ari])) {
				$armultiwrk[$ari] = NULL; // Marked for removal
				$selwrk = " checked";
				if ($selwrk <> "") $emptywrk = FALSE;
				break;
			}
		}
?>
<input type="checkbox" data-table="nos_members" data-field="x_division" data-page="1" name="x_division[]" id="x_division_<?php echo $rowcntwrk ?>[]" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $nos_members->division->EditAttributes() ?>><?php echo $nos_members->division->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
	}
	for ($ari = 0; $ari < $cnt; $ari++) {
		if (!is_null($armultiwrk[$ari])) {
?>
<input type="checkbox" data-table="nos_members" data-field="x_division" data-page="1" name="x_division[]" value="<?php echo ew_HtmlEncode($armultiwrk[$ari]) ?>" checked<?php echo $nos_members->division->EditAttributes() ?>><?php echo $armultiwrk[$ari] ?>
<?php
		}
	}
}
?>
		</div>
	</div>
	<div id="tp_x_division" class="ewTemplate"><input type="checkbox" data-table="nos_members" data-field="x_division" data-page="1" data-value-separator="<?php echo ew_HtmlEncode(is_array($nos_members->division->DisplayValueSeparator) ? json_encode($nos_members->division->DisplayValueSeparator) : $nos_members->division->DisplayValueSeparator) ?>" name="x_division[]" id="x_division[]" value="{value}"<?php echo $nos_members->division->EditAttributes() ?>></div>
</div>
</span>
<?php echo $nos_members->division->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($nos_members->has_expansion->Visible) { // has_expansion ?>
	<div id="r_has_expansion" class="form-group">
		<label id="elh_nos_members_has_expansion" for="x_has_expansion" class="col-sm-2 control-label ewLabel"><?php echo $nos_members->has_expansion->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $nos_members->has_expansion->CellAttributes() ?>>
<span id="el_nos_members_has_expansion">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $nos_members->has_expansion->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x_has_expansion" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php
$arwrk = $nos_members->has_expansion->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($nos_members->has_expansion->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<input type="radio" data-table="nos_members" data-field="x_has_expansion" data-page="1" name="x_has_expansion" id="x_has_expansion_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $nos_members->has_expansion->EditAttributes() ?>><?php echo $nos_members->has_expansion->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
	}
	if ($emptywrk && strval($nos_members->has_expansion->CurrentValue) <> "") {
?>
<input type="radio" data-table="nos_members" data-field="x_has_expansion" data-page="1" name="x_has_expansion" id="x_has_expansion_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($nos_members->has_expansion->CurrentValue) ?>" checked<?php echo $nos_members->has_expansion->EditAttributes() ?>><?php echo $nos_members->has_expansion->CurrentValue ?>
<?php
    }
}
?>
		</div>
	</div>
	<div id="tp_x_has_expansion" class="ewTemplate"><input type="radio" data-table="nos_members" data-field="x_has_expansion" data-page="1" data-value-separator="<?php echo ew_HtmlEncode(is_array($nos_members->has_expansion->DisplayValueSeparator) ? json_encode($nos_members->has_expansion->DisplayValueSeparator) : $nos_members->has_expansion->DisplayValueSeparator) ?>" name="x_has_expansion" id="x_has_expansion" value="{value}"<?php echo $nos_members->has_expansion->EditAttributes() ?>></div>
</div>
</span>
<?php echo $nos_members->has_expansion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($nos_members->notes->Visible) { // notes ?>
	<div id="r_notes" class="form-group">
		<label id="elh_nos_members_notes" class="col-sm-2 control-label ewLabel"><?php echo $nos_members->notes->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $nos_members->notes->CellAttributes() ?>>
<span id="el_nos_members_notes">
<?php ew_AppendClass($nos_members->notes->EditAttrs["class"], "editor"); ?>
<textarea data-table="nos_members" data-field="x_notes" data-page="1" name="x_notes" id="x_notes" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($nos_members->notes->getPlaceHolder()) ?>"<?php echo $nos_members->notes->EditAttributes() ?>><?php echo $nos_members->notes->EditValue ?></textarea>
</span>
<?php echo $nos_members->notes->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<input type="hidden" data-table="nos_members" data-field="x_memberID" name="x_memberID" id="x_memberID" value="<?php echo ew_HtmlEncode($nos_members->memberID->CurrentValue) ?>">
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $nos_members_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fnos_membersedit.Init();
</script>
<?php
$nos_members_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$nos_members_edit->Page_Terminate();
?>
