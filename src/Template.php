<?php

namespace PH7\PHYZSYLE;

class Template
{
    private $sTplExt;

    public function __construct(Syntaxable $templateSyntax)
    {

    }

    /**
     * Get the template extension.
     *
     * @return string The extension with the dot.
     */
    public function getTplExt(): string
    {
        return $this->sTplExt;
    }

    /**
     * Set the template extension.
     *
     * @param string $sExt The extension with the dot.
     * @return void
     */
    public function setTplExt($sExt)
    {
        $this->sTplExt = $sExt;
    }
}
