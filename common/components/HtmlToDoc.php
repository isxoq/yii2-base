<?php
/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 05.08.2021, 9:43
 */

namespace common\components;

class HtmlToDoc
{
    var $docFile = '';
    var $title = '';
    var $htmlHead = '';
    var $htmlBody = '';

    public function __construct()
    {
        $this->title = '';
        $this->htmlHead = '';
        $this->htmlBody = '';
    }

    public function setDocFileName($docfile)
    {
        $this->docFile = $docfile;
        if (!preg_match("/\.doc$/i", $this->docFile) && !preg_match("/\.docx$/i", $this->docFile)) {
            $this->docFile .= '.doc';
        }
        return;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getHeader()
    {
        return <<<EOH
         <html xmlns:v="urn:schemas-microsoft-com:vml" 
        xmlns:o="urn:schemas-microsoft-com:office:office" 
        xmlns:w="urn:schemas-microsoft-com:office:word" 
        xmlns="http://www.w3.org/TR/REC-html40"> 
         
        <head> 
        <meta http-equiv=Content-Type content="text/html; charset=utf-8"> 
        <meta name=ProgId content=Word.Document> 
        <meta name=Generator content="Microsoft Word 9"> 
        <meta name=Originator content="Microsoft Word 9"> 
       
        <title>$this->title</title> 
        <style> 
       <!--
 /* Font Definitions */
 @font-face
	{font-family:"Cambria Math";
	panose-1:2 4 5 3 5 4 6 3 2 4;
	mso-font-charset:204;
	mso-generic-font-family:roman;
	mso-font-pitch:variable;
	mso-font-signature:-536869121 1107305727 33554432 0 415 0;}
@font-face
	{font-family:"Segoe UI";
	panose-1:2 11 5 2 4 2 4 2 2 3;
	mso-font-charset:204;
	mso-generic-font-family:swiss;
	mso-font-pitch:variable;
	mso-font-signature:-469750017 -1073683329 9 0 511 0;}
@font-face
	{font-family:AACADEMY;
	mso-font-alt:"Times New Roman";
	mso-font-charset:0;
	mso-generic-font-family:auto;
	mso-font-pitch:variable;
	mso-font-signature:1 0 0 0 5 0;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-parent:"";
	margin:0cm;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";
	mso-fareast-font-family:"Times New Roman";}
h1
	{mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-link:"Заголовок 1 Знак";
	mso-style-next:Обычный;
	margin:0cm;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	page-break-after:avoid;
	mso-outline-level:1;
	font-size:14.0pt;
	mso-bidi-font-size:10.0pt;
	font-family:AACADEMY;
	mso-font-kerning:0pt;
	font-weight:normal;}
p.MsoAcetate, li.MsoAcetate, div.MsoAcetate
	{mso-style-unhide:no;
	mso-style-link:"Текст выноски Знак";
	margin:0cm;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:9.0pt;
	font-family:"Segoe UI","sans-serif";
	mso-fareast-font-family:"Times New Roman";}
p.Style7, li.Style7, div.Style7
	{mso-style-name:Style7;
	mso-style-unhide:no;
	margin:0cm;
	margin-bottom:.0001pt;
	mso-pagination:none;
	mso-layout-grid-align:none;
	text-autospace:none;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";
	mso-fareast-font-family:"Times New Roman";}
span.FontStyle15
	{mso-style-name:"Font Style15";
	mso-style-unhide:no;
	mso-style-parent:"";
	mso-ansi-font-size:8.0pt;
	mso-bidi-font-size:8.0pt;
	font-family:"Times New Roman","serif";
	mso-ascii-font-family:"Times New Roman";
	mso-hansi-font-family:"Times New Roman";
	mso-bidi-font-family:"Times New Roman";}
span.FontStyle13
	{mso-style-name:"Font Style13";
	mso-style-unhide:no;
	mso-style-parent:"";
	mso-ansi-font-size:11.0pt;
	mso-bidi-font-size:11.0pt;
	font-family:"Times New Roman","serif";
	mso-ascii-font-family:"Times New Roman";
	mso-hansi-font-family:"Times New Roman";
	mso-bidi-font-family:"Times New Roman";
	font-variant:small-caps;
	font-weight:bold;}
span.1
	{mso-style-name:"Заголовок 1 Знак";
	mso-style-unhide:no;
	mso-style-locked:yes;
	mso-style-parent:"";
	mso-style-link:"Заголовок 1";
	mso-ansi-font-size:14.0pt;
	font-family:AACADEMY;
	mso-ascii-font-family:AACADEMY;
	mso-hansi-font-family:AACADEMY;}
span.a
	{mso-style-name:"Знак Знак";
	mso-style-unhide:no;
	mso-style-locked:yes;
	mso-style-parent:"";
	mso-ansi-font-size:14.0pt;
	font-family:AACADEMY;
	mso-ascii-font-family:AACADEMY;
	mso-hansi-font-family:AACADEMY;
	mso-ansi-language:RU;
	mso-fareast-language:RU;
	mso-bidi-language:AR-SA;}
span.a0
	{mso-style-name:"Текст выноски Знак";
	mso-style-unhide:no;
	mso-style-locked:yes;
	mso-style-parent:"";
	mso-style-link:"Текст выноски";
	mso-ansi-font-size:9.0pt;
	mso-bidi-font-size:9.0pt;
	font-family:"Segoe UI","sans-serif";
	mso-ascii-font-family:"Segoe UI";
	mso-hansi-font-family:"Segoe UI";
	mso-bidi-font-family:"Segoe UI";}
span.SpellE
	{mso-style-name:"";
	mso-spl-e:yes;}
span.GramE
	{mso-style-name:"";
	mso-gram-e:yes;}
@page WordSection1
	{size:595.3pt 841.9pt;
	margin:18.0pt 42.5pt 18.0pt 36.0pt;
	mso-header-margin:35.4pt;
	mso-footer-margin:35.4pt;
	mso-paper-source:0;}
div.WordSection1
	{page:WordSection1;}
-->
 table.MsoNormalTable
	{mso-style-name:"Обычная таблица";
	mso-tstyle-rowband-size:0;
	mso-tstyle-colband-size:0;
	mso-style-noshow:yes;
	mso-style-unhide:no;
	mso-style-parent:"";
	mso-padding-alt:0cm 5.4pt 0cm 5.4pt;
	mso-para-margin:0cm;
	mso-para-margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:10.0pt;
	font-family:"Times New Roman","serif";}
table.MsoTableGrid
	{mso-style-name:"Сетка таблицы";
	mso-tstyle-rowband-size:0;
	mso-tstyle-colband-size:0;
	mso-style-unhide:no;
	border:solid windowtext 1.0pt;
	mso-border-alt:solid windowtext .5pt;
	mso-padding-alt:0cm 5.4pt 0cm 5.4pt;
	mso-border-insideh:.5pt solid windowtext;
	mso-border-insidev:.5pt solid windowtext;
	mso-para-margin:0cm;
	mso-para-margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:10.0pt;
	font-family:"Times New Roman","serif";}
	h2
	{margin:0cm;
	margin-bottom:.0001pt;
	text-align:center;
	page-break-after:avoid;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";}
        </style> 
      
         $this->htmlHead 
      
        </head> 
        <body style='tab-interval:35.4pt'> 
EOH;
    }

    public function getLandscapeHeader()
    {
        return <<<EOH
         <html xmlns:v="urn:schemas-microsoft-com:vml" 
        xmlns:o="urn:schemas-microsoft-com:office:office" 
        xmlns:w="urn:schemas-microsoft-com:office:word" 
        xmlns="http://www.w3.org/TR/REC-html40"> 
         
        <head> 
        <meta http-equiv=Content-Type content="text/html; charset=utf-8"> 
        <meta name=ProgId content=Word.Document> 
        <meta name=Generator content="Microsoft Word 9"> 
        <meta name=Originator content="Microsoft Word 9"> 
       
        <title>$this->title</title> 
        <style> 
       <!--
 /* Font Definitions */
 @font-face
	{font-family:"Cambria Math";
	panose-1:2 4 5 3 5 4 6 3 2 4;
	mso-font-charset:204;
	mso-generic-font-family:roman;
	mso-font-pitch:variable;
	mso-font-signature:-536869121 1107305727 33554432 0 415 0;}
@font-face
	{font-family:"Segoe UI";
	panose-1:2 11 5 2 4 2 4 2 2 3;
	mso-font-charset:204;
	mso-generic-font-family:swiss;
	mso-font-pitch:variable;
	mso-font-signature:-469750017 -1073683329 9 0 511 0;}
@font-face
	{font-family:AACADEMY;
	mso-font-alt:"Times New Roman";
	mso-font-charset:0;
	mso-generic-font-family:auto;
	mso-font-pitch:variable;
	mso-font-signature:1 0 0 0 5 0;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-parent:"";
	margin:0cm;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";
	mso-fareast-font-family:"Times New Roman";}
h1
	{mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-link:"Заголовок 1 Знак";
	mso-style-next:Обычный;
	margin:0cm;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	page-break-after:avoid;
	mso-outline-level:1;
	font-size:14.0pt;
	mso-bidi-font-size:10.0pt;
	font-family:AACADEMY;
	mso-font-kerning:0pt;
	font-weight:normal;}
p.MsoAcetate, li.MsoAcetate, div.MsoAcetate
	{mso-style-unhide:no;
	mso-style-link:"Текст выноски Знак";
	margin:0cm;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:9.0pt;
	font-family:"Segoe UI","sans-serif";
	mso-fareast-font-family:"Times New Roman";}
p.Style7, li.Style7, div.Style7
	{mso-style-name:Style7;
	mso-style-unhide:no;
	margin:0cm;
	margin-bottom:.0001pt;
	mso-pagination:none;
	mso-layout-grid-align:none;
	text-autospace:none;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";
	mso-fareast-font-family:"Times New Roman";}
span.FontStyle15
	{mso-style-name:"Font Style15";
	mso-style-unhide:no;
	mso-style-parent:"";
	mso-ansi-font-size:8.0pt;
	mso-bidi-font-size:8.0pt;
	font-family:"Times New Roman","serif";
	mso-ascii-font-family:"Times New Roman";
	mso-hansi-font-family:"Times New Roman";
	mso-bidi-font-family:"Times New Roman";}
span.FontStyle13
	{mso-style-name:"Font Style13";
	mso-style-unhide:no;
	mso-style-parent:"";
	mso-ansi-font-size:11.0pt;
	mso-bidi-font-size:11.0pt;
	font-family:"Times New Roman","serif";
	mso-ascii-font-family:"Times New Roman";
	mso-hansi-font-family:"Times New Roman";
	mso-bidi-font-family:"Times New Roman";
	font-variant:small-caps;
	font-weight:bold;}
span.1
	{mso-style-name:"Заголовок 1 Знак";
	mso-style-unhide:no;
	mso-style-locked:yes;
	mso-style-parent:"";
	mso-style-link:"Заголовок 1";
	mso-ansi-font-size:14.0pt;
	font-family:AACADEMY;
	mso-ascii-font-family:AACADEMY;
	mso-hansi-font-family:AACADEMY;}
span.a
	{mso-style-name:"Знак Знак";
	mso-style-unhide:no;
	mso-style-locked:yes;
	mso-style-parent:"";
	mso-ansi-font-size:14.0pt;
	font-family:AACADEMY;
	mso-ascii-font-family:AACADEMY;
	mso-hansi-font-family:AACADEMY;
	mso-ansi-language:RU;
	mso-fareast-language:RU;
	mso-bidi-language:AR-SA;}
span.a0
	{mso-style-name:"Текст выноски Знак";
	mso-style-unhide:no;
	mso-style-locked:yes;
	mso-style-parent:"";
	mso-style-link:"Текст выноски";
	mso-ansi-font-size:9.0pt;
	mso-bidi-font-size:9.0pt;
	font-family:"Segoe UI","sans-serif";
	mso-ascii-font-family:"Segoe UI";
	mso-hansi-font-family:"Segoe UI";
	mso-bidi-font-family:"Segoe UI";}
span.SpellE
	{mso-style-name:"";
	mso-spl-e:yes;}
span.GramE
	{mso-style-name:"";
	mso-gram-e:yes;}
@page WordSection1
	{
	size:841.9pt 595.3pt;
	mso-page-orientation:landscape;
	margin:18.0pt 42.5pt 18.0pt 36.0pt;
	mso-header-margin:35.4pt;
	mso-footer-margin:35.4pt;
	mso-paper-source:0;}
div.WordSection1
	{page:WordSection1;}
-->
 table.MsoNormalTable
	{mso-style-name:"Обычная таблица";
	mso-tstyle-rowband-size:0;
	mso-tstyle-colband-size:0;
	mso-style-noshow:yes;
	mso-style-unhide:no;
	mso-style-parent:"";
	mso-padding-alt:0cm 5.4pt 0cm 5.4pt;
	mso-para-margin:0cm;
	mso-para-margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:10.0pt;
	font-family:"Times New Roman","serif";}
table.MsoTableGrid
	{mso-style-name:"Сетка таблицы";
	mso-tstyle-rowband-size:0;
	mso-tstyle-colband-size:0;
	mso-style-unhide:no;
	border:solid windowtext 1.0pt;
	mso-border-alt:solid windowtext .5pt;
	mso-padding-alt:0cm 5.4pt 0cm 5.4pt;
	mso-border-insideh:.5pt solid windowtext;
	mso-border-insidev:.5pt solid windowtext;
	mso-para-margin:0cm;
	mso-para-margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:10.0pt;
	font-family:"Times New Roman","serif";}
        </style> 
      
         $this->htmlHead 
      
        </head> 
        <body style='tab-interval:35.4pt'> 
EOH;
    }


    public function getFooter()
    {
        return "</body></html>";
    }

    public function createDoc($html, $file, $download = false, $landscape = false)
    {
        if (is_file($html)) {
            $html = @file_get_contents($html);
        }

        $this->_parseHtml($html);
        $this->setDocFileName($file);
        $doc = $landscape ? $this->getLandscapeHeader() : $this->getHeader();
        $doc .= $this->htmlBody;
        $doc .= $this->getFooter();

        if ($download) {
            @header("Cache-Control: ");// leave blank to avoid IE errors
            @header("Pragma: ");// leave blank to avoid IE errors
            @header("Content-type: application/octet-stream");
            @header("Content-Disposition: attachment; filename=\"$this->docFile\"");
            echo $doc;
            return true;
        } else {
            return $this->write_file($this->docFile, $doc);
        }
    }

    public function _parseHtml($html)
    {
        $html = preg_replace("/<!DOCTYPE((.|\n)*?)>/ims", "", $html);
        $html = preg_replace("/<script((.|\n)*?)>((.|\n)*?)<\/script>/ims", "", $html);
        preg_match("/<head>((.|\n)*?)<\/head>/ims", $html, $matches);
        $head = !empty($matches[1]) ? $matches[1] : '';
        preg_match("/<title>((.|\n)*?)<\/title>/ims", $head, $matches);
        $this->title = !empty($matches[1]) ? $matches[1] : '';
        $html = preg_replace("/<head>((.|\n)*?)<\/head>/ims", "", $html);
        $head = preg_replace("/<title>((.|\n)*?)<\/title>/ims", "", $head);
        $head = preg_replace("/<\/?head>/ims", "", $head);
        $html = preg_replace("/<\/?body((.|\n)*?)>/ims", "", $html);
        $this->htmlHead = $head;
        $this->htmlBody = $html;
        return;
    }

    public function write_file($file, $content, $mode = "w")
    {
        $fp = @fopen($file, $mode);
        if (!is_resource($fp)) {
            return false;
        }
        fwrite($fp, $content);
        fclose($fp);
        return true;
    }
}