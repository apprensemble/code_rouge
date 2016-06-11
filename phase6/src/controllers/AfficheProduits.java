package controllers;

import java.io.IOException;
import java.io.PrintWriter;
import java.util.ArrayList;

import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import beans.Produit;
import dao.ProduitsDao;

/**
 * Servlet implementation class AfficheProduits
 */
@WebServlet(description = "permet d'afficher la liste des produits", urlPatterns = { "/AfficheProduits" })
public class AfficheProduits extends HttpServlet {
	private static final long serialVersionUID = 1L;
       
    /**
     * @see HttpServlet#HttpServlet()
     */
    public AfficheProduits() {
        super();
        // TODO Auto-generated constructor stub
    }

	/**
	 * @see HttpServlet#doGet(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		// TODO Auto-generated method stub
		ArrayList<Produit> produits = ProduitsDao.lireProduits();
		//response.getWriter().append("Served at: ").append(request.getContextPath()).append(resultats.get(0).getCode_prod());
		response.setContentType("text/html;charset=UTF-8");
		//gestionnaire de sorties
		PrintWriter out = response.getWriter();
		out.write("<style> table, th, td { border: 1px solid black; border-collapse: collapse; } </style>");
		out.write("<p>liste des produits disponibles</p>");
		out.write("<table style=\"width:100%\"> <tr> <th>code produit</th> <th>description produit</th> <th>prix produit</th> </tr> ");
		for (Produit produit : produits) {
			out.append("<tr>");
			out.append("<td>"+produit.getCode_prod()+"</td>");
			out.append("<td>"+produit.getDesc_court()+"</td>");
			out.append("<td>"+produit.getPric_HT()+"</td>");
			out.append("</tr>");
		}
			out.append("</table>");
	}

	/**
	 * @see HttpServlet#doPost(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		// TODO Auto-generated method stub
		doGet(request, response);
	}

}
