<?xml version="1.0" encoding="UTF-8" ?>
<xsl:stylesheet version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">


	<xsl:template name="footnote_section_id">
		<xsl:text>footnotes_</xsl:text>
		<xsl:number count="text" from="akkordeon" level="any"/>
	</xsl:template>


	<xsl:template name="footnote_id">
		<xsl:text>footnote_</xsl:text>
		<xsl:number count="text" from="akkordeon" level="any"/>
		<xsl:text>_</xsl:text>
		<xsl:call-template name="footnote_number"/>
	</xsl:template>

	<xsl:template name="footnote_number">
		<xsl:number count="note" from="text" level="any"/>
	</xsl:template>


	<!-- Ausgabe der Liste der Fussnoten -->
	<xsl:template name="footnotes">
		<xsl:param name="text"/>
		<xsl:if test="count($text//note) > 0">
			<h3>
				<xsl:attribute name="id">
					<xsl:call-template name="footnote_section_id" select="current()"/>
				</xsl:attribute>
				<xsl:text>Fussnoten</xsl:text>
			</h3>
			<ul class="footnotes">
				<xsl:for-each select="$text//note">
					<li>
						<sup>
							<a>
								<xsl:attribute name="href">
									<xsl:text>#to_</xsl:text>
									<xsl:call-template name="footnote_id"/>
								</xsl:attribute>
								<xsl:attribute name="id">
									<xsl:call-template name="footnote_id"/>
								</xsl:attribute>
								<xsl:call-template name="footnote_number"/>
							</a>
						</sup>
						<xsl:text>&#160;</xsl:text>
						<xsl:apply-templates/>
					</li>
				</xsl:for-each>
			</ul>
		</xsl:if>

	</xsl:template>



</xsl:stylesheet>