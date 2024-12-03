<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:xs="http://www.w3.org/2001/XMLSchema" exclude-result-prefixes="xs" version="1.0">
    <xsl:output method="xml" indent="yes" omit-xml-declaration="yes" />
    <xsl:template match="/">
        <xsl:for-each select="//l | //pb">
            <xsl:choose>
                <xsl:when test="name() = 'l'">
                    <tr>
                        <td class="manuscriptLine">
                            <!--<xsl:for-each select="./w | ./pc[supplied or add or del or hi or unclear] | ./pc[text() != '&#160;']">-->
                            <xsl:for-each select="./w | ./pc[text() != '&#160;' and not(*)]">

                                <xsl:variable name="childCount">
                                    <xsl:value-of select="count(*)"/>
                                </xsl:variable>

                                <xsl:variable name="sure">
                                    <xsl:value-of select="substring(./@n, 1, 3)"/>
                                </xsl:variable>

                                <xsl:variable name="vers">
                                    <xsl:value-of select="substring(./@n, 5, 3)"/>
                                </xsl:variable>

                                <xsl:variable name="wort">
                                    <xsl:value-of select="substring(./@n, 9, 3)"/>
                                </xsl:variable>

                                <xsl:variable name="tooltip">
                                    <xsl:choose>
                                        <xsl:when test="number($sure) = 0 and number($vers) = 0 and number($wort) = 0">
                                                Verstrenner
                                        </xsl:when>
                                        <xsl:when test="$sure = ''">
                                                Leerzeichen
                                        </xsl:when>
                                        <xsl:otherwise>
                                                Sure: <xsl:value-of select="number($sure)"/>
, Vers: <xsl:value-of select="number($vers)"/>
, Wort: <xsl:value-of select="number($wort)"/>
                                </xsl:otherwise>

                            </xsl:choose>
                        </xsl:variable>

                        <span class="translitWort tooltip" sure="{$sure}" vers="{$vers}" wort="{$wort}" title="{normalize-space($tooltip)}">


                            <xsl:apply-templates/>


                            <!-- Insert Whitespace between words -->
                            <xsl:text></xsl:text>
                        </span>


                    </xsl:for-each>
                </td>
                <td class="linenumber">
                    <xsl:value-of select="./@n"/>
                </td>

            </tr>

        </xsl:when>

        <xsl:when test="name() = 'pb'">
            <tr class="empty">
                <td>
                    <hr/>
                </td>
                <td></td>
            </tr>
        </xsl:when>
    </xsl:choose>
</xsl:for-each>
</xsl:template>

<xsl:template match="unclear">
<span class="unclear">
    <xsl:variable name="pos">
        <xsl:value-of select="count(preceding-sibling::*)+1"/>
    </xsl:variable>

    <xsl:variable name="siblings">
        <xsl:value-of select="count(../*)"/>
    </xsl:variable>

    <xsl:choose>
        <xsl:when test="$siblings &gt; 1 and $pos = 1">
            <xsl:value-of select="."/>
&#8205;
        </xsl:when>
        <xsl:when test="$siblings &gt; 1 and $pos &lt; $siblings and $pos != 1">
                    &#8205;<xsl:value-of select="."/>
&#8205;
        </xsl:when>
        <xsl:when test="$siblings &gt; 1 and $pos = $siblings and $pos != 1">
            <xsl:value-of select="."/>
        </xsl:when>
        <xsl:otherwise>
            <xsl:value-of select="."/>
        </xsl:otherwise>
    </xsl:choose>
</span>
</xsl:template>

<xsl:template match="add[@type='rasm']">
<span class="added">
    <xsl:variable name="pos">
        <xsl:value-of select="count(preceding-sibling::*)+1"/>
    </xsl:variable>

    <xsl:variable name="siblings">
        <xsl:value-of select="count(../*)"/>
    </xsl:variable>

    <xsl:choose>
        <xsl:when test="$siblings &gt; 1 and $pos = 1">
            <xsl:value-of select="."/>
&#8205;
        </xsl:when>
        <xsl:when test="$siblings &gt; 1 and $pos &lt; $siblings and $pos != 1">
                    &#8205;<xsl:value-of select="."/>
&#8205;
        </xsl:when>
        <xsl:when test="$siblings &gt; 1 and $pos = $siblings and $pos != 1">
            <xsl:value-of select="."/>
        </xsl:when>
        <xsl:otherwise>
            <xsl:value-of select="."/>
        </xsl:otherwise>
    </xsl:choose>
</span>
</xsl:template>

<xsl:template match="supplied[@reason='illigible' and @source='#cairo_rasm']">
<span class="missing">
    <xsl:variable name="pos">
        <xsl:value-of select="count(preceding-sibling::*)+1"/>
    </xsl:variable>

    <xsl:variable name="siblings">
        <xsl:value-of select="count(../*)"/>
    </xsl:variable>

    <xsl:choose>
        <xsl:when test="$siblings &gt; 1 and $pos = 1">
            <xsl:value-of select="."/>
&#8205;
        </xsl:when>
        <xsl:when test="$siblings &gt; 1 and $pos &lt; $siblings and $pos != 1">
                    &#8205;<xsl:value-of select="."/>
&#8205;
        </xsl:when>
        <xsl:when test="$siblings &gt; 1 and $pos = $siblings and $pos != 1">
            <xsl:value-of select="."/>
        </xsl:when>
        <xsl:otherwise>
            <xsl:value-of select="."/>
        </xsl:otherwise>
    </xsl:choose>
</span>
</xsl:template>

<xsl:template match="supplied[@reason='omitted-in-original' and @source='#cairo_rasm']">
<span class="unavailable">
    <xsl:variable name="pos">
        <xsl:value-of select="count(preceding-sibling::*)+1"/>
    </xsl:variable>

    <xsl:variable name="siblings">
        <xsl:value-of select="count(../*)"/>
    </xsl:variable>

    <xsl:choose>
        <xsl:when test="$siblings &gt; 1 and $pos = 1">
            <xsl:value-of select="."/>
&#8205;
        </xsl:when>
        <xsl:when test="$siblings &gt; 1 and $pos &lt; $siblings and $pos != 1">
                    &#8205;<xsl:value-of select="."/>
&#8205;
        </xsl:when>
        <xsl:when test="$siblings &gt; 1 and $pos = $siblings and $pos != 1">
            <xsl:value-of select="."/>
        </xsl:when>
        <xsl:otherwise>
            <xsl:value-of select="."/>
        </xsl:otherwise>
    </xsl:choose>
</span>
</xsl:template>

<xsl:template match="add[@type='rasm' and @subtype='variant']">
<span class="variation">
    <xsl:variable name="pos">
        <xsl:value-of select="count(preceding-sibling::*)+1"/>
    </xsl:variable>

    <xsl:variable name="siblings">
        <xsl:value-of select="count(../*)"/>
    </xsl:variable>

    <xsl:choose>
        <xsl:when test="$siblings &gt; 1 and $pos = 1">
            <xsl:value-of select="."/>
&#8205;
        </xsl:when>
        <xsl:when test="$siblings &gt; 1 and $pos &lt; $siblings and $pos != 1">
                    &#8205;<xsl:value-of select="."/>
&#8205;
        </xsl:when>
        <xsl:when test="$siblings &gt; 1 and $pos = $siblings and $pos != 1">
            <xsl:value-of select="."/>
        </xsl:when>
        <xsl:otherwise>
            <xsl:value-of select="."/>
        </xsl:otherwise>
    </xsl:choose>
</span>
</xsl:template>

<xsl:template match="hi[@rend='4_-_multiple_modification']">
<span class="modified">
    <xsl:variable name="pos">
        <xsl:value-of select="count(preceding-sibling::*)+1"/>
    </xsl:variable>

    <xsl:variable name="siblings">
        <xsl:value-of select="count(../*)"/>
    </xsl:variable>

    <xsl:choose>
        <xsl:when test="$siblings &gt; 1 and $pos = 1">
            <xsl:value-of select="."/>
&#8205;
        </xsl:when>
        <xsl:when test="$siblings &gt; 1 and $pos &lt; $siblings and $pos != 1">
                    &#8205;<xsl:value-of select="."/>
&#8205;
        </xsl:when>
        <xsl:when test="$siblings &gt; 1 and $pos = $siblings and $pos != 1">
            <xsl:value-of select="."/>
        </xsl:when>
        <xsl:otherwise>
            <xsl:value-of select="."/>
        </xsl:otherwise>
    </xsl:choose>
</span>
</xsl:template>

<xsl:template match="hi[@rend='italic']">
<span class="italic">
    <xsl:variable name="pos">
        <xsl:value-of select="count(preceding-sibling::*)+1"/>
    </xsl:variable>

    <xsl:variable name="siblings">
        <xsl:value-of select="count(../*)"/>
    </xsl:variable>

    <xsl:choose>
        <xsl:when test="$siblings &gt; 1 and $pos = 1">
            <xsl:value-of select="."/>
&#8205;
        </xsl:when>
        <xsl:when test="$siblings &gt; 1 and $pos &lt; $siblings and $pos != 1">
                    &#8205;<xsl:value-of select="."/>
&#8205;
        </xsl:when>
        <xsl:when test="$siblings &gt; 1 and $pos = $siblings and $pos != 1">
            <xsl:value-of select="."/>
        </xsl:when>
        <xsl:otherwise>
            <xsl:value-of select="."/>
        </xsl:otherwise>
    </xsl:choose>
</span>
</xsl:template>

<xsl:template match="del">
<span class="erased">
    <xsl:variable name="pos">
        <xsl:value-of select="count(preceding-sibling::*)+1"/>
    </xsl:variable>

    <xsl:variable name="siblings">
        <xsl:value-of select="count(../*)"/>
    </xsl:variable>

    <xsl:choose>
        <xsl:when test="$siblings &gt; 1 and $pos = 1">
            <xsl:value-of select="."/>
&#8205;
        </xsl:when>
        <xsl:when test="$siblings &gt; 1 and $pos &lt; $siblings and $pos != 1">
                    &#8205;<xsl:value-of select="."/>
&#8205;
        </xsl:when>
        <xsl:when test="$siblings &gt; 1 and $pos = $siblings and $pos != 1">
            <xsl:value-of select="."/>
        </xsl:when>
        <xsl:otherwise>
            <xsl:value-of select="."/>
        </xsl:otherwise>
    </xsl:choose>
</span>
</xsl:template>
</xsl:stylesheet>