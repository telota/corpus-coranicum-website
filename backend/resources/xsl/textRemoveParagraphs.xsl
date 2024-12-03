<xsl:stylesheet version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:output method="xml" omit-xml-declaration="yes" />

	<xsl:include href="flowtext.xsl" />

	<xsl:template match="text">
		<xsl:for-each select="p">
			<xsl:apply-templates/>
		</xsl:for-each>
	</xsl:template>

</xsl:stylesheet> 