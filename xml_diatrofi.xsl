<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" >
<xsl:output method = "html"></xsl:output>

<xsl:template match="/">
	<!-- count and display the number of <pelatis>< -->
	<h3 align="center">Συνολικός αριθμός πελατών: <xsl:value-of select="count(/diatrofi/pelatis)"/></h3>
	
	<xsl:for-each select="diatrofi/pelatis">
	<table align="center" width="50%" border="1" border-radius="25px">
	<tr bgcolor="#428BCA">
	  	<td><b>Όνομα</b></td>
		<td><b>Επίθετο</b></td>
		<td><b>Βάρος</b></td>
		<td><b>Φύλο</b></td>
		<td><b>Ηλικία</b></td>
	</tr>
	<tr>
		<td><xsl:value-of select="onoma"/></td>
	    <td><xsl:value-of select="epitheto"/></td>
	    <td><xsl:value-of select="baros"/></td>
	    <td><xsl:value-of select="filo"/></td>
	    <td><xsl:value-of select="ilikia"/></td>
	</tr>
	<tr bgcolor="#37B1D6">
		<td><b>Γεύμα</b></td>
		<td><b>Τύπος</b></td>
		<td><b>Ημερομηνία</b></td>
	</tr>
	<xsl:for-each select="geyma">
	<tr>
		<td><xsl:value-of select="sxolia-diaitologou"/></td>
	    <td><xsl:value-of select="typos-geymatos"/></td>
	    <td><xsl:value-of select="imerominia"/></td>
	</tr>
	
	</xsl:for-each>
	</table>
	</xsl:for-each>

</xsl:template>
</xsl:stylesheet>