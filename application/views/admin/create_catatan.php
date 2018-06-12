<!-- <script type="text/javascript">
	$(document).ready(function(){
		$('#catatan_obat').wysihtml5();
	});
</script> -->
<style>
	small {
	display: block;
	margin-top: 40px;
	font-size: 9px;
	}

	small,
	small a {
	color: #666;
	}

	#toolbar [data-wysihtml-action] {
	float: right;
	}

	#toolbar,
	textarea {
	width: 920px;
	padding: 5px;
	-webkit-box-sizing: border-box;
	-ms-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
	}

	textarea {
	height: 500px;
	border: 2px solid green;
	font-family: Verdana;
	font-size: 11px;
	}

	textarea:focus {
	color: black;
	border: 2px solid black;
	}

	.wysihtml-command-active, .wysihtml-action-active {
	font-weight: bold;
	}

	[data-wysihtml-dialog] {
	margin: 5px 0 0;
	padding: 5px;
	border: 1px solid #666;
	}



	a[data-wysihtml-command-value="red"] {
	color: red;
	}

	a[data-wysihtml-command-value="green"] {
	color: green;
	}

	a[data-wysihtml-command-value="blue"] {
	color: blue;
	}

	.wysihtml-editor, .wysihtml-editor table td {
	outline: 1px dotted #abc;

	}

	code {
	background: #ddd;
	padding: 10px;
	white-space: pre;
	display: block;
	margin: 1em 0;
	}

	.toolbar {
	display: block;
	border-radius: 3px;
	border: 1px solid #fff;
	margin-bottom: 9px;
	line-height: 1em;
	}
	.toolbar a {
	display: inline-block;
	height: 1.5em;
	border-radius: 3px;
	font-size: 9px;
	line-height: 1.5em;
	text-decoration: none;
	background: #e1e1e1;
	border: 1px solid #ddd;
	padding: 0 0.2em;
	margin: 1px 0;
	}
	.toolbar a.wysihtml-command-active, .toolbar .wysihtml-action-active {
	background: #222;
	color: white;
	}
	.toolbar .block { 
	padding: 1px 1px;
	display: inline-block;
	background: #eee;
	border-radius: 3px;
	margin: 0px 1px 1px 0;
	}

	div[data-wysihtml-dialog="createTable"] {
	position: absolute;
	background: white;
	}

	div[data-wysihtml-dialog="createTable"] td {
	width: 10px; height: 5px;
	border: 1px solid #666;
	}

	.wysihtml-editor table td.wysiwyg-tmp-selected-cell {
	outline: 2px solid green;
	}

	.editor-container-tag {
	padding: 5px 10px;
	position: absolute;
	color: white;
	background: rgba(0,0,0,0.8);
	width: 100px;
	margin-left: -50px;
	-webkit-transition: 0.1s left, 0.1s top;
	}

	.wrap {
	max-width: 700px;
	margin: 40px;
	}

	.editable .wysihtml-uneditable-container {
	outline: 1px dotted gray;
	position: relative;
	}
	.editable .wysihtml-uneditable-container-right {
	float: right;
	width: 50%;
	margin-left: 2em;
	margin-bottom: 1em;
	}

	.editable .wysihtml-uneditable-container-left {
	float: left;
	width: 50%;
	margin-right: 2em;
	margin-bottom: 1em;
	}

</style>
<main>
<div class="container-fluid margin-top-15  padding-bottom-15">
	<div class="row">
		<div class="col-12">
			<?=$this->session->flashdata("alert_catatan");?>
			<h3>Catatan Obat <?=$nama_obat[0]->nama_obat?></h3>
		</div>
	</div>
	<div class="row margin-top-15">
		<div class="col-12">
			<form action="<?=base_url("Admin_C/handle_create_catatan")?>" method="POST">
				<button type="submit" class="btn btn-primary btn-xs ml-auto float-right">Create Catatan Obat <i class="icon ion-android-create"></i> </button>
				<div class="form-group">
					<input type="hidden" name="id_obat" value="<?=$id_obat?>">
<div class="ewrapper" contentEditable="false">
<div class="toolbar" style="display: none;">
<div class="block">
<a data-wysihtml-command="bold" title="CTRL+B">bold</a>
<a data-wysihtml-command="italic" title="CTRL+I">italic</a>
<a data-wysihtml-command="underline" title="CTRL+U">underline</a>
<a data-wysihtml-command="superscript" title="sup">superscript</a>
<a data-wysihtml-command="subscript" title="sub">subscript</a>
</div>


<div class="block">
<a data-wysihtml-command="createLink">link</a>
<a data-wysihtml-command="removeLink"><s>link</s></a>
<a data-wysihtml-command="insertImage">image</a>
<a data-wysihtml-command="formatBlock" data-wysihtml-command-value="h1">h1</a>
<a data-wysihtml-command="formatBlock" data-wysihtml-command-value="h2">h2</a>
<a data-wysihtml-command="formatBlock" data-wysihtml-command-value="h3">h3</a>
<a data-wysihtml-command="formatBlock" data-wysihtml-command-value="p">p</a>
<a data-wysihtml-command="formatBlock" data-wysihtml-command-value="pre">pre</a>
<a data-wysihtml-command="formatBlock" data-wysihtml-command-blank-value="true">plaintext</a>
<a data-wysihtml-command="insertBlockQuote">blockquote</a>
<a data-wysihtml-command="formatCode" data-wysihtml-command-value="language-html">Code</a>
</div>

<div class="block">
<a data-wysihtml-command="fontSizeStyle">Size</a>
<div data-wysihtml-dialog="fontSizeStyle" style="display: none;">
Size:
<input type="text" data-wysihtml-dialog-field="size" style="width: 60px;" value="" />
<a data-wysihtml-dialog-action="save">OK</a>&nbsp;<a data-wysihtml-dialog-action="cancel">Cancel</a>
</div>
</div>

<div class="block">
<a data-wysihtml-command="insertUnorderedList">&bull; List</a>
<a data-wysihtml-command="insertOrderedList">1. List</a>
</div>
<div class="block">
<a data-wysihtml-command="outdentList">&lt;-</a>
<a data-wysihtml-command="indentList">-&gt;</a>
</div>
<div class="block">
<a data-wysihtml-command="justifyLeft">justifyLeft</a>
<a data-wysihtml-command="justifyRight">justifyRight</a>
<a data-wysihtml-command="justifyFull">justifyFull</a>
</div>

<div class="block">
<a data-wysihtml-command="alignLeftStyle">alignLeft</a>
<a data-wysihtml-command="alignRightStyle">alignRight</a>
<a data-wysihtml-command="alignCenterStyle">alignCenter</a>
</div>

<div class="block">
<a data-wysihtml-command="foreColorStyle">Color</a>
<div data-wysihtml-dialog="foreColorStyle" style="display: none;">
Color:
<input type="text" data-wysihtml-dialog-field="color" value="rgba(0,0,0,1)" />
<a data-wysihtml-dialog-action="save">OK</a>&nbsp;<a data-wysihtml-dialog-action="cancel">Cancel</a>
</div>
</div>

<div class="block">
<a data-wysihtml-command="bgColorStyle">BG Color</a>
<div data-wysihtml-dialog="bgColorStyle" style="display: none;">
Color:
<input type="text" data-wysihtml-dialog-field="color" value="rgba(0,0,0,1)" />
<a data-wysihtml-dialog-action="save">OK</a>&nbsp;<a data-wysihtml-dialog-action="cancel">Cancel</a>
</div>
</div>

<div class="block">
<a data-wysihtml-command="undo">undo</a>
<a data-wysihtml-command="redo">redo</a>
</div>

<div class="block">
<a data-wysihtml-action="change_view">HTML</a>
</div>

<div data-wysihtml-dialog="createLink" style="display: none;">
<label>
Link:
<input data-wysihtml-dialog-field="href" value="http://">
</label>
<a data-wysihtml-dialog-action="save">OK</a>&nbsp;<a data-wysihtml-dialog-action="cancel">Cancel</a>
</div>



<div data-wysihtml-dialog="insertImage" style="display: none;">
<label>
Image:
<input data-wysihtml-dialog-field="src" value="http://">
</label>
<label>
Align:
<select data-wysihtml-dialog-field="className">
<option value="">default</option>
<option value="wysiwyg-float-left">left</option>
<option value="wysiwyg-float-right">right</option>
</select>
</label>
<a data-wysihtml-dialog-action="save">OK</a>&nbsp;<a data-wysihtml-dialog-action="cancel">Cancel</a>
</div>
</div><!-- toolbar -->
<textarea class="form-control col-12 editable" id="catatan_obat" name="catatan_obat" data-placeholder="Enter text ..."></textarea>
</div>
				</div>
			</form>
		</div>
	</div>
</div>
</main>
<script type="text/javascript">
var editors = [];

$('.ewrapper').each(function(idx, wrapper) {

var e = new wysihtml.Editor($(wrapper).find('.editable').get(0), {
toolbar:        $(wrapper).find('.toolbar').get(0),
parserRules:    wysihtmlParserRules,
pasteParserRulesets: wysihtmlParserPasteRulesets
//showToolbarAfterInit: false
});
editors.push(e);

e.on("showSource", function() {
alert(e.getValue(true));
});


});
</script>
