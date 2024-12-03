<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output encoding="UTF-8" indent="yes"/>
    <xsl:include href="header.xsl"/>
    <xsl:include href="text_struktur.xsl"/>
    <xsl:include href="kommentar.xsl"/>
    <xsl:template match="/">
        <xsl:processing-instruction name="xml-model">href="../schema/corpus_coranicum.rng" type="application/xml" schematypens="http://relaxng.org/ns/structure/1.0"</xsl:processing-instruction>
        <xsl:processing-instruction name="xml-model">href="../schema/corpus_coranicum.rng" type="application/xml" schematypens="http://purl.oclc.org/dsdl/schematron"</xsl:processing-instruction>        <TEI>
            <xsl:apply-templates select="body/korankommentar" mode="header"/>
            <text>
                <body>
                    <xsl:apply-templates select="//Quran"/>
                    <xsl:apply-templates select="body/korankommentar" mode="commentary"/>
                </body>
            </text>
        </TEI>
    </xsl:template>

    <xsl:template match="lang">
        <foreign>
            <xsl:apply-templates select="@* | node()" />
        </foreign>
    </xsl:template>

    <xsl:template match="@*|node()">
        <xsl:copy>
            <xsl:apply-templates select="@*|node()"/>
        </xsl:copy>
    </xsl:template>

</xsl:stylesheet>
