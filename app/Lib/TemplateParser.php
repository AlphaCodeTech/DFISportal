<?php

namespace App\Lib;


use Illuminate\Support\Str;
use App\Models\MailVariable;
use App\Settings\SystemSetting;
use Illuminate\Support\Facades\App;

class TemplateParser
{
    /**
     * @var string $templateStr
     */
    private $templateStr;


    private $systemSetting;

    /**
     * optional in case of raw messages
     *
     * @var mixed|string $rawMessage
     */
    private $rawMessage = "";

    /**
     * @var array $templateVariables
     */
    private $templateVariables = [];

    /**
     * The final compiled template
     *
     * @var string $compiled
     */
    private $compiled = "";

    /**
     * container for dynamic data variables
     *
     * @var array $dynamicData
     */
    private $dynamicData = [];

    public function __construct($templateStr, $rawMessage = "")
    {
        $this->systemSetting = App::make(SystemSetting::class);
        $this->templateStr = $templateStr;

        $this->rawMessage = $rawMessage;
    }

    public function process()
    {
        // first: retrieve variable keys using regex using this pattern
        $matches = $this->getMatchedTemplateVariables();
        // second: loop for the matches and retrieve each variable from mail_variables table
        if ($matches && count($matches) > 0) {
            $this->templateVariables = $this->getParsedTemplateVariables($matches);
        }

        $this->compiled = $this->replaceKeysWithValues();
    }

    public function getCompiled()
    {
        return $this->compiled;
    }

    /**
     * setter for dynamic data
     */
    public function __set($propertyName, $propertyValue)
    {
        $this->dynamicData[$propertyName] = $propertyValue;
    }

    /**
     * getter for dynamic data
     */
    public function __get($propertyName)
    {
        if (array_key_exists($propertyName, $this->dynamicData)) {
            return $this->dynamicData[$propertyName];
        }

        return "";
    }

    private function getMatchedTemplateVariables()
    {
        $regex = '/\[\w.+?\]/m';

        preg_match_all($regex, $this->templateStr, $matches, PREG_SET_ORDER);

        return $matches;
    }

    private function getParsedTemplateVariables($matches)
    {
        $templateVariables = [];
        foreach ($matches as $match) {
            $mailVariable = MailVariable::where('key', $match[0])->first();

            if ($mailVariable) {
                $templateVariables[$mailVariable->key] = $this->getRealVariableValue($mailVariable->key, $mailVariable->value);
            }
        }

        return $templateVariables;
    }

    private function replaceKeysWithValues()
    {
        return str_replace(array_keys($this->templateVariables), array_values($this->templateVariables), $this->templateStr);
    }

    private function getRealVariableValue($variableKey, $variableValue)
    {
        // if variable value not empty return it
        if ($variableValue) {
            return $variableValue;
        }

        // else look for this in the reserved variables below
        if (array_key_exists($variableKey, $this->reservedVariableKeys())) {
            return $this->reservedVariableKeys()[$variableKey];
        }

        // else if the variable key is a form input
        if (Str::contains($variableKey, "INPUT")) {
            return $this->getInputTypeVariable($variableKey, $variableValue);
        }

        // else if the key is a dynamic data variable
        if (Str::contains($variableKey, "DYNAMIC")) {
            return $this->getDynamicTypeVariable($variableKey, $variableValue);
        }

        // otherwise return the value as is
        return $variableValue;
    }

    private function getInputTypeVariable($variableKey, $variableValue)
    {
        $inputName = explode(":", str_replace("]", "", str_replace("[", "", $variableKey)))[1];

        if (request()->has($inputName)) {
            return request()->input($inputName);
        }

        return $variableValue;
    }

    private function getDynamicTypeVariable($variableKey, $variableValue)
    {
        $propertyName = explode(":", str_replace("]", "", str_replace("[", "", $variableKey)))[1];

        if (isset($this->dynamicData[$propertyName])) {
            return $this->dynamicData[$propertyName];
        }

        return $variableValue;
    }

    private function reservedVariableKeys()
    {
        return [
            "[WEBSITE_LOGO]" => $this->getWebsiteLogo(),
            "[WEBSITE_NAME]" => $this->systemSetting->name,
            "[WEBSITE_EMAIL]" => $this->systemSetting->email,
            "[YEAR]" => date("Y"),
            "[MESSAGE_BODY]" => $this->rawMessage,
            "[CURR_USER]" => (auth()->check() ? auth()->user()->name : "")
        ];
    }

    private function getWebsiteLogo()
    {
        // return whatever your website logo
        $logoUrl = $this->systemSetting->logo;

        return '<img src="' . asset($logoUrl) . '" width="200" height="160" alt="website logo" />';
    }
}
