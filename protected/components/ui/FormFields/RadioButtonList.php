<?php
/**
 * Class RadioButtonList
 * @author rizky
 */
class RadioButtonList extends FormField {
    /**
     * @return array me-return array property RadioButton.
     */
    public function getFieldProperties() {
        return array (
            array (
                'label' => 'Field Name',
                'name' => 'name',
                'options' => array (
                    'ng-model' => 'active.name',
                    'ng-change' => 'save()',
                    'ng-form-list' => 'modelFieldList',
                    'searchable' => 'size(modelFieldList) > 5',
                ),
                'list' => array (),
                'showOther' => 'Yes',
                'type' => 'DropDownList',
            ),
            array (
                'label' => 'Label',
                'name' => 'label',
                'options' => array (
                    'ng-model' => 'active.label',
                    'ng-change' => 'save()',
                    'ng-delay' => '500',
                ),
                'type' => 'TextField',
            ),
            array (
                'label' => 'Layout',
                'name' => 'layout',
                'options' => array (
                    'ng-model' => 'active.layout',
                    'ng-change' => 'save();',
                    'ng-delay' => '500',
                ),
                'list' => array (
                    'Horizontal' => 'Horizontal',
                    'Vertical' => 'Vertical',
                ),
                'listExpr' => 'array(\'Horizontal\',\'Vertical\')',
                'fieldWidth' => '6',
                'type' => 'DropDownList',
            ),
            array (
                'label' => 'Item Layout',
                'name' => 'itemLayout',
                'options' => array (
                    'ng-model' => 'active.itemLayout',
                    'ng-change' => 'save()',
                    'ng-delay' => '500',
                ),
                'list' => array (
                    'Horizontal' => 'Horizontal',
                    'Vertical' => 'Vertical',
                    'ButtonGroup' => 'ButtonGroup',
                ),
                'listExpr' => 'array(\'Horizontal\',\'Vertical\',\'ButtonGroup\')',
                'fieldWidth' => '6',
                'type' => 'DropDownList',
            ),
            array (
                'label' => 'Label Width',
                'name' => 'labelWidth',
                'fieldWidth' => '4',
                'options' => array (
                    'ng-model' => 'active.labelWidth',
                    'ng-change' => 'save()',
                    'ng-delay' => '500',
                    'ng-disabled' => 'active.layout == \'Vertical\';',
                ),
                'type' => 'TextField',
            ),
            array (
                'label' => 'Radio Button Item',
                'fieldname' => 'list',
                'options' => array (
                    'ng-hide' => 'active.listExpr != \'\' || active.options[\'ng-form-list\'] != null',
                ),
                'allowSpaceOnKey' => 'Yes',
                'type' => 'KeyValueGrid',
            ),
            array (
                'label' => 'List Expression',
                'fieldname' => 'listExpr',
                'validAction' => 'active.list = result;save();',
                'options' => array (
                    'ng-hide' => 'active.options[\'ng-form-list\'] != null',
                ),
                'desc' => '<i class="fa fa-warning"></i> WARNING: Using List Expression will replace <i>Radio Button Item</i> with expression result',
                'type' => 'ExpressionField',
            ),
            array (
                'label' => 'Options',
                'fieldname' => 'options',
                'type' => 'KeyValueGrid',
            ),
            array (
                'label' => 'Label Options',
                'fieldname' => 'labelOptions',
                'type' => 'KeyValueGrid',
            ),
            array (
                'label' => 'Field Options',
                'fieldname' => 'fieldOptions',
                'type' => 'KeyValueGrid',
            ),
        );
    }

    /** @var string $label */
    public $label = '';
	
    /** @var string $name */
    public $name = '';
	
    /** @var string $value digunakan pada function checked */
    public $value = '';
	
    /** @var string $list */
    public $list = '';
	
    /** @var string $listExpr digunakan pada function processExpr */
    public $listExpr = '';
	
    /** @var string $layout */
    public $layout = 'Horizontal';
	
    /** @var string $itemLayout */
    public $itemLayout = 'Vertical';
	
    /** @var integer $labelWidth */
    public $labelWidth = 4;
	
    /** @var array $options */
    public $options = array();
	
    /** @var array $labelOptions */
    public $labelOptions = array();
	
    /** @var array $fieldOptions */
    public $fieldOptions = array();
	
    /** @var string $toolbarName */
    public static $toolbarName = "RadioButton List";
	
    /** @var string $category */
    public static $category = "User Interface";
	
    /** @var string $toolbarIcon */
    public static $toolbarIcon = "fa fa-dot-circle-o";
	
    /**
     * @return array me-return array javascript yang di-include
    */
    public function includeJS() {
        return array('radio-button-list.js');
    }

    /**
     * @return array me-return array hasil proses expression.
     */
    public function processExpr() {
        if ($this->listExpr != "") {
            ## evaluate expression
            $this->list = $this->evaluate($this->listExpr, true);
            
            ## change sequential array to associative array
            if (is_array($this->list) && !Helper::is_assoc($this->list)) {
                $this->list = Helper::toAssoc($this->list);
            }

            if (FormField::$inEditor) {
                if (count($this->list) > 5) {
                    $this->list = array_slice($this->list, 0, 5);
                    $this->list['z...'] = "...";
                }
            }
        } else if (is_array($this->list) && !Helper::is_assoc($this->list)) {
            $this->list = Helper::toAssoc($this->list);
        }

        return array(
            'list' => $this->list
        );
    }

    /**
     * getLayoutClass
     * Fungsi ini akan mengecek nilai property $layout untuk menentukan nama Class Layout
     * @return string me-return string Class layout yang digunakan
     */
    public function getLayoutClass() {
        return ($this->layout == 'Vertical' ? 'form-vertical' : '');
    }

    /**
     * @return string me-return string Class error jika terdapat error pada satu atau banyak attribute.
     */
    public function getErrorClass() {
        return (count($this->errors) > 0 ? 'has-error has-feedback' : '');
    }

    /**
     * getlabelClass
     * Fungsi ini akan mengecek $layout untuk menentukan layout yang digunakan
     * dan me-load option label dari property $labelOptions
     * @return string me-return string Class label
     */
    public function getlabelClass() {
        if ($this->layout == 'Vertical') {
            $class = "control-label col-sm-12";
        } else {
            $class = "control-label col-sm-{$this->labelWidth}";
        }

        $class .= @$this->labelOptions['class'];
        return $class;
    }

    /**
     * checked
     * Fungsi ini untuk mengecek value dari field ada dalam sebuah array list
     * @param string $value
     * @return string me-return string hasil checked
     */
    public function checked($value) {
        return $value == $this->value ? 'checked="checked"' : '';
    }

     /**
     * getFieldColClass
     * Fungsi ini untuk menetukan width field
     * @return string me-return string class
     */	
    public function getFieldColClass() {
        return "col-sm-" . ($this->layout == 'Vertical' ? 12 : 12 - $this->labelWidth);
    }

    /**
     * render
     * Fungsi ini untuk me-render field dan atributnya
     * @return mixed me-return sebuah field dan atribut RadioButtonList dari hasil render
     */
    public function render() {
        $this->addClass('form-group form-group-sm');
        $this->addClass($this->layoutClass);
        $this->addClass($this->errorClass);

        $this->addClass('input-group', 'fieldOptions');
        if ($this->itemLayout == "Horizontal") {
            $this->addClass('inline', 'fieldOptions');
        }

        $this->setDefaultOption('ng-model', "model.{$this->originalName}", $this->options);
        
        $this->processExpr();
        return $this->renderInternal('template_render.php');
    }

}
