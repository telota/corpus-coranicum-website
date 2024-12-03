<xsl:stylesheet version="1.0"
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <!-- bibliographische Referenzen werden in einem Span-Element gewrappt und mit Link zur Literaturliste unterlegt, wenn Id vorhanden -->
    <xsl:template name="bibl">

        <xsl:param name="prefix"/>

        <span class="bibl">
            <xsl:choose>
                <xsl:when test="@Zotero_Id_1">
                    <a class="litlink" target="_blank">
                        <xsl:attribute name="href">
                            <xsl:text>https://www.zotero.org/groups/corpuscoranicum_pub/items/itemKey/</xsl:text>
                            <xsl:value-of select="@Zotero_Id_1"></xsl:value-of>
                        </xsl:attribute>
                        <xsl:apply-templates/>
                    </a>
                </xsl:when>
                <xsl:otherwise>
                    <xsl:apply-templates/>
                </xsl:otherwise>
            </xsl:choose>
        </span>
    </xsl:template>

</xsl:stylesheet>