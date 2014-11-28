<?php

/**
 * Provides an admin e-mail body editor UI element
 * @package Am_Form 
 */
class Am_Form_Element_MailEditor extends HTML_QuickForm2_Container_Group
{
    protected $editor;
    
    public function __construct($name, $options = array())
    {
        parent::__construct('', array('id' => 'mail-editor'));
        $this->addClass('no-label');

        $this->addStatic()->setContent('<div class="mail-editor">');
            $this->addStatic()->setContent('<div class="mail-editor-element">');
                $subject = $this->addElement('text', 'subject', array(
                        'class' => 'el-wide',
                        'placeholder' => ___('Subject')))
                        ->setLabel(___('Subject'));
                $subject->addRule('required');
            $this->addStatic()->setContent('</div>');

            $this->addStatic()->setContent('<div class="mail-editor-element">');
                $format = $this->addGroup(null)->setLabel(___('E-Mail Format'))->setSeparator(' ');
                $format->addRadio('format', array('value'=>'html'))->setContent(___('HTML Message'));
                $format->addRadio('format', array('value'=>'text'))->setContent(___('Plain-Text Message'));
            $this->addStatic()->setContent('</div>');

            $this->addStatic()->setContent('<div class="mail-editor-element">');
                $this->editor = $this->addElement(new Am_Form_Element_HtmlEditor('txt', null, true));
                $this->editor->addRule('required');
            $this->addStatic()->setContent('</div>');

            $this->addStatic()->setContent('<div class="mail-editor-element" id="insert-tags-wrapper">');
                $this->tagsOptions = Am_Mail_TemplateTypes::getInstance()->getTagsOptions($name);
                $tagsOptions = array();
                foreach ($this->tagsOptions as $k => $v)
                    $tagsOptions[$k] = "$k - $v";
                $sel = $this->addSelect('', array('id'=>'insert-tags', ));
                $sel->loadOptions(array_merge(array(''=>''), $tagsOptions));
            $this->addStatic()->setContent('</div>');

            $this->addStatic()->setContent('<div class="mail-editor-element">');
                $prefix = isset($options['upload-prefix']) ? $options['upload-prefix'] : EmailTemplate::ATTACHMENT_FILE_PREFIX;

                $fileChooser = new Am_Form_Element_Upload('attachments',
                        array('multiple'=>1), array('prefix'=>$prefix));
                $this->addElement($fileChooser)->setLabel(___('Attachments'));
            $this->addStatic()->setContent('</div>');
        $this->addStatic()->setContent('</div>');
    }
    
    protected function renderClientRules(HTML_QuickForm2_JavascriptBuilder $builder)
    {
        $id = Am_Controller::escape($this->editor->getId());
        $vars = "";
        foreach ($this->tagsOptions as $k => $v)
            $vars .= sprintf("[%s, %s],\n", Am_Controller::getJson($v), Am_Controller::getJson($k));
        $vars = trim($vars, "\n\r,");

        $builder->addElementJavascript(<<<CUT
$(function(){
    $('select#insert-tags').change(function(){
        var val = $(this).val();
        if (!val) return;
        $("#txt-0").insertAtCaret(val);
        $(this).prop("selectedIndex", -1);
    });
            
    if (CKEDITOR.instances["$id"]) {
        delete CKEDITOR.instances["$id"];
    }
    var editor = null;
    $("input[name='format']").change(function()
    {
        if (window.configDisable_rte) return;
        if (!this.checked) return;
        if (this.value == 'html')
        {
            if (!editor) {
                editor = initCkeditor("$id", { placeholder_items: [
                    $vars
                ]});
            }
            $('#insert-tags-wrapper').hide();
        } else {
            if (editor) {
                editor.destroy();
                editor = null;
            }
            $('#insert-tags-wrapper').show();
        }
    }).change();
});            
CUT
            );
    }
}