<?php

/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Public License Version
 * 1.1.3 ("License"); You may not use this file except in compliance with the
 * License. You may obtain a copy of the License at http://www.sugarcrm.com/SPL
 * Software distributed under the License is distributed on an "AS IS" basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied.  See the License
 * for the specific language governing rights and limitations under the
 * License.
 *
 * All copies of the Covered Code must include on each user interface screen:
 *    (i) the "Powered by SugarCRM" logo and
 *    (ii) the SugarCRM copyright notice
 * in the same form as they appear in the distribution.  See full license for
 * requirements.
 *
 * The Original Code is: SugarCRM Open Source
 * The Initial Developer of the Original Code is SugarCRM, Inc.
 * Portions created by SugarCRM are Copyright (C) 2004-2006 SugarCRM, Inc.;
 * All Rights Reserved.
 * Contributor(s): ______________________________________.
 ********************************************************************************/

$js_loaded = false;
require_once("include/tabgroup/Template.php");

class TemplateGroupChooser extends Template
{

 var $args;
 var $js_loaded = false;
 var $display_hide_tabs = true;
 var $display_third_tabs = false;

 function TemplateGroupChooser()
 {
 }

 function display()
 {
 global $mod_strings,$js_loaded;
 $image_path="themes/images/";
 if ( $js_loaded == false)
 {
  $this->template_groups_chooser_js();
  $js_loaded = true;
 }
  if ( ! isset($this->args['display']))
  {
   $table_style = "";
  }
  else
  {
   $table_style = "display: ".$this->args['display'];
  }

ob_start();
?>
<div id="<?php echo $this->args['id']; ?>" style="<?php echo $table_style;?>">
<?php echo $this->args['title']; ?></h4>
</th>
</tr>
<tr>
	<td>
<table cellpadding="0" cellspacing="0" border="0">

<tr>
	<td>&nbsp;</td>
	<td  class="dataLabel" id="chooser_<?php echo $this->args['left_name'];?>_text" align="center"><nobr><b><?php echo $this->args['left_label']; ?></b></nobr></td>
	<?php if ($this->display_hide_tabs==true) {?>
	<td>&nbsp;</td>
	<td  class="dataLabel" id="chooser_<?php echo $this->args['right_name'];?>" align="center"><nobr><b><?php echo $this->args['right_label']; ?></b></nobr></td>
	<?php } ?>
	<?php if ($this->display_third_tabs==true) {?>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td  class="dataLabel" id="chooser_<?php echo $this->args['third_name'];?>" align="center"><nobr><b><?php echo $this->args['third_label']; ?></b></nobr></td>
	<?php } ?>
</tr>
<tr>
	<td valign="top" style="padding-right: 2px; padding-left: 2px;" align="center">
<?php if (! isset($this->args['disable'])) { ?>

<a onclick="javascript:upto('<?php echo $this->args['left_name'];?>');"><?php echo get_image($image_path.'uparrow_big','border="0" style="margin-bottom: 1px;" alt="Sort"');?></a><br>
<a onclick="javascript:downto('<?php echo $this->args['left_name'];?>');"><?php echo get_image($image_path.'downarrow_big','border="0" style="margin-top: 1px;"  alt="Sort"');?></a>
<?Php } ?>
			</td>
	
	<td align="center">

		<table border="0" cellspacing=0 cellpadding="0" align="center">
		<tr>
			<td id="<?php echo $this->args['left_name'];?>_td" align="center">
			<select id="<?php echo $this->args['left_name'];?>" name="<?php echo $this->args['left_name'];?>[]" size="10" multiple="multiple" size="10" <?php if ( isset($this->args['disable'])) { echo "DISABLED"; } ?>>
<?php
foreach ($this->args['values_array'][0] as $key=>$value)
{
?>
<option value="<?php echo $key ?>"><?php echo $value; ?></option>
<?php
}
?>
</select>
</td>
		</tr>
		</table>
	</td>
	<?php if ($this->display_hide_tabs==true) {?>
	<td valign="top" style="padding-right: 2px; padding-left: 2px;" align="center">
<?php if (! isset($this->args['disable'])) { ?>
<a onclick="javascript:right_to_left('<?php echo $this->args['left_name'];?>','<?php echo $this->args['right_name'];?>');"><?php echo get_image($image_path.'leftarrow_big','border="0" style="margin-right: 1px;" alt="Sort"');?></a><a onclick="javascript:left_to_right('<?php echo $this->args['left_name'];?>','<?php echo $this->args['right_name'];?>');"><?php echo get_image($image_path.'rightarrow_big','border="0" style="margin-left: 1px;" alt="Sort"');?></a>
<?php } ?>
</td>
	<td id="<?php echo $this->args['right_name']; ?>_td" align="center">
<select id="<?php echo $this->args['right_name']; ?>" name="<?php echo $this->args['right_name']; ?>[]" size="10" multiple="multiple" <?php if ( isset($this->args['disable'])) { echo "DISABLED"; } ?>>
<?php
foreach ($this->args['values_array'][1] as $key=>$value)
{
?>
<option value="<?php echo $key ?>"><?php echo $value; ?></option>
<?php
}
?>
</select>
<script>
object_refs['<?php echo $this->args['right_name']?>'] = document.getElementById('<?php echo $this->args['right_name']?>');
</script>

	<td valign="top" style="padding-right: 2px; padding-left: 2px;" align="center">
<!--
<a onclick="javascript:up('<?php echo $this->args['right_name'];?>');"><?php echo get_image($image_path.'uparrow_big','border="0" style="margin-bottom: 1px;" alt="Sort"');?></a><br>
<a onclick="javascript:down('<?php echo $this->args['right_name'];?>');"><?php echo get_image($image_path.'downarrow_big','border="0" style="margin-top: 1px;"  alt="Sort"');?></a>
-->

			</td>
			<?php }?>
	<?php if ($this->display_third_tabs==true) {?>
	<td valign="top" style="padding-right: 2px; padding-left: 2px;" align="center">
<?php if (! isset($this->args['disable'])) { ?>
<a onclick="javascript:right_to_left('<?php echo $this->args['right_name'];?>','<?php echo $this->args['third_name'];?>');"><?php echo get_image($image_path.'leftarrow_big','border="0" style="margin-right: 1px;" alt="Sort"');?></a><a onclick="javascript:left_to_right('<?php echo $this->args['right_name'];?>','<?php echo $this->args['third_name'];?>');"><?php echo get_image($image_path.'rightarrow_big','border="0" style="margin-left: 1px;" alt="Sort"');?></a>
<?php } ?>
</td>
	<td id="<?php echo $this->args['third_name']; ?>_td" align="center">
<select id="<?php echo $this->args['third_name']; ?>" name="<?php echo $this->args['third_name']; ?>[]" size="10" multiple="multiple" <?php if ( isset($this->args['disable'])) { echo "DISABLED"; } ?>>
<?php
foreach ($this->args['values_array'][2] as $key=>$value)
{
?>
<option value="<?php echo $key ?>"><?php echo $value; ?></option>
<?php
}
?>
</select>
<script>
object_refs['<?php echo $this->args['third_name'];?>'] = document.getElementById('<?php echo $this->args['third_name'];?>');
</script>

	<td valign="top" style="padding-right: 2px; padding-left: 2px;" align="center">
<!--
<a onclick="javascript:up('<?php echo $this->args['third_name'];?>');"><?php echo get_image($image_path.'uparrow_big','border="0" style="margin-bottom: 1px;" alt="Sort"');?></a><br>
<a onclick="javascript:down('<?php echo $this->args['third_name'];?>');"><?php echo get_image($image_path.'downarrow_big','border="0" style="margin-top: 1px;"  alt="Sort"');?></a>
-->

			</td>
			<?php }?>
<script>
object_refs['<?php echo $this->args['left_name']?>'] = document.getElementById('<?php echo $this->args['left_name']?>');
</script>
</tr>
</table>

<?php
$output = ob_get_contents();

ob_end_clean();
return $output;

}



////////////////////////////////////////////// 
// TEMPLATE:
////////////////////////////////////////////// 
function template_groups_chooser_js()
{
?>

<script language="javascript" id="tabchooser">
var object_refs = new Object();


function buildSelectHTML(info)
{
        var text;
        text = "<select";

        if ( typeof (info['select']['size']) != 'undefined')
        {
                text +=" size=\""+ info['select']['size'] +"\"";
        }

        if ( typeof (info['select']['name']) != 'undefined')
        {
                text +=" name=\""+ info['select']['name'] +"\"";
        }

        if ( typeof (info['select']['style']) != 'undefined')
        {
                text +=" style=\""+ info['select']['style'] +"\"";
        }

        if ( typeof (info['select']['onchange']) != 'undefined')
        {
                text +=" onChange=\""+ info['select']['onchange'] +"\"";
        }

        if ( typeof (info['select']['multiple']) != 'undefined')
        {
                text +=" multiple";
        }
        text +=">";

        for(i=0; i<info['options'].length;i++)
        {
                option = info['options'][i];
                text += "<option value=\""+option['value']+"\" ";
                if ( typeof (option['selected']) != 'undefined' && option['selected']== true)
                {
                        text += "SELECTED";
                }
                text += ">"+option['text']+"</option>";
        }
        text += "</select>";
        return text;
}


function left_to_right(left_name,right_name) 
{
	var display_columns_ref = object_refs[left_name];
//alert(display_columns_ref);
	var hidden_columns_ref = object_refs[right_name];

	var left_td = document.getElementById(left_name+'_td');
	var right_td = document.getElementById(right_name+'_td');

	var selected_left = new Array();
	var notselected_left = new Array();
	var notselected_right = new Array();

	var left_array = new Array();

        // determine which options are selected in left 
	for (i=0; i < display_columns_ref.options.length; i++)
	{
		if ( display_columns_ref.options[i].selected == true) 
		{
			selected_left[selected_left.length] = {text: display_columns_ref.options[i].text, value: display_columns_ref.options[i].value};
		}
		else
		{
			notselected_left[notselected_left.length] = {text: display_columns_ref.options[i].text, value: display_columns_ref.options[i].value};
		}
		
	}

	for (i=0; i < hidden_columns_ref.options.length; i++)
	{
		notselected_right[notselected_right.length] = {text:hidden_columns_ref.options[i].text, value:hidden_columns_ref.options[i].value};
		
	}

	var left_select_html_info = new Object();
	var left_options = new Array();
	var left_select = new Object();

	left_select['name'] = left_name+'[]';
	left_select['id'] = left_name;
	left_select['size'] = '10';
	left_select['multiple'] = 'true';

	var right_select_html_info = new Object();
	var right_options = new Array();
	var right_select = new Object();

	right_select['name'] = right_name+'[]';
	right_select['id'] = right_name;
	right_select['size'] = '10';
	right_select['multiple'] = 'true';

	for (i=0;i < notselected_right.length;i++)
	{
		right_options[right_options.length] = notselected_right[i];	
	}

	for (i=0;i < selected_left.length;i++)
	{
		right_options[right_options.length] = selected_left[i];	
	}
	for (i=0;i < notselected_left.length;i++)
	{
		left_options[left_options.length] = notselected_left[i];	
	}
	left_select_html_info['options'] = left_options;
	left_select_html_info['select'] = left_select;
	right_select_html_info['options'] = right_options;
	right_select_html_info['select'] = right_select;
	right_select_html_info['style'] = 'background: lightgrey';

	var left_html = buildSelectHTML(left_select_html_info);
	var right_html = buildSelectHTML(right_select_html_info);

	left_td.innerHTML = left_html;
	right_td.innerHTML = right_html;
	object_refs[left_name] = left_td.getElementsByTagName('select')[0];
	object_refs[right_name] = right_td.getElementsByTagName('select')[0];
}


function right_to_left(left_name,right_name) 
{
	var display_columns_ref = object_refs[left_name];
	var hidden_columns_ref = object_refs[right_name];

	var left_td = document.getElementById(left_name+'_td');
	var right_td = document.getElementById(right_name+'_td');

	var selected_right = new Array();
	var notselected_right = new Array();
	var notselected_left = new Array();

	for (i=0; i < hidden_columns_ref.options.length; i++)
	{
		if (hidden_columns_ref.options[i].selected == true) 
		{
			selected_right[selected_right.length] = {text:hidden_columns_ref.options[i].text, value:hidden_columns_ref.options[i].value};
		}
		else
		{
			notselected_right[notselected_right.length] = {text:hidden_columns_ref.options[i].text, value:hidden_columns_ref.options[i].value};
		}
		
	}

	for (i=0; i < display_columns_ref.options.length; i++)
	{
		notselected_left[notselected_left.length] = {text:display_columns_ref.options[i].text, value:display_columns_ref.options[i].value};
		
	}

	var left_select_html_info = new Object();
	var left_options = new Array();
	var left_select = new Object();

	left_select['name'] = left_name+'[]';
	left_select['id'] = left_name;
	left_select['multiple'] = 'true';
	left_select['size'] = '10';

	var right_select_html_info = new Object();
	var right_options = new Array();
	var right_select = new Object();

	right_select['name'] = right_name+ '[]';
	right_select['id'] = right_name;
	right_select['multiple'] = 'true';
	right_select['size'] = '10';

	for (i=0;i < notselected_left.length;i++)
	{
		left_options[left_options.length] = notselected_left[i];	
	}

	for (i=0;i < selected_right.length;i++)
	{
		left_options[left_options.length] = selected_right[i];	
	}
	for (i=0;i < notselected_right.length;i++)
	{
		right_options[right_options.length] = notselected_right[i];	
	}
	left_select_html_info['options'] = left_options;
	left_select_html_info['select'] = left_select;
	right_select_html_info['options'] = right_options;
	right_select_html_info['select'] = right_select;
	right_select_html_info['style'] = 'background: lightgrey';

	var left_html = buildSelectHTML(left_select_html_info);
	var right_html = buildSelectHTML(right_select_html_info);

	left_td.innerHTML = left_html;
	right_td.innerHTML = right_html;
	object_refs[left_name] = left_td.getElementsByTagName('select')[0];
	object_refs[right_name] = right_td.getElementsByTagName('select')[0];
}


function upto(name) {
	var td = document.getElementById(name+'_td');
	var obj = td.getElementsByTagName('select')[0];
	obj = (typeof obj == "string") ? document.getElementById(obj) : obj;
	if (obj.tagName.toLowerCase() != "select" && obj.length < 2)
		return false;
	var sel = new Array();
	for (i=0; i<obj.length; i++) {
		if (obj[i].selected == true) {
			sel[sel.length] = i;
		}
	}
	for (i in sel) {
		if (sel[i] != 0 && typeof (obj[sel[i]-1]) != 'undefined' && !obj[sel[i]-1].selected) {
			var tmp = new Array(obj[sel[i]-1].text, obj[sel[i]-1].value);
			obj[sel[i]-1].text = obj[sel[i]].text;
			obj[sel[i]-1].value = obj[sel[i]].value;
			obj[sel[i]].text = tmp[0];
			obj[sel[i]].value = tmp[1];
			obj[sel[i]-1].selected = true;
			obj[sel[i]].selected = false;
		}
	}
}


function downto(name) {
	var td = document.getElementById(name+'_td');
	var obj = td.getElementsByTagName('select')[0];
	if (obj.tagName.toLowerCase() != "select" && obj.length < 2)
		return false;
	var sel = new Array();
	for (i=obj.length-1; i>-1; i--) {
		if (obj[i].selected == true) {
			sel[sel.length] = i;
		}
	}
	for (i in sel) {
		if (sel[i] != obj.length-1 && typeof (obj[sel[i]+1]) != 'undefined' && !obj[sel[i]+1].selected) {
			var tmp = new Array(obj[sel[i]+1].text, obj[sel[i]+1].value);
			obj[sel[i]+1].text = obj[sel[i]].text;
			obj[sel[i]+1].value = obj[sel[i]].value;
			obj[sel[i]].text = tmp[0];
			obj[sel[i]].value = tmp[1];
			obj[sel[i]+1].selected = true;
			obj[sel[i]].selected = false;
		}
	}
}

</script>
<?php
}

}

?>
