<?php

namespace PH7\PHYZSYLE\Syntax;

class pH7Tpl extends Syntax implements Syntaxable
{
    /**
     * Parse the general code for translating the template language.
     *
     * @return void
     */
    public function parse(): void
    {
        /***** Includes *****/
        $this->sCode = str_replace('{auto_include}', '<?php $this->display($this->getCurrentController() . PH7_DS . $this->registry->action . \'' .
                  $this->sTplExt . '\', $this->registry->path_module_views . PH7_TPL_MOD_NAME . PH7_DS); ?>', $this->sCode);
        $this->sCode = preg_replace('#{include ([^\{\}\n]+)}#', '<?php $this->display($1); ?>', $this->sCode);
        $this->sCode = preg_replace('#{main_include ([^\{\}\n]+)}#', '<?php $this->display($1, PH7_PATH_TPL . PH7_TPL_NAME . PH7_DS); ?>', $this->sCode);
        $this->sCode = preg_replace('#{def_main_auto_include}#', '<?php $this->display(\'' . $this->sTplFile . '\', PH7_PATH_TPL . PH7_DEFAULT_THEME . PH7_DS); ?>', $this->sCode);
        $this->sCode = preg_replace('#{def_main_include ([^\{\}\n]+)}#', '<?php $this->display($1, PH7_PATH_TPL . PH7_DEFAULT_THEME . PH7_DS); ?>', $this->sCode);
        $this->sCode = preg_replace('#{manual_include ([^\{\}\n]+)}#', '<?php $this->display($this->getCurrentController() . PH7_DS . $1, $this->registry->path_module_views . PH7_TPL_MOD_NAME . PH7_DS); ?>', $this->sCode);

        /***** Objects *****/
        $this->sCode = str_replace(array('$browser->', '$designModel->'), array('$this->browser->', '$this->designModel->'), $this->sCode);

        /***** CLassic Syntax *****/
        $this->classicSyntax();

        /***** XML Syntax *****/
        if ($this->bXmlTags)
           $this->xmlSyntax();

        /***** Variables *****/
        $this->sCode = preg_replace('#{([a-z0-9_]+)}#i', '<?php echo $$1; ?>', $this->sCode);

        /***** Clears comments {* comment *} *****/
        $this->sCode = preg_replace('#{\*.+\*}#isU', null, $this->sCode);

        /***** Code optimization *****/
        $this->optimization();
    }

    /**
     * Get the reserved variables.
     *
     * @return array
     */
    public function getReservedWords(): array
    {
        return ['auto_include', 'def_main_auto_include', 'else', 'literal', 'lang'];
    }

    /**
     * Allows testing with empty() and isset() to work.
     *
     * @param string $sKey
     * @return boolean
     */
    public function __isset($sKey): bool
    {
        return isset($this->_aVars[$sKey]);
    }
}