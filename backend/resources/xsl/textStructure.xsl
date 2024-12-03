<xsl:stylesheet version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:strip-space elements="*" />

	<xsl:template match="/">
		<document type="array">
			<xsl:apply-templates/>
		</document>
	</xsl:template>

	<xsl:template match="Kolon[@lang='ar']">
		<xsl:variable name="verse" select="./@n"/>
		<item>
			<ar>
				<xsl:value-of select="normalize-space(.)"/>
			</ar>
			<de>
				<xsl:value-of select="normalize-space(//Kolon[@n = $verse][@lang='de'])"/>
			</de>
			<insert type="bool">
				<xsl:value-of select="@Einschub"/>
			</insert>
			<rhyme>
				<xsl:value-of select="ancestor::Teilvers/@reim"/>
			</rhyme>
			<verse_part type="int">
				<xsl:value-of select="ancestor::Teilvers/@n"/>
			</verse_part>
			<verse type="int">
				<xsl:value-of select="ancestor::Vers/@n"/>
			</verse>
			<decade type="int">
				<xsl:value-of select="ancestor::Gesaetz/@n"/>
			</decade>
			<section type="int">
				<xsl:value-of select="ancestor::Abschnitt/@id"/>
			</section>
			<main_part type="int">
				<xsl:value-of select="ancestor::Hauptteil/@id"/>
			</main_part>
		</item>
	</xsl:template>

</xsl:stylesheet>