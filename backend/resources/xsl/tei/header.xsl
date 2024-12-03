<?xml version="1.0" encoding="UTF-8"?>
<?xml-model href="../schema/corpus_coranicum.rng" type="application/xml" schematypens="http://relaxng.org/ns/structure/1.0"?>
<?xml-model href="../schema/corpus_coranicum.rng" type="application/xml" schematypens="http://purl.oclc.org/dsdl/schematron"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output encoding="UTF-8" indent="yes"/>
    <xsl:template match="korankommentar" mode="header">
        <teiHeader>
            <fileDesc>
                <titleStmt>
                    <title>
                        <xsl:apply-templates select=".//surentitel/text/p/node()"/>
                    </title>
                    <editor role="translator">
                        <xsl:value-of select="preceding-sibling::Quran/Sure/@translator"/>
                    </editor>
                </titleStmt>
                <publicationStmt>
                    <p>Corpus Coranicum Project</p>
                </publicationStmt>
                <sourceDesc>
                    <xsl:apply-templates select=".//autorenkurz/text/p"/>
                </sourceDesc>
            </fileDesc>
        </teiHeader>
    </xsl:template>

</xsl:stylesheet>
