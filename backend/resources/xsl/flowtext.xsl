<?xml version="1.0" encoding="UTF-8" ?>
<xsl:stylesheet version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:include href="zotero.xsl" />
	<xsl:include href="headerId.xsl" />
	<!-- **** Alle Templates gesammelt, welche die Textausgabe steuern *** -->

	<!-- Sprache kursiv ausgeben -->
	<xsl:template match="lang">
		<em>
			<xsl:value-of select="."/>
		</em>
	</xsl:template>

	<!-- Sprache kursiv ausgeben -->
	<xsl:template match="lem">
		<em>
			<xsl:value-of select="."/>
		</em>
	</xsl:template>

	<!-- Versangabe -->
	<xsl:template match="q">
		<xsl:choose>
			<xsl:when test="@versstart and @type != 'bibel'">
				<a data-type="{@type}" data-start="{@versstart}" data-end="{@versend}">
					<xsl:if test="@id">
						<xsl:attribute name="data-id">
							<xsl:value-of select="@id"/>
						</xsl:attribute>
					</xsl:if>
					<xsl:value-of select="."/>
				</a>
			</xsl:when>
			<xsl:otherwise>
				<!-- keine Verlnnkung, nur ausgeben -->
				<span class="vers">
					<xsl:value-of select="."/>
				</span>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>

	<!-- TUK Text -->
	<!-- apply-templates does not work here, for reasons I can't figure out - Marcus Lampert -->
	<xsl:template match="//ref[starts-with(@target, '#TUK')]">
		<a data-type="intertext" data-id="{substring(./@target, 5)}">
			<xsl:value-of select="."></xsl:value-of>
		</a>
	</xsl:template>

	<!-- Hoch gestellte Texte -->
	<xsl:template match="superscript">
		<sup>
			<xsl:apply-templates select="."/>
		</sup>
	</xsl:template>

	<!-- fetter und kursiver Text -->
	<xsl:template match="hi">
		<xsl:choose>
			<!-- Don't do anything with empty hi nodes. -->
			<xsl:when test="not(./node())">
			</xsl:when>
			<xsl:when test="@rend = 'bold'">
				<strong>
					<xsl:apply-templates/>
				</strong>
			</xsl:when>
			<xsl:when test="@rend = 'italic'">
				<em>
					<xsl:apply-templates/>
				</em>
			</xsl:when>
			<xsl:when test="@rend = 'superscript'">
				<sup>
					<xsl:apply-templates/>
				</sup>
			</xsl:when>
			<xsl:when test="@rend = 'text-indent'">
				<p class="indent">
					<xsl:apply-templates/>
				</p>
			</xsl:when>
			<xsl:when test="@rend = 'h1'">
				<h3>
					<xsl:attribute name="id">
						<xsl:call-template name="header_id">
							<xsl:with-param name="text" select="."/>
						</xsl:call-template>
					</xsl:attribute>
					<xsl:apply-templates/>
				</h3>
			</xsl:when>
			<xsl:when test="@rend = 'h2'">
				<h4>
					<xsl:attribute name="id">
						<xsl:call-template name="header_id">
							<xsl:with-param name="text" select="."/>
						</xsl:call-template>
					</xsl:attribute>
					<xsl:apply-templates/>
				</h4>
			</xsl:when>
			<xsl:otherwise>
				<xsl:value-of select="."/>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>

	<!-- Tabelle -->
	<xsl:template match="table">
		<table>
			<xsl:apply-templates/>
		</table>
	</xsl:template>


	<xsl:template match="head">
	</xsl:template>

	<xsl:template match="row">
		<tr>
			<xsl:apply-templates/>
		</tr>
	</xsl:template>

	<xsl:template match="cell">
		<td>
			<xsl:apply-templates/>
		</td>
	</xsl:template>

	<!-- Listen -->
	<xsl:template match="list">
		<xsl:choose>
			<xsl:when test="@type = 'orderd'">
				<ol>
					<xsl:apply-templates/>
				</ol>
			</xsl:when>
			<xsl:when test="@type = 'bulleted'">
				<ul>
					<xsl:apply-templates/>
				</ul>
			</xsl:when>
		</xsl:choose>
	</xsl:template>


	<xsl:template match="item">
		<li>
			<xsl:apply-templates/>
		</li>
	</xsl:template>

	<xsl:template match="bibl">
		<xsl:call-template name="bibl">
			<xsl:with-param name="abschnitt" select="'l'"/>
			<xsl:with-param name="prefix" select="'l_'"/>
		</xsl:call-template>
	</xsl:template>

</xsl:stylesheet>