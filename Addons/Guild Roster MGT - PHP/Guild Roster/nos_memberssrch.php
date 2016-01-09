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

$nos_members_search = NULL; // Initialize page object first

class cnos_members_search extends cnos_members {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{035BB177-6A34-4418-A6BD-DF1DD7A296CE}";

	// Table name
	var $TableName = 'nos_members';

	// Page object name
	var $PageObjName = 'nos_members_search';

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
			define("EW_PAGE_ID", 'search', TRUE);

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
	var $FormClassName = "form-horizontal ewForm ewSearchForm";
	var $IsModal = FALSE;
	var $SearchLabelClass = "col-sm-3 control-label ewLabel";
	var $SearchRightColumnClass = "col-sm-9";

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsSearchError;
		global $gbSkipHeaderFooter;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$this->FormClassName = "ewForm ewSearchForm";
		if (ew_IsMobile() || $this->IsModal)
			$this->FormClassName = ew_Concat("form-horizontal", $this->FormClassName, " ");
		if ($this->IsPageRequest()) { // Validate request

			// Get action
			$this->CurrentAction = $objForm->GetValue("a_search");
			switch ($this->CurrentAction) {
				case "S": // Get search criteria

					// Build search string for advanced search, remove blank field
					$this->LoadSearchValues(); // Get search values
					if ($this->ValidateSearch()) {
						$sSrchStr = $this->BuildAdvancedSearch();
					} else {
						$sSrchStr = "";
						$this->setFailureMessage($gsSearchError);
					}
					if ($sSrchStr <> "") {
						$sSrchStr = $this->UrlParm($sSrchStr);
						$sSrchStr = "nos_memberslist.php" . "?" . $sSrchStr;
						if ($this->IsModal) {
							$row = array();
							$row["url"] = $sSrchStr;
							echo ew_ArrayToJson(array($row));
							$this->Page_Terminate();
							exit();
						} else {
							$this->Page_Terminate($sSrchStr); // Go to list page
						}
					}
			}
		}

		// Restore search settings from Session
		if ($gsSearchError == "")
			$this->LoadAdvancedSearch();

		// Render row for search
		$this->RowType = EW_ROWTYPE_SEARCH;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Build advanced search
	function BuildAdvancedSearch() {
		$sSrchUrl = "";
		$this->BuildSearchUrl($sSrchUrl, $this->name); // name
		$this->BuildSearchUrl($sSrchUrl, $this->_email); // email
		$this->BuildSearchUrl($sSrchUrl, $this->profession); // profession
		$this->BuildSearchUrl($sSrchUrl, $this->game_type); // game_type
		$this->BuildSearchUrl($sSrchUrl, $this->division); // division
		$this->BuildSearchUrl($sSrchUrl, $this->has_expansion); // has_expansion
		if ($sSrchUrl <> "") $sSrchUrl .= "&";
		$sSrchUrl .= "cmd=search";
		return $sSrchUrl;
	}

	// Build search URL
	function BuildSearchUrl(&$Url, &$Fld, $OprOnly=FALSE) {
		global $objForm;
		$sWrk = "";
		$FldParm = substr($Fld->FldVar, 2);
		$FldVal = $objForm->GetValue("x_$FldParm");
		$FldOpr = $objForm->GetValue("z_$FldParm");
		$FldCond = $objForm->GetValue("v_$FldParm");
		$FldVal2 = $objForm->GetValue("y_$FldParm");
		$FldOpr2 = $objForm->GetValue("w_$FldParm");
		$FldVal = ew_StripSlashes($FldVal);
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);
		$FldVal2 = ew_StripSlashes($FldVal2);
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$FldOpr = strtoupper(trim($FldOpr));
		$lFldDataType = ($Fld->FldIsVirtual) ? EW_DATATYPE_STRING : $Fld->FldDataType;
		if ($FldOpr == "BETWEEN") {
			$IsValidValue = ($lFldDataType <> EW_DATATYPE_NUMBER) ||
				($lFldDataType == EW_DATATYPE_NUMBER && $this->SearchValueIsNumeric($Fld, $FldVal) && $this->SearchValueIsNumeric($Fld, $FldVal2));
			if ($FldVal <> "" && $FldVal2 <> "" && $IsValidValue) {
				$sWrk = "x_" . $FldParm . "=" . urlencode($FldVal) .
					"&y_" . $FldParm . "=" . urlencode($FldVal2) .
					"&z_" . $FldParm . "=" . urlencode($FldOpr);
			}
		} else {
			$IsValidValue = ($lFldDataType <> EW_DATATYPE_NUMBER) ||
				($lFldDataType == EW_DATATYPE_NUMBER && $this->SearchValueIsNumeric($Fld, $FldVal));
			if ($FldVal <> "" && $IsValidValue && ew_IsValidOpr($FldOpr, $lFldDataType)) {
				$sWrk = "x_" . $FldParm . "=" . urlencode($FldVal) .
					"&z_" . $FldParm . "=" . urlencode($FldOpr);
			} elseif ($FldOpr == "IS NULL" || $FldOpr == "IS NOT NULL" || ($FldOpr <> "" && $OprOnly && ew_IsValidOpr($FldOpr, $lFldDataType))) {
				$sWrk = "z_" . $FldParm . "=" . urlencode($FldOpr);
			}
			$IsValidValue = ($lFldDataType <> EW_DATATYPE_NUMBER) ||
				($lFldDataType == EW_DATATYPE_NUMBER && $this->SearchValueIsNumeric($Fld, $FldVal2));
			if ($FldVal2 <> "" && $IsValidValue && ew_IsValidOpr($FldOpr2, $lFldDataType)) {
				if ($sWrk <> "") $sWrk .= "&v_" . $FldParm . "=" . urlencode($FldCond) . "&";
				$sWrk .= "y_" . $FldParm . "=" . urlencode($FldVal2) .
					"&w_" . $FldParm . "=" . urlencode($FldOpr2);
			} elseif ($FldOpr2 == "IS NULL" || $FldOpr2 == "IS NOT NULL" || ($FldOpr2 <> "" && $OprOnly && ew_IsValidOpr($FldOpr2, $lFldDataType))) {
				if ($sWrk <> "") $sWrk .= "&v_" . $FldParm . "=" . urlencode($FldCond) . "&";
				$sWrk .= "w_" . $FldParm . "=" . urlencode($FldOpr2);
			}
		}
		if ($sWrk <> "") {
			if ($Url <> "") $Url .= "&";
			$Url .= $sWrk;
		}
	}

	function SearchValueIsNumeric($Fld, $Value) {
		if (ew_IsFloatFormat($Fld->FldType)) $Value = ew_StrToFloat($Value);
		return is_numeric($Value);
	}

	// Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// name

		$this->name->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_name"));
		$this->name->AdvancedSearch->SearchOperator = $objForm->GetValue("z_name");

		// email
		$this->_email->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x__email"));
		$this->_email->AdvancedSearch->SearchOperator = $objForm->GetValue("z__email");

		// profession
		$this->profession->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_profession"));
		$this->profession->AdvancedSearch->SearchOperator = $objForm->GetValue("z_profession");
		if (is_array($this->profession->AdvancedSearch->SearchValue)) $this->profession->AdvancedSearch->SearchValue = implode(",", $this->profession->AdvancedSearch->SearchValue);
		if (is_array($this->profession->AdvancedSearch->SearchValue2)) $this->profession->AdvancedSearch->SearchValue2 = implode(",", $this->profession->AdvancedSearch->SearchValue2);

		// game_type
		$this->game_type->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_game_type"));
		$this->game_type->AdvancedSearch->SearchOperator = $objForm->GetValue("z_game_type");
		if (is_array($this->game_type->AdvancedSearch->SearchValue)) $this->game_type->AdvancedSearch->SearchValue = implode(",", $this->game_type->AdvancedSearch->SearchValue);
		if (is_array($this->game_type->AdvancedSearch->SearchValue2)) $this->game_type->AdvancedSearch->SearchValue2 = implode(",", $this->game_type->AdvancedSearch->SearchValue2);

		// division
		$this->division->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_division"));
		$this->division->AdvancedSearch->SearchOperator = $objForm->GetValue("z_division");
		if (is_array($this->division->AdvancedSearch->SearchValue)) $this->division->AdvancedSearch->SearchValue = implode(",", $this->division->AdvancedSearch->SearchValue);
		if (is_array($this->division->AdvancedSearch->SearchValue2)) $this->division->AdvancedSearch->SearchValue2 = implode(",", $this->division->AdvancedSearch->SearchValue2);

		// has_expansion
		$this->has_expansion->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_has_expansion"));
		$this->has_expansion->AdvancedSearch->SearchOperator = $objForm->GetValue("z_has_expansion");
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
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// name
			$this->name->EditAttrs["class"] = "form-control";
			$this->name->EditCustomAttributes = "";
			$this->name->EditValue = ew_HtmlEncode($this->name->AdvancedSearch->SearchValue);
			$this->name->PlaceHolder = ew_RemoveHtml($this->name->FldCaption());

			// email
			$this->_email->EditAttrs["class"] = "form-control";
			$this->_email->EditCustomAttributes = "";
			$this->_email->EditValue = ew_HtmlEncode($this->_email->AdvancedSearch->SearchValue);
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

	// Validate search
	function ValidateSearch() {
		global $gsSearchError;

		// Initialize
		$gsSearchError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;

		// Return validate result
		$ValidateSearch = ($gsSearchError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateSearch = $ValidateSearch && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsSearchError, $sFormCustomError);
		}
		return $ValidateSearch;
	}

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->name->AdvancedSearch->Load();
		$this->_email->AdvancedSearch->Load();
		$this->profession->AdvancedSearch->Load();
		$this->game_type->AdvancedSearch->Load();
		$this->division->AdvancedSearch->Load();
		$this->has_expansion->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("nos_memberslist.php"), "", $this->TableVar, TRUE);
		$PageId = "search";
		$Breadcrumb->Add("search", $PageId, $url);
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
if (!isset($nos_members_search)) $nos_members_search = new cnos_members_search();

// Page init
$nos_members_search->Page_Init();

// Page main
$nos_members_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$nos_members_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($nos_members_search->IsModal) { ?>
var CurrentAdvancedSearchForm = fnos_memberssearch = new ew_Form("fnos_memberssearch", "search");
<?php } else { ?>
var CurrentForm = fnos_memberssearch = new ew_Form("fnos_memberssearch", "search");
<?php } ?>

// Form_CustomValidate event
fnos_memberssearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fnos_memberssearch.ValidateRequired = true;
<?php } else { ?>
fnos_memberssearch.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fnos_memberssearch.Lists["x_profession[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fnos_memberssearch.Lists["x_profession[]"].Options = <?php echo json_encode($nos_members->profession->Options()) ?>;
fnos_memberssearch.Lists["x_game_type[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fnos_memberssearch.Lists["x_game_type[]"].Options = <?php echo json_encode($nos_members->game_type->Options()) ?>;
fnos_memberssearch.Lists["x_division[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fnos_memberssearch.Lists["x_division[]"].Options = <?php echo json_encode($nos_members->division->Options()) ?>;
fnos_memberssearch.Lists["x_has_expansion"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fnos_memberssearch.Lists["x_has_expansion"].Options = <?php echo json_encode($nos_members->has_expansion->Options()) ?>;

// Form object for search
// Validate function for search

fnos_memberssearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$nos_members_search->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $nos_members_search->ShowPageHeader(); ?>
<?php
$nos_members_search->ShowMessage();
?>
<form name="fnos_memberssearch" id="fnos_memberssearch" class="<?php echo $nos_members_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($nos_members_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $nos_members_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="nos_members">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($nos_members_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if (!ew_IsMobile() && !$nos_members_search->IsModal) { ?>
<div class="ewDesktop">
<?php } ?>
<?php if (ew_IsMobile() || $nos_members_search->IsModal) { ?>
<div>
<?php } else { ?>
<div>
<table id="tbl_nos_memberssearch" class="table table-bordered table-striped ewDesktopTable">
<?php } ?>
<?php if ($nos_members->name->Visible) { // name ?>
<?php if (ew_IsMobile() || $nos_members_search->IsModal) { ?>
	<div id="r_name" class="form-group">
		<label for="x_name" class="<?php echo $nos_members_search->SearchLabelClass ?>"><span id="elh_nos_members_name"><?php echo $nos_members->name->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_name" id="z_name" value="LIKE"></p>
		</label>
		<div class="<?php echo $nos_members_search->SearchRightColumnClass ?>"><div<?php echo $nos_members->name->CellAttributes() ?>>
			<span id="el_nos_members_name">
<input type="text" data-table="nos_members" data-field="x_name" data-page="1" name="x_name" id="x_name" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($nos_members->name->getPlaceHolder()) ?>" value="<?php echo $nos_members->name->EditValue ?>"<?php echo $nos_members->name->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } else { ?>
	<tr id="r_name">
		<td><span id="elh_nos_members_name"><?php echo $nos_members->name->FldCaption() ?></span></td>
		<td><span class="ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_name" id="z_name" value="LIKE"></span></td>
		<td<?php echo $nos_members->name->CellAttributes() ?>>
			<div style="white-space: nowrap;">
				<span id="el_nos_members_name">
<input type="text" data-table="nos_members" data-field="x_name" data-page="1" name="x_name" id="x_name" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($nos_members->name->getPlaceHolder()) ?>" value="<?php echo $nos_members->name->EditValue ?>"<?php echo $nos_members->name->EditAttributes() ?>>
</span>
			</div>
		</td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($nos_members->_email->Visible) { // email ?>
<?php if (ew_IsMobile() || $nos_members_search->IsModal) { ?>
	<div id="r__email" class="form-group">
		<label for="x__email" class="<?php echo $nos_members_search->SearchLabelClass ?>"><span id="elh_nos_members__email"><?php echo $nos_members->_email->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z__email" id="z__email" value="LIKE"></p>
		</label>
		<div class="<?php echo $nos_members_search->SearchRightColumnClass ?>"><div<?php echo $nos_members->_email->CellAttributes() ?>>
			<span id="el_nos_members__email">
<input type="text" data-table="nos_members" data-field="x__email" data-page="1" name="x__email" id="x__email" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($nos_members->_email->getPlaceHolder()) ?>" value="<?php echo $nos_members->_email->EditValue ?>"<?php echo $nos_members->_email->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } else { ?>
	<tr id="r__email">
		<td><span id="elh_nos_members__email"><?php echo $nos_members->_email->FldCaption() ?></span></td>
		<td><span class="ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z__email" id="z__email" value="LIKE"></span></td>
		<td<?php echo $nos_members->_email->CellAttributes() ?>>
			<div style="white-space: nowrap;">
				<span id="el_nos_members__email">
<input type="text" data-table="nos_members" data-field="x__email" data-page="1" name="x__email" id="x__email" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($nos_members->_email->getPlaceHolder()) ?>" value="<?php echo $nos_members->_email->EditValue ?>"<?php echo $nos_members->_email->EditAttributes() ?>>
</span>
			</div>
		</td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($nos_members->profession->Visible) { // profession ?>
<?php if (ew_IsMobile() || $nos_members_search->IsModal) { ?>
	<div id="r_profession" class="form-group">
		<label for="x_profession" class="<?php echo $nos_members_search->SearchLabelClass ?>"><span id="elh_nos_members_profession"><?php echo $nos_members->profession->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_profession" id="z_profession" value="LIKE"></p>
		</label>
		<div class="<?php echo $nos_members_search->SearchRightColumnClass ?>"><div<?php echo $nos_members->profession->CellAttributes() ?>>
			<span id="el_nos_members_profession">
<select data-table="nos_members" data-field="x_profession" data-page="1" data-value-separator="<?php echo ew_HtmlEncode(is_array($nos_members->profession->DisplayValueSeparator) ? json_encode($nos_members->profession->DisplayValueSeparator) : $nos_members->profession->DisplayValueSeparator) ?>" id="x_profession[]" name="x_profession[]" multiple="multiple"<?php echo $nos_members->profession->EditAttributes() ?>>
<?php
if (is_array($nos_members->profession->EditValue)) {
	$arwrk = $nos_members->profession->EditValue;
	$armultiwrk = (strval($nos_members->profession->AdvancedSearch->SearchValue) <> "") ? explode(",", strval($nos_members->profession->AdvancedSearch->SearchValue)) : array();
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
		</div></div>
	</div>
<?php } else { ?>
	<tr id="r_profession">
		<td><span id="elh_nos_members_profession"><?php echo $nos_members->profession->FldCaption() ?></span></td>
		<td><span class="ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_profession" id="z_profession" value="LIKE"></span></td>
		<td<?php echo $nos_members->profession->CellAttributes() ?>>
			<div style="white-space: nowrap;">
				<span id="el_nos_members_profession">
<select data-table="nos_members" data-field="x_profession" data-page="1" data-value-separator="<?php echo ew_HtmlEncode(is_array($nos_members->profession->DisplayValueSeparator) ? json_encode($nos_members->profession->DisplayValueSeparator) : $nos_members->profession->DisplayValueSeparator) ?>" id="x_profession[]" name="x_profession[]" multiple="multiple"<?php echo $nos_members->profession->EditAttributes() ?>>
<?php
if (is_array($nos_members->profession->EditValue)) {
	$arwrk = $nos_members->profession->EditValue;
	$armultiwrk = (strval($nos_members->profession->AdvancedSearch->SearchValue) <> "") ? explode(",", strval($nos_members->profession->AdvancedSearch->SearchValue)) : array();
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
			</div>
		</td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($nos_members->game_type->Visible) { // game_type ?>
<?php if (ew_IsMobile() || $nos_members_search->IsModal) { ?>
	<div id="r_game_type" class="form-group">
		<label for="x_game_type" class="<?php echo $nos_members_search->SearchLabelClass ?>"><span id="elh_nos_members_game_type"><?php echo $nos_members->game_type->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_game_type" id="z_game_type" value="LIKE"></p>
		</label>
		<div class="<?php echo $nos_members_search->SearchRightColumnClass ?>"><div<?php echo $nos_members->game_type->CellAttributes() ?>>
			<span id="el_nos_members_game_type">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $nos_members->game_type->AdvancedSearch->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x_game_type" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php
$arwrk = $nos_members->game_type->EditValue;
if (is_array($arwrk)) {
	$armultiwrk = (strval($nos_members->game_type->AdvancedSearch->SearchValue) <> "") ? explode(",", strval($nos_members->game_type->AdvancedSearch->SearchValue)) : array();
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
		</div></div>
	</div>
<?php } else { ?>
	<tr id="r_game_type">
		<td><span id="elh_nos_members_game_type"><?php echo $nos_members->game_type->FldCaption() ?></span></td>
		<td><span class="ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_game_type" id="z_game_type" value="LIKE"></span></td>
		<td<?php echo $nos_members->game_type->CellAttributes() ?>>
			<div style="white-space: nowrap;">
				<span id="el_nos_members_game_type">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $nos_members->game_type->AdvancedSearch->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x_game_type" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php
$arwrk = $nos_members->game_type->EditValue;
if (is_array($arwrk)) {
	$armultiwrk = (strval($nos_members->game_type->AdvancedSearch->SearchValue) <> "") ? explode(",", strval($nos_members->game_type->AdvancedSearch->SearchValue)) : array();
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
			</div>
		</td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($nos_members->division->Visible) { // division ?>
<?php if (ew_IsMobile() || $nos_members_search->IsModal) { ?>
	<div id="r_division" class="form-group">
		<label for="x_division" class="<?php echo $nos_members_search->SearchLabelClass ?>"><span id="elh_nos_members_division"><?php echo $nos_members->division->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_division" id="z_division" value="LIKE"></p>
		</label>
		<div class="<?php echo $nos_members_search->SearchRightColumnClass ?>"><div<?php echo $nos_members->division->CellAttributes() ?>>
			<span id="el_nos_members_division">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $nos_members->division->AdvancedSearch->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x_division" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php
$arwrk = $nos_members->division->EditValue;
if (is_array($arwrk)) {
	$armultiwrk = (strval($nos_members->division->AdvancedSearch->SearchValue) <> "") ? explode(",", strval($nos_members->division->AdvancedSearch->SearchValue)) : array();
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
		</div></div>
	</div>
<?php } else { ?>
	<tr id="r_division">
		<td><span id="elh_nos_members_division"><?php echo $nos_members->division->FldCaption() ?></span></td>
		<td><span class="ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_division" id="z_division" value="LIKE"></span></td>
		<td<?php echo $nos_members->division->CellAttributes() ?>>
			<div style="white-space: nowrap;">
				<span id="el_nos_members_division">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $nos_members->division->AdvancedSearch->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x_division" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php
$arwrk = $nos_members->division->EditValue;
if (is_array($arwrk)) {
	$armultiwrk = (strval($nos_members->division->AdvancedSearch->SearchValue) <> "") ? explode(",", strval($nos_members->division->AdvancedSearch->SearchValue)) : array();
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
			</div>
		</td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($nos_members->has_expansion->Visible) { // has_expansion ?>
<?php if (ew_IsMobile() || $nos_members_search->IsModal) { ?>
	<div id="r_has_expansion" class="form-group">
		<label for="x_has_expansion" class="<?php echo $nos_members_search->SearchLabelClass ?>"><span id="elh_nos_members_has_expansion"><?php echo $nos_members->has_expansion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_has_expansion" id="z_has_expansion" value="="></p>
		</label>
		<div class="<?php echo $nos_members_search->SearchRightColumnClass ?>"><div<?php echo $nos_members->has_expansion->CellAttributes() ?>>
			<span id="el_nos_members_has_expansion">
<select data-table="nos_members" data-field="x_has_expansion" data-page="1" data-value-separator="<?php echo ew_HtmlEncode(is_array($nos_members->has_expansion->DisplayValueSeparator) ? json_encode($nos_members->has_expansion->DisplayValueSeparator) : $nos_members->has_expansion->DisplayValueSeparator) ?>" id="x_has_expansion" name="x_has_expansion" size=3<?php echo $nos_members->has_expansion->EditAttributes() ?>>
<?php
if (is_array($nos_members->has_expansion->EditValue)) {
	$arwrk = $nos_members->has_expansion->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($nos_members->has_expansion->AdvancedSearch->SearchValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
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
		</div></div>
	</div>
<?php } else { ?>
	<tr id="r_has_expansion">
		<td><span id="elh_nos_members_has_expansion"><?php echo $nos_members->has_expansion->FldCaption() ?></span></td>
		<td><span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_has_expansion" id="z_has_expansion" value="="></span></td>
		<td<?php echo $nos_members->has_expansion->CellAttributes() ?>>
			<div style="white-space: nowrap;">
				<span id="el_nos_members_has_expansion">
<select data-table="nos_members" data-field="x_has_expansion" data-page="1" data-value-separator="<?php echo ew_HtmlEncode(is_array($nos_members->has_expansion->DisplayValueSeparator) ? json_encode($nos_members->has_expansion->DisplayValueSeparator) : $nos_members->has_expansion->DisplayValueSeparator) ?>" id="x_has_expansion" name="x_has_expansion" size=3<?php echo $nos_members->has_expansion->EditAttributes() ?>>
<?php
if (is_array($nos_members->has_expansion->EditValue)) {
	$arwrk = $nos_members->has_expansion->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($nos_members->has_expansion->AdvancedSearch->SearchValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
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
			</div>
		</td>
	</tr>
<?php } ?>
<?php } ?>
<?php if (ew_IsMobile() || $nos_members_search->IsModal) { ?>
</div>
<?php } else { ?>
</table>
</div>
<?php } ?>
<?php if (!$nos_members_search->IsModal) { ?>
<?php if (ew_IsMobile()) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<?php } else { ?>
<div class="ewDesktopButton">
<?php } ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
<?php if (ew_IsMobile()) { ?>
	</div>
</div>
<?php } else { ?>
</div>
<?php } ?>
<?php } ?>
<?php if (!ew_IsMobile() && !$nos_members_search->IsModal) { ?>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fnos_memberssearch.Init();
</script>
<?php
$nos_members_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$nos_members_search->Page_Terminate();
?>
