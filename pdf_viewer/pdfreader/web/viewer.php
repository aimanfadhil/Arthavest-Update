<?php 
//require_once('../../configuration.php');
?>
<!DOCTYPE html>
<!--
Copyright 2012 Mozilla Foundation

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
-->
<html dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>PDF.js viewer</title>

<!--#if FIREFOX || MOZCENTRAL-->
<!--#include viewer-snippet-firefox-extension.html-->
<!--#endif-->

    <link rel="stylesheet" href="../../pdf_reader/web/viewer.css"/>
<!--#if !PRODUCTION-->
    <!--link rel="resource" type="application/l10n" href="../pdf_reader/web/locale/locale.properties"/-->
<!--#endif-->
<script>
var DEFAULT_URL = '<?php echo decrypt($_GET['d']).decrypt($_GET['f'])?>';
//var DEFAULT_URL = '<?php echo $_GET['d'].$_GET['f']?>';
//var DEFAULT_URL = '../../file/02-memo/<?php echo $_GET['f']?>';
//var DEFAULT_URL = '../../file/<?php echo $_GET['f']?>.pdf';
</script>
<!--#if !(FIREFOX || MOZCENTRAL || CHROME)-->
    <script type="text/javascript" src="../../pdf_reader/web/compatibility.js"></script>
<!--#endif-->

<!--#if !PRODUCTION-->
    <script type="text/javascript" src="../../pdf_reader/external/webL10n/l10n.js"></script>
<!--#endif-->

<!--#if !PRODUCTION-->
    <script type="text/javascript" src="../../pdf_reader/src/core.js"></script>
    <script type="text/javascript" src="../../pdf_reader/src/util.js"></script>
    <script type="text/javascript" src="../../pdf_reader/src/api.js"></script>
    <script type="text/javascript" src="../../pdf_reader/src/metadata.js"></script>
    <script type="text/javascript" src="../../pdf_reader/src/canvas.js"></script>
    <script type="text/javascript" src="../../pdf_reader/src/obj.js"></script>
    <script type="text/javascript" src="../../pdf_reader/src/function.js"></script>
    <script type="text/javascript" src="../../pdf_reader/src/charsets.js"></script>
    <script type="text/javascript" src="../../pdf_reader/src/cidmaps.js"></script>
    <script type="text/javascript" src="../../pdf_reader/src/colorspace.js"></script>
    <script type="text/javascript" src="../../pdf_reader/src/crypto.js"></script>
    <script type="text/javascript" src="../../pdf_reader/src/evaluator.js"></script>
    <script type="text/javascript" src="../../pdf_reader/src/fonts.js"></script>
    <script type="text/javascript" src="../../pdf_reader/src/glyphlist.js"></script>
    <script type="text/javascript" src="../../pdf_reader/src/image.js"></script>
    <script type="text/javascript" src="../../pdf_reader/src/metrics.js"></script>
    <script type="text/javascript" src="../../pdf_reader/src/parser.js"></script>
    <script type="text/javascript" src="../../pdf_reader/src/pattern.js"></script>
    <script type="text/javascript" src="../../pdf_reader/src/stream.js"></script>
    <script type="text/javascript" src="../../pdf_reader/src/worker.js"></script>
    <script type="text/javascript" src="../../pdf_reader/external/jpgjs/jpg.js"></script>
    <script type="text/javascript" src="../../pdf_reader/src/jpx.js"></script>
    <script type="text/javascript" src="../../pdf_reader/src/jbig2.js"></script>
    <script type="text/javascript" src="../../pdf_reader/src/bidi.js"></script>
    <script type="text/javascript">PDFJS.workerSrc = '../../pdf_reader/src/worker_loader.js';</script>
<!--#endif-->

<!--#if GENERIC || CHROME-->
<!--#include viewer-snippet.html-->
<!--#endif-->

    <script type="text/javascript" src="debugger.js"></script>
    <script type="text/javascript" src="viewer.js"></script>
	<script type="text/javascript">

	/***********************************************
	* Disable Text Selection script- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
	* This notice MUST stay intact for legal use
	* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
	***********************************************/
	
	function disableSelection(target){
	if (typeof target.onselectstart!="undefined") //IE route
		target.onselectstart=function(){return false}
	else if (typeof target.style.MozUserSelect!="undefined") //Firefox route
		target.style.MozUserSelect="none"
	else //All other route (ie: Opera)
		target.onmousedown=function(){return false}
	target.style.cursor = "default"
	}
	
	//Sample usages
	//disableSelection(document.body) //Disable text selection on entire body
	//disableSelection(document.getElementById("mydiv")) //Disable text selection on element with id="mydiv"
	
	</script>
  </head>

  <body>
    <!--input type="text" id="filename" name="filename" value="<?php echo $_GET['f']?>"-->
    <div id="outerContainer">

      <div id="sidebarContainer">
        <div id="toolbarSidebar">
          <div class="splitToolbarButton toggled">
            <button id="viewThumbnail" class="toolbarButton group toggled" title="Show Thumbnails" tabindex="1" data-l10n-id="thumbs">
               <span data-l10n-id="thumbs_label">Thumbnails</span>
            </button>
            <button id="viewOutline" class="toolbarButton group" title="Show Document Outline" tabindex="2" data-l10n-id="outline">
               <span data-l10n-id="outline_label">Document Outline</span>
            </button>
          </div>
        </div>
        <div id="sidebarContent">
          <div id="thumbnailView">
          </div>
          <div id="outlineView" class="hidden">
          </div>
        </div>
      </div>  <!-- sidebarContainer -->

      <div id="mainContainer">
        <div class="findbar hidden doorHanger" id="findbar">
          <label for="findInput" class="toolbarLabel" data-l10n-id="find_label">Find:</label>
          <input id="findInput" class="toolbarField" tabindex="20">
          <div class="splitToolbarButton">
            <button class="toolbarButton findPrevious" title="" id="findPrevious" tabindex="21" data-l10n-id="find_previous">
              <span data-l10n-id="find_previous_label">Previous</span>
            </button>
            <div class="splitToolbarButtonSeparator"></div>
            <button class="toolbarButton findNext" title="" id="findNext" tabindex="22" data-l10n-id="find_next">
              <span data-l10n-id="find_next_label">Next</span>
            </button>
          </div>
          <input type="checkbox" id="findHighlightAll" class="toolbarField">
          <label for="findHighlightAll" class="toolbarLabel" tabindex="23" data-l10n-id="find_highlight">Highlight all</label>
          <input type="checkbox" id="findMatchCase" class="toolbarField">
          <label for="findMatchCase" class="toolbarLabel" tabindex="24" data-l10n-id="find_match_case_label">Match case</label>
          <span id="findMsg" class="toolbarLabel"></span>
        </div>
        <div class="toolbar">
          <div id="toolbarContainer">
            <div id="toolbarViewer">
              <div id="toolbarViewerLeft">
                <button id="sidebarToggle" class="toolbarButton" title="Toggle Sidebar" tabindex="3" data-l10n-id="toggle_slider">
                  <span data-l10n-id="toggle_slider_label">Toggle Sidebar</span>
                </button>
                <div class="toolbarButtonSpacer"></div>
                <button id="viewFind" class="toolbarButton group" title="Find in Document" tabindex="4" data-l10n-id="findbar">
                   <span data-l10n-id="findbar_label">Find</span>
                </button>
                <div class="splitToolbarButton">
                  <button class="toolbarButton pageUp" title="Previous Page" id="previous" tabindex="5" data-l10n-id="previous">
                    <span data-l10n-id="previous_label">Previous</span>
                  </button>
                  <div class="splitToolbarButtonSeparator"></div>
                  <button class="toolbarButton pageDown" title="Next Page" id="next" tabindex="6" data-l10n-id="next">
                    <span data-l10n-id="next_label">Next</span>
                  </button>
                </div>
                <label id="pageNumberLabel" class="toolbarLabel" for="pageNumber" data-l10n-id="page_label">Page: </label>
                <input type="number" id="pageNumber" class="toolbarField pageNumber" value="1" size="4" min="1" tabindex="7">
                </input>
                <span id="numPages" class="toolbarLabel"></span>
              </div>
              <div id="toolbarViewerRight">
                <input id="fileInput" class="fileInput" type="file" oncontextmenu="return false;" style="visibility: hidden; position: fixed; right: 0; top: 0" />


                <button id="fullscreen" class="toolbarButton fullscreen" title="Switch to Presentation Mode" tabindex="11" data-l10n-id="presentation_mode">
                  <span data-l10n-id="presentation_mode_label">Presentation Mode</span>
                </button>

                <button id="openFile" class="toolbarButton openFile" title="Open File" tabindex="12" data-l10n-id="open_file"  style="display:none">
                   <span data-l10n-id="open_file_label">Open</span>
                </button>

                <button id="print" class="toolbarButton print" title="Print" tabindex="13" data-l10n-id="print" style="display:none">
                  <span data-l10n-id="print_label">Print</span>
                </button>

                <button id="download" class="toolbarButton download" title="Download" tabindex="14" data-l10n-id="download" style="display:none">
                  <span data-l10n-id="download_label">Download</span>
                </button>
                <!-- <div class="toolbarButtonSpacer"></div> -->
				<div  style="display:none">
                <a href="#" id="viewBookmark" class="toolbarButton bookmark" title="Current view (copy or open in new window)" tabindex="15" data-l10n-id="bookmark"><span data-l10n-id="bookmark_label" >Current View</span></a>
				</div>
              </div>
              <div class="outerCenter">
                <div class="innerCenter" id="toolbarViewerMiddle">
                  <div class="splitToolbarButton">
                    <button class="toolbarButton zoomOut" title="Zoom Out" tabindex="8" data-l10n-id="zoom_out">
                      <span data-l10n-id="zoom_out_label">Zoom Out</span>
                    </button>
                    <div class="splitToolbarButtonSeparator"></div>
                    <button class="toolbarButton zoomIn" title="Zoom In" tabindex="9" data-l10n-id="zoom_in">
                      <span data-l10n-id="zoom_in_label">Zoom In</span>
                     </button>
                  </div>
                  <span id="scaleSelectContainer" class="dropdownToolbarButton">
                     <select id="scaleSelect" title="Zoom" oncontextmenu="return false;" tabindex="10" data-l10n-id="zoom">
                      <option id="pageAutoOption" value="auto" selected="selected" data-l10n-id="page_scale_auto">Automatic Zoom</option>
                      <option id="pageActualOption" value="page-actual" data-l10n-id="page_scale_actual">Actual Size</option>
                      <option id="pageFitOption" value="page-fit" data-l10n-id="page_scale_fit">Fit Page</option>
                      <option id="pageWidthOption" value="page-width" data-l10n-id="page_scale_width">Full Width</option>
                      <option id="customScaleOption" value="custom"></option>
                      <option value="0.5">50%</option>
                      <option value="0.75">75%</option>
                      <option value="1">100%</option>
                      <option value="1.25">125%</option>
                      <option value="1.5">150%</option>
                      <option value="2">200%</option>
                    </select>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <menu type="context" id="viewerContextMenu">
          <menuitem label="First Page" id="first_page"
                    data-l10n-id="first_page" ></menuitem>
          <menuitem label="Last Page" id="last_page"
                    data-l10n-id="last_page" ></menuitem>
          <menuitem label="Rotate Counter-Clockwise" id="page_rotate_ccw"
                    data-l10n-id="page_rotate_ccw" ></menuitem>
          <menuitem label="Rotate Clockwise" id="page_rotate_cw"
                    data-l10n-id="page_rotate_cw" ></menuitem>
        </menu>

        <div id="viewerContainer">
          <div id="viewer" contextmenu="viewerContextMenu"></div>
        </div>

        <div id="loadingBox">
          <div id="loading"></div>
          <div id="loadingBar"><div class="progress"></div></div>
        </div>

        <div id="errorWrapper" hidden='true'>
          <div id="errorMessageLeft">
            <span id="errorMessage"></span>
            <button id="errorShowMore" onClick="" oncontextmenu="return false;" data-l10n-id="error_more_info">
              More Information
            </button>
            <button id="errorShowLess" onClick="" oncontextmenu="return false;" data-l10n-id="error_less_info" hidden='true'>
              Less Information
            </button>
          </div>
          <div id="errorMessageRight">
            <button id="errorClose" oncontextmenu="return false;" data-l10n-id="error_close">
              Close
            </button>
          </div>
          <div class="clearBoth"></div>
          <textarea id="errorMoreInfo" hidden='true' readonly></textarea>
        </div>
      </div> <!-- mainContainer -->

    </div> <!-- outerContainer -->
    <div id="printContainer"></div>
	<script language="javascript" src="../../jquery.js"></script>
	<script>
	$(function() {
            $(this).bind("contextmenu", function(e) {
                e.preventDefault();
            });
        }); 
	
	$(document).keypress("c",function(e) {
	  if(e.ctrlKey)
		//alert("Ctrl+C was pressed!!");
		return false
	})
			
	/*$(document).keypress("p",function(e) {
	  if(e.ctrlKey)
		alert("Ctrl+P was pressed!!");
		return false
	});*/

    
	</script>
	
	<script type="text/javascript">
	var somediv=document.getElementById("viewerContainer")
	disableSelection(somediv) //disable text selection within DIV with id="mydiv"
	</script>
	
	<!--script type="text/javascript">
	disableSelection(document.body) //disable text selection on entire body of page
	
	var isMouseDown = false;
	document.onmousedown = function() { isMouseDown = true };
	document.onmouseup   = function() { isMouseDown = false };
	document.onmousemove = function() { if(isMouseDown) { 
		document.getElementById('viewerContainer').innerHTML += 'a';
	} };
	</script-->
  </body>
</html>