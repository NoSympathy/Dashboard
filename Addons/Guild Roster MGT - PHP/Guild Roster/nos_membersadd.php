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

$nos_members_add = NULL; // Initialize page object first

class cnos_members_add extends cnos_members {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{035BB177-6A34-4418-A6BD-DF1DD7A296CE}";

	// Table name
	var $TableName = 'nos_members';

	// Page object name
	var $PageObjName = 'nos_members_add';

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
		$hidden = TRUE;
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
			define("EW_PAGE_ID", 'add', TRUE);

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
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		$this->FormClassName = "ewForm ewAddForm";
		if (ew_IsMobile())
			$this->FormClassName = ew_Concat("form-horizontal", $this->FormClassName, " ");

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["memberID"] != "") {
				$this->memberID->setQueryStringValue($_GET["memberID"]);
				$this->setKey("memberID", $this->memberID->CurrentValue); // Set up key
			} else {
				$this->setKey("memberID", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		} else {
			if ($this->CurrentAction == "I") // Load default values for blank record
				$this->LoadDefaultValues();
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("nos_memberslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->GetViewUrl();
					if (ew_GetPageName($sReturnUrl) == "nos_memberslist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "nos_membersview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->name->CurrentValue = NULL;
		$this->name->OldValue = $this->name->CurrentValue;
		$this->_email->CurrentValue = NULL;
		$this->_email->OldValue = $this->_email->CurrentValue;
		$this->profession->CurrentValue = NULL;
		$this->profession->OldValue = $this->profession->CurrentValue;
		$this->game_type->CurrentValue = NULL;
		$this->game_type->OldValue = $this->game_type->CurrentValue;
		$this->division->CurrentValue = NULL;
		$this->division->OldValue = $this->division->CurrentValue;
		$this->has_expansion->CurrentValue = NULL;
		$this->has_expansion->OldValue = $this->has_expansion->CurrentValue;
		$this->notes->CurrentValue = NULL;
		$this->notes->OldValue = $this->notes->CurrentValue;
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
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->name->CurrentValue = $this->name->FormValue;
		$this->_email->CurrentValue = $this->_email->FormValue;
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
		$this->profession->DbValue = $row['profession'];
		$this->game_type->DbValue = $row['game_type'];
		$this->division->DbValue = $row['division'];
		$this->has_expansion->DbValue = $row['has_expansion'];
		$this->notes->DbValue = $row['notes'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("memberID")) <> "")
			$this->memberID->CurrentValue = $this->getKey("memberID"); // memberID
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
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
		if (!is_null($this->notes->ViewValue)) $this->notes->ViewValue = str_replace("\n", "<br>", $this->notes->ViewValue); 
		$this->notes->ViewCustomAttributes = "";

			// name
			$this->name->LinkCustomAttributes = "";
			$this->name->HrefValue = "";
			$this->name->TooltipValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";
			$this->_email->TooltipValue = "";

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
			$this->notes->HrefValue = "";
			$this->notes->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

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
			$this->has_expansion->EditAttrs["class"] = "form-control";
			$this->has_expansion->EditCustomAttributes = "";
			$this->has_expansion->EditValue = $this->has_expansion->Options(TRUE);

			// notes
			$this->notes->EditAttrs["class"] = "form-control";
			$this->notes->EditCustomAttributes = "";
			$this->notes->EditValue = ew_HtmlEncode($this->notes->CurrentValue);
			$this->notes->PlaceHolder = ew_RemoveHtml($this->notes->FldCaption());

			// Add refer script
			// name

			$this->name->LinkCustomAttributes = "";
			$this->name->HrefValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";

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
			$this->notes->HrefValue = "";
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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// name
		$this->name->SetDbValueDef($rsnew, $this->name->CurrentValue, "", FALSE);

		// email
		$this->_email->SetDbValueDef($rsnew, $this->_email->CurrentValue, "", FALSE);

		// profession
		$this->profession->SetDbValueDef($rsnew, $this->profession->CurrentValue, NULL, FALSE);

		// game_type
		$this->game_type->SetDbValueDef($rsnew, $this->game_type->CurrentValue, NULL, FALSE);

		// division
		$this->division->SetDbValueDef($rsnew, $this->division->CurrentValue, NULL, FALSE);

		// has_expansion
		$this->has_expansion->SetDbValueDef($rsnew, $this->has_expansion->CurrentValue, "", FALSE);

		// notes
		$this->notes->SetDbValueDef($rsnew, $this->notes->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->memberID->setDbValue($conn->Insert_ID());
				$rsnew['memberID'] = $this->memberID->DbValue;
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("nos_memberslist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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
if (!isset($nos_members_add)) $nos_members_add = new cnos_members_add();

// Page init
$nos_members_add->Page_Init();

// Page main
$nos_members_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$nos_members_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fnos_membersadd = new ew_Form("fnos_membersadd", "add");

// Validate form
fnos_membersadd.Validate = function() {
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
fnos_membersadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fnos_membersadd.ValidateRequired = true;
<?php } else { ?>
fnos_membersadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fnos_membersadd.Lists["x_profession[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fnos_membersadd.Lists["x_profession[]"].Options = <?php echo json_encode($nos_members->profession->Options()) ?>;
fnos_membersadd.Lists["x_game_type[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fnos_membersadd.Lists["x_game_type[]"].Options = <?php echo json_encode($nos_members->game_type->Options()) ?>;
fnos_membersadd.Lists["x_division[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fnos_membersadd.Lists["x_division[]"].Options = <?php echo json_encode($nos_members->division->Options()) ?>;
fnos_membersadd.Lists["x_has_expansion"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fnos_membersadd.Lists["x_has_expansion"].Options = <?php echo json_encode($nos_members->has_expansion->Options()) ?>;

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
<?php $nos_members_add->ShowPageHeader(); ?>
<?php
$nos_members_add->ShowMessage();
?>
<form name="fnos_membersadd" id="fnos_membersadd" class="<?php echo $nos_members_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($nos_members_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $nos_members_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="nos_members">
<input type="hidden" name="a_add" id="a_add" value="A">
<div class="ewDesktop">
<div>
<table id="tbl_nos_membersadd" class="table table-bordered table-striped ewDesktopTable">
<?php if ($nos_members->name->Visible) { // name ?>
	<tr id="r_name">
		<td><span id="elh_nos_members_name"><?php echo $nos_members->name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $nos_members->name->CellAttributes() ?>>
<span id="el_nos_members_name">
<input type="text" data-table="nos_members" data-field="x_name" data-page="1" name="x_name" id="x_name" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($nos_members->name->getPlaceHolder()) ?>" value="<?php echo $nos_members->name->EditValue ?>"<?php echo $nos_members->name->EditAttributes() ?>>
</span>
<?php echo $nos_members->name->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($nos_members->_email->Visible) { // email ?>
	<tr id="r__email">
		<td><span id="elh_nos_members__email"><?php echo $nos_members->_email->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $nos_members->_email->CellAttributes() ?>>
<span id="el_nos_members__email">
<input type="text" data-table="nos_members" data-field="x__email" data-page="1" name="x__email" id="x__email" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($nos_members->_email->getPlaceHolder()) ?>" value="<?php echo $nos_members->_email->EditValue ?>"<?php echo $nos_members->_email->EditAttributes() ?>>
</span>
<?php echo $nos_members->_email->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($nos_members->profession->Visible) { // profession ?>
	<tr id="r_profession">
		<td><span id="elh_nos_members_profession"><?php echo $nos_members->profession->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $nos_members->profession->CellAttributes() ?>>
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
<?php echo $nos_members->profession->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($nos_members->game_type->Visible) { // game_type ?>
	<tr id="r_game_type">
		<td><span id="elh_nos_members_game_type"><?php echo $nos_members->game_type->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $nos_members->game_type->CellAttributes() ?>>
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
<?php echo $nos_members->game_type->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($nos_members->division->Visible) { // division ?>
	<tr id="r_division">
		<td><span id="elh_nos_members_division"><?php echo $nos_members->division->FldCaption() ?></span></td>
		<td<?php echo $nos_members->division->CellAttributes() ?>>
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
<?php echo $nos_members->division->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($nos_members->has_expansion->Visible) { // has_expansion ?>
	<tr id="r_has_expansion">
		<td><span id="elh_nos_members_has_expansion"><?php echo $nos_members->has_expansion->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $nos_members->has_expansion->CellAttributes() ?>>
<span id="el_nos_members_has_expansion">
<select data-table="nos_members" data-field="x_has_expansion" data-page="1" data-value-separator="<?php echo ew_HtmlEncode(is_array($nos_members->has_expansion->DisplayValueSeparator) ? json_encode($nos_members->has_expansion->DisplayValueSeparator) : $nos_members->has_expansion->DisplayValueSeparator) ?>" id="x_has_expansion" name="x_has_expansion" size=3<?php echo $nos_members->has_expansion->EditAttributes() ?>>
<?php
if (is_array($nos_members->has_expansion->EditValue)) {
	$arwrk = $nos_members->has_expansion->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($nos_members->has_expansion->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $nos_members->has_expansion->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($nos_members->has_expansion->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($nos_members->has_expansion->CurrentValue) ?>" selected><?php echo $nos_members->has_expansion->CurrentValue ?></option>
<?php
    }
}
?>
</select>
</span>
<?php echo $nos_members->has_expansion->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($nos_members->notes->Visible) { // notes ?>
	<tr id="r_notes">
		<td><span id="elh_nos_members_notes"><?php echo $nos_members->notes->FldCaption() ?></span></td>
		<td<?php echo $nos_members->notes->CellAttributes() ?>>
<span id="el_nos_members_notes">
<?php ew_AppendClass($nos_members->notes->EditAttrs["class"], "editor"); ?>
<textarea data-table="nos_members" data-field="x_notes" data-page="1" name="x_notes" id="x_notes" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($nos_members->notes->getPlaceHolder()) ?>"<?php echo $nos_members->notes->EditAttributes() ?>><?php echo $nos_members->notes->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("fnos_membersadd", "x_notes", 0, 0, <?php echo ($nos_members->notes->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $nos_members->notes->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
<div class="ewDesktopButton">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $nos_members_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</div>
</form>
<script type="text/javascript">
fnos_membersadd.Init();
</script>
<?php
$nos_members_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$nos_members_add->Page_Terminate();
?>
