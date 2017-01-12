<?php

namespace PH7\PHYZSYLE\Syntax;

class pH7Xml extends Syntax implements Syntaxable
{
    /**
     * Parse XML style syntax.
     *
     * @access protected
     * @return void
     */
    public function parse()
    {
        /***** <?php *****/
        $this->sCode = str_replace('<ph:code>', '<?php ', $this->sCode);

        /***** ?> *****/
        if (!preg_match('#;[\s]+</ph:code>$#', $this->sCode))
            $this->sCode = str_replace('</ph:code>', ';?>', $this->sCode);
        else
            $this->sCode = str_replace('</ph:code>', '?>', $this->sCode);

        /***** <?php ?> *****/
        $this->sCode = preg_replace('#<ph:code value=(?:"|\')(.+)(?:"|\') ?/?>#', '<?php $1 ?>', $this->sCode);

        /***** <?php echo *****/
        $this->sCode = preg_replace('#<ph:print value=(?:"|\')(.+)(?:"|\') ?/?>#', '<?php echo ', $this->sCode);

        /***** if *****/
        $this->sCode = preg_replace('#<ph:if test=(?:"|\')([^\<\>"\n]+)(?:"|\')>#', '<?php if($1) { ?>', $this->sCode);

        /***** if isset *****/
        $this->sCode = preg_replace('#<ph:if-set test=(?:"|\')([^\<\>"\n]+)(?:"|\')>#', '<?php if(!empty($1)) { ?>', $this->sCode);

        /***** if empty *****/
        $this->sCode = preg_replace('#<ph:if-empty test=(?:"|\')([^\<\>"\n]+)(?:"|\')>#', '<?php if(empty($1)) { ?>', $this->sCode);

        /***** if equal *****/
        $this->sCode = preg_replace('#<ph:if-equal test=(?:"|\')([^\{\},"\n]+)(?:"|\'),(?:"|\')([^\{\},"\n]+)(?:"|\')>#', '<?php if($1 == $2) { ?>', $this->sCode);


        /***** elseif *****/
        $this->sCode = preg_replace('#<ph:else-if test=(?:"|\')([^\<\>"\n]+)(?:"|\')>#', '<?php elseif($1) { ?>', $this->sCode);

        /***** else *****/
        $this->sCode = str_replace('<ph:else>', '<?php else { ?>', $this->sCode);

        /***** for *****/
        /*** Example ***/
        /* <ph:for test="$sData in $aData"> <p>Total items: <ph:print value="$sData_total" /><br /> Number: <ph:print value="$sData_i" /><br /> Name: <ph:print value="$sData" /></p> </ph:for> */
        $this->sCode = preg_replace('#<ph:for test=(?:"|\')([^\<\>"\n]+) in ([^\<\>"\n]+)(?:"|\')>#', '<?php for($1_i=0,$1_total=count($2);$1_i<$1_total;$1_i++) { $1=$2[$1_i]; ?>', $this->sCode);

        /***** while *****/
        $this->sCode = preg_replace('#<ph:while test=(?:"|\')([^\<\>"\n]+)(?:"|\')>#', '<?php while($1) { ?>', $this->sCode);

        /***** each (foreach) *****/
        $this->sCode = preg_replace('#<ph:each test=(?:"|\')([^\<\>"\n]+) in ([^\<\>"\n]+)(?:"|\')>#', '<?php foreach($2 as $1) { ?>', $this->sCode);

        /***** endif | endfor | endwhile | endforeach *****/
        $this->sCode = str_replace(array('</ph:if>', '</ph:else>', '</ph:else-if>', '</ph:for>', '</ph:while>', '</ph:each>', '</ph:if-set>', '</ph:if-empty>', '</ph:if-equal>'), '<?php } ?>', $this->sCode);

        /***** Escape (htmlspecialchars) *****/
        $this->sCode = preg_replace('#<ph:escape value=(?:"|\')([^\{\}]+)(?:"|\') ?/?>#', '<?php this->str->escape($1); ?>', $this->sCode);

        /***** Translate (Gettext) *****/
        $this->sCode = preg_replace('#<ph:lang value=(?:"|\')([^\{\}]+)(?:"|\') ?/?>#', '<?php echo t($1); ?>', $this->sCode);
        $this->sCode = preg_replace('#<ph:lang>([^\{\}]+)</ph:lang>#', '<?php echo t(\'$1\'); ?>', $this->sCode);

        /***** literal JavaScript Code *****/
        $this->sCode = preg_replace('#<ph:literal>(.+)</ph:literal>#', '$1', $this->sCode);
    }
}