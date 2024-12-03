<xsl:stylesheet version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<!-- <xsl:output method="xml" omit-xml-declaration="yes" /> -->
	<xsl:strip-space elements="*" />
	<xsl:include href="flowtext.xsl" />
	<xsl:include href="footnotes.xsl"/>
	<xsl:include href="tableOfContents.xsl"/>

	<xsl:template match="overlay">
		<document>
			<Introductions type="array">
				<xsl:apply-templates/>
			</Introductions>
		</document>
	</xsl:template>

	<xsl:template match="akkordeon">
		<Introduction>
			<title>
				<xsl:value-of select="preceding-sibling::text[1]/p/hi[@rend='h1']"/>
			</title>
			<author>
				<xsl:value-of select="preceding-sibling::text[1]/p/hi[@rend='italic']"/>
			</author>
			<subauthor>
				<xsl:value-of select="preceding-sibling::text[1]/p/text()"/>
			</subauthor>
			<table_of_contents type="array">
				<xsl:call-template name="tableOfContents">
					<xsl:with-param name="intro" select="."/>
				</xsl:call-template>
			</table_of_contents>
			<sections type="array">
				<xsl:apply-templates mode="text"/>
			</sections>
		</Introduction>
	</xsl:template>

	<xsl:template match="text">
	</xsl:template>

	<xsl:template match="text" mode="text">
		<section>
			<title>
				<xsl:value-of select="preceding-sibling::label[1]"/>
			</title>
			<id>
				<xsl:call-template name="header_id">
					<xsl:with-param name="text" select="preceding-sibling::label[1]"/>
				</xsl:call-template>
			</id>
			<content type="html">
				<xsl:apply-templates/>
				<xsl:call-template name="footnotes">
					<xsl:with-param name="text" select="."/>
				</xsl:call-template>
			</content>
		</section>
	</xsl:template>

	<xsl:template match="p">
		<p>
			<xsl:apply-templates/>
		</p>
	</xsl:template>


	<xsl:template match="note">
		<sup>
			<a>
				<xsl:attribute name="href">
					<xsl:text>#</xsl:text>
					<xsl:call-template name="footnote_id"/>
				</xsl:attribute>
				<xsl:attribute name="id">
					<xsl:text>to_</xsl:text>
					<xsl:call-template name="footnote_id"/>
				</xsl:attribute>
				<xsl:call-template name="footnote_number"/>
			</a>
		</sup>
	</xsl:template>

	<xsl:template match="label">
	</xsl:template>

	<!-- Uncomment this to look for matched elements -->
	<xsl:template match="*">
		<xsl:message terminate="no">
   WARNING: Unmatched element: <xsl:value-of select="name()"/>
		</xsl:message>
		<xsl:apply-templates/>
	</xsl:template>

</xsl:stylesheet>