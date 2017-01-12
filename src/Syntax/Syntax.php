<?php

namespace PH7\PHYZSYLE\Syntax;

class Syntax
{
    protected $sCode;

    /**
     * Optimizes the code generated by the compiler php template.
     */
    protected function optimization(): void
    {
        $this->sCode = preg_replace(array('#[\t\r\n];?\?>#s', '#\?>[\t\r\n]+?<\?(php)?#si'), '', $this->sCode);
        $this->sCode = preg_replace('#;{2,}#s', ';', $this->sCode);
    }
}