<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" omit-xml-declaration="yes"/>


    <xsl:template match="div|p|em|sup|strong|h5">
        <xsl:element name="{local-name()}">
            <xsl:apply-templates/>
        </xsl:element>
    </xsl:template>

    <xsl:template match="b">
        <hi rend="bold"><xsl:apply-templates/></hi>
    </xsl:template>

    <xsl:template match="u">
        <hi rend="underline"><xsl:apply-templates/></hi>
    </xsl:template>

    <xsl:template match="span|font|big|html|body|xml|style">
        <xsl:apply-templates/>
    </xsl:template>

    <xsl:template match="text()">
        <xsl:value-of select="."/>
    </xsl:template>

    <xsl:template match="*">
    </xsl:template>

    <xsl:template match="i|em">
        <hi rend="italic">
            <xsl:apply-templates/>
        </hi>
    </xsl:template>

    <xsl:template match="a">
        <ref>
            <xsl:attribute name="target">
                <xsl:value-of select="@href"/>
            </xsl:attribute>
            <xsl:if test="@zotero">
                <xsl:attribute name="sameAs">
                    <xsl:value-of select="@zotero"/>
                </xsl:attribute>
                <xsl:attribute name="type">
                    <xsl:value-of select="'zotero'"/>
                </xsl:attribute>
            </xsl:if>
            <xsl:apply-templates/>
        </ref>
    </xsl:template>

</xsl:stylesheet>