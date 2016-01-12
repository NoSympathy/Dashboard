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

$nos_members_list = NULL; // Initialize page object first

class cnos_members_list extends cnos_members {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{035BB177-6A34-4418-A6BD-DF1DD7A296CE}";

	// Table name
	var $TableName = 'nos_members';

	// Page object name
	var $PageObjName = 'nos_members_list';

	// Grid form hidden field names
	var $FormName = 'fnos_memberslist';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Custom export
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "nos_membersadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "nos_membersdelete.php";
		$this->MultiUpdateUrl = "nos_membersupdate.php";

		// Table object (nos_roster_admin)
		if (!isset($GLOBALS['nos_roster_admin'])) $GLOBALS['nos_roster_admin'] = new cnos_roster_admin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

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

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";

		// Filter options
		$this->FilterOptions = new cListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption fnos_memberslistsrch";

		// List actions
		$this->ListActions = new cListActions();
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

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();

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

		// Setup other options
		$this->SetupOtherOptions();

		// Set up custom action (compatible with old version)
		foreach ($this->CustomActions as $name => $action)
			$this->ListActions->Add($name, $action);

		// Show checkbox column if multiple action
		foreach ($this->ListActions->Items as $listaction) {
			if ($listaction->Select == EW_ACTION_MULTIPLE && $listaction->Allow) {
				$this->ListOptions->Items["checkbox"]->Visible = TRUE;
				break;
			}
		}
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

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $OtherOptions = array(); // Other options
	var $FilterOptions; // Filter options
	var $ListActions; // List actions
	var $SelectedCount = 0;
	var $SelectedIndex = 0;
	var $DisplayRecs = 20;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $DefaultSearchWhere = ""; // Default search WHERE clause
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $MultiColumnClass;
	var $MultiColumnEditClass = "col-sm-12";
	var $MultiColumnCnt = 12;
	var $MultiColumnEditCnt = 12;
	var $GridCnt = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;	
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $DetailPages;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Process list action first
			if ($this->ProcessListAction()) // Ajax request
				$this->Page_Terminate();

			// Handle reset command
			$this->ResetCmd();

			// Set up Breadcrumb
			if ($this->Export == "")
				$this->SetupBreadcrumb();

			// Check QueryString parameters
			if (@$_GET["a"] <> "") {
				$this->CurrentAction = $_GET["a"];

				// Clear inline mode
				if ($this->CurrentAction == "cancel")
					$this->ClearInlineMode();

				// Switch to inline edit mode
				if ($this->CurrentAction == "edit")
					$this->InlineEditMode();
			} else {
				if (@$_POST["a_list"] <> "") {
					$this->CurrentAction = $_POST["a_list"]; // Get action

					// Inline Update
					if (($this->CurrentAction == "update" || $this->CurrentAction == "overwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "edit")
						$this->InlineUpdate();
				}
			}

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide options
			if ($this->Export <> "" || $this->CurrentAction <> "") {
				$this->ExportOptions->HideAllOptions();
				$this->FilterOptions->HideAllOptions();
			}

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Get default search criteria
			ew_AddFilter($this->DefaultSearchWhere, $this->AdvancedSearchWhere(TRUE));

			// Get and validate search values for advanced search
			$this->LoadSearchValues(); // Get search values

			// Restore filter list
			$this->RestoreFilterList();
			if (!$this->ValidateSearch())
				$this->setFailureMessage($gsSearchError);

			// Restore search parms from Session if not searching / reset / export
			if (($this->Export <> "" || $this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall") && $this->CheckSearchParms())
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get search criteria for advanced search
			if ($gsSearchError == "")
				$sSrchAdvanced = $this->AdvancedSearchWhere();
		}

		// Restore display records
		if ($this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Load search default if no existing search criteria
		if (!$this->CheckSearchParms()) {

			// Load advanced search from default
			if ($this->LoadAdvancedSearchDefault()) {
				$sSrchAdvanced = $this->AdvancedSearchWhere();
			}
		}

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$this->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->Command == "search" && !$this->RestoreSearch) {
			$this->setSearchWhere($this->SearchWhere); // Save to Session
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} else {
			$this->SearchWhere = $this->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		if (!$Security->CanList())
			$sFilter = "(0=1)"; // Filter all records
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter in session
		$this->setSessionWhere($sFilter);
		$this->CurrentFilter = "";

		// Load record count first
		if (!$this->IsAddOrEdit()) {
			$bSelectLimit = $this->UseSelectLimit;
			if ($bSelectLimit) {
				$this->TotalRecs = $this->SelectRecordCount();
			} else {
				if ($this->Recordset = $this->LoadRecordset())
					$this->TotalRecs = $this->Recordset->RecordCount();
			}
		}

		// Search options
		$this->SetupSearchOptions();
	}

	//  Exit inline mode
	function ClearInlineMode() {
		$this->setKey("memberID", ""); // Clear inline edit key
		$this->LastAction = $this->CurrentAction; // Save last action
		$this->CurrentAction = ""; // Clear action
		$_SESSION[EW_SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Inline Edit mode
	function InlineEditMode() {
		global $Security, $Language;
		if (!$Security->CanEdit())
			$this->Page_Terminate("login.php"); // Go to login page
		$bInlineEdit = TRUE;
		if (@$_GET["memberID"] <> "") {
			$this->memberID->setQueryStringValue($_GET["memberID"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {
				$this->setKey("memberID", $this->memberID->CurrentValue); // Set up inline edit key
				$_SESSION[EW_SESSION_INLINE_MODE] = "edit"; // Enable inline edit
			}
		}
	}

	// Perform update to Inline Edit record
	function InlineUpdate() {
		global $Language, $objForm, $gsFormError;
		$objForm->Index = 1; 
		$this->LoadFormValues(); // Get form values

		// Validate form
		$bInlineUpdate = TRUE;
		if (!$this->ValidateForm()) {	
			$bInlineUpdate = FALSE; // Form error, reset action
			$this->setFailureMessage($gsFormError);
		} else {
			$bInlineUpdate = FALSE;
			$rowkey = strval($objForm->GetValue($this->FormKeyName));
			if ($this->SetupKeyValues($rowkey)) { // Set up key values
				if ($this->CheckInlineEditKey()) { // Check key
					$this->SendEmail = TRUE; // Send email on update success
					$bInlineUpdate = $this->EditRow(); // Update record
				} else {
					$bInlineUpdate = FALSE;
				}
			}
		}
		if ($bInlineUpdate) { // Update success
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
			$this->EventCancelled = TRUE; // Cancel event
			$this->CurrentAction = "edit"; // Stay in edit mode
		}
	}

	// Check Inline Edit key
	function CheckInlineEditKey() {

		//CheckInlineEditKey = True
		if (strval($this->getKey("memberID")) <> strval($this->memberID->CurrentValue))
			return FALSE;
		return TRUE;
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 1) {
			$this->memberID->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->memberID->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->name->AdvancedSearch->ToJSON(), ","); // Field name
		$sFilterList = ew_Concat($sFilterList, $this->_email->AdvancedSearch->ToJSON(), ","); // Field email
		$sFilterList = ew_Concat($sFilterList, $this->profession->AdvancedSearch->ToJSON(), ","); // Field profession
		$sFilterList = ew_Concat($sFilterList, $this->game_type->AdvancedSearch->ToJSON(), ","); // Field game_type
		$sFilterList = ew_Concat($sFilterList, $this->division->AdvancedSearch->ToJSON(), ","); // Field division
		$sFilterList = ew_Concat($sFilterList, $this->has_expansion->AdvancedSearch->ToJSON(), ","); // Field has_expansion

		// Return filter list in json
		return ($sFilterList <> "") ? "{" . $sFilterList . "}" : "null";
	}

	// Restore list of filters
	function RestoreFilterList() {

		// Return if not reset filter
		if (@$_POST["cmd"] <> "resetfilter")
			return FALSE;
		$filter = json_decode(ew_StripSlashes(@$_POST["filter"]), TRUE);
		$this->Command = "search";

		// Field name
		$this->name->AdvancedSearch->SearchValue = @$filter["x_name"];
		$this->name->AdvancedSearch->SearchOperator = @$filter["z_name"];
		$this->name->AdvancedSearch->SearchCondition = @$filter["v_name"];
		$this->name->AdvancedSearch->SearchValue2 = @$filter["y_name"];
		$this->name->AdvancedSearch->SearchOperator2 = @$filter["w_name"];
		$this->name->AdvancedSearch->Save();

		// Field email
		$this->_email->AdvancedSearch->SearchValue = @$filter["x__email"];
		$this->_email->AdvancedSearch->SearchOperator = @$filter["z__email"];
		$this->_email->AdvancedSearch->SearchCondition = @$filter["v__email"];
		$this->_email->AdvancedSearch->SearchValue2 = @$filter["y__email"];
		$this->_email->AdvancedSearch->SearchOperator2 = @$filter["w__email"];
		$this->_email->AdvancedSearch->Save();

		// Field profession
		$this->profession->AdvancedSearch->SearchValue = @$filter["x_profession"];
		$this->profession->AdvancedSearch->SearchOperator = @$filter["z_profession"];
		$this->profession->AdvancedSearch->SearchCondition = @$filter["v_profession"];
		$this->profession->AdvancedSearch->SearchValue2 = @$filter["y_profession"];
		$this->profession->AdvancedSearch->SearchOperator2 = @$filter["w_profession"];
		$this->profession->AdvancedSearch->Save();

		// Field game_type
		$this->game_type->AdvancedSearch->SearchValue = @$filter["x_game_type"];
		$this->game_type->AdvancedSearch->SearchOperator = @$filter["z_game_type"];
		$this->game_type->AdvancedSearch->SearchCondition = @$filter["v_game_type"];
		$this->game_type->AdvancedSearch->SearchValue2 = @$filter["y_game_type"];
		$this->game_type->AdvancedSearch->SearchOperator2 = @$filter["w_game_type"];
		$this->game_type->AdvancedSearch->Save();

		// Field division
		$this->division->AdvancedSearch->SearchValue = @$filter["x_division"];
		$this->division->AdvancedSearch->SearchOperator = @$filter["z_division"];
		$this->division->AdvancedSearch->SearchCondition = @$filter["v_division"];
		$this->division->AdvancedSearch->SearchValue2 = @$filter["y_division"];
		$this->division->AdvancedSearch->SearchOperator2 = @$filter["w_division"];
		$this->division->AdvancedSearch->Save();

		// Field has_expansion
		$this->has_expansion->AdvancedSearch->SearchValue = @$filter["x_has_expansion"];
		$this->has_expansion->AdvancedSearch->SearchOperator = @$filter["z_has_expansion"];
		$this->has_expansion->AdvancedSearch->SearchCondition = @$filter["v_has_expansion"];
		$this->has_expansion->AdvancedSearch->SearchValue2 = @$filter["y_has_expansion"];
		$this->has_expansion->AdvancedSearch->SearchOperator2 = @$filter["w_has_expansion"];
		$this->has_expansion->AdvancedSearch->Save();
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere($Default = FALSE) {
		global $Security;
		$sWhere = "";
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->name, $Default, FALSE); // name
		$this->BuildSearchSql($sWhere, $this->_email, $Default, FALSE); // email
		$this->BuildSearchSql($sWhere, $this->profession, $Default, TRUE); // profession
		$this->BuildSearchSql($sWhere, $this->game_type, $Default, TRUE); // game_type
		$this->BuildSearchSql($sWhere, $this->division, $Default, TRUE); // division
		$this->BuildSearchSql($sWhere, $this->has_expansion, $Default, FALSE); // has_expansion

		// Set up search parm
		if (!$Default && $sWhere <> "") {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->name->AdvancedSearch->Save(); // name
			$this->_email->AdvancedSearch->Save(); // email
			$this->profession->AdvancedSearch->Save(); // profession
			$this->game_type->AdvancedSearch->Save(); // game_type
			$this->division->AdvancedSearch->Save(); // division
			$this->has_expansion->AdvancedSearch->Save(); // has_expansion
		}
		return $sWhere;
	}

	// Build search SQL
	function BuildSearchSql(&$Where, &$Fld, $Default, $MultiValue) {
		$FldParm = substr($Fld->FldVar, 2);
		$FldVal = ($Default) ? $Fld->AdvancedSearch->SearchValueDefault : $Fld->AdvancedSearch->SearchValue; // @$_GET["x_$FldParm"]
		$FldOpr = ($Default) ? $Fld->AdvancedSearch->SearchOperatorDefault : $Fld->AdvancedSearch->SearchOperator; // @$_GET["z_$FldParm"]
		$FldCond = ($Default) ? $Fld->AdvancedSearch->SearchConditionDefault : $Fld->AdvancedSearch->SearchCondition; // @$_GET["v_$FldParm"]
		$FldVal2 = ($Default) ? $Fld->AdvancedSearch->SearchValue2Default : $Fld->AdvancedSearch->SearchValue2; // @$_GET["y_$FldParm"]
		$FldOpr2 = ($Default) ? $Fld->AdvancedSearch->SearchOperator2Default : $Fld->AdvancedSearch->SearchOperator2; // @$_GET["w_$FldParm"]
		$sWrk = "";

		//$FldVal = ew_StripSlashes($FldVal);
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);

		//$FldVal2 = ew_StripSlashes($FldVal2);
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$FldOpr = strtoupper(trim($FldOpr));
		if ($FldOpr == "") $FldOpr = "=";
		$FldOpr2 = strtoupper(trim($FldOpr2));
		if ($FldOpr2 == "") $FldOpr2 = "=";
		if (EW_SEARCH_MULTI_VALUE_OPTION == 1 || $FldOpr <> "LIKE" ||
			($FldOpr2 <> "LIKE" && $FldVal2 <> ""))
			$MultiValue = FALSE;
		if ($MultiValue) {
			$sWrk1 = ($FldVal <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr, $FldVal, $this->DBID) : ""; // Field value 1
			$sWrk2 = ($FldVal2 <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr2, $FldVal2, $this->DBID) : ""; // Field value 2
			$sWrk = $sWrk1; // Build final SQL
			if ($sWrk2 <> "")
				$sWrk = ($sWrk <> "") ? "($sWrk) $FldCond ($sWrk2)" : $sWrk2;
		} else {
			$FldVal = $this->ConvertSearchValue($Fld, $FldVal);
			$FldVal2 = $this->ConvertSearchValue($Fld, $FldVal2);
			$sWrk = ew_GetSearchSql($Fld, $FldVal, $FldOpr, $FldCond, $FldVal2, $FldOpr2, $this->DBID);
		}
		ew_AddFilter($Where, $sWrk);
	}

	// Convert search value
	function ConvertSearchValue(&$Fld, $FldVal) {
		if ($FldVal == EW_NULL_VALUE || $FldVal == EW_NOT_NULL_VALUE)
			return $FldVal;
		$Value = $FldVal;
		if ($Fld->FldDataType == EW_DATATYPE_BOOLEAN) {
			if ($FldVal <> "") $Value = ($FldVal == "1" || strtolower(strval($FldVal)) == "y" || strtolower(strval($FldVal)) == "t") ? $Fld->TrueValue : $Fld->FalseValue;
		} elseif ($Fld->FldDataType == EW_DATATYPE_DATE) {
			if ($FldVal <> "") $Value = ew_UnFormatDateTime($FldVal, $Fld->FldDateTimeFormat);
		}
		return $Value;
	}

	// Check if search parm exists
	function CheckSearchParms() {
		if ($this->name->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->_email->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->profession->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->game_type->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->division->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->has_expansion->AdvancedSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear advanced search parameters
		$this->ResetAdvancedSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all advanced search parameters
	function ResetAdvancedSearchParms() {
		$this->name->AdvancedSearch->UnsetSession();
		$this->_email->AdvancedSearch->UnsetSession();
		$this->profession->AdvancedSearch->UnsetSession();
		$this->game_type->AdvancedSearch->UnsetSession();
		$this->division->AdvancedSearch->UnsetSession();
		$this->has_expansion->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore advanced search values
		$this->name->AdvancedSearch->Load();
		$this->_email->AdvancedSearch->Load();
		$this->profession->AdvancedSearch->Load();
		$this->game_type->AdvancedSearch->Load();
		$this->division->AdvancedSearch->Load();
		$this->has_expansion->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->name); // name
			$this->UpdateSort($this->_email); // email
			$this->UpdateSort($this->profession); // profession
			$this->UpdateSort($this->game_type); // game_type
			$this->UpdateSort($this->division); // division
			$this->UpdateSort($this->has_expansion); // has_expansion
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->getSqlOrderBy() <> "") {
				$sOrderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset search criteria
			if ($this->Command == "reset" || $this->Command == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->name->setSort("");
				$this->_email->setSort("");
				$this->profession->setSort("");
				$this->game_type->setSort("");
				$this->division->setSort("");
				$this->has_expansion->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanView();
		$item->OnLeft = FALSE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanEdit();
		$item->OnLeft = FALSE;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssStyle = "white-space: nowrap;";
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = FALSE;
		$item->OnLeft = FALSE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = FALSE;
		if ($this->ListOptions->UseButtonGroup && ew_IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$this->SetupListOptionsExt();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// Set up row action and key
		if (is_numeric($this->RowIndex) && $this->CurrentMode <> "view") {
			$objForm->Index = $this->RowIndex;
			$ActionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
			$OldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormOldKeyName);
			$KeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormKeyName);
			$BlankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
			if ($this->RowAction <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $ActionName . "\" id=\"" . $ActionName . "\" value=\"" . $this->RowAction . "\">";
			if ($this->RowAction == "delete") {
				$rowkey = $objForm->GetValue($this->FormKeyName);
				$this->SetupKeyValues($rowkey);
			}
			if ($this->RowAction == "insert" && $this->CurrentAction == "F" && $this->EmptyRow())
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $BlankRowName . "\" id=\"" . $BlankRowName . "\" value=\"1\">";
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($this->CurrentAction == "edit" && $this->RowType == EW_ROWTYPE_EDIT) { // Inline-Edit
			$this->ListOptions->CustomItem = "edit"; // Show edit column only
			$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
				$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
					"<a class=\"ewGridLink ewInlineUpdate\" title=\"" . ew_HtmlTitle($Language->Phrase("UpdateLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("UpdateLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . ew_GetHashUrl($this->PageName(), $this->PageObjName . "_row_" . $this->RowCnt) . "');\">" . $Language->Phrase("UpdateLink") . "</a>&nbsp;" .
					"<a class=\"ewGridLink ewInlineCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("CancelLink") . "</a>" .
					"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"update\"></div>";
			$oListOpt->Body .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . ew_HtmlEncode($this->memberID->CurrentValue) . "\">";
			return;
		}

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		if ($Security->CanView())
			$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewLink")) . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
		else
			$oListOpt->Body = "";

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($Security->CanEdit()) {
			$oListOpt->Body .= "<a class=\"ewRowLink ewInlineEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("InlineEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InlineEditLink")) . "\" href=\"" . ew_HtmlEncode(ew_GetHashUrl($this->InlineEditUrl, $this->PageObjName . "_row_" . $this->RowCnt)) . "\">" . $Language->Phrase("InlineEditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// Set up list action buttons
		$oListOpt = &$this->ListOptions->GetItem("listactions");
		if ($oListOpt) {
			$body = "";
			$links = array();
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_SINGLE && $listaction->Allow) {
					$action = $listaction->Action;
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode(str_replace(" ewIcon", "", $listaction->Icon)) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\"></span> " : "";
					$links[] = "<li><a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . $listaction->Caption . "</a></li>";
					if (count($links) == 1) // Single button
						$body = "<a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $Language->Phrase("ListActionButton") . "</a>";
				}
			}
			if (count($links) > 1) { // More than one buttons, use dropdown
				$body = "<button class=\"dropdown-toggle btn btn-default btn-sm ewActions\" title=\"" . ew_HtmlTitle($Language->Phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("ListActionButton") . "<b class=\"caret\"></b></button>";
				$content = "";
				foreach ($links as $link)
					$content .= "<li>" . $link . "</li>";
				$body .= "<ul class=\"dropdown-menu" . ($oListOpt->OnLeft ? "" : " dropdown-menu-right") . "\">". $content . "</ul>";
				$body = "<div class=\"btn-group\">" . $body . "</div>";
			}
			if (count($links) > 0) {
				$oListOpt->Body = $body;
				$oListOpt->Visible = TRUE;
			}
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->memberID->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];

		// Add
		$item = &$option->Add("add");
		$item->Body = "<a class=\"ewAddEdit ewAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("AddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddLink")) . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());
		$option = $options["action"];

		// Set up options default
		foreach ($options as &$option) {
			$option->UseImageAndText = TRUE;
			$option->UseDropDownButton = TRUE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-sm"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fnos_memberslistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fnos_memberslistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
		$this->FilterOptions->DropDownButtonPhrase = $Language->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fnos_memberslist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
					$item->Visible = $listaction->Allow;
				}
			}

			// Hide grid edit and other options
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$option->HideAllOptions();
			}
	}

	// Process list action
	function ProcessListAction() {
		global $Language, $Security;
		$userlist = "";
		$user = "";
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {

			// Check permission first
			$ActionCaption = $UserAction;
			if (array_key_exists($UserAction, $this->ListActions->Items)) {
				$ActionCaption = $this->ListActions->Items[$UserAction]->Caption;
				if (!$this->ListActions->Items[$UserAction]->Allow) {
					$errmsg = str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionNotAllowed"));
					if (@$_POST["ajax"] == $UserAction) // Ajax
						echo "<p class=\"text-danger\">" . $errmsg . "</p>";
					else
						$this->setFailureMessage($errmsg);
					return FALSE;
				}
			}
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$this->CurrentAction = $UserAction;

			// Call row action event
			if ($rs && !$rs->EOF) {
				$conn->BeginTrans();
				$this->SelectedCount = $rs->RecordCount();
				$this->SelectedIndex = 0;
				while (!$rs->EOF) {
					$this->SelectedIndex++;
					$row = $rs->fields;
					$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
					$rs->MoveNext();
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionFailed")));
					}
				}
			}
			if ($rs)
				$rs->Close();
			$this->CurrentAction = ""; // Clear action
			if (@$_POST["ajax"] == $UserAction) { // Ajax
				if ($this->getSuccessMessage() <> "") {
					echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
					$this->ClearSuccessMessage(); // Clear message
				}
				if ($this->getFailureMessage() <> "") {
					echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
					$this->ClearFailureMessage(); // Clear message
				}
				return TRUE;
			}
		}
		return FALSE; // Not ajax request
	}

	// Set up search options
	function SetupSearchOptions() {
		global $Language;
		$this->SearchOptions = new cListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Advanced search button
		$item = &$this->SearchOptions->Add("advancedsearch");
		$item->Body = "<a class=\"btn btn-default ewAdvancedSearch\" title=\"" . $Language->Phrase("AdvancedSearch") . "\" data-caption=\"" . $Language->Phrase("AdvancedSearch") . "\" href=\"nos_memberssrch.php\">" . $Language->Phrase("AdvancedSearchBtn") . "</a>";
		$item->Visible = TRUE;

		// Button group for search
		$this->SearchOptions->UseDropDownButton = FALSE;
		$this->SearchOptions->UseImageAndText = TRUE;
		$this->SearchOptions->UseButtonGroup = TRUE;
		$this->SearchOptions->DropDownButtonPhrase = $Language->Phrase("ButtonSearch");

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide search options
		if ($this->Export <> "" || $this->CurrentAction <> "")
			$this->SearchOptions->HideAllOptions();
		global $Security;
		if (!$Security->CanSearch()) {
			$this->SearchOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
		}
	}

	function SetupListOptionsExt() {
		global $Security, $Language;
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
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
	}

	// Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// name

		$this->name->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_name"]);
		if ($this->name->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->name->AdvancedSearch->SearchOperator = @$_GET["z_name"];

		// email
		$this->_email->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x__email"]);
		if ($this->_email->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->_email->AdvancedSearch->SearchOperator = @$_GET["z__email"];

		// profession
		$this->profession->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_profession"]);
		if ($this->profession->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->profession->AdvancedSearch->SearchOperator = @$_GET["z_profession"];
		if (is_array($this->profession->AdvancedSearch->SearchValue)) $this->profession->AdvancedSearch->SearchValue = implode(",", $this->profession->AdvancedSearch->SearchValue);
		if (is_array($this->profession->AdvancedSearch->SearchValue2)) $this->profession->AdvancedSearch->SearchValue2 = implode(",", $this->profession->AdvancedSearch->SearchValue2);

		// game_type
		$this->game_type->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_game_type"]);
		if ($this->game_type->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->game_type->AdvancedSearch->SearchOperator = @$_GET["z_game_type"];
		if (is_array($this->game_type->AdvancedSearch->SearchValue)) $this->game_type->AdvancedSearch->SearchValue = implode(",", $this->game_type->AdvancedSearch->SearchValue);
		if (is_array($this->game_type->AdvancedSearch->SearchValue2)) $this->game_type->AdvancedSearch->SearchValue2 = implode(",", $this->game_type->AdvancedSearch->SearchValue2);

		// division
		$this->division->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_division"]);
		if ($this->division->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->division->AdvancedSearch->SearchOperator = @$_GET["z_division"];
		if (is_array($this->division->AdvancedSearch->SearchValue)) $this->division->AdvancedSearch->SearchValue = implode(",", $this->division->AdvancedSearch->SearchValue);
		if (is_array($this->division->AdvancedSearch->SearchValue2)) $this->division->AdvancedSearch->SearchValue2 = implode(",", $this->division->AdvancedSearch->SearchValue2);

		// has_expansion
		$this->has_expansion->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_has_expansion"]);
		if ($this->has_expansion->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->has_expansion->AdvancedSearch->SearchOperator = @$_GET["z_has_expansion"];
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
		if (!$this->memberID->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->memberID->setFormValue($objForm->GetValue("x_memberID"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->memberID->CurrentValue = $this->memberID->FormValue;
		$this->name->CurrentValue = $this->name->FormValue;
		$this->_email->CurrentValue = $this->_email->FormValue;
		$this->profession->CurrentValue = $this->profession->FormValue;
		$this->game_type->CurrentValue = $this->game_type->FormValue;
		$this->division->CurrentValue = $this->division->FormValue;
		$this->has_expansion->CurrentValue = $this->has_expansion->FormValue;
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->SelectSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// memberID

		$this->memberID->CellCssStyle = "white-space: nowrap;";

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

			// Edit refer script
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

			// profession
			$this->profession->SetDbValueDef($rsnew, $this->profession->CurrentValue, NULL, $this->profession->ReadOnly);

			// game_type
			$this->game_type->SetDbValueDef($rsnew, $this->game_type->CurrentValue, NULL, $this->game_type->ReadOnly);

			// division
			$this->division->SetDbValueDef($rsnew, $this->division->CurrentValue, NULL, $this->division->ReadOnly);

			// has_expansion
			$this->has_expansion->SetDbValueDef($rsnew, $this->has_expansion->CurrentValue, "", $this->has_expansion->ReadOnly);

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
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
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

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example: 
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
	}

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

	    //$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($nos_members_list)) $nos_members_list = new cnos_members_list();

// Page init
$nos_members_list->Page_Init();

// Page main
$nos_members_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$nos_members_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fnos_memberslist = new ew_Form("fnos_memberslist", "list");
fnos_memberslist.FormKeyCountName = '<?php echo $nos_members_list->FormKeyCountName ?>';

// Validate form
fnos_memberslist.Validate = function() {
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
	return true;
}

// Form_CustomValidate event
fnos_memberslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fnos_memberslist.ValidateRequired = true;
<?php } else { ?>
fnos_memberslist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fnos_memberslist.Lists["x_profession[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fnos_memberslist.Lists["x_profession[]"].Options = <?php echo json_encode($nos_members->profession->Options()) ?>;
fnos_memberslist.Lists["x_game_type[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fnos_memberslist.Lists["x_game_type[]"].Options = <?php echo json_encode($nos_members->game_type->Options()) ?>;
fnos_memberslist.Lists["x_division[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fnos_memberslist.Lists["x_division[]"].Options = <?php echo json_encode($nos_members->division->Options()) ?>;
fnos_memberslist.Lists["x_has_expansion"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fnos_memberslist.Lists["x_has_expansion"].Options = <?php echo json_encode($nos_members->has_expansion->Options()) ?>;

// Form object for search
var CurrentSearchForm = fnos_memberslistsrch = new ew_Form("fnos_memberslistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php if ($nos_members_list->TotalRecs > 0 && $nos_members_list->ExportOptions->Visible()) { ?>
<?php $nos_members_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($nos_members_list->SearchOptions->Visible()) { ?>
<?php $nos_members_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($nos_members_list->FilterOptions->Visible()) { ?>
<?php $nos_members_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php
	$bSelectLimit = $nos_members_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($nos_members_list->TotalRecs <= 0)
			$nos_members_list->TotalRecs = $nos_members->SelectRecordCount();
	} else {
		if (!$nos_members_list->Recordset && ($nos_members_list->Recordset = $nos_members_list->LoadRecordset()))
			$nos_members_list->TotalRecs = $nos_members_list->Recordset->RecordCount();
	}
	$nos_members_list->StartRec = 1;
	if ($nos_members_list->DisplayRecs <= 0 || ($nos_members->Export <> "" && $nos_members->ExportAll)) // Display all records
		$nos_members_list->DisplayRecs = $nos_members_list->TotalRecs;
	if (!($nos_members->Export <> "" && $nos_members->ExportAll))
		$nos_members_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$nos_members_list->Recordset = $nos_members_list->LoadRecordset($nos_members_list->StartRec-1, $nos_members_list->DisplayRecs);

	// Set no record found message
	if ($nos_members->CurrentAction == "" && $nos_members_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$nos_members_list->setWarningMessage($Language->Phrase("NoPermission"));
		if ($nos_members_list->SearchWhere == "0=101")
			$nos_members_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$nos_members_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$nos_members_list->RenderOtherOptions();
?>
<?php $nos_members_list->ShowPageHeader(); ?>
<?php
$nos_members_list->ShowMessage();
?>
<?php if ($nos_members_list->TotalRecs > 0 || $nos_members->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<form name="fnos_memberslist" id="fnos_memberslist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($nos_members_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $nos_members_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="nos_members">
<div id="gmp_nos_members" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($nos_members_list->TotalRecs > 0) { ?>
<table id="tbl_nos_memberslist" class="table ewTable">
<?php echo $nos_members->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$nos_members_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$nos_members_list->RenderListOptions();

// Render list options (header, left)
$nos_members_list->ListOptions->Render("header", "left");
?>
<?php if ($nos_members->name->Visible) { // name ?>
	<?php if ($nos_members->SortUrl($nos_members->name) == "") { ?>
		<th data-name="name"><div id="elh_nos_members_name" class="nos_members_name"><div class="ewTableHeaderCaption"><?php echo $nos_members->name->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="name"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $nos_members->SortUrl($nos_members->name) ?>',1);"><div id="elh_nos_members_name" class="nos_members_name">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $nos_members->name->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($nos_members->name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($nos_members->name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($nos_members->_email->Visible) { // email ?>
	<?php if ($nos_members->SortUrl($nos_members->_email) == "") { ?>
		<th data-name="_email"><div id="elh_nos_members__email" class="nos_members__email"><div class="ewTableHeaderCaption"><?php echo $nos_members->_email->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="_email"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $nos_members->SortUrl($nos_members->_email) ?>',1);"><div id="elh_nos_members__email" class="nos_members__email">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $nos_members->_email->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($nos_members->_email->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($nos_members->_email->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($nos_members->profession->Visible) { // profession ?>
	<?php if ($nos_members->SortUrl($nos_members->profession) == "") { ?>
		<th data-name="profession"><div id="elh_nos_members_profession" class="nos_members_profession"><div class="ewTableHeaderCaption"><?php echo $nos_members->profession->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="profession"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $nos_members->SortUrl($nos_members->profession) ?>',1);"><div id="elh_nos_members_profession" class="nos_members_profession">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $nos_members->profession->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($nos_members->profession->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($nos_members->profession->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($nos_members->game_type->Visible) { // game_type ?>
	<?php if ($nos_members->SortUrl($nos_members->game_type) == "") { ?>
		<th data-name="game_type"><div id="elh_nos_members_game_type" class="nos_members_game_type"><div class="ewTableHeaderCaption"><?php echo $nos_members->game_type->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="game_type"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $nos_members->SortUrl($nos_members->game_type) ?>',1);"><div id="elh_nos_members_game_type" class="nos_members_game_type">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $nos_members->game_type->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($nos_members->game_type->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($nos_members->game_type->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($nos_members->division->Visible) { // division ?>
	<?php if ($nos_members->SortUrl($nos_members->division) == "") { ?>
		<th data-name="division"><div id="elh_nos_members_division" class="nos_members_division"><div class="ewTableHeaderCaption"><?php echo $nos_members->division->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="division"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $nos_members->SortUrl($nos_members->division) ?>',1);"><div id="elh_nos_members_division" class="nos_members_division">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $nos_members->division->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($nos_members->division->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($nos_members->division->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($nos_members->has_expansion->Visible) { // has_expansion ?>
	<?php if ($nos_members->SortUrl($nos_members->has_expansion) == "") { ?>
		<th data-name="has_expansion"><div id="elh_nos_members_has_expansion" class="nos_members_has_expansion"><div class="ewTableHeaderCaption"><?php echo $nos_members->has_expansion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="has_expansion"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $nos_members->SortUrl($nos_members->has_expansion) ?>',1);"><div id="elh_nos_members_has_expansion" class="nos_members_has_expansion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $nos_members->has_expansion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($nos_members->has_expansion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($nos_members->has_expansion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$nos_members_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($nos_members->ExportAll && $nos_members->Export <> "") {
	$nos_members_list->StopRec = $nos_members_list->TotalRecs;
} else {

	// Set the last record to display
	if ($nos_members_list->TotalRecs > $nos_members_list->StartRec + $nos_members_list->DisplayRecs - 1)
		$nos_members_list->StopRec = $nos_members_list->StartRec + $nos_members_list->DisplayRecs - 1;
	else
		$nos_members_list->StopRec = $nos_members_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($nos_members_list->FormKeyCountName) && ($nos_members->CurrentAction == "gridadd" || $nos_members->CurrentAction == "gridedit" || $nos_members->CurrentAction == "F")) {
		$nos_members_list->KeyCount = $objForm->GetValue($nos_members_list->FormKeyCountName);
		$nos_members_list->StopRec = $nos_members_list->StartRec + $nos_members_list->KeyCount - 1;
	}
}
$nos_members_list->RecCnt = $nos_members_list->StartRec - 1;
if ($nos_members_list->Recordset && !$nos_members_list->Recordset->EOF) {
	$nos_members_list->Recordset->MoveFirst();
	$bSelectLimit = $nos_members_list->UseSelectLimit;
	if (!$bSelectLimit && $nos_members_list->StartRec > 1)
		$nos_members_list->Recordset->Move($nos_members_list->StartRec - 1);
} elseif (!$nos_members->AllowAddDeleteRow && $nos_members_list->StopRec == 0) {
	$nos_members_list->StopRec = $nos_members->GridAddRowCount;
}

// Initialize aggregate
$nos_members->RowType = EW_ROWTYPE_AGGREGATEINIT;
$nos_members->ResetAttrs();
$nos_members_list->RenderRow();
$nos_members_list->EditRowCnt = 0;
if ($nos_members->CurrentAction == "edit")
	$nos_members_list->RowIndex = 1;
while ($nos_members_list->RecCnt < $nos_members_list->StopRec) {
	$nos_members_list->RecCnt++;
	if (intval($nos_members_list->RecCnt) >= intval($nos_members_list->StartRec)) {
		$nos_members_list->RowCnt++;

		// Set up key count
		$nos_members_list->KeyCount = $nos_members_list->RowIndex;

		// Init row class and style
		$nos_members->ResetAttrs();
		$nos_members->CssClass = "";
		if ($nos_members->CurrentAction == "gridadd") {
			$nos_members_list->LoadDefaultValues(); // Load default values
		} else {
			$nos_members_list->LoadRowValues($nos_members_list->Recordset); // Load row values
		}
		$nos_members->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($nos_members->CurrentAction == "edit") {
			if ($nos_members_list->CheckInlineEditKey() && $nos_members_list->EditRowCnt == 0) { // Inline edit
				$nos_members->RowType = EW_ROWTYPE_EDIT; // Render edit
			}
		}
		if ($nos_members->CurrentAction == "edit" && $nos_members->RowType == EW_ROWTYPE_EDIT && $nos_members->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$nos_members_list->RestoreFormValues(); // Restore form values
		}
		if ($nos_members->RowType == EW_ROWTYPE_EDIT) // Edit row
			$nos_members_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$nos_members->RowAttrs = array_merge($nos_members->RowAttrs, array('data-rowindex'=>$nos_members_list->RowCnt, 'id'=>'r' . $nos_members_list->RowCnt . '_nos_members', 'data-rowtype'=>$nos_members->RowType));

		// Render row
		$nos_members_list->RenderRow();

		// Render list options
		$nos_members_list->RenderListOptions();
?>
	<tr<?php echo $nos_members->RowAttributes() ?>>
<?php

// Render list options (body, left)
$nos_members_list->ListOptions->Render("body", "left", $nos_members_list->RowCnt);
?>
	<?php if ($nos_members->name->Visible) { // name ?>
		<td data-name="name"<?php echo $nos_members->name->CellAttributes() ?>>
<?php if ($nos_members->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $nos_members_list->RowCnt ?>_nos_members_name" class="form-group nos_members_name">
<input type="text" data-table="nos_members" data-field="x_name" name="x<?php echo $nos_members_list->RowIndex ?>_name" id="x<?php echo $nos_members_list->RowIndex ?>_name" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($nos_members->name->getPlaceHolder()) ?>" value="<?php echo $nos_members->name->EditValue ?>"<?php echo $nos_members->name->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($nos_members->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $nos_members_list->RowCnt ?>_nos_members_name" class="nos_members_name">
<span<?php echo $nos_members->name->ViewAttributes() ?>>
<?php echo $nos_members->name->ListViewValue() ?></span>
</span>
<?php } ?>
<a id="<?php echo $nos_members_list->PageObjName . "_row_" . $nos_members_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($nos_members->RowType == EW_ROWTYPE_EDIT || $nos_members->CurrentMode == "edit") { ?>
<input type="hidden" data-table="nos_members" data-field="x_memberID" name="x<?php echo $nos_members_list->RowIndex ?>_memberID" id="x<?php echo $nos_members_list->RowIndex ?>_memberID" value="<?php echo ew_HtmlEncode($nos_members->memberID->CurrentValue) ?>">
<?php } ?>
	<?php if ($nos_members->_email->Visible) { // email ?>
		<td data-name="_email"<?php echo $nos_members->_email->CellAttributes() ?>>
<?php if ($nos_members->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $nos_members_list->RowCnt ?>_nos_members__email" class="form-group nos_members__email">
<input type="text" data-table="nos_members" data-field="x__email" name="x<?php echo $nos_members_list->RowIndex ?>__email" id="x<?php echo $nos_members_list->RowIndex ?>__email" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($nos_members->_email->getPlaceHolder()) ?>" value="<?php echo $nos_members->_email->EditValue ?>"<?php echo $nos_members->_email->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($nos_members->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $nos_members_list->RowCnt ?>_nos_members__email" class="nos_members__email">
<span<?php echo $nos_members->_email->ViewAttributes() ?>>
<?php echo $nos_members->_email->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($nos_members->profession->Visible) { // profession ?>
		<td data-name="profession"<?php echo $nos_members->profession->CellAttributes() ?>>
<?php if ($nos_members->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $nos_members_list->RowCnt ?>_nos_members_profession" class="form-group nos_members_profession">
<select data-table="nos_members" data-field="x_profession" data-value-separator="<?php echo ew_HtmlEncode(is_array($nos_members->profession->DisplayValueSeparator) ? json_encode($nos_members->profession->DisplayValueSeparator) : $nos_members->profession->DisplayValueSeparator) ?>" id="x<?php echo $nos_members_list->RowIndex ?>_profession[]" name="x<?php echo $nos_members_list->RowIndex ?>_profession[]" multiple="multiple"<?php echo $nos_members->profession->EditAttributes() ?>>
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
<?php } ?>
<?php if ($nos_members->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $nos_members_list->RowCnt ?>_nos_members_profession" class="nos_members_profession">
<span<?php echo $nos_members->profession->ViewAttributes() ?>>
<?php echo $nos_members->profession->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($nos_members->game_type->Visible) { // game_type ?>
		<td data-name="game_type"<?php echo $nos_members->game_type->CellAttributes() ?>>
<?php if ($nos_members->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $nos_members_list->RowCnt ?>_nos_members_game_type" class="form-group nos_members_game_type">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $nos_members->game_type->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x<?php echo $nos_members_list->RowIndex ?>_game_type" data-repeatcolumn="1" class="dropdown-menu">
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
<input type="checkbox" data-table="nos_members" data-field="x_game_type" name="x<?php echo $nos_members_list->RowIndex ?>_game_type[]" id="x<?php echo $nos_members_list->RowIndex ?>_game_type_<?php echo $rowcntwrk ?>[]" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $nos_members->game_type->EditAttributes() ?>><?php echo $nos_members->game_type->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
	}
	for ($ari = 0; $ari < $cnt; $ari++) {
		if (!is_null($armultiwrk[$ari])) {
?>
<input type="checkbox" data-table="nos_members" data-field="x_game_type" name="x<?php echo $nos_members_list->RowIndex ?>_game_type[]" value="<?php echo ew_HtmlEncode($armultiwrk[$ari]) ?>" checked<?php echo $nos_members->game_type->EditAttributes() ?>><?php echo $armultiwrk[$ari] ?>
<?php
		}
	}
}
?>
		</div>
	</div>
	<div id="tp_x<?php echo $nos_members_list->RowIndex ?>_game_type" class="ewTemplate"><input type="checkbox" data-table="nos_members" data-field="x_game_type" data-value-separator="<?php echo ew_HtmlEncode(is_array($nos_members->game_type->DisplayValueSeparator) ? json_encode($nos_members->game_type->DisplayValueSeparator) : $nos_members->game_type->DisplayValueSeparator) ?>" name="x<?php echo $nos_members_list->RowIndex ?>_game_type[]" id="x<?php echo $nos_members_list->RowIndex ?>_game_type[]" value="{value}"<?php echo $nos_members->game_type->EditAttributes() ?>></div>
</div>
</span>
<?php } ?>
<?php if ($nos_members->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $nos_members_list->RowCnt ?>_nos_members_game_type" class="nos_members_game_type">
<span<?php echo $nos_members->game_type->ViewAttributes() ?>>
<?php echo $nos_members->game_type->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($nos_members->division->Visible) { // division ?>
		<td data-name="division"<?php echo $nos_members->division->CellAttributes() ?>>
<?php if ($nos_members->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $nos_members_list->RowCnt ?>_nos_members_division" class="form-group nos_members_division">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $nos_members->division->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x<?php echo $nos_members_list->RowIndex ?>_division" data-repeatcolumn="1" class="dropdown-menu">
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
<input type="checkbox" data-table="nos_members" data-field="x_division" name="x<?php echo $nos_members_list->RowIndex ?>_division[]" id="x<?php echo $nos_members_list->RowIndex ?>_division_<?php echo $rowcntwrk ?>[]" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $nos_members->division->EditAttributes() ?>><?php echo $nos_members->division->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
	}
	for ($ari = 0; $ari < $cnt; $ari++) {
		if (!is_null($armultiwrk[$ari])) {
?>
<input type="checkbox" data-table="nos_members" data-field="x_division" name="x<?php echo $nos_members_list->RowIndex ?>_division[]" value="<?php echo ew_HtmlEncode($armultiwrk[$ari]) ?>" checked<?php echo $nos_members->division->EditAttributes() ?>><?php echo $armultiwrk[$ari] ?>
<?php
		}
	}
}
?>
		</div>
	</div>
	<div id="tp_x<?php echo $nos_members_list->RowIndex ?>_division" class="ewTemplate"><input type="checkbox" data-table="nos_members" data-field="x_division" data-value-separator="<?php echo ew_HtmlEncode(is_array($nos_members->division->DisplayValueSeparator) ? json_encode($nos_members->division->DisplayValueSeparator) : $nos_members->division->DisplayValueSeparator) ?>" name="x<?php echo $nos_members_list->RowIndex ?>_division[]" id="x<?php echo $nos_members_list->RowIndex ?>_division[]" value="{value}"<?php echo $nos_members->division->EditAttributes() ?>></div>
</div>
</span>
<?php } ?>
<?php if ($nos_members->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $nos_members_list->RowCnt ?>_nos_members_division" class="nos_members_division">
<span<?php echo $nos_members->division->ViewAttributes() ?>>
<?php echo $nos_members->division->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($nos_members->has_expansion->Visible) { // has_expansion ?>
		<td data-name="has_expansion"<?php echo $nos_members->has_expansion->CellAttributes() ?>>
<?php if ($nos_members->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $nos_members_list->RowCnt ?>_nos_members_has_expansion" class="form-group nos_members_has_expansion">
<select data-table="nos_members" data-field="x_has_expansion" data-value-separator="<?php echo ew_HtmlEncode(is_array($nos_members->has_expansion->DisplayValueSeparator) ? json_encode($nos_members->has_expansion->DisplayValueSeparator) : $nos_members->has_expansion->DisplayValueSeparator) ?>" id="x<?php echo $nos_members_list->RowIndex ?>_has_expansion" name="x<?php echo $nos_members_list->RowIndex ?>_has_expansion" size=3<?php echo $nos_members->has_expansion->EditAttributes() ?>>
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
<?php } ?>
<?php if ($nos_members->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $nos_members_list->RowCnt ?>_nos_members_has_expansion" class="nos_members_has_expansion">
<span<?php echo $nos_members->has_expansion->ViewAttributes() ?>>
<?php echo $nos_members->has_expansion->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$nos_members_list->ListOptions->Render("body", "right", $nos_members_list->RowCnt);
?>
	</tr>
<?php if ($nos_members->RowType == EW_ROWTYPE_ADD || $nos_members->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fnos_memberslist.UpdateOpts(<?php echo $nos_members_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	if ($nos_members->CurrentAction <> "gridadd")
		$nos_members_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($nos_members->CurrentAction == "edit") { ?>
<input type="hidden" name="<?php echo $nos_members_list->FormKeyCountName ?>" id="<?php echo $nos_members_list->FormKeyCountName ?>" value="<?php echo $nos_members_list->KeyCount ?>">
<?php } ?>
<?php if ($nos_members->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($nos_members_list->Recordset)
	$nos_members_list->Recordset->Close();
?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($nos_members->CurrentAction <> "gridadd" && $nos_members->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($nos_members_list->Pager)) $nos_members_list->Pager = new cPrevNextPager($nos_members_list->StartRec, $nos_members_list->DisplayRecs, $nos_members_list->TotalRecs) ?>
<?php if ($nos_members_list->Pager->RecordCount > 0) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($nos_members_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $nos_members_list->PageUrl() ?>start=<?php echo $nos_members_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($nos_members_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $nos_members_list->PageUrl() ?>start=<?php echo $nos_members_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $nos_members_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($nos_members_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $nos_members_list->PageUrl() ?>start=<?php echo $nos_members_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($nos_members_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $nos_members_list->PageUrl() ?>start=<?php echo $nos_members_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $nos_members_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $nos_members_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $nos_members_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $nos_members_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($nos_members_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($nos_members_list->TotalRecs == 0 && $nos_members->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($nos_members_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fnos_memberslistsrch.Init();
fnos_memberslistsrch.FilterList = <?php echo $nos_members_list->GetFilterList() ?>;
fnos_memberslist.Init();
</script>
<?php
$nos_members_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$nos_members_list->Page_Terminate();
?>
