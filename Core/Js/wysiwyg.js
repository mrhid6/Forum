iFrameon();
function iFrameon(){
	richTextField.document.body.style.fontFamily="arial,sans-serif";
	richTextField.document.body.style.fontSize="13px";
	richTextField.document.body.style.color="#ffffff";
	richTextField.document.designMode = 'On';
}
function iBold(){
	richTextField.document.execCommand('bold',false,null);
}
function iUnderline(){
	richTextField.document.execCommand('underline',false,null);
}

function iStrike(){
	richTextField.document.execCommand('strikeThrough',false,null);
}
function iItalic(){
	richTextField.document.execCommand('italic',false,null);
}

function iSubscript(){
	richTextField.document.execCommand('subscript',false,null);
}
function iSuperscript(){
	richTextField.document.execCommand('superscript',false,null);
}
function iFontSize(){
	var size= prompt('Enter A Size 1-7','');
	richTextField.document.execCommand('FontSize',false,size);
}
function iFontColor(){
	var colour= prompt('Enter A Hexadecimal Colour Code','');
	richTextField.document.execCommand('ForeColor',false,colour);
}
function iHorizonntalRule(){
	richTextField.document.execCommand('inserthorizontalrule',false,null);
}
function iUnorderedList(){
	richTextField.document.execCommand('InsertUnorderedList',false,"newUL");
}
function iOrderedList(){
	richTextField.document.execCommand('InsertOrderedList',false,"newOL");
}
function iLink(){
	var linkURL= prompt('Enter A Url','http://');
	richTextField.document.execCommand('CreateLink',false,linkURL);
}
function iUnlink(){
	richTextField.document.execCommand('Unlink',false,null);
}
function iUndo(){
	richTextField.document.execCommand('undo',false,null);
}
function iAlignleft(){
	richTextField.document.execCommand('justifyLeft',false,null);
}
function iAligncenter(){
	richTextField.document.execCommand('justifyCenter',false,null);
}
function iAlignright(){
	richTextField.document.execCommand('justifyRight',false,null);
}

function iQuote(){
	richTextField.document.execCommand('formatBlock',false,"BLOCKQUOTE");
}
function iRedo(){
	richTextField.document.execCommand('redo',false,null);
}
function iImage(){
	var imgSRC= prompt('Enter A Image Url','');
	if(imgSRC!=null){
		richTextField.document.execCommand('insertimage',false,imgSRC);
	}
}
function submit_form(){
	var theForm=document.getElementById("form_wysiwyg");
	
	theForm.elements['wysiwyg_text'].value= window.frames['richTextField'].document.body.innerHTML;
	theForm.submit();
}
