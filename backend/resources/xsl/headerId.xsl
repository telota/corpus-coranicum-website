<?xml version="1.0" encoding="UTF-8" ?>
<xsl:stylesheet version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:variable name="lowercase" select="'abcdefghijklmnopqrstuvwxyzäöü'" />
	<xsl:variable name="uppercase" select="'ABCDEFGHIJKLMNOPQRSTUVWXYZÄÖÜ'" />
	<xsl:variable name="drop" select="'12345567890.:‚’'" />


	<xsl:template name="header_id">
		<xsl:param name="text"/>
		<xsl:value-of select="
			translate(
				normalize-space(
					translate(
						translate($text/text(), $uppercase, $lowercase),
						$drop,''
					)
				),' ','_'
			)" />
		<xsl:if test="normalize-space($text/text())='Vorbemerkungen'">
			<xsl:text>_</xsl:text>
			<xsl:value-of select="$text/preceding::label[1]/@n"/>
		</xsl:if>
	</xsl:template>



</xsl:stylesheet>