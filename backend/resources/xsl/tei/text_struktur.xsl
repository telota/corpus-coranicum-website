<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output encoding="UTF-8" indent="yes"/>
    <xsl:template match="Quran">
        <div type="Textstruktur" resp="an">
            <xsl:apply-templates/>
        </div>
    </xsl:template>

    <xsl:template match="Sure">
        <lg type="sura">
            <xsl:attribute name="xml:id">
                <xsl:text>sura-</xsl:text>
                <xsl:variable name="id" select="@id"/>
                <xsl:value-of select="format-number($id,'000')"/>
            </xsl:attribute>
            <xsl:apply-templates/>
        </lg>
    </xsl:template>

    <xsl:template match="Hauptteil">
        <lg type="Hauptteil">
            <xsl:attribute name="xml:id">
                <xsl:text>h-</xsl:text>
                <xsl:variable name="id" select="@id"/>
                <xsl:value-of select="format-number($id,'000')"/>
            </xsl:attribute>
            <xsl:apply-templates/>
        </lg>
    </xsl:template>

    <xsl:template match="Abschnitt">
        <lg type="Abschnitt">
            <xsl:attribute name="xml:id">
                <xsl:text>a-</xsl:text>
                <xsl:variable name="id" select="@id"/>
                <xsl:value-of select="format-number($id,'000')"/>
            </xsl:attribute>
            <xsl:apply-templates/>
        </lg>
    </xsl:template>

    <xsl:template match="Gesaetz">
        <lg type="Gesaetz">
            <xsl:attribute name="xml:id">
                <xsl:text>g-</xsl:text>
                <xsl:variable name="id" select="@n"/>
                <xsl:value-of select="format-number($id,'000')"/>
            </xsl:attribute>
            <xsl:apply-templates/>
        </lg>
    </xsl:template>

    <xsl:template match="Vers">
        <lg type="Vers">
            <xsl:attribute name="xml:id">
                <xsl:text>v-</xsl:text>
                <xsl:variable name="id" select="@n"/>
                <xsl:value-of select="format-number($id,'000')"/>
            </xsl:attribute>
            <xsl:apply-templates/>
        </lg>
    </xsl:template>

    <xsl:template match="Teilvers">
        <lg type="Teilvers">
            <xsl:attribute name="xml:id">
                <xsl:text>t-</xsl:text>
                <xsl:variable name="id" select="@n"/>
                <xsl:value-of select="format-number($id,'000')"/>
            </xsl:attribute>
            <xsl:attribute name="rhyme">
                <xsl:value-of select="@reim"/>
            </xsl:attribute>
            <xsl:apply-templates/>
        </lg>
    </xsl:template>

    <xsl:template match="Kolon">
        <l>
            <xsl:copy-of select="@n"/>
            <xsl:attribute name="xml:lang">
                <xsl:value-of select="@lang"/>
            </xsl:attribute>
            <xsl:if test="@Einschub='true'">
                <xsl:attribute name="key">einschub</xsl:attribute>
            </xsl:if>
            <xsl:apply-templates/>
        </l>

    </xsl:template>


</xsl:stylesheet>
