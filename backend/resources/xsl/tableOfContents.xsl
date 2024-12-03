<xsl:stylesheet version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<!-- Note: this template uses footnotes.xsl, but that is imported in another file.  -->

	<xsl:template name="tableOfContents">
		<xsl:param name="intro"/>
		<xsl:for-each select="$intro/text">
			<item>
				<text>
					<xsl:value-of select="preceding-sibling::label[1]"/>
				</text>
				<link>
					<xsl:call-template name="header_id">
						<xsl:with-param name="text" select="preceding-sibling::label[1]"/>
					</xsl:call-template>
				</link>
				<children type="array">
					<xsl:apply-templates mode="tableOfContents" select='.'/>
					<xsl:if test="count(.//note) > 0">
						<item>
							<text>Fussnoten</text>
							<link>
								<xsl:call-template name="footnote_section_id" select="current()"/>
							</link>
						</item>
					</xsl:if>
				</children>
			</item>
		</xsl:for-each>
	</xsl:template>

	<xsl:template match="text" mode="tableOfContents">
		<xsl:apply-templates mode="tableOfContents"/>
	</xsl:template>

	<xsl:template match="p" mode="tableOfContents">
		<xsl:apply-templates mode="tableOfContents"/>
	</xsl:template>

	<xsl:key name="innerHeadings" match="akkordeon//hi[@rend='h2']" use="preceding::hi[@rend='h1'][1]" />

	<xsl:template match="hi[@rend='h1']" mode="tableOfContents">
		<xsl:if test="(./node())">
			<item>
				<text>
					<xsl:value-of select="text()"/>
				</text>
				<link>
					<xsl:call-template name="header_id">
						<xsl:with-param name="text" select="."/>
					</xsl:call-template>
				</link>
				<children type="array">
					<xsl:for-each select="key('innerHeadings',current())">
						<item>
							<text>
								<xsl:value-of select="."/>
							</text>
							<link>
								<xsl:call-template name="header_id">
									<xsl:with-param name="text" select="."/>
								</xsl:call-template>
							</link>
						</item>
					</xsl:for-each>
				</children>
			</item>
		</xsl:if>
	</xsl:template>


	<xsl:template name="h2entry">
		<xsl:param name="entry"/>
		<item>
			<text>
				<xsl:value-of select="$entry/text()"/>
			</text>
			<link>
			</link>
		</item>
	</xsl:template>

</xsl:stylesheet>