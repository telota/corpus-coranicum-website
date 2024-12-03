<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output encoding="UTF-8" indent="yes"/>
    <xsl:template match="korankommentar" mode="commentary">
        <xsl:apply-templates select="datierung" mode="section"/>
        <xsl:apply-templates select="literarkritik" mode="section"/>
        <xsl:apply-templates select="aufbauinhalt" mode="section"/>
        <xsl:apply-templates select="ueberblick" mode="section"/>
        <xsl:apply-templates select="anmerkungen" mode="section"/>
        <xsl:apply-templates select="textkritik" mode="section"/>
        <xsl:apply-templates select="komposition" mode="section"/>
        <xsl:apply-templates select="kommentar" mode="section"/>
        <xsl:apply-templates select="analysedeutung" mode="section"/>
    </xsl:template>
    <xsl:template match="*" mode="section">
        <div>
            <xsl:if test="parent::korankommentar">
                <xsl:attribute name="resp">an</xsl:attribute>
            </xsl:if>

            <xsl:attribute name="type">
                <xsl:value-of select="name()"/>
            </xsl:attribute>

            <xsl:variable name="preceding" select="name(preceding-sibling::*[1])"/>
            <xsl:variable name="ending" select="substring($preceding, string-length($preceding) - 3)"/>
            <xsl:if test="$ending='kurz'">
                <xsl:apply-templates select="preceding-sibling::*[1]" mode="title"/>
            </xsl:if>
            <xsl:apply-templates select="EntwicklungsgeschichtlicheEinordnung" mode="section"/>
            <xsl:apply-templates select="Inhaltstruktur" mode="section"/>
            <xsl:apply-templates select="Situativität" mode="section"/>
            <xsl:apply-templates select="text" mode="section"/>
        </div>
    </xsl:template>

    <xsl:template match="*" mode="title">
        <ab type="title">
            <xsl:apply-templates select="./text/p/node()"/>
        </ab>
    </xsl:template>
    <xsl:template match="text" mode="section">
        <xsl:choose>
            <xsl:when test="(parent::kommentar) or (parent::anmerkungen)">
                <div>
                    <xsl:attribute name="xml:id">
                        <xsl:value-of select="'kommentar-'"/>
                        <xsl:value-of select="@versstart"/>
                        <xsl:if test="@versstart!=@versend">
                            <xsl:value-of select="'-'"/>
                            <xsl:value-of select="@versend"/>

                        </xsl:if>
                    </xsl:attribute>
                    <xsl:apply-templates select="*"/>
                </div>
            </xsl:when>
            <xsl:otherwise>
                <xsl:apply-templates select="*"/>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>

    <xsl:template match="q">
        <ref>
           <xsl:apply-templates select="@type" />
            <xsl:apply-templates select="@id" />
            <xsl:apply-templates select="@buch" />
            <xsl:attribute name="target">
                <xsl:value-of select="@type"/>
                <xsl:value-of select="'-'"/>
                <xsl:value-of select="@versstart"/>
                <xsl:value-of select="'-'"/>
                <xsl:value-of select="@versend"/>
            </xsl:attribute>
           <xsl:apply-templates/>
        </ref>
    </xsl:template>


    <xsl:template match="bibl">
        <bibl type="zotero">
            <xsl:attribute name="key">
                <xsl:value-of select="'zotero-'"/>
                <xsl:value-of select="@Zotero_Id_1"/>
            </xsl:attribute>
            <xsl:apply-templates/>
        </bibl>
    </xsl:template>
    <xsl:template match="lem">
        <app>
            <lem>
                <xsl:apply-templates/>
            </lem>
        </app>

    </xsl:template>



</xsl:stylesheet>
