<?php

class Am_Grid_Action_Total extends Am_Grid_Action_Abstract
{

    protected $privilege = 'browse';
    protected $type = self::HIDDEN;
    protected $fields = array();
    protected $stms = array();
    /** @var Am_Query */
    protected $ds;

    public function run()
    {
        //nop
    }

    /**
     *
     * @param Am_Grid_Field $field
     * @return Am_Grid_Action_Total
     */
    public function addField(Am_Grid_Field $field, $stm = '%s')
    {
        $this->fields[$field->getFieldName()] = $field;
        $this->stms[$field->getFieldName()] = $stm;
        return $this;
    }

    public function setGrid(Am_Grid_Editable $grid)
    {
        $grid->addCallback(Am_Grid_ReadOnly::CB_RENDER_TABLE, array($this, 'renderOut'));
        /* @var $ds Am_Query */
        $this->ds = clone $grid->getDataSource();
        parent::setGrid($grid);
    }

    public function renderOut(& $out)
    {
        $titles = array();

        $this->ds->clearFields()
            ->clearOrder()
            ->toggleAutoGroupBy(false);

        foreach ($this->fields as $field) {
            /* @var $field Am_Grid_Field */
            $name = $field->getFieldName();
            $stm = $this->stms[$name];
            $this->ds
                ->addField(sprintf("SUM($stm)", $name), '_' . $name);
            $titles['_' . $name] = $field->getFieldTitle();
        }

        $totals = array();
        foreach (Am_Di::getInstance()->db->selectRow($this->ds->getSql()) as $key => $val) {
            $totals[] = sprintf('%s %s: <strong>%s</strong>', ___('Total'), $titles[$key], Am_Currency::render($val));
        }
        $count = count($this->grid->getFields());
        $tr = sprintf('<tr><td class="grid-total" colspan="%d">%s</td></td>',
                $count, implode(',', $totals));

        $out = preg_replace('|(<tr>\s*<th>)|', str_replace('$', '\$', $tr) . '\1', $out);
    }
}