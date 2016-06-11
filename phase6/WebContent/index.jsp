<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
    <%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c"%> 
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<base href='<%=request.getScheme() + "://" + request.getServerName() + ":" + request.getServerPort() + request.getContextPath() + "/"%>'></base>
<title>Menu</title>
<style type="css"> table, th, td { border: 1px solid black; border-collapse: collapse; } </style>
</head>
<body>
	<p><a href=http://localhost:8080/servlet/AfficheProduits>liste des produits disponibles</a></p>
	<p><a href=http://localhost:8080/servlet/AfficheProduitsJSP>liste des produits disponibles(version JSP)</a></p>
</body>
</html>
