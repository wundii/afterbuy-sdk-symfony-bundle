<?php

declare(strict_types=1);

namespace Wundii\AfterbuySdk\SymfonyBundle\Tests;

use DOMDocument;
use LibXMLError;
use PHPUnit\Framework\TestCase;

class XsdSchemaValidationTest extends TestCase
{
    public const SCHEMA_PATH = __DIR__ . '/../src/Resources/config/schema/afterbuy_sdk-1.0.xsd';

    public function testValidXmlPassesXsdValidation(): void
    {
        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<config>
    <afterbuy_global>
        <accountToken>token1</accountToken>
        <partnerToken>token2</partnerToken>
        <endpointEnum>sandbox</endpointEnum>
        <errorLanguageEnum>DE</errorLanguageEnum>
</afterbuy_global>
    <logger_interface>interface</logger_interface>
    <validatorBuilder/>
</config>
XML;

        $dom = new DOMDocument();
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($xml);

        libxml_use_internal_errors(true);
        $isValid = $dom->schemaValidate(self::SCHEMA_PATH);

        $errors = libxml_get_errors();
        libxml_clear_errors();

        $this->assertTrue($isValid, self::formatLibxmlErrors($errors));
    }

    /**
     * @param LibXMLError[] $errors
     */
    public static function formatLibxmlErrors(array $errors): string
    {
        return implode("\n", array_map(function (LibXMLError $error) {
            return trim($error->message) . ' on line ' . $error->line;
        }, $errors));
    }
}
